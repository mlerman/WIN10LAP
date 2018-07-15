for /f "tokens=1,* delims= " %%a in ("%*") do set ALL_BUT_FIRST=%%b
set %1=%ALL_BUT_FIRST%
exit /b