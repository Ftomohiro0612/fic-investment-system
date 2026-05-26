<?php
/**
 * FIC navigation measurement.
 *
 * Sends lightweight GA4/GTM-friendly events for links marked with
 * data-fic-area/data-fic-label and for FIC search forms.
 */

if (!function_exists('fic_output_navigation_measurement_script')) {
function fic_output_navigation_measurement_script() {
    if (is_admin()) {
        return;
    }
    ?>
    <script id="fic-navigation-measurement">
      (function () {
        function getFicPageType() {
          var body = document.body;
          var path = window.location.pathname || '/';

          if (body && body.classList.contains('home')) {
            return 'home';
          }
          if (body && body.classList.contains('search')) {
            return 'search';
          }
          if (body && body.classList.contains('single-post')) {
            return 'article';
          }
          if (body && body.classList.contains('category')) {
            if (body.classList.contains('category-theme-analysis')) {
              return 'category_theme_analysis';
            }
            if (body.classList.contains('category-theme-reading')) {
              return 'category_theme_reading';
            }
            if (body.classList.contains('category-investment-reading')) {
              return 'category_investment_reading';
            }
            if (body.classList.contains('category-99')) {
              return 'category_company_analysis';
            }
            return 'category';
          }
          if (path === '/companies/' || path === '/companies') {
            return 'hub_company';
          }
          if (path === '/themes/' || path === '/themes') {
            return 'hub_theme';
          }
          if (path === '/learn/' || path === '/learn') {
            return 'hub_learning';
          }
          if (path === '/earnings-schedule/' || path === '/earnings-schedule') {
            return 'earnings_schedule';
          }

          return 'other';
        }

        function getFicPageParams() {
          return {
            fic_page_type: getFicPageType(),
            fic_page_path: window.location.pathname || '/'
          };
        }

        function sendFicEvent(name, params) {
          var payload = Object.assign(getFicPageParams(), params || {});

          if (typeof window.gtag === 'function') {
            window.gtag('event', name, payload);
          }

          window.dataLayer = window.dataLayer || [];
          window.dataLayer.push(Object.assign({ event: name }, payload));

          try {
            window.dispatchEvent(new CustomEvent('fic:measurement', {
              detail: Object.assign({ event: name }, payload)
            }));
          } catch (error) {}
        }

        document.addEventListener('click', function (event) {
          var target = event.target && event.target.closest ? event.target.closest('[data-fic-area]') : null;
          if (!target) {
            return;
          }

          sendFicEvent('fic_navigation_click', {
            fic_area: target.getAttribute('data-fic-area') || '',
            fic_label: target.getAttribute('data-fic-label') || target.textContent.trim(),
            link_url: target.href || '',
            page_location: window.location.href
          });
        }, true);

        document.addEventListener('submit', function (event) {
          var form = event.target;
          if (!form || !form.matches || !form.matches('.fic-home-search, .fic-hub-search')) {
            return;
          }

          var input = form.querySelector('input[type="search"], input[name="s"]');
          sendFicEvent('fic_search_submit', {
            fic_area: form.classList.contains('fic-hub-search') ? 'hub_search' : 'home_search',
            fic_label: input ? input.value : '',
            search_term: input ? input.value : '',
            page_location: window.location.href
          });
        }, true);
      }());
    </script>
    <?php
}
}
add_action('wp_footer', 'fic_output_navigation_measurement_script', 99);
