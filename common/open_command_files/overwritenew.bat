@echo off
echo running %0
set THISDIR=%CD%

set THISPLACE=%cd%
set THISPLACE=%THISPLACE:~27,512%
set THISPLACESLASH=%THISPLACE%
set THISPLACEBACKSLASH=%THISPLACE%
set THISPLACE=%THISPLACE:\=-%

set THISPLACESLASH=%THISPLACESLASH:\=/%
echo THISPLACE=%THISPLACE%
echo THISPLACESLASH=%THISPLACESLASH%
echo THISPLACEBACKSLASH=%THISPLACEBACKSLASH%

for %%a in (.) do set currentfolder=%%~na
echo current directory name: %currentfolder%


for %%a in (..) do set parentfolder=%%~na
echo parent directory name: %parentfolder%

copy c:\UniServer\www\doc\files\common\constructor_new_files\open-command-prompt-here.html c:\UniServer\www\doc\files\%THISPLACEBACKSLASH%\open-command-prompt-here.html /Y
copy c:\UniServer\www\doc\files\common\constructor_new_files\.htaccess c:\UniServer\www\doc\files\%THISPLACEBACKSLASH%\.htaccess /Y

rem pause