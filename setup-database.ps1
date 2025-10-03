# POS Seblak Database Setup Script
# PowerShell version of setup script

Write-Host "===============================================" -ForegroundColor Green
Write-Host "          POS SEBLAK DATABASE SETUP" -ForegroundColor Green  
Write-Host "===============================================" -ForegroundColor Green
Write-Host ""

# Check Docker
Write-Host "[1/4] Checking Docker installation..." -ForegroundColor Yellow
try {
    docker --version | Out-Null
    Write-Host "✓ Docker found" -ForegroundColor Green
}
catch {
    Write-Host "ERROR: Docker not found! Please install Docker Desktop first." -ForegroundColor Red
    Write-Host "Download from: https://www.docker.com/products/docker-desktop" -ForegroundColor Red
    Read-Host "Press Enter to exit"
    exit 1
}

Write-Host ""
Write-Host "[2/4] Setting up MySQL container..." -ForegroundColor Yellow

# Remove existing container if exists
try {
    docker stop mysql-seblak 2>$null
    docker rm mysql-seblak 2>$null
    Write-Host "Removed existing container" -ForegroundColor Cyan
}
catch {
    # Container doesn't exist, continue
}

# Create new container
try {
    docker run --name mysql-seblak -e MYSQL_ROOT_PASSWORD=mysql -e MYSQL_DATABASE=db_restoran -p 3306:3306 -d mysql:5.7
    Write-Host "✓ MySQL container created" -ForegroundColor Green
}
catch {
    Write-Host "ERROR: Failed to create MySQL container" -ForegroundColor Red
    Read-Host "Press Enter to exit"
    exit 1
}

Write-Host ""
Write-Host "[3/4] Waiting for MySQL to start (15 seconds)..." -ForegroundColor Yellow
Start-Sleep 15

Write-Host ""
Write-Host "[4/4] Importing database..." -ForegroundColor Yellow
try {
    Get-Content "web\database\db_restoran.sql" | docker exec -i mysql-seblak mysql -u root -pmysql db_restoran
    Write-Host "✓ Database setup complete" -ForegroundColor Green
}
catch {
    Write-Host "Warning: Database import might have failed" -ForegroundColor Yellow
    Write-Host "The application will still try to connect" -ForegroundColor Yellow
}

Write-Host ""
Write-Host "===============================================" -ForegroundColor Green
Write-Host "     DATABASE SETUP COMPLETED SUCCESSFULLY!" -ForegroundColor Green
Write-Host "===============================================" -ForegroundColor Green
Write-Host ""

Write-Host "Database Connection Details:" -ForegroundColor Cyan
Write-Host "Host: localhost"
Write-Host "Port: 3306" 
Write-Host "Username: root"
Write-Host "Password: mysql"
Write-Host "Database: db_restoran"
Write-Host ""

Write-Host "Login Accounts Available:" -ForegroundColor Cyan
Write-Host "- Admin: username=admin, password=123"
Write-Host "- Kasir: username=hendro, password=123"  
Write-Host "- Owner: username=lia, password=123"
Write-Host ""

Write-Host "Starting POS Seblak application..." -ForegroundColor Yellow
Write-Host ""

Read-Host "Press Enter to start the application"

# Start the application  
if (Test-Path "POS Seblak.exe") {
    Start-Process "POS Seblak.exe"
} else {
    Write-Host "POS Seblak.exe not found in current directory!" -ForegroundColor Red
    Write-Host "Please run this script from the application folder." -ForegroundColor Red
    Read-Host "Press Enter to exit"
}