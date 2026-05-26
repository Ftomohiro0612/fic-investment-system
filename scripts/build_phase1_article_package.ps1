param(
    [string] $OutputDir = 'wordpress\deploy\phase1-articles'
)

$ErrorActionPreference = 'Stop'

$RepoRoot = Split-Path -Parent $PSScriptRoot
Set-Location $RepoRoot

function Assert-InRepo {
    param([string] $Path)

    $repoFullPath = [IO.Path]::GetFullPath($RepoRoot)
    $targetFullPath = [IO.Path]::GetFullPath($Path)

    if (-not $targetFullPath.StartsWith($repoFullPath, [StringComparison]::OrdinalIgnoreCase)) {
        throw "Refusing to operate outside repository: $targetFullPath"
    }
}

function Get-ArticleMeta {
    param([string] $Path)

    $text = Get-Content -Raw -LiteralPath $Path -Encoding UTF8
    $metaMatch = [regex]::Match($text, '(?s)^\s*<!--\s*(.*?)\s*-->\s*')

    if (-not $metaMatch.Success) {
        throw "Missing metadata comment: $Path"
    }

    $metaText = $metaMatch.Groups[1].Value
    $body = $text.Substring($metaMatch.Length).Trim()
    $meta = [ordered]@{}

    foreach ($line in ($metaText -split "`r?`n")) {
        if ($line -match '^\s*([^:]+):\s*(.+?)\s*$') {
            $meta[$Matches[1].Trim()] = $Matches[2].Trim()
        }
    }

    foreach ($requiredKey in @('article_title', 'slug', 'category', 'description')) {
        if (-not $meta.Contains($requiredKey)) {
            throw "Missing metadata key `${requiredKey}` in $Path"
        }
    }

    return [pscustomobject]@{
        Title       = $meta.article_title
        Slug        = $meta.slug
        Category    = $meta.category
        Description = $meta.description
        Body        = $body
    }
}

function Escape-Csv {
    param([string] $Value)

    if ($null -eq $Value) {
        return '""'
    }

    return '"' + ($Value -replace '"', '""') + '"'
}

function Escape-Html {
    param([string] $Value)

    if ($null -eq $Value) {
        return ''
    }

    return [Net.WebUtility]::HtmlEncode($Value)
}

function Get-PublishBatch {
    param([int] $No)

    if ($No -le 5) {
        return 'batch-1-company-foundation'
    }
    if ($No -le 11) {
        return 'batch-2-theme-entry'
    }
    if ($No -le 18) {
        return 'batch-3-financial-reading'
    }

    return 'batch-4-theme-expansion'
}

