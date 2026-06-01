#Requires -RunAsAdministrator
# setup-php.ps1 - Idempotent PHP 8.5.6 NTS setup untuk Windows 11
# Aman dijalankan berkali-kali, tidak akan duplikasi atau overwrite yang sudah benar.

$ZipName = "php-8.5.6-nts-Win32-vs17-x64.zip"
$ZipPath = "$env:USERPROFILE\Downloads\$ZipName"
$PhpDir  = "C:\php"
$PhpExe  = "$PhpDir\php.exe"
$PhpIni  = "$PhpDir\php.ini"

function Write-Step { param($msg) Write-Host "[....] $msg" -ForegroundColor Cyan }
function Write-Ok   { param($msg) Write-Host "[ OK ] $msg" -ForegroundColor Green }
function Write-Skip { param($msg) Write-Host "[SKIP] $msg" -ForegroundColor Yellow }
function Write-Fail { param($msg) Write-Host "[FAIL] $msg" -ForegroundColor Red }

Write-Host "`n=== Setup PHP 8.5.6 NTS ===" -ForegroundColor White

# --- 1. Ekstrak ZIP ----------------------------------------------------------
Write-Step "Cek instalasi PHP di $PhpDir"

if (Test-Path $PhpExe) {
    Write-Skip "php.exe sudah ada - lewati ekstrak"
} else {
    if (-not (Test-Path $ZipPath)) {
        Write-Fail "ZIP tidak ditemukan: $ZipPath"
        Write-Host "       Download dari: https://downloads.php.net/~windows/releases/archives/$ZipName"
        exit 1
    }
    Write-Step "Mengekstrak $ZipName ke $PhpDir..."
    Expand-Archive -Path $ZipPath -DestinationPath $PhpDir -Force
    Write-Ok "PHP diekstrak ke $PhpDir"
}

# --- 2. Buat php.ini ---------------------------------------------------------
Write-Step "Cek php.ini"

if (Test-Path $PhpIni) {
    Write-Skip "php.ini sudah ada"
} else {
    Copy-Item "$PhpDir\php.ini-development" $PhpIni
    Write-Ok "php.ini dibuat dari php.ini-development"
}

# --- 3. Aktifkan extension ---------------------------------------------------
Write-Step "Mengaktifkan extension yang dibutuhkan"

# openssl, curl, mbstring = DLL terpisah di NTS Windows, harus di-load eksplisit
$targets = @(
    'extension_dir = "ext"',
    'extension=openssl',
    'extension=curl',
    'extension=mbstring',
    'extension=pdo_sqlite',
    'extension=sqlite3',
    'extension=fileinfo',
    'extension=zip'
)

$content = Get-Content $PhpIni -Raw

foreach ($line in $targets) {
    $escaped = [regex]::Escape($line)
    if ($content -match "(?m)^$escaped") {
        Write-Skip "Sudah aktif  : $line"
    } elseif ($content -match "(?m)^;+\s*$escaped") {
        $content = $content -replace "(?m)^;+\s*($escaped)", '$1'
        Write-Ok "Diaktifkan   : $line"
    } else {
        $content += "`r`n$line"
        Write-Ok "Ditambahkan  : $line"
    }
}

Set-Content $PhpIni $content -NoNewline -Encoding UTF8
Write-Ok "php.ini disimpan"

# --- 4. Update System PATH ---------------------------------------------------
Write-Step "Cek PATH"

$machinePath = [System.Environment]::GetEnvironmentVariable("PATH", "Machine")
$pathEntries = $machinePath -split ";" | ForEach-Object { $_.TrimEnd("\") }

if ($pathEntries -contains "C:\php") {
    Write-Skip "C:\php sudah ada di System PATH"
} else {
    $newPath = "C:\php;" + $machinePath
    [System.Environment]::SetEnvironmentVariable("PATH", $newPath, "Machine")
    Write-Ok "C:\php ditambahkan ke System PATH"
}

$env:PATH = "C:\php;" + $env:PATH

# --- 5. Verifikasi -----------------------------------------------------------
Write-Host "`n=== Verifikasi ===" -ForegroundColor White

$ver = & "C:\php\php.exe" -v 2>&1
if ($ver -match "PHP 8\.5\.6") {
    Write-Ok "Versi OK"
} else {
    Write-Fail "Versi tidak sesuai"
}

$warn = $ver | Where-Object { $_ -match "Warning" }
if ($warn) {
    Write-Host "  Masih ada warning:" -ForegroundColor Yellow
    $warn | ForEach-Object { Write-Host "    $_" -ForegroundColor Yellow }
} else {
    Write-Ok "Tidak ada warning"
}

$modules  = & "C:\php\php.exe" -m 2>&1
$required = @("openssl", "curl", "mbstring", "pdo_sqlite", "sqlite3", "fileinfo", "zip")
foreach ($mod in $required) {
    if ($modules -contains $mod) {
        Write-Ok "Extension aktif : $mod"
    } else {
        Write-Fail "Extension tidak aktif: $mod - cek php.ini"
    }
}

Write-Host "`n=== Selesai ===" -ForegroundColor White
Write-Host "Buka terminal baru lalu jalankan: php -v"