::Setting a default printer
RUNDLL32 PRINTUI.DLL,PrintUIEntry /y /n "HP LaserJet M101-M106 PCLmS"

@echo off

::print a txt file
echo.
echo Print txt file
notepad /p printers.txt