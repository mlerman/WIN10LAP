for /f "delims=" %%a  in ("%TARGETFILE%") do set "Extension=%%~xa"

if /i "%Extension%"==".elf" ( echo %TARGETFILE% is a bin executable
start c:\"Program Files (x86)"\HxD\HxD.exe %TARGETFILE%
goto EOF
)

if /i "%Extension%"==".png" ( echo %TARGETFILE% is an image using paint
start %windir%\system32\mspaint.exe %TARGETFILE%
goto EOF
)

if /i "%Extension%"==".doc" ( echo %TARGETFILE% is a MS Word document
start %TARGETFILE%
goto EOF
)

if /i "%Extension%"==".rtf" ( echo %TARGETFILE% is a MS Word document
start %TARGETFILE%
goto EOF
)

if /i "%Extension%"==".docx" ( echo %TARGETFILE% is a MS Word document
start %TARGETFILE%
goto EOF
)

if /i "%Extension%"==".xls" ( echo %TARGETFILE% is a MS Excel document
start %TARGETFILE%
goto EOF
)

if /i "%Extension%"==".xlsx" ( echo %TARGETFILE% is a MS Excel document
start %TARGETFILE%
goto EOF
)

if /i "%Extension%"==".pot" ( echo %TARGETFILE% is a Powerpoint presentation
start %TARGETFILE%
goto EOF
)

if /i "%Extension%"==".pptx" ( echo %TARGETFILE% is a Powerpoint presentation
start %TARGETFILE%
goto EOF
)

if /i "%Extension%"==".pdf" ( echo %TARGETFILE% is a PDF file
start C:\"Program Files (x86)"\"Foxit Software"\"PDF Editor"\PDFEdit.exe %TARGETFILE%
goto EOF
)

if /i "%Extension%"==".bin" ( echo %TARGETFILE% is a binay file
start c:\UniServer\www\doc\files\Engineering\ENVIRONMENT\WINDOWS_VSTUDIO\HexEdit4\ReleaseVS2010\HexEdit.exe %TARGETFILE%
goto EOF
)

rem notepad++
if not exist "%cd%\%TARGETFILE%" copy nul %cd%\%TARGETFILE%
start c:\"Program Files (x86)"\Notepad++\notepad++.exe %cd%\%TARGETFILE%

