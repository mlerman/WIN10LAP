set FSIZE=35964671
set HOST=win7-pc
if "%SKIPDELETE%"=="SKIP" echo preserve previous downloads of the large zip files
echo SKIPDELETE is %SKIPDELETE%
if NOT "%SKIPDELETE%"=="SKIP" echo no
if "%SKIPDELETE%"=="SKIP" echo yes
cd %USERPROFILE%\Downloads
ECHO creating a new update.log > update.log

echo running %0 in folder %cd%
set UNISERVEREXIST=no
if exist c:\UniServer\www\local\hostname.txt set UNISERVEREXIST=yes
echo if the browser ask Run or Save, choose save
echo ================================= curl.exe =============================
if exist curl.exe goto FoundIt0
if exist curl*.exe del curl*.exe /Q
start http://%HOST%/doc/files/ThisPC/install_curl_static/curl.exe
SET LookForFile="curl.exe"
:CheckForFile0
IF EXIST %LookForFile% GOTO FoundIt0
REM If no delay is needed, comment/remove the timeout line.
TIMEOUT /T 5 >nul
GOTO CheckForFile0
:FoundIt0
ECHO Found: %LookForFile%



echo ================================= unzip.exe =============================
rem download unzip

if exist unzip.exe goto FoundIt3
if exist unzip*.exe del unzip*.exe /Q
rem start http://%HOST%/doc/files/ThisPC/install_zip/unzip.exe
curl.exe -O "http://%HOST%/doc/files/ThisPC/install_zip/unzip.exe"

SET LookForFile="unzip.exe"
:CheckForFile3
IF EXIST %LookForFile% GOTO FoundIt3
REM If no delay is needed, comment/remove the timeout line.
TIMEOUT /T 5 >nul
GOTO CheckForFile3
:FoundIt3
ECHO Found: %LookForFile%
echo ================================= zip.exe =============================
rem download zip

if exist zip.exe goto FoundIt3b
del zip*.exe /Q
rem start http://%HOST%/doc/files/ThisPC/install_zip/zip.exe
curl.exe -O "http://%HOST%/doc/files/ThisPC/install_zip/zip.exe"

SET LookForFile="zip.exe"
:CheckForFile3b
IF EXIST %LookForFile% GOTO FoundIt3b
REM If no delay is needed, comment/remove the timeout line.
TIMEOUT /T 5 >nul
GOTO CheckForFile3b
:FoundIt3b
ECHO Found: %LookForFile% >> update.log

echo ================================= uniserver.zip =============================
echo downloading uniserver.zip
echo SKIPDELETE is %SKIPDELETE%

if NOT "%SKIPDELETE%"=="SKIP" del uniserver*.zip /Q
  if exist uniserver.zip goto CheckForFile2z

rem start http://%HOST%/doc/files/Engineering/ENVIRONMENT/WINDOWS_BATCH/cloneThisUniserver/uniserver.zip 
curl.exe -O "http://%HOST%/doc/files/public/uniserver.zip"
:CheckForFile2z
SET LookForFile="uniserver.zip"
:CheckForFile2
IF EXIST %LookForFile% GOTO FoundIt2
REM If no delay is needed, comment/remove the timeout line.
TIMEOUT /T 5 >nul
GOTO CheckForFile2
:FoundIt2
ECHO Found: %LookForFile% >> update.log


echo ================================= uniserver.zXX =============================
set /a c=01
:debut
  set Var=%c%
  IF 1%Var% LSS 100 SET Var=0%c%  
  set "Var=%Var: =%"
  echo  ===z%Var%===   >> update.log
  
  echo downloading uniserver.z%Var%

  if NOT "%SKIPDELETE%"=="SKIP" del uniserver.z%Var% /Q
  if exist uniserver.z%Var% goto CheckForFile2a
  echo downloading from "http://%HOST%/doc/files/public/uniserver.z%Var%"  >> update.log
  curl.exe -O "http://%HOST%/doc/files/public/uniserver.z%Var%"
  if not ERRORLEVEL 0 goto suite

:CheckForFile2a
  echo looking for "uniserver.z%Var%"  >> update.log
  SET LookForFile="uniserver.z%Var%"
:CheckForFile2b
  IF EXIST %LookForFile% GOTO FoundIt2b
  REM If no delay is needed, comment/remove the timeout line.
  TIMEOUT /T 5 >nul
  GOTO CheckForFile2b
:FoundIt2b
  ECHO Found: %LookForFile% >> update.log

  set /a c=c+1

  for %%a in (uniserver.z%Var%) do set fileSize=%%~Za

  echo fileSize %fileSize% >> update.log

  rem set fileSize=%fileSize:~0,-3%


  rem if it is too small it must be page not found
  if %fileSize% GTR 300 goto debut

