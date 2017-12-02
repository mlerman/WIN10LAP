For /f "tokens=2-4 delims=/ " %%a in ("%DATE%") do (
    SET YYYY=%%c
    SET MM=%%a
    SET DD=%%b
)
For /f "tokens=1-4 delims=/:." %%a in ("%TIME%") do (
    SET HH24=%%a
    SET MI=%%b
    SET SS=%%c
    SET FF=%%d
)
echo %%DATE%%=%DATE%
echo %%TIME%%=%TIME%
echo %YYYY%-%MM%-%DD%_%HH24%-%MI%-%SS%-%FF%
echo %YYYY%/%MM%/%DD% %HH24%:%MI%:%SS%
echo %MM%/%DD%/%YYYY% %HH24%:%MI%:%SS%
echo YYYY=%YYYY%
echo MM=%MM%
echo DD=%DD%
echo HH24=%HH24%
echo MI=%MI%
echo SS=%SS%
echo FF=%FF%

set MINEXT=%MI%
set /A MINEXT+=1
echo MINEXT=%MINEXT%


echo running %0
echo scheduling server restart at %HH24%:%MINEXT%
c:\UniServer\www\doc\files\ThisPC\nircmd\nircmdc.exe elevate at %HH24%:%MINEXT% c:\UniServer\www\doc\files\common\clean_apache_log\ui_clean.bat
echo will be done in a minute at %HH24%:%MINEXT%
