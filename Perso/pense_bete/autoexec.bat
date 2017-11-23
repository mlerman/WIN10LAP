@echo off
if exist get_counter.bat call get_counter.bat
set /A COUNTER+=1
echo %COUNTER%
echo %COUNTER% > .outtop
echo set COUNTER=%COUNTER% >get_counter.bat
rem start c:\UniServer\www\doc\files\ThisPC\install_notify-send\notify-send.exe -i important "Attention!" "The counter is %COUNTER%"

