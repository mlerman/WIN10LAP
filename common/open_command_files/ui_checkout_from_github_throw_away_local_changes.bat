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
  goto done_proxy
)

if "%COMPUTERNAME%" == "WIN7-PC" ( echo this is WIN7-PC 
  echo user is mlerman
  git config --global --unset http.proxy
  goto done_proxy
)

if "%COMPUTERNAME%" == "DESKTOP-MCQS4FT" ( rem echo this is WIN7-PC 
  rem echo user is mlerman
  git config --global --unset http.proxy
  goto done_proxy
)

if "%COMPUTERNAME%" == "XSJMIKHAELL30" ( echo this is XSJMIKHAELL30 
  echo user is mikhaell
  git config --global http.proxy proxy:8080
  goto done_proxy
)

call C:\UniServer\www\doc\files\common\global_settings\HTTP_PROXY.sh.bat
call C:\UniServer\www\doc\files\common\global_settings\PROXY_PORT.sh.bat
git config --global http.proxy %HTTP_PROXY%:%PROXY_PORT%


:done_proxy

git config --global user.email "michael_lerman@yahoo.com"
git config --global user.name "Mikhael Lerman"
git config --global core.safecrlf false

rem focus only on the current directory
rem untrack all files except this directory
git update-index --assume-unchanged c:\UniServer\www\doc\files\*
git update-index --no-assume-unchanged %THISPLACEBACKSLASH%\*

rem add only this project and subdir
git add -A %THISPLACEBACKSLASH%\  
git remote set-url origin https://mlerman@github.com/mlerman/%REPONAME%.git  
git remote update 
git fetch origin 

rem a commit will delete a file in the repo
rem git commit -m "before checkout" 

git reset --hard origin/master 

git checkout HEAD %THISPLACEBACKSLASH%\ 

rem returning to the directory
:test
cd %THISDIR%

:end
rem pause
