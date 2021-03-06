set FSIZE=287743132
set HOST=mlerman-lap
cd %USERPROFILE%\Downloads
echo running %0 in folder %cd%

if exist curl.exe goto FoundIt0
del curl*.exe /Q
start http://mlerman-lap/doc/files/ThisPC/install_curl_static/curl.exe
SET LookForFile="curl.exe"
:CheckForFile0
IF EXIST %LookForFile% GOTO FoundIt0
REM If no delay is needed, comment/remove the timeout line.
TIMEOUT /T 5 >nul
GOTO CheckForFile0
:FoundIt0
ECHO Found: %LookForFile%

goto suiteupdate
echo Attention !!! extract to c:\
rem pause Presse Enter pour continuer

SET LookForFile="Coral_8_9_2.exe"
if exist %LookForFile% goto FoundIt

del Coral_8_9_2*.exe /Q
rem start http://mlerman-lap/doc/files/ThisPC/install_uniserver/Coral_8_9_2.exe
curl.exe -o uniserver.exe "http://mlerman-lap/doc/files/ThisPC/install_uniserver/Coral_8_9_2.exe"
rem curl.exe -o uniserver.exe "http://mlerman-lap/doc/files/ThisPC/install_uniserver/12_0_1_ZeroXII.exe"

SET LookForFile="uniserver.exe"
:CheckForFile
IF EXIST %LookForFile% GOTO FoundIt
REM If no delay is needed, comment/remove the timeout line.
TIMEOUT /T 5 >nul
GOTO CheckForFile
:FoundIt
ECHO Found: %LookForFile%

echo Attention !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! extract to c:\

%LookForFile%

:suiteupdate
rem download clone

if exist uniserver*.zip del uniserver*.zip /Q
rem start http://mlerman-lap/doc/files/Engineering/ENVIRONMENT/WINDOWS_BATCH/cloneThisUniserver/uniserver.zip 
curl.exe -O "http://mlerman-lap/doc/files/public/uniserver.zip"

SET LookForFile="uniserver.zip"
:CheckForFile2
IF EXIST %LookForFile% GOTO FoundIt2
REM If no delay is needed, comment/remove the timeout line.
TIMEOUT /T 5 >nul
GOTO CheckForFile2
:FoundIt2
ECHO Found: %LookForFile%


rem download unzip

if exist unzip.exe goto FoundIt3
del unzip*.exe /Q
rem start http://mlerman-lap/doc/files/ThisPC/install_zip/unzip.exe
curl.exe -O "http://mlerman-lap/doc/files/ThisPC/install_zip/unzip.exe"

SET LookForFile="unzip.exe"
:CheckForFile3
IF EXIST %LookForFile% GOTO FoundIt3
REM If no delay is needed, comment/remove the timeout line.
TIMEOUT /T 5 >nul
GOTO CheckForFile3
:FoundIt3
ECHO Found: %LookForFile%
:suite
unzip -o uniserver.zip -d c:\

cd c:\UniServer\
c:\UniServer\Start_as_service.exe


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
if exist Coral_8_9_2*.exe del Coral_8_9_2*.exe /Q
if exist uniserver*.exe del uniserver*.exe /Q
if exist uniserver*.zip del uniserver*.zip /Q
if exist unzip*.exe del unzip*.exe /Q


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

