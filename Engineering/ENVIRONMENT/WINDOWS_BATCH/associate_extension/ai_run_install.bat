@echo off
ftype runfile=c:\UniServer\www\doc\files\Engineering\ENVIRONMENT\WINDOWS_BATCH\associate_extension\callrun.bat "%%1" %%*
assoc .run=runfile
rem assoc .run=cmdfile
assoc .run
pause
call test.run toto titi tutu
pause
