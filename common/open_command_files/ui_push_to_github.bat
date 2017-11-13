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
rem goto test

#git config --global http.proxy proxy:8080
git config --global user.email "michael_lerman@yahoo.com"
git config --global user.name "Mikhael Lerman"

git add -A %THISPLACEBACKSLASH%\ 2>&1
git remote set-url origin https://mlerman@github.com/mlerman/%REPONAME%.git 2>&1
rem git status
git commit -m "commit for %currentfolder% project from %COMPUTERNAME%"  2>&1
rem echo username hint: ati, password hint: nrlPI
git push origin master 2>&1
rem returning to the directory
:test
cd %THISDIR%

:end
rem pause
