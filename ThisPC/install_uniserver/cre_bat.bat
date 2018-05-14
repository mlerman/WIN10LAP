@echo off
cls
echo Creating batch files

FOR /F "tokens=* USEBACKQ" %%F IN (`type c:\UniServer\www\local\hostname.txt`) DO (
SET var=%%F
)
ECHO %var%

set TARGETFILE=ui_update_from_anywhere.bat
copy %TARGETFILE% tmp /Y
more +2 tmp > tmp2
FOR %%I in (c:\UniServer\www\doc\files\public\uniserver.zip) do @ECHO set FSIZE=%%~zI>%TARGETFILE%
echo set HOST=%var%>>%TARGETFILE%
type tmp2>>%TARGETFILE%

set TARGETFILE=update_from_anywhere.bat.non
copy %TARGETFILE% tmp /Y
more +2 tmp > tmp2
FOR %%I in (c:\UniServer\www\doc\files\public\uniserver.zip) do @ECHO set FSIZE=%%~zI>%TARGETFILE%
echo set HOST=%var%>>%TARGETFILE%
type tmp2>>%TARGETFILE%

set TARGETFILE=ui_install_from_anywhere.bat
copy %TARGETFILE% tmp /Y
more +2 tmp > tmp2
FOR %%I in (c:\UniServer\www\doc\files\public\uniserver.zip) do @ECHO set FSIZE=%%~zI>%TARGETFILE%
echo set HOST=%var%>>%TARGETFILE%
type tmp2>>%TARGETFILE%
