@echo off
echo Menyiapkan aplikasi sistem penjualan web bengkel...
echo.

:: Menyalin .env.example ke .env
echo Menyalin file .env.example ke .env...
copy .env.example .env >nul
if %errorlevel% neq 0 (
    echo Gagal menyalin .env.example ke .env
    exit /b %errorlevel%
)



:: Menghasilkan kunci aplikasi
echo Menghasilkan kunci aplikasi...
php artisan key:generate
if %errorlevel% neq 0 (
    echo Gagal menghasilkan kunci aplikasi
    exit /b %errorlevel%
)


echo.
echo Setup selesai! Aplikasi siap digunakan.
pause