echo fileSize %fileSize% deleting uniserver.z%Var% >> update.log
del uniserver.z%Var% /Q
:suite
echo finished downloading
pause
echo unzipping >> update.log
zip -s 0 uniserver.zip --out unsplit_uniserver.zip
unzip -o unsplit_uniserver.zip -d c:\


if "%UNISERVEREXIST%" == "no" (
rem New install
rem ne marche pas toujours
::cd c:\UniServer\
::c:\UniServer\Start_as_service.exe
c:\UniServer\www\doc\files\ThisPC\nircmd\nircmdc.exe elevate c:\UniServer\usr\local\apache2\bin\httpd1.exe
pause


echo http://%HOST%>c:\UniServer\www\local\allsites.txt

echo Installing TightVNC
if exist "c:\Program Files\TightVNC\tvnserver.exe" goto fintight
msiexec /i "c:\UniServer\www\doc\files\ThisPC-NEW\install_tightvnc_silent\tightvnc-2.7.10-setup-64bit.msi" /quiet /norestart ADDLOCAL="Server,Viewer" VIEWER_ASSOCIATE_VNC_EXTENSION=1 SERVER_REGISTER_AS_SERVICE=1 SERVER_ADD_FIREWALL_EXCEPTION=1 VIEWER_ADD_FIREWALL_EXCEPTION=1 SERVER_ALLOW_SAS=1 SET_USEVNCAUTHENTICATION=1 VALUE_OF_USEVNCAUTHENTICATION=1 SET_PASSWORD=1 VALUE_OF_PASSWORD=lab123 SET_USECONTROLAUTHENTICATION=1 VALUE_OF_USECONTROLAUTHENTICATION=1 SET_CONTROLPASSWORD=1 VALUE_OF_CONTROLPASSWORD=lab123
:fintight
)


SETLOCAL ENABLEDELAYEDEXPANSION
set HOST=%COMPUTERNAME%
set HOST
CALL :LoCase HOST
SET HOST
if not exist c:\UniServer\www\local md c:\UniServer\www\local
echo %HOST%>c:\UniServer\www\local\hostname.txt
ENDLOCAL

copy c:\UniServer\www\doc\favicon.ico c:\UniServer\www\favicon.ico /Y

echo les fichiers de base on ete ecrases et remis a jour
echo Excepte hostname.txt et allsites.txt
rem pause Presse Enter pour finir

echo updated on %date% %time% >> update.txt

rem do some cleaning
if exist curl*.exe del curl*.exe /Q
if exist uniserver*.exe del uniserver*.exe /Q
if exist uniserver*.zip del uniserver*.zip /Q
if exist unzip*.exe del unzip*.exe /Q

:finished
echo finished


pause


goto:EOF
:LoCase
:: Subroutine to convert a variable VALUE to all lower case.
:: The argument for this subroutine is the variable NAME.
SET %~1=!%1:A=a!
SET %~1=!%1:B=b!
SET %~1=!%1:C=c!
SET %~1=!%1:D=d!
SET %~1=!%1:E=e!
SET %~1=!%1:F=f!
SET %~1=!%1:G=g!
SET %~1=!%1:H=h!
SET %~1=!%1:I=i!
SET %~1=!%1:J=j!
SET %~1=!%1:K=k!
SET %~1=!%1:L=l!
SET %~1=!%1:M=m!
SET %~1=!%1:N=n!
SET %~1=!%1:O=o!
SET %~1=!%1:P=p!
SET %~1=!%1:Q=q!
SET %~1=!%1:R=r!
SET %~1=!%1:S=s!
SET %~1=!%1:T=t!
SET %~1=!%1:U=u!
SET %~1=!%1:V=v!
SET %~1=!%1:W=w!
SET %~1=!%1:X=x!
SET %~1=!%1:Y=y!
SET %~1=!%1:Z=z!
GOTO:EOF

:UpCase
:: Subroutine to convert a variable VALUE to all upper case.
:: The argument for this subroutine is the variable NAME.
SET %~1=!%1:a=A!
SET %~1=!%1:b=B!
SET %~1=!%1:c=C!
SET %~1=!%1:d=D!
SET %~1=!%1:e=E!
SET %~1=!%1:f=F!
SET %~1=!%1:g=G!
SET %~1=!%1:h=H!
SET %~1=!%1:i=I!
SET %~1=!%1:j=J!
SET %~1=!%1:k=K!
SET %~1=!%1:l=L!
SET %~1=!%1:m=M!
SET %~1=!%1:n=N!
SET %~1=!%1:o=O!
SET %~1=!%1:p=P!
SET %~1=!%1:q=Q!
SET %~1=!%1:r=R!
SET %~1=!%1:s=S!
SET %~1=!%1:t=T!
SET %~1=!%1:u=U!
SET %~1=!%1:v=V!
SET %~1=!%1:w=W!
SET %~1=!%1:x=X!
SET %~1=!%1:y=Y!
SET %~1=!%1:z=Z!
GOTO:EOF

