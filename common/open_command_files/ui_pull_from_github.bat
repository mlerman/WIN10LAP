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
<<<<<<< HEAD
git config --global core.sparsecheckout true
=======
>>>>>>> 676f16f6710e4bfd5aea496140d2993e716b76c0

rem remove previous add
rem ceci efface les fichier dans le repo github
rem git rm -r --cached c:\UniServer\www\doc\files\ >nul
<<<<<<< HEAD
=======
rem ceci aussi
>>>>>>> 676f16f6710e4bfd5aea496140d2993e716b76c0
rem git reset --hard origin/master


rem add only this project and subdir
git add -A %THISPLACEBACKSLASH%\  2>&1
git remote set-url origin https://mlerman@github.com/mlerman/%REPONAME%.git  2>&1
rem git status
rem git commit -m "commit for %currentfolder% project from %COMPUTERNAME%"
rem echo username hint: ati, password hint: nrl14
<<<<<<< HEAD
git pull origin master 2>&1
=======
git pull origin master --allow-unrelated-histories 2>&1
>>>>>>> 676f16f6710e4bfd5aea496140d2993e716b76c0


rem returning to the directory
:test
cd %THISDIR%

:end
<<<<<<< HEAD
rem pause
=======
rem pause
>>>>>>> 676f16f6710e4bfd5aea496140d2993e716b76c0
