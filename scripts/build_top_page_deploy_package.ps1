param(
    [string] $OutputDir = 'wordpress\deploy\top-page-mvp',
    [switch] $SkipVerify
)

$ErrorActionPreference = 'Stop'

$RepoRoot = Split-Path -Parent $PSScriptRoot
Set-Location $RepoRoot

function Decode-Utf8Base64 {
    param([string] $Value)
    return [Text.Encoding]::UTF8.GetString([Convert]::FromBase64String($Value))
}

if (-not $SkipVerify) {
    & powershell -ExecutionPolicy Bypass -File (Join-Path $PSScriptRoot 'verify_top_page_mvp.ps1')
    if ($LASTEXITCODE -ne 0) {
        throw 'Verification failed; deploy package was not built.'
    }
}

$resolvedOutput = Join-Path $RepoRoot $OutputDir

if (Test-Path -LiteralPath $resolvedOutput) {
    Remove-Item -LiteralPath $resolvedOutput -Recurse -Force
}

New-Item -ItemType Directory -Path $resolvedOutput | Out-Null
New-Item -ItemType Directory -Path (Join-Path $resolvedOutput 'code-snippets') | Out-Null
New-Item -ItemType Directory -Path (Join-Path $resolvedOutput 'code-snippets-paste') | Out-Null
New-Item -ItemType Directory -Path (Join-Path $resolvedOutput 'css') | Out-Null
New-Item -ItemType Directory -Path (Join-Path $resolvedOutput 'assets') | Out-Null
New-Item -ItemType Directory -Path (Join-Path $resolvedOutput 'docs') | Out-Null
New-Item -ItemType Directory -Path (Join-Path $resolvedOutput 'fixed-page-bodies') | Out-Null

$filesToCopy = @(
    @{ Source = 'wordpress\snippets\fic-home-page-mvp.php'; Target = 'code-snippets\fic-home-page-mvp.php' },
    @{ Source = 'wordpress\snippets\fic-hub-pages.php'; Target = 'code-snippets\fic-hub-pages.php' },
    @{ Source = 'wordpress\snippets\fic-category-bridge-links.php'; Target = 'code-snippets\fic-category-bridge-links.php' },
    @{ Source = 'wordpress\snippets\fic-navigation-measurement.php'; Target = 'code-snippets\fic-navigation-measurement.php' },
    @{ Source = 'wordpress\snippets\fic-earnings-page-guide.php'; Target = 'code-snippets\fic-earnings-page-guide.php' },
    @{ Source = 'wordpress\css\fic-home-page-mvp.css'; Target = 'css\fic-home-page-mvp.css' },
    @{ Source = 'wordpress\assets\fic-logo-header-white-transparent.png'; Target = 'assets\fic-logo-header-white-transparent.png' },
    @{ Source = 'wordpress\assets\fic-logo-header-dark-transparent.png'; Target = 'assets\fic-logo-header-dark-transparent.png' },
    @{ Source = 'docs\top_page_publication_playbook.md'; Target = 'docs\top_page_publication_playbook.md' },
    @{ Source = 'docs\top_page_rollout_checklist.md'; Target = 'docs\top_page_rollout_checklist.md' },
    @{ Source = 'docs\top_page_admin_runbook.md'; Target = 'docs\top_page_admin_runbook.md' },
    @{ Source = 'docs\top_page_measurement_plan.md'; Target = 'docs\top_page_measurement_plan.md' },
    @{ Source = 'docs\top_page_legacy_cleanup_plan.md'; Target = 'docs\top_page_legacy_cleanup_plan.md' },
    @{ Source = 'docs\top_page_content_growth_plan.md'; Target = 'docs\top_page_content_growth_plan.md' },
    @{ Source = 'docs\top_page_mvp_deployment.md'; Target = 'docs\top_page_mvp_deployment.md' },
    @{ Source = 'docs\phase1_publication_matrix.md'; Target = 'docs\phase1_publication_matrix.md' },
    @{ Source = 'docs\phase1_wordpress_publish_checklist.md'; Target = 'docs\phase1_wordpress_publish_checklist.md' },
    @{ Source = 'docs\navigation_measurement_events.md'; Target = 'docs\navigation_measurement_events.md' },
    @{ Source = 'docs\handoff_2026-05-23_top_page_production.md'; Target = 'docs\handoff_2026-05-23_top_page_production.md' }
)

