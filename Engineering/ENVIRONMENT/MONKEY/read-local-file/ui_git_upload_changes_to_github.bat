set THISPLACE=%cd%
set THISPLACE=%THISPLACE:~27,512%
set THISPLACE=%THISPLACE:\=-%
echo THISPLACE=%THISPLACE%
for %%a in (.) do set currentfolder=%%~na
echo current directory name: %currentfolder%

@echo off

git remote set-url origin https://mlerman@github.com/mlerman/%THISPLACE%.git

rem add files to local index with all subdir
git add -A . --force

rem git show
git status

git commit -m "commit from %currentfolder%"

echo username hint: ati, password hint: nrl14
git push origin master
rem Optionally, you can rebase your changes on top of the remote master (this will prevent a merge commit)
rem git pull origin master --rebase
pause
