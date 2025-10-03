# Build Script untuk POS Seblak
# Script otomatis untuk build aplikasi menjadi .exe

param(
    [string]$BuildType = "win32",
    [string]$Architecture = "ia32",
    [string]$OutputDir = "dist"
)

Write-Host "===============================================" -ForegroundColor Green
Write-Host "          POS SEBLAK BUILD SCRIPT" -ForegroundColor Green
Write-Host "===============================================" -ForegroundColor Green
Write-Host ""

# Check if node_modules exists
if (-not (Test-Path "node_modules")) {
    Write-Host "Installing dependencies..." -ForegroundColor Yellow
    npm install
}

# Check if electron-packager is installed
try {
    npx electron-packager --version | Out-Null
}
catch {
    Write-Host "Installing electron-packager..." -ForegroundColor Yellow
    npm install --save-dev electron-packager
}

# Clean previous builds
if (Test-Path $OutputDir) {
    Write-Host "Cleaning previous builds..." -ForegroundColor Yellow
    Remove-Item $OutputDir -Recurse -Force
}

# Build application
Write-Host "Building POS Seblak for $BuildType-$Architecture..." -ForegroundColor Yellow
Write-Host ""

$buildCommand = @(
    "npx", "electron-packager", ".",
    "POS Seblak",
    "--platform=$BuildType",
    "--arch=$Architecture", 
    "--out=$OutputDir",
    "--overwrite",
    "--icon=icons/logo.ico",
    "--app-version=1.0.0",
    "--build-version=1.0.0",
    "--version-string.CompanyName=Seblak Corp",
    "--version-string.FileDescription=Aplikasi Kasir Seblak",
    "--version-string.ProductName=POS Seblak",
    "--ignore=node_modules/(electron-prebuilt|electron-packager)",
    "--ignore=.git",
    "--ignore=dist",
    "--ignore=*.md",
    "--ignore=build.ps1",
    "--prune=true"
)

try {
    & $buildCommand[0] $buildCommand[1..($buildCommand.Length-1)]
    
    Write-Host ""
    Write-Host "✓ Build completed successfully!" -ForegroundColor Green
    
    # Copy setup scripts to build directory
    $buildDir = "$OutputDir\POS Seblak-$BuildType-$Architecture"
    if (Test-Path $buildDir) {
        Write-Host "Copying setup scripts..." -ForegroundColor Yellow
        Copy-Item "setup-database.bat" $buildDir -ErrorAction SilentlyContinue
        Copy-Item "setup-database.ps1" $buildDir -ErrorAction SilentlyContinue
        Copy-Item "CARA-INSTALL.txt" $buildDir -ErrorAction SilentlyContinue
        
        # Create README for distribution
        @"
# POS Seblak v1.0

## Quick Start
1. Jalankan setup-database.bat untuk setup database
2. Atau jalankan langsung POS Seblak.exe jika database sudah setup

## System Requirements
- Windows 10/11
- Docker Desktop (untuk database)
- RAM minimum 4GB
- Disk space: 500MB

## Login Accounts
- Admin: admin / 123
- Kasir: hendro / 123  
- Owner: lia / 123

## Support
GitHub: https://github.com/zakkutsu/cashier_app
"@ | Out-File "$buildDir\README.txt" -Encoding UTF8

        Write-Host "✓ Setup scripts copied" -ForegroundColor Green
        Write-Host ""
        Write-Host "Build location: $buildDir" -ForegroundColor Cyan
        Write-Host "Main executable: $buildDir\POS Seblak.exe" -ForegroundColor Cyan
        Write-Host ""
        Write-Host "To distribute:" -ForegroundColor Yellow
        Write-Host "1. Zip the entire folder: $buildDir" 
        Write-Host "2. Or create installer using electron-builder"
        Write-Host ""
        
        # Calculate size
        $size = (Get-ChildItem $buildDir -Recurse | Measure-Object -Property Length -Sum).Sum
        $sizeMB = [math]::Round($size / 1MB, 2)
        Write-Host "Total size: $sizeMB MB" -ForegroundColor Cyan
        
        # Ask to open folder
        $openFolder = Read-Host "Open build folder? (y/n)"
        if ($openFolder -eq "y" -or $openFolder -eq "Y") {
            Start-Process "explorer.exe" -ArgumentList $buildDir
        }
    }
}
catch {
    Write-Host "✗ Build failed!" -ForegroundColor Red
    Write-Host $_.Exception.Message -ForegroundColor Red
    exit 1
}

Write-Host ""
Write-Host "===============================================" -ForegroundColor Green
Write-Host "               BUILD COMPLETE!" -ForegroundColor Green
Write-Host "===============================================" -ForegroundColor Green