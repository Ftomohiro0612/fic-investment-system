param(
    [switch] $SkipGitDiffCheck
)

$ErrorActionPreference = 'Stop'

$RepoRoot = Split-Path -Parent $PSScriptRoot
Set-Location $RepoRoot

function Write-Check {
    param([string] $Message)
    Write-Host "[OK] $Message"
}

function Assert-FileExists {
    param([string] $Path)
    if (-not (Test-Path -LiteralPath $Path)) {
        throw "Missing required file: $Path"
    }
}

function Assert-Contains {
    param(
        [string] $Path,
        [string] $Pattern,
        [string] $Label
    )

    $text = Get-Content -Raw -LiteralPath $Path
    if ($text -notmatch $Pattern) {
        throw "Missing expected marker in ${Path}: ${Label}"
    }
}

$requiredFiles = @(
    'wordpress\snippets\functions.php',
    'wordpress\snippets\fic-home-page-mvp.php',
    'wordpress\snippets\fic-hub-pages.php',
    'wordpress\css\custom.css',
    'wordpress\css\fic-home-page-mvp.css',
    'wordpress\previews\index.html',
    'wordpress\previews\fic-home-page-mvp-preview.html',
    'wordpress\previews\fic-company-hub-preview.html',
    'wordpress\previews\fic-theme-hub-preview.html',
    'wordpress\previews\fic-learning-hub-preview.html',
    'wordpress\previews\responsive-qa.html',
    'wordpress\assets\fic-logo-header-white-transparent.png',
    'wordpress\assets\fic-logo-header-dark-transparent.png',
    'docs\top_page_rollout_checklist.md',
    'docs\top_page_publication_playbook.md',
    'docs\top_page_admin_runbook.md',
    'docs\top_page_measurement_plan.md',
    'docs\top_page_legacy_cleanup_plan.md',
    'docs\top_page_content_growth_plan.md',
    'docs\phase1_publication_matrix.md',
    'docs\phase1_wordpress_publish_checklist.md'
)

foreach ($file in $requiredFiles) {
    Assert-FileExists $file
}
Write-Check 'Required files exist'

$phpLikeFiles = @(
    'wordpress\snippets\functions.php',
    'wordpress\snippets\fic-home-page-mvp.php',
    'wordpress\snippets\fic-hub-pages.php'
)

foreach ($file in $phpLikeFiles) {
    $text = Get-Content -Raw -LiteralPath $file
    $open = ($text.ToCharArray() | Where-Object { $_ -eq '{' }).Count
    $close = ($text.ToCharArray() | Where-Object { $_ -eq '}' }).Count

    if ($open -ne $close) {
        throw "Brace count mismatch in ${file}: ${open} / ${close}"
    }
}
Write-Check 'PHP snippet brace counts match'

$customCss = Get-Content -Raw -LiteralPath 'wordpress\css\custom.css'
$standaloneCss = Get-Content -Raw -LiteralPath 'wordpress\css\fic-home-page-mvp.css'
$cssStart = $customCss.IndexOf('.fic-home {')
$cssEnd = $customCss.IndexOf('.fic-upcoming-box {')

if ($cssStart -lt 0 -or $cssEnd -lt 0) {
    throw 'CSS block markers missing in wordpress\css\custom.css'
}

$customHomeCss = $customCss.Substring($cssStart, $cssEnd - $cssStart).Trim()
if ($customHomeCss -ne $standaloneCss.Trim()) {
    throw 'Standalone fic-home-page-mvp.css is not synced with custom.css'
}
Write-Check 'Standalone CSS is synced with custom.css'

$markerChecks = @(
    @{ Path = 'wordpress\snippets\fic-home-page-mvp.php'; Pattern = '\[fic_home_mvp\]|fic_home_mvp'; Label = 'home shortcode' },
    @{ Path = 'wordpress\snippets\fic-hub-pages.php'; Pattern = 'fic_company_hub'; Label = 'company hub shortcode' },
    @{ Path = 'wordpress\snippets\fic-hub-pages.php'; Pattern = 'fic_theme_hub'; Label = 'theme hub shortcode' },
    @{ Path = 'wordpress\snippets\fic-hub-pages.php'; Pattern = 'fic_learning_hub'; Label = 'learning hub shortcode' },
    @{ Path = 'wordpress\snippets\fic-hub-pages.php'; Pattern = 'aria-current="page"'; Label = 'active hub aria-current' },
    @{ Path = 'wordpress\snippets\fic-home-page-mvp.php'; Pattern = 'data-fic-area'; Label = 'home click tracking attributes' },
    @{ Path = 'wordpress\snippets\fic-hub-pages.php'; Pattern = 'data-fic-area'; Label = 'hub click tracking attributes' },
    @{ Path = 'docs\top_page_admin_runbook.md'; Pattern = 'Code Snippets'; Label = 'admin runbook Code Snippets instructions' },
    @{ Path = 'docs\top_page_measurement_plan.md'; Pattern = 'fic_navigation_click'; Label = 'measurement event name' },
    @{ Path = 'docs\top_page_legacy_cleanup_plan.md'; Pattern = 'legacy-cleanup-plan'; Label = 'legacy cleanup timeline' },
    @{ Path = 'docs\top_page_content_growth_plan.md'; Pattern = 'content-growth-plan'; Label = 'content growth plan' },
    @{ Path = 'docs\phase1_publication_matrix.md'; Pattern = 'phase1-publication-matrix'; Label = 'phase 1 publication matrix' },
    @{ Path = 'docs\phase1_wordpress_publish_checklist.md'; Pattern = 'phase1-wordpress-publish-checklist'; Label = 'phase 1 publish checklist' },
    @{ Path = 'wordpress\previews\fic-home-page-mvp-preview.html'; Pattern = 'fic-company-hub-preview\.html'; Label = 'company entry link' },
    @{ Path = 'wordpress\previews\fic-home-page-mvp-preview.html'; Pattern = 'fic-theme-hub-preview\.html'; Label = 'theme entry link' },
    @{ Path = 'wordpress\previews\fic-home-page-mvp-preview.html'; Pattern = 'fic-learning-hub-preview\.html'; Label = 'learning entry link' },
    @{ Path = 'wordpress\previews\fic-home-page-mvp-preview.html'; Pattern = 'fic-home-upcoming'; Label = 'earnings entry anchor' },
    @{ Path = 'wordpress\previews\responsive-qa.html'; Pattern = '390px'; Label = 'responsive QA mobile width' },
    @{ Path = 'docs\top_page_rollout_checklist.md'; Pattern = 'responsive-qa\.html'; Label = 'rollout checklist responsive QA link' }
)

foreach ($check in $markerChecks) {
    Assert-Contains -Path $check.Path -Pattern $check.Pattern -Label $check.Label
}
Write-Check 'Required content markers exist'

if (-not $SkipGitDiffCheck) {
    git diff --check
    if ($LASTEXITCODE -ne 0) {
        throw 'git diff --check failed'
    }
    Write-Check 'git diff --check passed'
}

$php = Get-Command php -ErrorAction SilentlyContinue
if ($php) {
    foreach ($file in $phpLikeFiles) {
        php -l $file
        if ($LASTEXITCODE -ne 0) {
            throw "php -l failed for $file"
        }
    }
    Write-Check 'php -l passed'
} else {
    Write-Host '[WARN] php command not found; skipped php -l'
}

Write-Host 'Top page MVP verification complete.'
