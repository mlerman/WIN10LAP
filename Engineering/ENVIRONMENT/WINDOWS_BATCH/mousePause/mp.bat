@echo off
rem echo %1
set str=%1

rem if empty put something
if %str%.==. ( set str="Press OK" )
rem echo %str%
rem pause

rem remove quote
set str=%str:"=%

echo MSGBOX "%str%", 0, "Pause" > TEMPmessage.vbs
rem call TEMPmessage.vbs
rem try with hidden console
wscript.exe TEMPmessage.vbs 


del TEMPmessage.vbs /f /q
