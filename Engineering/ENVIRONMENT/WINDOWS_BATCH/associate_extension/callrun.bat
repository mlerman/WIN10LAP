@echo off
rem check the case where we download a windows shortcut .lnk
set _test=%1
set _test=%_test:"=%
set noquote=%_test%
set _test=%_test:~-8%
echo %_test%

if /I "%_test%" neq ".lnk.run" goto suite 
  copy %1 %1.lnk /Y
  if exist %1 del %1 /Q
  echo running start %noquote%.lnk
  start %noquote%.lnk
  if exist %noquote%.lnk del %noquote%.lnk /Q
  goto end 

:suite
copy %1 %1.bat /Y
cls
call %1.bat %2 
rem c:\UniServer\www\doc\files\Engineering\ENVIRONMENT\WINDOWS_GCC\chp\chp.exe cmd.exe /c %1.bat %2
if exist %1.bat del %1.bat /Q

:end
