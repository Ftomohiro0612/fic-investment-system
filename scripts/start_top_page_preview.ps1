param(
    [int] $Port = 4291,
    [switch] $Restart,
    [switch] $Stop
)

$ErrorActionPreference = 'Stop'

$RepoRoot = Split-Path -Parent $PSScriptRoot
$WordPressRoot = Join-Path $RepoRoot 'wordpress'
$ServerFile = Join-Path $env:TEMP "fic-top-page-preview-$Port.js"

function Get-PreviewProcess {
    Get-CimInstance Win32_Process |
        Where-Object {
            $_.CommandLine -like "*fic-top-page-preview-$Port.js*" -or
            $_.CommandLine -like "*fic-preview-server-4291.js*"
        }
}

function Stop-PreviewProcess {
    $processes = Get-PreviewProcess
    foreach ($process in $processes) {
        Stop-Process -Id $process.ProcessId -Force -ErrorAction SilentlyContinue
    }
}

if ($Restart -or $Stop) {
    Stop-PreviewProcess
}

if ($Stop) {
    Write-Host "Stopped FIC preview server on port $Port."
    exit 0
}

$existing = Get-PreviewProcess
if ($existing) {
    Write-Host "FIC preview server already appears to be running."
    Write-Host "Index:      http://127.0.0.1:$Port/previews/index.html"
    Write-Host "Responsive: http://127.0.0.1:$Port/previews/responsive-qa.html"
    exit 0
}

$root = (Resolve-Path -LiteralPath $WordPressRoot).Path.Replace('\', '/')

$serverScript = @"
const http = require('http');
const fs = require('fs');
const path = require('path');

const root = '$root';
const port = $Port;
const types = {
  '.html': 'text/html; charset=utf-8',
  '.css': 'text/css; charset=utf-8',
  '.js': 'text/javascript; charset=utf-8',
  '.png': 'image/png',
  '.jpg': 'image/jpeg',
  '.jpeg': 'image/jpeg',
  '.svg': 'image/svg+xml'
};

http.createServer((req, res) => {
  let urlPath = decodeURIComponent(req.url.split('?')[0]);
  if (urlPath === '/') urlPath = '/previews/index.html';

  const filePath = path.normalize(path.join(root, urlPath));
  const safePath = filePath.replace(/\\/g, '/');

  if (!safePath.startsWith(root)) {
    res.writeHead(403);
    res.end('Forbidden');
    return;
  }

  fs.readFile(filePath, (error, data) => {
    if (error) {
      res.writeHead(404);
      res.end('Not found');
      return;
    }

    res.writeHead(200, {
      'Content-Type': types[path.extname(filePath).toLowerCase()] || 'application/octet-stream'
    });
    res.end(data);
  });
}).listen(port, '127.0.0.1');
"@

Set-Content -Path $ServerFile -Value $serverScript -Encoding UTF8
Start-Process -FilePath node -ArgumentList @($ServerFile) -WindowStyle Hidden
Start-Sleep -Seconds 2

$indexUrl = "http://127.0.0.1:$Port/previews/index.html"
$responsiveUrl = "http://127.0.0.1:$Port/previews/responsive-qa.html"

try {
    $response = Invoke-WebRequest -Uri $indexUrl -UseBasicParsing -TimeoutSec 5
    if ($response.StatusCode -ne 200) {
        throw "Unexpected HTTP status: $($response.StatusCode)"
    }
} catch {
    throw "Preview server started but health check failed: $($_.Exception.Message)"
}

Write-Host "FIC preview server started."
Write-Host "Index:      $indexUrl"
Write-Host "Responsive: $responsiveUrl"