foreach ($file in $filesToCopy) {
    $source = Join-Path $RepoRoot $file.Source
    $target = Join-Path $resolvedOutput $file.Target
    Copy-Item -LiteralPath $source -Destination $target -Force
}

$pasteSnippetFiles = @(
    @{ Source = 'wordpress\snippets\fic-home-page-mvp.php'; Target = 'code-snippets-paste\fic-home-page-mvp-no-open-tag.php' },
    @{ Source = 'wordpress\snippets\fic-hub-pages.php'; Target = 'code-snippets-paste\fic-hub-pages-no-open-tag.php' },
    @{ Source = 'wordpress\snippets\fic-category-bridge-links.php'; Target = 'code-snippets-paste\fic-category-bridge-links-no-open-tag.php' },
    @{ Source = 'wordpress\snippets\fic-navigation-measurement.php'; Target = 'code-snippets-paste\fic-navigation-measurement-no-open-tag.php' },
    @{ Source = 'wordpress\snippets\fic-earnings-page-guide.php'; Target = 'code-snippets-paste\fic-earnings-page-guide-no-open-tag.php' }
)

foreach ($file in $pasteSnippetFiles) {
    $source = Join-Path $RepoRoot $file.Source
    $target = Join-Path $resolvedOutput $file.Target
    $content = Get-Content -Raw -LiteralPath $source -Encoding UTF8
    $content = $content -replace '^\s*<\?php\s*\r?\n', ''
    Set-Content -Path $target -Value $content -Encoding UTF8
    $written = Get-Content -Raw -LiteralPath $target -Encoding UTF8
    if ($written.TrimEnd() -ne $content.TrimEnd()) {
        throw "Generated paste snippet does not match UTF-8 source: $target"
    }
}

$fixedPageBodies = @(
    @{ Target = 'fixed-page-bodies\top-page.txt'; Content = '[fic_home_mvp]' },
    @{ Target = 'fixed-page-bodies\companies.txt'; Content = '[fic_company_hub]' },
    @{ Target = 'fixed-page-bodies\themes.txt'; Content = '[fic_theme_hub]' },
    @{ Target = 'fixed-page-bodies\learn.txt'; Content = '[fic_learning_hub]' }
)

foreach ($body in $fixedPageBodies) {
    Set-Content -Path (Join-Path $resolvedOutput $body.Target) -Value $body.Content -Encoding UTF8
}

$menuLines = @(
    '# Recommended WordPress Menu',
    '',
    '| Label | URL |',
    '| --- | --- |',
    ('| ' + (Decode-Utf8Base64 '5LyB5qWt44KS5o6i44GZ') + ' | `/companies/` |'),
    ('| ' + (Decode-Utf8Base64 '44OG44O844Oe44GL44KJ5o6i44GZ') + ' | `/themes/` |'),
    ('| ' + (Decode-Utf8Base64 '5oqV6LOH44Gu6Kqt44G/5pa5') + ' | `/learn/` |'),
    ('| ' + (Decode-Utf8Base64 '5rG6566X5LqI5a6a') + ' | `/earnings-schedule/` |'),
    '',
    'Optional:',
    '',
    '- YouTube',
    '- About',
    '- Editorial Policy'
)

Set-Content -Path (Join-Path $resolvedOutput 'fixed-page-bodies\recommended-menu.md') -Value $menuLines -Encoding UTF8

