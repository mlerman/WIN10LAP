set THISPLACE=%cd%
set THISPLACE=%THISPLACE:~27,512%
set THISPLACE=%THISPLACE:\=-%
echo THISPLACE=%THISPLACE%
for %%a in (.) do set currentfolder=%%~na
echo current directory name: %currentfolder%
@echo off

git remote set-url origin https://mlerman@github.com/mlerman/%THISPLACE%.git

git pull origin master
pause
