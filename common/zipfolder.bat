echo %DATE%
echo %TIME%
set datetimef=%date:~-4%_%date:~3,2%_%date:~0,2%__%time:~0,2%_%time:~3,2%_%time:~6,2%
rem echo %datetimef% zipfolder.bat %0 7za.exe a -tzip -mx0 %1 %2 %3 %4 >> list

rem problem recurent dans access log je ne sais pas d'ou ca vient. avec fname == ""
rem j'ai fait un hack pour enlever ce cas dans zipfolder.php
rem fe80::a99d:7aa3:484f:c53c - - [11/Jan/2016:15:09:57 -0800] "GET /mlscript/zipfolder.php?fname=&targetdir=C:\\UniServer\\www HTTP/1.0" 200 - "-" "-"

rem c:\UniServer\www\doc\files\ThisPC\install_7zip\7za.exe a -tzip -mx0 %1 %2

rem OK plus compresse
rem c:\UniServer\www\doc\files\ThisPC\install_7zip\7za.exe a -tzip %1 %2

rem contien le full path
c:\UniServer\www\doc\files\ThisPC\install_7zip\7z.exe a -tzip -mx0 -spf2 %1 %2