$manifestLines = @(
    '# FIC Top Page MVP Deploy Package',
    '',
    "Generated: $(Get-Date -Format 'yyyy-MM-dd HH:mm:ss')",
    '',
    '## 1. Code Snippets',
    '',
    'For the Code Snippets plugin, use the files in `code-snippets-paste/` first.',
    'These files omit the opening `<?php` tag.',
    '',
    '### FIC: Home page MVP shortcode',
    '',
    '- Paste: `code-snippets-paste/fic-home-page-mvp-no-open-tag.php`',
    '- Shortcode: `[fic_home_mvp]`',
    '',
    '### FIC: Purpose hub shortcodes',
    '',
    '- Paste: `code-snippets-paste/fic-hub-pages-no-open-tag.php`',
    '- Shortcodes: `[fic_company_hub]`, `[fic_theme_hub]`, `[fic_learning_hub]`',
    '',
    '### FIC: Category bridge internal links',
    '',
    '- Paste: `code-snippets-paste/fic-category-bridge-links-no-open-tag.php`',
    '- Adds reading-guide context links and category bridge blocks to company/theme articles.',
    '',
    '### FIC: Navigation measurement events',
    '',
    '- Paste: `code-snippets-paste/fic-navigation-measurement-no-open-tag.php`',
    '- Sends `fic_navigation_click` and `fic_search_submit` events.',
    '',
    '### FIC: Earnings schedule page guide',
    '',
    '- Paste: `code-snippets-paste/fic-earnings-page-guide-no-open-tag.php`',
    '- Adds the guide section above `/earnings-schedule/`.',
    '',
    'Original PHP files with the opening `<?php` tag are preserved in `code-snippets/` for file-based use.',
    '',
    '## 2. CSS',
    '',
    'Paste this file into WordPress Additional CSS or the active theme CSS:',
    '',
    '- `css/fic-home-page-mvp.css`',
    '',
    '## 3. Logo Asset',
    '',
    'Upload or place these files:',
    '',
'- `assets/fic-logo-header-dark-transparent.png`',
'- `assets/fic-logo-header-white-transparent.png`',
'',
'Use the dark logo on the white site header. Keep the white logo only as a spare asset for dark-background placements.',
'If the Diver header image cannot be changed directly, keep the managed CSS replacement that maps the old header image URL to the dark logo URL.',
    '',
    '## 4. Fixed Pages',
    '',
    'Use the small text files in `fixed-page-bodies/` when creating or updating WordPress pages.',
    '',
    '| Page | URL | Body |',
    '| --- | --- | --- |',
    '| Top page | existing top page | `fixed-page-bodies/top-page.txt` |',
    '| Company hub | `/companies/` | `fixed-page-bodies/companies.txt` |',
    '| Theme hub | `/themes/` | `fixed-page-bodies/themes.txt` |',
    '| Learning hub | `/learn/` | `fixed-page-bodies/learn.txt` |',
    '',
    'Recommended menu: `fixed-page-bodies/recommended-menu.md`',
    '',
    '## 5. Local Preview',
    '',
    'Start:',
    '',
    '```powershell',
    'powershell -ExecutionPolicy Bypass -File scripts\start_top_page_preview.ps1 -Restart',
    '```',
    '',
    'Open:',
    '',
    '- http://127.0.0.1:4291/previews/index.html',
    '- http://127.0.0.1:4291/previews/responsive-qa.html',
    '',
    '## 6. Local Verification',
    '',
    'Run:',
    '',
    '```powershell',
    'powershell -ExecutionPolicy Bypass -File scripts\verify_top_page_mvp.ps1',
    '```',
    '',
    'If PHP CLI is not installed, only `php -l` is skipped. The other checks still verify the local package basics.',
    '',
    'For Japanese admin-screen instructions, see `docs/top_page_admin_runbook.md`.',
    'For broader publication notes, see `docs/top_page_publication_playbook.md` in this package.',
    'For phase-1 article publishing, see `docs/phase1_wordpress_publish_checklist.md` and `docs/phase1_publication_matrix.md`.',
    'For post-launch click measurement, see `docs/top_page_measurement_plan.md`.',
    'For legacy navigation cleanup, see `docs/top_page_legacy_cleanup_plan.md`.',
    'For content growth priorities, see `docs/top_page_content_growth_plan.md`.'
)

Set-Content -Path (Join-Path $resolvedOutput 'README.md') -Value $manifestLines -Encoding UTF8

Write-Host "Deploy package built: $resolvedOutput"
