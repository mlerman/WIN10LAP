@echo off
set REPONAME=WIN10LAP
set THISDIR=%CD%

set THISPLACE=%cd%
set THISPLACE=%THISPLACE:~27,512%
set THISPLACESLASH=%THISPLACE%
set THISPLACEBACKSLASH=%THISPLACE%
set THISPLACE=%THISPLACE:\=-%

set THISPLACESLASH=%THISPLACESLASH:\=/%
rem echo THISPLACE=%THISPLACE%
rem echo THISPLACESLASH=%THISPLACESLASH%
rem echo THISPLACEBACKSLASH=%THISPLACEBACKSLASH%
rem echo REPONAME=%REPONAME%
for %%a in (.) do set currentfolder=%%~na
rem echo current directory name: %currentfolder%


cd c:\UniServer\www\doc\files\

if "%COMPUTERNAME%" == "LAPTOP-7KQRMTC0" ( rem echo this is LAPTOP-7KQRMTC0 WIN10LAP
  rem echo user is mlerman
  git config --global --unset http.proxy
)

if "%COMPUTERNAME%" == "WIN7-PC" ( rem echo this is WIN7-PC 
  rem echo user is mlerman
  git config --global --unset http.proxy
)

if "%COMPUTERNAME%" == "DESKTOP-MCQS4FT" ( rem echo this is WIN7-PC 
  rem echo user is mlerman
  git config --global --unset http.proxy
)

if "%COMPUTERNAME%" == "XSJMIKHAELL30" ( rem echo this is XSJMIKHAELL30 
  rem echo user is mikhaell
  git config --global http.proxy proxy:8080
)


git config --global user.email "michael_lerman@yahoo.com"
git config --global user.name "Mikhael Lerman"
git config --global core.safecrlf false
git config --global core.autocrlf false
git config --global core.sparsecheckout true

rem remove previous add
rem ceci efface les fichier dans le repo github
rem git rm -r --cached c:\UniServer\www\doc\files\ >nul
rem git reset --hard origin/master

rem focus only on the current directory
rem untrack all files except this directory
git update-index --assume-unchanged c:\UniServer\www\doc\files\*
git update-index --no-assume-unchanged %THISPLACEBACKSLASH%\*


rem add only this project and subdir
git add -A %THISPLACEBACKSLASH%\  2>&1
call c:\UniServer\www\local\set_git_usep.bat
git remote set-url origin https://%GITUSEP%@github.com/mlerman/%REPONAME%.git  2>&1
rem git status
rem git commit -m "commit for %currentfolder% project from %COMPUTERNAME%"
rem echo username hint: ati, password hint: nrl14
git pull origin master 2>&1


rem returning to the directory
:test
cd %THISDIR%

:end
rem pause
