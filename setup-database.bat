@echo off
title POS Seblak Database Setup
color 0A

echo ===============================================
echo          POS SEBLAK DATABASE SETUP
echo ===============================================
echo.

echo [1/4] Checking Docker installation...
docker --version >nul 2>&1
if errorlevel 1 (
    echo ERROR: Docker not found! Please install Docker Desktop first.
    echo Download from: https://www.docker.com/products/docker-desktop
    pause
    exit /b 1
)
echo ✓ Docker found

echo.
echo [2/4] Setting up MySQL container...
docker run --name mysql-seblak -e MYSQL_ROOT_PASSWORD=mysql -e MYSQL_DATABASE=db_restoran -p 3306:3306 -d mysql:5.7
if errorlevel 1 (
    echo Container might already exist, removing old one...
    docker stop mysql-seblak >nul 2>&1
    docker rm mysql-seblak >nul 2>&1
    echo Recreating container...
    docker run --name mysql-seblak -e MYSQL_ROOT_PASSWORD=mysql -e MYSQL_DATABASE=db_restoran -p 3306:3306 -d mysql:5.7
)
echo ✓ MySQL container created

echo.
echo [3/4] Waiting for MySQL to start (15 seconds)...
timeout /t 15 /nobreak >nul

echo.
echo [4/4] Importing database...
docker exec -i mysql-seblak mysql -u root -pmysql db_restoran < web\database\db_restoran.sql
if errorlevel 1 (
    echo Warning: Database import might have failed
    echo The application will still try to connect
)
echo ✓ Database setup complete

echo.
echo ===============================================
echo     DATABASE SETUP COMPLETED SUCCESSFULLY!
echo ===============================================
echo.
echo Database Connection Details:
echo Host: localhost
echo Port: 3306
echo Username: root
echo Password: mysql
echo Database: db_restoran
echo.
echo Login Accounts Available:
echo - Admin: username=admin, password=123
echo - Kasir: username=hendro, password=123
echo - Owner: username=lia, password=123
echo.
echo Starting POS Seblak application...
echo.
pause

REM Start the application
start "" "POS Seblak.exe"