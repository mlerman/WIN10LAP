set FSIZE=24701918
set HOST=laptop-7kqrmtc0
echo running %0 in folder %cd% >> update.log
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



echo =============================== vc_redist.x86.exe ===========================
SET LookForFile="vc_redist.x86.exe"
if exist %LookForFile% goto FoundItVC

rem del Coral_8_9_2*.exe /Q
curl.exe -O "http://%HOST%/doc/files/ThisPC/install_Visual_Cpp_Redistributable_for_Visual_Studio_2015/vc_redist.x86.exe"

:CheckForFile
IF EXIST %LookForFile% GOTO FoundItVC
REM If no delay is needed, comment/remove the timeout line.
TIMEOUT /T 5 >nul
GOTO CheckForFile
:FoundItVC
ECHO Found: %LookForFile% >> update.log


echo TEST vc_redist.x86.exe is downloaded in to C:\UniServer\www\doc\files\ThisPC\install_uniserver
rem pause 

vc_redist.x86.exe /install /passive /norestart

rem goto skipthis1
rem it is done by ui_update_from_anywhere -----------------------------------------

echo ================================= UniServerZ.zip =============================
SET LookForFile="UniServerZ.zip"
if exist %LookForFile% goto FoundIt

rem del Coral_8_9_2*.exe /Q
curl.exe -O "http://%HOST%/doc/files/ThisPC/install_uniserver_Z/UniServerZ.zip"

:CheckForFile
IF EXIST %LookForFile% GOTO FoundIt
REM If no delay is needed, comment/remove the timeout line.
TIMEOUT /T 5 >nul
GOTO CheckForFile
:FoundIt
ECHO Found: %LookForFile% >> update.log

echo TEST UniServerZ.zip is downloaded in to C:\UniServer\www\doc\files\ThisPC\install_uniserver
rem pause 


rem 13_0_2_ZeroXIII.exe
rem move /Y c:\UniserverZ\ UniServer\..

unzip UniServerZ.zip -d c:\


echo TEST c:\UniserverZ is in to c:\UniServer
rem pause 


c:\UniServer\UniController.exe start_both
rem return to the install directory
rem cd C:\UniServer\www\doc\files\ThisPC\install_uniserver


rem pause Press Enter pour continuer
 
:suiteupdate
rem download clone

echo ================================= TightVNC =============================
echo Installing TightVNC
if exist "c:\Program Files\TightVNC\tvnserver.exe" goto fintight
msiexec /i "c:\UniServer\www\doc\files\ThisPC\install_tightvnc_silent\tightvnc-2.7.10-setup-64bit.msi" /quiet /norestart ADDLOCAL="Server,Viewer" VIEWER_ASSOCIATE_VNC_EXTENSION=1 SERVER_REGISTER_AS_SERVICE=1 SERVER_ADD_FIREWALL_EXCEPTION=1 VIEWER_ADD_FIREWALL_EXCEPTION=1 SERVER_ALLOW_SAS=1 SET_USEVNCAUTHENTICATION=1 VALUE_OF_USEVNCAUTHENTICATION=1 SET_PASSWORD=1 VALUE_OF_PASSWORD=lab123 SET_USECONTROLAUTHENTICATION=1 VALUE_OF_USECONTROLAUTHENTICATION=1 SET_CONTROLPASSWORD=1 VALUE_OF_CONTROLPASSWORD=lab123
:fintight

rem --------------------------------------------------------------------------
:skipthis1

echo ================================= share files =============================
rem interactive because it asks for user approval
c:\UniServer\www\doc\files\ThisPC\nircmd\nircmdc.exe elevate cmd /K "net share files=c:\UniServer\www\doc\files /GRANT:Everyone,FULL" 

echo ================================= other =============================
SETLOCAL ENABLEDELAYEDEXPANSION
set HOST=%COMPUTERNAME%
set HOST
CALL :LoCase HOST
SET HOST
if not exist c:\UniServer\www\local md c:\UniServer\www\local
echo %HOST%>c:\UniServer\www\local\hostname.txt
ENDLOCAL

copy c:\UniServer\www\doc\favicon.ico c:\UniServer\www\favicon.ico /Y
echo. >c:\UniServer\www\local\recent.txt

rem pause Presse Enter pour finir

echo Last update on %date% %time% >> update.txt
echo ^<br/^>Last update on %date% %time% >> c:\UniServer\www\doc\files\ThisPC\install_uniserver\.head

cd c:\UniServer\www\doc\files\ThisPC\install_total_commander\
start tcmd852ax32_64.exe

copy c:\UniServer\www\doc\files\ThisPC\install_total_commander\wincmd.key c:\totalcmd\ /Y
echo run with and associate extention with callrun.bat
echo also with chrome always open files of this type


goto skipZ
echo next extract to c:\
pause
start /WAIT c:\UniServer\www\doc\files\ThisPC\install_uniserver\13_0_2_ZeroXIII.exe

xcopy c:\UniServerZ\core c:\UniServer\core /s /Y
xcopy c:\UniServerZ\db_backup_restore c:\UniServer\db_backup_restore /s /Y
xcopy c:\UniServerZ\docs c:\UniServer\docs /s /Y
xcopy c:\UniServerZ\home c:\UniServer\home /s /Y
xcopy c:\UniServerZ\htpasswd c:\UniServer\htpasswd /s /Y
xcopy c:\UniServerZ\ssl c:\UniServer\ssl /s /Y
xcopy c:\UniServerZ\tmp c:\UniServer\tmp /s /Y
xcopy c:\UniServerZ\utils c:\UniServer\utils /s /Y
xcopy c:\UniServerZ\UniController.exe c:\UniServer\UniController.exe /Y
pause
start c:\UniServer\UniController.exe
pause
:skipZ
echo %COMPUTERNAME%
start C:\"Program Files (x86)"\Google\Chrome\Application\chrome.exe http://%COMPUTERNAME%/doc/elfinder.html


echo fini >> update.log
echo ================================= fini =============================


:finished
echo testing more 
pause



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

