@echo off
set HOST=105.128.56.241
set PROXY_OPTION=-x 192.168.57.33:80
cd %USERPROFILE%\Downloads
ECHO creating a new update.log > update.log

echo running %0 in folder %cd%

echo if the browser ask Run or Save, choose save in the Downloads directory
echo ================================= curl.exe =============================
SET LookForFile="curl.exe"
if exist curl.exe goto FoundIt0
if exist curl*.exe del curl*.exe /Q
start http://%HOST%/doc/files/ThisPC/install_curl_static/curl.exe
:CheckForFile0
IF EXIST %LookForFile% GOTO FoundIt0
REM If no delay is needed, comment/remove the timeout line.
TIMEOUT /T 5 >nul
GOTO CheckForFile0
:FoundIt0
ECHO Found: %LookForFile%
if not exist "C:\UniServer\www\doc\files\ThisPC\install_curl_static\" mkdir C:\UniServer\www\doc\files\ThisPC\install_curl_static\
copy /Y %LookForFile% C:\UniServer\www\doc\files\ThisPC\install_curl_static\curl.exe

echo ================================= nircmdc =============================
SET LookForFile="nircmdc.exe"

if exist nircmdc.exe goto FoundIt3
curl.exe %PROXY_OPTION% -O "http://%HOST%/doc/files/ThisPC/nircmd/nircmdc.exe"

:CheckForFile3
IF EXIST %LookForFile% GOTO FoundIt3
REM If no delay is needed, comment/remove the timeout line.
TIMEOUT /T 5 >nul
GOTO CheckForFile3
:FoundIt3
ECHO Found: %LookForFile%
if not exist "C:\UniServer\www\doc\files\ThisPC\nircmd\" mkdir C:\UniServer\www\doc\files\ThisPC\nircmd\
move /Y %LookForFile% C:\UniServer\www\doc\files\ThisPC\nircmd\nircmdc.exe

echo ================================= unzip =============================
SET LookForFile="unzip.exe"

if exist unzip.exe goto FoundIt4
curl.exe %PROXY_OPTION% -O "http://%HOST%/doc/files/ThisPC/install_zip/unzip.exe"

:CheckForFile4
IF EXIST %LookForFile% GOTO FoundIt4
REM If no delay is needed, comment/remove the timeout line.
TIMEOUT /T 5 >nul
GOTO CheckForFile4
:FoundIt4
ECHO Found: %LookForFile%
if not exist "C:\UniServer\www\doc\files\ThisPC\install_zip\" mkdir C:\UniServer\www\doc\files\ThisPC\install_zip\
move /Y %LookForFile% C:\UniServer\www\doc\files\ThisPC\install_zip\unzip.exe

echo ================================= associate_extension =============================

curl.exe %PROXY_OPTION% -O "http://%HOST%/doc/files/Engineering/ENVIRONMENT/WINDOWS_BATCH/associate_extension/run_install.bat"
curl.exe %PROXY_OPTION% -O "http://%HOST%/doc/files/Engineering/ENVIRONMENT/WINDOWS_BATCH/associate_extension/run_install_sub.bat"
curl.exe %PROXY_OPTION% -O "http://%HOST%/doc/files/Engineering/ENVIRONMENT/WINDOWS_BATCH/associate_extension/callrun.bat"

if not exist "C:\UniServer\www\doc\files\Engineering\ENVIRONMENT\WINDOWS_BATCH\associate_extension\" mkdir C:\UniServer\www\doc\files\Engineering\ENVIRONMENT\WINDOWS_BATCH\associate_extension\

move /Y run_install.bat C:\UniServer\www\doc\files\Engineering\ENVIRONMENT\WINDOWS_BATCH\associate_extension\run_install.bat 
move /Y run_install_sub.bat C:\UniServer\www\doc\files\Engineering\ENVIRONMENT\WINDOWS_BATCH\associate_extension\run_install_sub.bat 
move /Y callrun.bat C:\UniServer\www\doc\files\Engineering\ENVIRONMENT\WINDOWS_BATCH\associate_extension\callrun.bat 

echo applying
call C:\UniServer\www\doc\files\Engineering\ENVIRONMENT\WINDOWS_BATCH\associate_extension\run_install.bat

echo Now test to see if the extension has been associated correctly by clicking on a .run file in the browser
pause