function Add-AfterReadNav {
    param(
        [string] $Body,
        [string] $Group
    )

    if ($Group -eq 'theme-reading') {
        $leadHtml = '&#38306;&#36899;&#12377;&#12427;&#12486;&#12540;&#12510;&#12420;&#20225;&#26989;&#20998;&#26512;&#12408;&#24195;&#12370;&#12390;&#30906;&#35469;&#12391;&#12365;&#12414;&#12377;&#12290;'
        $links = @(
            @{ LabelHtml = '&#12486;&#12540;&#12510;&#12363;&#12425;&#25506;&#12377;'; BodyHtml = '&#26448;&#26009;&#21029;&#12395;&#24433;&#38911;&#12434;&#30906;&#35469;&#12377;&#12427;'; Url = '/themes/' },
            @{ LabelHtml = '&#20225;&#26989;&#12434;&#25506;&#12377;'; BodyHtml = '&#24433;&#38911;&#12364;&#20986;&#12427;&#20225;&#26989;&#12434;&#20491;&#21029;&#12395;&#35211;&#12427;'; Url = '/companies/' },
            @{ LabelHtml = '&#25237;&#36039;&#12398;&#35501;&#12415;&#26041;'; BodyHtml = '&#27770;&#31639;&#12420;&#25351;&#27161;&#12398;&#22522;&#30990;&#12395;&#25147;&#12387;&#12390;&#30906;&#35469;&#12377;&#12427;'; Url = '/learn/' }
        )
    } else {
        $leadHtml = '&#27770;&#31639;&#12420;&#25351;&#27161;&#12434;&#25276;&#12373;&#12360;&#12383;&#12425;&#12289;&#20225;&#26989;&#20998;&#26512;&#12420;&#12486;&#12540;&#12510;&#20998;&#26512;&#12391;&#20351;&#12387;&#12390;&#12415;&#12414;&#12377;&#12290;'
        $links = @(
            @{ LabelHtml = '&#20225;&#26989;&#12434;&#25506;&#12377;'; BodyHtml = '&#27671;&#12395;&#12394;&#12427;&#20225;&#26989;&#12398;&#20998;&#26512;&#12408;&#36914;&#12416;'; Url = '/companies/' },
            @{ LabelHtml = '&#12486;&#12540;&#12510;&#12363;&#12425;&#25506;&#12377;'; BodyHtml = '&#12491;&#12517;&#12540;&#12473;&#26448;&#26009;&#12363;&#12425;&#24433;&#38911;&#20808;&#12434;&#25506;&#12377;'; Url = '/themes/' },
            @{ LabelHtml = '&#25237;&#36039;&#12398;&#35501;&#12415;&#26041;'; BodyHtml = '&#12411;&#12363;&#12398;&#27770;&#31639;&#12539;&#25351;&#27161;&#12398;&#22522;&#30990;&#12434;&#35211;&#12427;'; Url = '/learn/' }
        )
    }

    $navLines = New-Object System.Collections.Generic.List[string]
    $navLines.Add('<section class="fic-article-after-nav" aria-label="&#27425;&#12395;&#35501;&#12416;">') | Out-Null
    $navLines.Add('<p class="fic-article-after-nav-label">&#27425;&#12395;&#35501;&#12416;</p>') | Out-Null
    $navLines.Add('<p class="fic-article-after-nav-lead">' + $leadHtml + '</p>') | Out-Null
    $navLines.Add('<div class="fic-article-after-nav-grid">') | Out-Null

    foreach ($link in $links) {
        $navLines.Add('<a href="' + (Escape-Html $link.Url) + '"><strong>' + $link.LabelHtml + '</strong><span>' + $link.BodyHtml + '</span></a>') | Out-Null
    }

    $navLines.Add('</div>') | Out-Null
    $navLines.Add('</section>') | Out-Null
    $nav = ($navLines -join "`n")

    if ($Body -match '<p class="author-credit">') {
        return $Body -replace '<p class="author-credit">', ($nav + "`n`n" + '<p class="author-credit">')
    }

    return $Body + "`n`n" + $nav
}

$resolvedOutput = Join-Path $RepoRoot $OutputDir
Assert-InRepo $resolvedOutput

if (Test-Path -LiteralPath $resolvedOutput) {
    Remove-Item -LiteralPath $resolvedOutput -Recurse -Force
}

$dirs = @(
    $resolvedOutput,
    (Join-Path $resolvedOutput 'bodies\investment-reading'),
    (Join-Path $resolvedOutput 'bodies\theme-reading'),
    (Join-Path $resolvedOutput 'eyecatch\investment-reading'),
    (Join-Path $resolvedOutput 'eyecatch\theme-reading'),
    (Join-Path $resolvedOutput 'docs'),
    (Join-Path $resolvedOutput 'metadata'),
    (Join-Path $resolvedOutput 'previews')
)

foreach ($dir in $dirs) {
    New-Item -ItemType Directory -Path $dir | Out-Null
}

