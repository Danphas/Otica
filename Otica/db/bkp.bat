@echo off

for /f "tokens=1-3 delims=/" %%a in ('echo %date%') do (
    set "timestamp=%%c-%%b-%%a"
)

for /f "tokens=1-2 delims=: " %%a in ('time /t') do (
    set "timestamp=!timestamp!_%%a-%%b"
)

"C:\wamp64\bin\mysql\mysql8.0.31\bin\mysqldump.exe" -u root -p db_otica > C:\temp\backup_!timestamp!.sql
