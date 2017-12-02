@echo off
echo running %0
set THISPLACE=%1
rem substring from /doc
set THISPLACE=%THISPLACE:~16,512%
rem change backslash characters into -
set THISPLACE=%THISPLACE:\=/%
echo THISPLACE=%THISPLACE%

for %%a in (.) do set currentfolder=%%~na
echo current directory name: %currentfolder%

for %%a in (..) do set parentfolder=%%~na
echo parent directory name: %parentfolder%

rem remove substring /%currentfolder% from THISPLACE
set THISPLACE=%THISPLACE:/_constructor=%
echo THISPLACE=%THISPLACE%

echo Running new.bat THISPLACE=%THISPLACE% 
if "%2" == "" ( echo usage new ^<project_and_directory_name^>
goto end
)
if exist ..\%2\*.* ( echo The directory already exist.
goto end
)
echo New project: %2
md ..\%2
copy c:\UniServer\www\doc\files\common\constructor_new_files\.htaccess ..\%2 /Y
copy c:\UniServer\www\doc\files\common\constructor_new_files\open-command-prompt-here.html ..\%2 /Y

rem if there is specific initialization to this project run it now
if exist %parentfolder%.bat call %parentfolder%.bat %2 %3 %4 %5 %6 %7 %8 %9

if exist favicon.ico copy favicon.ico ..\%2 /Y

if exist copy_over_those_files\*.* ( echo copying directory copy_over_those_files
xcopy copy_over_those_files\*.* ..\%2\ /Y /s
)

rem adding the project in the link section
echo ^<a href=^"%THISPLACE%/%2/open-command-prompt-here.html^" target=^"%2^" ^>%2^</a^>^<br/^> >.links
rem pause
rem start C:\"Program Files (x86)"\Google\Chrome\Application\chrome.exe http://mlerman-lap%THISPLACE%/../%2/open-command-prompt-here.html


:end
