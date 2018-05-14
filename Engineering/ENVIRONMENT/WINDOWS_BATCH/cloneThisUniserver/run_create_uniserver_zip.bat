@echo off
echo Creating a zip file of Uniserver 
if exist uniserver.zip del uniserver.zip /Q

rem c:\UniServer\www\doc\files\ThisPC\install_7zip\7za.exe a -tzip -mx0 -xr@exclude.txt uniserver.zip c:\UniServer\
c:\UniServer\www\doc\files\ThisPC\install_7zip\7za.exe a -tzip -mx0 -ir@include.txt uniserver.zip 
:end