$articleGroups = @(
    @{
        Group = 'investment-reading'
        SourceDir = 'wordpress\drafts\beginner_guide'
        ImageDir = 'wordpress\assets\eyecatch\investment-reading\articles'
        Slugs = @(
            'kessan-tanshin-reading-guide',
            'operating-margin-guide',
            'orders-backlog-inventory-guide',
            'roe-roic-guide',
            'segment-information-guide',
            'cash-flow-guide',
            'medium-term-plan-guide',
            'price-pass-through-guide',
            'earnings-progress-rate-guide',
            'goodwill-impairment-guide',
            'payout-ratio-total-return-guide',
            'equity-ratio-interest-bearing-debt-guide'
        )
    },
    @{
        Group = 'theme-reading'
        SourceDir = 'wordpress\drafts\theme_entry'
        ImageDir = 'wordpress\assets\eyecatch\theme-reading\articles'
        Slugs = @(
            'interest-rate-impact-stocks',
            'fx-impact-company-earnings',
            'raw-material-cost-pass-through',
            'semiconductor-investment-supply-chain',
            'policy-subsidy-investment-theme',
            'energy-transition-power-investment',
            'labor-shortage-automation-investment',
            'price-hike-consumer-demand',
            'inbound-demand-company-impact',
            'defense-security-investment-theme',
            'logistics-reform-2024-problem'
        )
    }
)

$rows = New-Object System.Collections.Generic.List[object]
$publishNumber = 1

