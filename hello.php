<?php

    echo "My new commad \n";

    $set_default_printer_command = 'RUNDLL32 PRINTUI.DLL,PrintUIEntry /y /n  "printer_name"';
    $echo_off_cmd = '@echo off';
    $print_pdf_file = '"C:\Program Files\Foxit Software\Foxit Reader\FoxitReader.exe" /t "filename.pdf"';

    //run commands
    $data = shell_exec($set_default_printer_command);
    $data = shell_exec($echo_off_cmd);
    $data = shell_exec($print_pdf_file);
?>