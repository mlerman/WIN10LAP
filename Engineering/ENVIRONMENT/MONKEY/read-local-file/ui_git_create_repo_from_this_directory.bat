@echo off
set THISPLACE=%cd%
set THISPLACE=%THISPLACE:~27,512%
set THISPLACE=%THISPLACE:\=-%
echo THISPLACE=%THISPLACE%
for %%a in (.) do set currentfolder=%%~na
echo current directory name: %currentfolder%

if exist .git\index echo already done & goto end
nircmdc elevate cmd /K "cd %cd% & (

git config --global user.name "Michael Lerman"
git config --global user.email "michael_lerman@yahoo.com"
git init

rem Add all files in this directory to the local list of files to be committed
for %%F in (*.*) do (
   echo adding %%F
   git add %%F
)
rem commit locally

echo commit from %currentfolder%
git commit -m "initial commit from %currentfolder%"

echo "Creating the repo on github before pushing, password hint: nrl14"
curl -u 'mlerman' https://api.github.com/user/repos -d '{"name":"%THISPLACE%"}'

rem git push origin master
git remote add origin https://github.com/mlerman/%THISPLACE%.git

echo "============================================================"
rem Put the username in the url to prevent prompting
git remote set-url origin https://mlerman@github.com/mlerman/%THISPLACE%.git

echo username hint: ati, password hint: nrl14
git push origin master

rem this was returning error:
rem error: The requested URL returned error: 403 Forbidden while accessing https://mlerman@github.com/mlerman/all_permutations_with_recursion.git/info/refs
rem fatal: HTTP request failed
rem fix: use a newer revision of git commands, the one in cygwin is not working

:end
pause
)