foreach ($group in $articleGroups) {
    foreach ($slug in $group.Slugs) {
        $sourcePath = Join-Path $RepoRoot (Join-Path $group.SourceDir ($slug + '.html'))
        $imagePath = Join-Path $RepoRoot (Join-Path $group.ImageDir ($slug + '.png'))

        if (-not (Test-Path -LiteralPath $sourcePath)) {
            throw "Missing article source: $sourcePath"
        }
        if (-not (Test-Path -LiteralPath $imagePath)) {
            throw "Missing eyecatch image: $imagePath"
        }

        $meta = Get-ArticleMeta -Path $sourcePath
        if ($meta.Slug -ne $slug) {
            throw "Slug mismatch in ${sourcePath}: expected $slug, got $($meta.Slug)"
        }

        $bodyTargetRel = Join-Path ('bodies\' + $group.Group) ($slug + '.html')
        $imageTargetRel = Join-Path ('eyecatch\' + $group.Group) ($slug + '.png')
        $bodyTarget = Join-Path $resolvedOutput $bodyTargetRel
        $imageTarget = Join-Path $resolvedOutput $imageTargetRel

        $bodyWithNav = Add-AfterReadNav -Body $meta.Body -Group $group.Group
        Set-Content -LiteralPath $bodyTarget -Value $bodyWithNav -NoNewline -Encoding UTF8
        Copy-Item -LiteralPath $imagePath -Destination $imageTarget -Force

        $rows.Add([pscustomobject]@{
            No = $publishNumber
            Group = $group.Group
            Title = $meta.Title
            Slug = $meta.Slug
            Category = $meta.Category
            Description = $meta.Description
            BodyFile = ($bodyTargetRel -replace '\\', '/')
            EyecatchFile = ($imageTargetRel -replace '\\', '/')
        }) | Out-Null

        $publishNumber++
    }
}

$publishOrder = @(
    'kessan-tanshin-reading-guide',
    'operating-margin-guide',
    'orders-backlog-inventory-guide',
    'roe-roic-guide',
    'segment-information-guide',
    'interest-rate-impact-stocks',
    'fx-impact-company-earnings',
    'raw-material-cost-pass-through',
    'semiconductor-investment-supply-chain',
    'policy-subsidy-investment-theme',
    'logistics-reform-2024-problem',
    'cash-flow-guide',
    'medium-term-plan-guide',
    'price-pass-through-guide',
    'earnings-progress-rate-guide',
    'goodwill-impairment-guide',
    'payout-ratio-total-return-guide',
    'equity-ratio-interest-bearing-debt-guide',
    'energy-transition-power-investment',
    'labor-shortage-automation-investment',
    'price-hike-consumer-demand',
    'inbound-demand-company-impact',
    'defense-security-investment-theme'
)

$rowsBySlug = @{}
foreach ($row in $rows) {
    $rowsBySlug[$row.Slug] = $row
}

$orderedRows = New-Object System.Collections.Generic.List[object]
for ($i = 0; $i -lt $publishOrder.Count; $i++) {
    $slug = $publishOrder[$i]
    if (-not $rowsBySlug.ContainsKey($slug)) {
        throw "Publish order references missing slug: $slug"
    }

    $row = $rowsBySlug[$slug]
    $row.No = $i + 1
    $orderedRows.Add($row) | Out-Null
}

if ($orderedRows.Count -ne $rows.Count) {
    throw "Publish order count mismatch: expected $($rows.Count), got $($orderedRows.Count)"
}

$rows = $orderedRows

$csvLines = New-Object System.Collections.Generic.List[string]
$csvLines.Add('no,group,title,slug,category,description,body_file,eyecatch_file') | Out-Null
$trackerLines = New-Object System.Collections.Generic.List[string]
$trackerLines.Add('no,batch,status,title,slug,category,body_file,eyecatch_file,preview_file,description,published_url,published_date,notes') | Out-Null

foreach ($row in $rows) {
    $csvLines.Add((@(
        $row.No,
        (Escape-Csv $row.Group),
        (Escape-Csv $row.Title),
        (Escape-Csv $row.Slug),
        (Escape-Csv $row.Category),
        (Escape-Csv $row.Description),
        (Escape-Csv $row.BodyFile),
        (Escape-Csv $row.EyecatchFile)
    ) -join ',')) | Out-Null

    $trackerLines.Add((@(
        $row.No,
        (Escape-Csv (Get-PublishBatch -No $row.No)),
        (Escape-Csv 'todo'),
        (Escape-Csv $row.Title),
        (Escape-Csv $row.Slug),
        (Escape-Csv $row.Category),
        (Escape-Csv $row.BodyFile),
        (Escape-Csv $row.EyecatchFile),
        (Escape-Csv ('previews/' + $row.Slug + '.html')),
        (Escape-Csv $row.Description),
        (Escape-Csv ''),
        (Escape-Csv ''),
        (Escape-Csv '')
    ) -join ',')) | Out-Null
}

Set-Content -LiteralPath (Join-Path $resolvedOutput 'metadata\phase1-article-upload.csv') -Value $csvLines -Encoding UTF8
Set-Content -LiteralPath (Join-Path $resolvedOutput 'metadata\phase1-article-publish-tracker.csv') -Value $trackerLines -Encoding UTF8

Copy-Item -LiteralPath (Join-Path $RepoRoot 'docs\phase1_publication_matrix.md') -Destination (Join-Path $resolvedOutput 'docs\phase1_publication_matrix.md') -Force
Copy-Item -LiteralPath (Join-Path $RepoRoot 'docs\phase1_wordpress_publish_checklist.md') -Destination (Join-Path $resolvedOutput 'docs\phase1_wordpress_publish_checklist.md') -Force

$readme = @(
    '# FIC Phase 1 Article Publish Package',
    '',
    "Generated: $(Get-Date -Format 'yyyy-MM-dd HH:mm:ss')",
    '',
    '## Contents',
    '',
    '- `bodies/`: WordPress-ready article HTML. The leading management metadata comment has been removed.',
    '- `eyecatch/`: Per-article featured images.',
    '- `metadata/phase1-article-upload.csv`: title, slug, category, description, body file, and image file.',
    '- `metadata/phase1-article-publish-tracker.csv`: batch-by-batch publishing tracker with status and published URL fields.',
    '- `previews/`: local static preview pages for all articles.',
    '- `docs/phase1_publication_matrix.md`: source publication matrix.',
    '- `docs/phase1_wordpress_publish_checklist.md`: publishing order and checks.',
    '',
    '## Recommended Workflow',
    '',
    '1. Follow the batches in `docs/phase1_wordpress_publish_checklist.md`.',
    '2. Use `metadata/phase1-article-upload.csv` to confirm title, slug, category, and description.',
    '3. Paste the matching file from `bodies/` into the WordPress post body.',
    '4. Set the matching PNG from `eyecatch/` as the featured image.',
    '5. Track status and published URLs in `metadata/phase1-article-publish-tracker.csv` or `docs/phase1_wordpress_publish_checklist.md`.',
    '',
    '## Local Preview',
    '',
    'After starting the local preview server, open:',
    '',
    '- http://127.0.0.1:4291/deploy/phase1-articles/previews/index.html',
    '',
    '## Counts',
    '',
    "- Total articles: $($rows.Count)",
    "- Investment reading: $(($rows | Where-Object { $_.Group -eq 'investment-reading' }).Count)",
    "- Theme reading: $(($rows | Where-Object { $_.Group -eq 'theme-reading' }).Count)"
)

Set-Content -LiteralPath (Join-Path $resolvedOutput 'README.md') -Value $readme -Encoding UTF8

$previewCss = @(
    'body { margin: 0; background: #f5f6f8; color: #17191f; font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif; line-height: 1.8; }',
    'a { color: inherit; }',
    '.wrap { width: min(1040px, calc(100% - 32px)); margin: 0 auto; padding: 32px 0 56px; }',
    '.hero { background: #111318; color: #fff; border-bottom: 5px solid #ffd400; padding: 28px; margin-bottom: 24px; }',
    '.hero p { color: #d7dde8; margin: 8px 0 0; }',
    '.grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 14px; }',
    '.card { display: block; background: #fff; border: 1px solid #dfe3ea; border-radius: 8px; overflow: hidden; text-decoration: none; box-shadow: 0 10px 28px rgba(15, 23, 42, .08); }',
    '.card img { width: 100%; aspect-ratio: 1200 / 630; object-fit: cover; display: block; }',
    '.card div { padding: 14px; }',
    '.card span, .meta { color: #8a6f00; font-size: 12px; font-weight: 800; text-transform: uppercase; letter-spacing: .04em; }',
    '.card strong { display: block; font-size: 17px; line-height: 1.5; margin-top: 6px; }',
    '.article { background: #fff; padding: 28px; border: 1px solid #dfe3ea; border-radius: 8px; }',
    '.article img.eyecatch { width: 100%; border-radius: 8px; margin-bottom: 24px; display: block; }',
    '.article h1 { font-size: 34px; line-height: 1.35; margin: 6px 0 14px; }',
    '.article h2 { border-left: 6px solid #ffd400; padding-left: 12px; margin-top: 34px; }',
    '.article table { width: 100%; border-collapse: collapse; }',
    '.article th, .article td { border: 1px solid #dfe3ea; padding: 10px; vertical-align: top; }',
    '.article th { background: #f7f8fb; }',
    '.one-liner-summary, .summary-box, .definition-lead, .beginner-box, .formula-box { background: #f7f8fb; border-left: 5px solid #ffd400; padding: 14px 16px; margin: 18px 0; }',
    '.fic-article-after-nav { margin: 38px 0 22px; padding: 22px; background: linear-gradient(135deg, #111318 0%, #1b1b1f 58%, #4c4100 100%); border-bottom: 5px solid #ffd400; color: #fff; }',
    '.fic-article-after-nav-label { margin: 0 0 8px; color: #ffd400; font-size: 12px; font-weight: 900; letter-spacing: .08em; text-transform: uppercase; }',
    '.fic-article-after-nav-lead { margin: 0 0 16px; color: #edf1f7; font-weight: 700; }',
    '.fic-article-after-nav-grid { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 10px; }',
    '.fic-article-after-nav a { display: block; min-height: 96px; padding: 14px; background: rgba(255,255,255,.08); border: 1px solid rgba(255,212,0,.32); color: #fff; text-decoration: none; }',
    '.fic-article-after-nav strong, .fic-article-after-nav span { display: block; }',
    '.fic-article-after-nav strong { margin-bottom: 6px; color: #ffd400; font-size: 17px; line-height: 1.45; }',
    '.fic-article-after-nav span { color: #d7dde8; font-size: 14px; line-height: 1.65; }',
    '@media (max-width: 760px) { .article { padding: 18px; } .article h1 { font-size: 26px; } .fic-article-after-nav { padding: 18px; } .fic-article-after-nav-grid { grid-template-columns: 1fr; } .fic-article-after-nav a { min-height: auto; } }',
    '.back { display: inline-block; margin-bottom: 18px; color: #8a6f00; font-weight: 800; text-decoration: none; }'
)
Set-Content -LiteralPath (Join-Path $resolvedOutput 'previews\preview.css') -Value $previewCss -Encoding UTF8

$indexCards = New-Object System.Collections.Generic.List[string]

foreach ($row in $rows) {
    $bodyPath = Join-Path $resolvedOutput ($row.BodyFile -replace '/', '\')
    $bodyHtml = Get-Content -Raw -LiteralPath $bodyPath -Encoding UTF8
    $previewFileName = $row.Slug + '.html'
    $imageSrc = '../' + $row.EyecatchFile

    $articlePage = @(
        '<!doctype html>',
        '<html lang="ja">',
        '<head>',
        '  <meta charset="utf-8">',
        '  <meta name="viewport" content="width=device-width, initial-scale=1">',
        '  <title>' + (Escape-Html $row.Title) + '</title>',
        '  <meta name="description" content="' + (Escape-Html $row.Description) + '">',
        '  <link rel="stylesheet" href="preview.css">',
        '</head>',
        '<body>',
        '  <main class="wrap">',
        '    <a class="back" href="index.html">Back to preview index</a>',
        '    <article class="article">',
        '      <img class="eyecatch" src="' + (Escape-Html $imageSrc) + '" alt="">',
        '      <p class="meta">' + (Escape-Html $row.Category) + ' / ' + (Escape-Html $row.Slug) + '</p>',
        '      <h1>' + (Escape-Html $row.Title) + '</h1>',
        $bodyHtml,
        '    </article>',
        '  </main>',
        '</body>',
        '</html>'
    )

    Set-Content -LiteralPath (Join-Path $resolvedOutput ('previews\' + $previewFileName)) -Value $articlePage -Encoding UTF8

    $indexCards.Add(
        '<a class="card" href="' + (Escape-Html $previewFileName) + '"><img src="' + (Escape-Html $imageSrc) + '" alt=""><div><span>' +
        (Escape-Html ($row.No.ToString() + ' / ' + $row.Category)) + '</span><strong>' + (Escape-Html $row.Title) + '</strong></div></a>'
    ) | Out-Null
}

$indexPage = @(
    '<!doctype html>',
    '<html lang="ja">',
    '<head>',
    '  <meta charset="utf-8">',
    '  <meta name="viewport" content="width=device-width, initial-scale=1">',
    '  <title>FIC Phase 1 Article Preview</title>',
    '  <link rel="stylesheet" href="preview.css">',
    '</head>',
    '<body>',
    '  <main class="wrap">',
    '    <section class="hero">',
    '      <p class="meta">FIC Phase 1</p>',
    '      <h1>Article Preview Index</h1>',
    '      <p>WordPress publication preview for investment-reading and theme-reading articles.</p>',
    '    </section>',
    '    <section class="grid">',
    ($indexCards -join "`n"),
    '    </section>',
    '  </main>',
    '</body>',
    '</html>'
)
Set-Content -LiteralPath (Join-Path $resolvedOutput 'previews\index.html') -Value $indexPage -Encoding UTF8

Write-Host "Phase 1 article package built: $resolvedOutput"
Write-Host "Articles: $($rows.Count)"
