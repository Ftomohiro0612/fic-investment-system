param(
    [string] $PackageDir = 'wordpress\deploy\phase1-articles'
)

$ErrorActionPreference = 'Stop'

$RepoRoot = Split-Path -Parent $PSScriptRoot
Set-Location $RepoRoot
Add-Type -AssemblyName System.Web

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

function Assert-Count {
    param(
        [int] $Actual,
        [int] $Expected,
        [string] $Label
    )

    if ($Actual -ne $Expected) {
        throw "${Label}: expected $Expected, got $Actual"
    }
}

$packagePath = Join-Path $RepoRoot $PackageDir

Assert-FileExists $packagePath
Assert-FileExists (Join-Path $packagePath 'README.md')
Assert-FileExists (Join-Path $packagePath 'metadata\phase1-article-upload.csv')
Assert-FileExists (Join-Path $packagePath 'metadata\phase1-article-publish-tracker.csv')
Assert-FileExists (Join-Path $packagePath 'docs\phase1_publication_matrix.md')
Assert-FileExists (Join-Path $packagePath 'docs\phase1_wordpress_publish_checklist.md')
Assert-FileExists (Join-Path $packagePath 'previews\index.html')
Assert-FileExists (Join-Path $packagePath 'previews\preview.css')
Write-Check 'Required package files exist'

$bodyFiles = @(Get-ChildItem -Path (Join-Path $packagePath 'bodies') -Recurse -Filter '*.html')
$imageFiles = @(Get-ChildItem -Path (Join-Path $packagePath 'eyecatch') -Recurse -Filter '*.png')
$previewFiles = @(Get-ChildItem -Path (Join-Path $packagePath 'previews') -Filter '*.html')
$csvRows = @(Import-Csv -LiteralPath (Join-Path $packagePath 'metadata\phase1-article-upload.csv') -Encoding UTF8)
$trackerRows = @(Import-Csv -LiteralPath (Join-Path $packagePath 'metadata\phase1-article-publish-tracker.csv') -Encoding UTF8)

Assert-Count $bodyFiles.Count 23 'Body HTML count'
Assert-Count $imageFiles.Count 23 'Eyecatch image count'
Assert-Count $previewFiles.Count 24 'Preview HTML count including index'
Assert-Count $csvRows.Count 23 'CSV row count'
Assert-Count $trackerRows.Count 23 'Publish tracker row count'
Write-Check 'Expected file counts match'

foreach ($row in $csvRows) {
    foreach ($field in @('no', 'group', 'title', 'slug', 'category', 'description', 'body_file', 'eyecatch_file')) {
        if (-not $row.$field) {
            throw "Missing CSV field `${field}` for row: $($row | ConvertTo-Json -Compress)"
        }
    }

    $body = Join-Path $packagePath ($row.body_file -replace '/', '\')
    $image = Join-Path $packagePath ($row.eyecatch_file -replace '/', '\')
    $preview = Join-Path $packagePath ('previews\' + $row.slug + '.html')

    Assert-FileExists $body
    Assert-FileExists $image
    Assert-FileExists $preview

    $bodyText = Get-Content -Raw -LiteralPath $body -Encoding UTF8
    if ($bodyText -match '^\s*<!--' -or $bodyText -match 'article_title:|^slug:|^category:|^description:') {
        throw "Management metadata remains in body file: $body"
    }
    if ($bodyText -notmatch 'class="fic-article-after-nav"') {
        throw "After-read navigation missing in body file: $body"
    }

    $previewText = Get-Content -Raw -LiteralPath $preview -Encoding UTF8
    $encodedTitle = [System.Web.HttpUtility]::HtmlEncode($row.title)
    if ($previewText -notmatch [regex]::Escape($row.title) -and $previewText -notmatch [regex]::Escape($encodedTitle)) {
        throw "Preview missing title for slug: $($row.slug)"
    }
    if ($previewText -notmatch 'img class="eyecatch"') {
        throw "Preview missing eyecatch image for slug: $($row.slug)"
    }
    if ($previewText -notmatch 'class="fic-article-after-nav"') {
        throw "Preview missing after-read navigation for slug: $($row.slug)"
    }
}
Write-Check 'CSV references, body cleanup, after-read navigation, and article previews are valid'

foreach ($row in $trackerRows) {
    foreach ($field in @('no', 'batch', 'status', 'title', 'slug', 'category', 'body_file', 'eyecatch_file', 'preview_file', 'description', 'published_url', 'published_date', 'notes')) {
        if (-not ($row.PSObject.Properties.Name -contains $field)) {
            throw "Missing tracker field: $field"
        }
    }

    if ($row.status -ne 'todo') {
        throw "Unexpected tracker default status for slug: $($row.slug)"
    }

    $matchingCsvRow = $csvRows | Where-Object { $_.slug -eq $row.slug } | Select-Object -First 1
    if (-not $matchingCsvRow) {
        throw "Tracker slug missing from upload CSV: $($row.slug)"
    }

    Assert-FileExists (Join-Path $packagePath ($row.preview_file -replace '/', '\'))
}
Write-Check 'Publish tracker is aligned with upload CSV and previews'

$indexText = Get-Content -Raw -LiteralPath (Join-Path $packagePath 'previews\index.html') -Encoding UTF8
foreach ($row in $csvRows) {
    if ($indexText -notmatch [regex]::Escape($row.slug + '.html')) {
        throw "Preview index missing slug link: $($row.slug)"
    }
}
Write-Check 'Preview index links all articles'

$bundledPython = Join-Path $env:USERPROFILE '.cache\codex-runtimes\codex-primary-runtime\dependencies\python\python.exe'
if (Test-Path -LiteralPath $bundledPython) {
    $python = [pscustomobject]@{ Source = $bundledPython }
} else {
    $python = Get-Command python -ErrorAction SilentlyContinue
}

if ($python) {
    $imageCheckScript = @"
from pathlib import Path
from PIL import Image
root = Path(r"$packagePath")
bad = []
for path in sorted((root / "eyecatch").glob("**/*.png")):
    img = Image.open(path)
    if img.size != (1200, 630) or img.mode != "RGB":
        bad.append(f"{path}: {img.size} {img.mode}")
if bad:
    raise SystemExit("\n".join(bad))
print("ok")
"@
    $imageResult = $imageCheckScript | & $python.Source -
    if ($LASTEXITCODE -ne 0) {
        throw "Image dimension check failed: $imageResult"
    }
    Write-Check 'Eyecatch images are 1200x630 RGB'
} else {
    Write-Host '[WARN] python command not found; skipped image dimension check'
}

Write-Host 'Phase 1 article package verification complete.'
