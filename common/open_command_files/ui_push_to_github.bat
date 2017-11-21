@echo off
set REPONAME=WIN10LAP
set THISDIR=%CD%

set THISPLACE=%cd%
set THISPLACE=%THISPLACE:~27,512%
set THISPLACESLASH=%THISPLACE%
set THISPLACEBACKSLASH=%THISPLACE%
set THISPLACE=%THISPLACE:\=-%

set THISPLACESLASH=%THISPLACESLASH:\=/%
echo THISPLACE=%THISPLACE%
echo THISPLACESLASH=%THISPLACESLASH%
echo THISPLACEBACKSLASH=%THISPLACEBACKSLASH%
echo REPONAME=%REPONAME%
for %%a in (.) do set currentfolder=%%~na
echo current directory name: %currentfolder%

cd c:\UniServer\www\doc\files\

if "%COMPUTERNAME%" == "LAPTOP-7KQRMTC0" ( echo this is LAPTOP-7KQRMTC0 WIN10LAP
  echo user is mlerman
  git config --global --unset http.proxy
)

if "%COMPUTERNAME%" == "WIN7-PC" ( echo this is WIN7-PC 
  echo user is mlerman
  git config --global --unset http.proxy
)

if "%COMPUTERNAME%" == "XSJMIKHAELL30" ( echo this is XSJMIKHAELL30 
  echo user is mikhaell
  git config --global http.proxy proxy:8080
)



git config --global user.email "michael_lerman@yahoo.com"
git config --global user.name "Mikhael Lerman"
git config --global core.safecrlf false
git config --global status.showUntrackedFiles no

rem remove previous add
rem ceci efface les fichier dans le repo github
rem git rm -r --cached c:\UniServer\www\doc\files\ >nul

rem focus only on the current directory
rem untrack all files except this directory
git update-index --assume-unchanged c:\UniServer\www\doc\files\*
git update-index --no-assume-unchanged %THISPLACEBACKSLASH%\*

rem add only this project and subdir
git add -A %THISPLACEBACKSLASH%\ 2>&1
call c:\UniServer\www\local\set_git_usep.bat 2>&1
git remote set-url origin https://%GITUSEP%@github.com/mlerman/%REPONAME%.git 2>&1
rem git status
rem commit only this directory
git commit -m "commit for %currentfolder% project from %COMPUTERNAME%" -- %THISPLACEBACKSLASH%\ 2>&1
rem echo username hint: ati, password hint: nrlPI
git push origin master 2>&1
rem returning to the directory
:test
cd %THISDIR%

:end
rem pause
