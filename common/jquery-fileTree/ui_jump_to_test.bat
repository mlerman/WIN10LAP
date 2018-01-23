rem echo %computername%
rem convert to lowercase
echo %computername%| c:\cygwin64\bin\tr.exe "[A-Z]" "[a-z]" > hostnamelowercase.txt
set /p hostname=<hostnamelowercase.txt
del hostnamelowercase.txt /Q
rem echo %hostname%====

start http://%hostname%/doc/files/Engineering/ENVIRONMENT/PHP_SERVER/jquery-fileTree/index.html
