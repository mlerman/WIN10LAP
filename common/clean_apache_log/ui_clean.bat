cd c:\UniServer\www\common\clean_apache_log\
rem stop uniserver to remove large log file
echo stopping apache
call stopapache.bat
echo deleting log files
del c:\UniServer\usr\local\apache2\logs\access.log /Q
del c:\UniServer\usr\local\apache2\logs\error.log /Q
echo starting apache
call startapache.bat
echo done