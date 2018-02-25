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

echo currentfolder : %currentfolder%>readme.md
echo.>>readme.md
echo parentfolder : %parentfolder%>>readme.md
echo.>>readme.md


:test
rem echo [%currentfolder% - %HOST%]^(http://%HOST%%URLDIR%open-command-prompt-here.html^)>>readme.md
set MACHINESERVING=win7-pc
echo [%currentfolder% : %MACHINESERVING%]^(http://%MACHINESERVING%/doc/files/%THISPLACESLASH%/open-command-prompt-here.html^)>>readme.md
echo.>>readme.md

set MACHINESERVING=celine-pc
echo [%currentfolder% : %MACHINESERVING%]^(http://%MACHINESERVING%/doc/files/%THISPLACESLASH%/open-command-prompt-here.html^)>>readme.md
echo [new]^(http://%MACHINESERVING%/doc/files/%THISPLACESLASH%/open-command-prompt-here.html^)>>readme.md
echo.>>readme.md

set MACHINESERVING=xsjmikhaell30
echo [%currentfolder% : %MACHINESERVING%]^(http://%MACHINESERVING%/doc/files/%THISPLACESLASH%/open-command-prompt-here.html^)>>readme.md
echo.>>readme.md

set MACHINESERVING=laptop-7kqrmtc0
echo [%currentfolder% : %MACHINESERVING%]^(http://%MACHINESERVING%/doc/files/%THISPLACESLASH%/open-command-prompt-here.html^)>>readme.md
echo.>>readme.md

echo.>>readme.md

rem pause