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

rem remove previous add
git rm -r --cached c:\UniServer\www\doc\files\ >nul
rem add only this project and subdir
git add -A %THISPLACEBACKSLASH%\  2>&1
git remote set-url origin https://mlerman@github.com/mlerman/%REPONAME%.git  2>&1
rem git status
rem git commit -m "commit for %currentfolder% project from %COMPUTERNAME%"
rem echo username hint: ati, password hint: nrl14
git pull origin master --allow-unrelated-histories 2>&1


rem returning to the directory
:test
cd %THISDIR%

:end
rem pause