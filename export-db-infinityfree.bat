@echo off
REM Database Export for InfinityFree
echo Exporting database for InfinityFree deployment...

REM Set your XAMPP MySQL path
set MYSQL_PATH=C:\xampp\mysql\bin

REM Set database credentials
set DB_HOST=localhost
set DB_USER=root
set DB_PASS=mysql2006
set DB_NAME=auraedition

REM Create exports directory
if not exist exports mkdir exports

REM Get timestamp
for /f "tokens=2 delims==" %%a in ('wmic OS Get localdatetime /value') do set "dt=%%a"
set "YYYY=%dt:~2,2%"
set "MM=%dt:~4,2%"
set "DD=%dt:~6,2%"
set "HH=%dt:~8,2%"
set "Min=%dt:~10,2%"
set "Sec=%dt:~12,2%"
set "datestamp=%YYYY%-%MM%-%DD%_%HH%-%Min%-%Sec%"

REM Export schema
"%MYSQL_PATH%\mysqldump.exe" -h %DB_HOST% -u %DB_USER% -p%DB_PASS% --no-data --single-transaction --routines --triggers --skip-comments %DB_NAME% > exports\schema.sql

REM Export data
"%MYSQL_PATH%\mysqldump.exe" -h %DB_HOST% -u %DB_USER% -p%DB_PASS% --no-create-info --single-transaction --skip-comments %DB_NAME% > exports\auraedition_data_%datestamp%.sql

echo Database exported successfully!
echo Files created:
echo - exports\schema.sql
echo - exports\auraedition_data_%datestamp%.sql
pause
