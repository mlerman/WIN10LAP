<# : chooser.bat
:: launches a File... Open sort of file chooser and outputs choice(s) to the console
:: http://stackoverflow.com/a/15885133/1683264

@echo off
set /a CTR=0
for /f "delims=" %%I in ('powershell -noprofile "iex (${%~f0} | out-string)"') do (
    rem echo You chose %%~I
    set SELECTED!CTR!=%%~I
    echo !CTR!
    set /a CTR=CTR+1
)
goto :EOF

: end Batch portion / begin PowerShell hybrid chimera #>

Add-Type -AssemblyName System.Windows.Forms
$f = new-object Windows.Forms.OpenFileDialog
$f.InitialDirectory = pwd
$f.Filter = "PDF Files (*.pdf)|*.pdf"
$f.ShowHelp = $true
$f.Multiselect = $true
[void]$f.ShowDialog()
if ($f.Multiselect) { $f.FileNames } else { $f.FileName }