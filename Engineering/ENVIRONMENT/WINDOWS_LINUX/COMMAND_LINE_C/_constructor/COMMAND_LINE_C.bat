echo to be completed
echo create each file with "main" replaced with %1 

copy ThisCProject\main.c ..\%1\%1.c /Y
copy ThisCProject\ui_make.run ..\%1 /Y

echo if exist %1.exe ( echo Succeeded>>..\%1\ui_make.run
echo c:\UniServer\www\doc\files\ThisPC\nircmd\nircmdc.exe mediaplay 1500 c:\UniServer\www\doc\files\ThisPC\speech\success.mp3>>..\%1\ui_make.run
echo )>>..\%1\ui_make.run
echo call c:\UniServer\www\doc\files\Engineering\ENVIRONMENT\WINDOWS_BATCH\mousePause\mp.bat>>..\%1\ui_make.run

copy ThisCProject\ui_clean.run ..\%1 /Y
copy ThisCProject\ui_edit_makefile.run ..\%1 /Y
echo %1.exe>..\%1\ui_run.run
echo pause>>..\%1\ui_run.run
echo "c:\Program Files (x86)\Notepad++\notepad++.exe" %%cd%%\%1.c>..\%1\ui_edit_main-c.run

echo TARGET    = %1.exe>..\%1\makefile
echo OBJECT_01 = %1.o>>..\%1\makefile
echo SOURCE_01 = %1.c>>..\%1\makefile
type ThisCProject\makefiletail.txt>>..\%1\makefile

echo ./%1.exe>..\%1\run.rn
echo read -p "Press [Enter] key to continue...">>..\%1\run.rn 

c:\UniServer\www\doc\files\ThisPC\install_tofrodos\fromdos.exe -d ..\%1\run.rn

copy ThisCProject\clean.rn ..\%1 /Y
copy ThisCProject\make.rn ..\%1 /Y
