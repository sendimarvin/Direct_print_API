::Setting a default printer
RUNDLL32 PRINTUI.DLL,PrintUIEntry /y /n  ""

@echo off

::print a txt file
echo.
echo Print txt file
"C:\Program Files\Foxit Software\Foxit Reader\FoxitReader.exe" /t "filename.pdf"
