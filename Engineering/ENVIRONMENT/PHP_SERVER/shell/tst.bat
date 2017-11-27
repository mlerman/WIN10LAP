echo. >input.txt
echo sleep 5 >input.txt
echo dir >>input.txt
echo call ui_test.bat >>input.txt
start cmd /c "type input.txt | cmd.exe > output"
sleep 10
echo. >>input.txt
echo. >>input.txt
echo. >>input.txt
echo. >>input.txt
echo time >> input.txt
echo. >>input.txt
echo echo "cette ligne a etait rajoutee apres le lancement de la commande">>input.txt
echo echo "ce qui prouve que cela peut se faire avec ajax">>input.txt
echo exit>> input.txt
rem sleep 10
rem voyons si la command pwd est executee
type output

