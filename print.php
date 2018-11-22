<?php
    //author marvin direct print API

    $current_directory = getcwd();

    if(isset($_GET['get_printers'])){//this will check the request required
        // echo "Get all connected printers<br>";
        //delete existing file in the folder
        if (!unlink("printers.txt")){
            echo ("Error deleting printers.txt");
        }else{

        }

        //this command will populate the printers list
        // system("start cmd /c list_printers.bat");
        $data = shell_exec('wmic printer get name >> "'.$current_directory.'\printers.txt"');

        //get printers into an array
        $my_printers = getPrintersList();
        echo json_encode($my_printers);

    }elseif(isset($_REQUEST['printer_name'])){
        $printer_name = $_REQUEST['printer_name'];
        // echo "Commant to print";
        setPrinterNameinBatFile($_REQUEST[$printer_name]);
        createFileToPrint($_REQUEST['content']);
        // system("start cmd /c print_now.bat");
        $set_default_printer_command = 'RUNDLL32 PRINTUI.DLL,PrintUIEntry /y /n  "'.$printer_name.'"';
        $echo_off_cmd = '@echo off';
        $print_pdf_file = '"'.$current_directory.'\FoxitReader.exe" /t "filename.pdf"';

        //run commands to print
        $data = shell_exec($set_default_printer_command);
        $data = shell_exec($echo_off_cmd);
        $data = shell_exec($print_pdf_file);
        
    }else{
        echo json_encode(array(
            "title" => "error",
            "msg" => "Invalid submmit"
        ));
    }

    function createFileToPrint($html_code){
        include("mpdf/mpdf.php");

        $mpdf=new mPDF('c','A5','','',20,15,48,25,10,10); 
        $mpdf->SetTitle('Confirmation Notice');
        $mpdf->SetAuthor("Link Internet Solutions");
        $mpdf->SetDisplayMode('fullpage');

        $mpdf->WriteHTML($html_code);
        $mpdf->Output('filename.pdf','F');

        // include("html2text-master/html2text-master/html2text.php");
        // $new_text = convert_html_to_text($html_code);

        // echo $new_text;
    }


    function setPrinterNameinBatFile($printer_name){
        $file_from = fopen('print_templete.bat', 'r') or die("Unable to open file!");
        $file_to = fopen('print_now.bat', 'w') or die("Unable to open file!");
        fwrite($file_to, '');
        fclose($file_to);
        $file_to = fopen('print_now.bat', 'a') or die("Unable to open file!");
        while(! feof($file_from)){
            $new_line = fgets($file_from);
            $new_line = trim($new_line);
            if($new_line == 'RUNDLL32 PRINTUI.DLL,PrintUIEntry /y /n  "printer_name"'){
                $new_line = 'RUNDLL32 PRINTUI.DLL,PrintUIEntry /y /n  "'.$printer_name.'"' ;
            }
            fwrite($file_to, $new_line."\n");
            // if($new_line == ''){
            //     fwrite($file_to, "\n");
            // }
        }
        fclose($file_to);
    }

    function getPrintersList(){
        $list = array();
        $file = fopen('printers.txt', 'r') or die("Unable to open file!");
        // echo fread($file, filesize('printers.txt'));
        $counter = 0;
        while(! feof($file)){
            $new_line = fgets($file);
            $new_line = trim($new_line);
            $new_line = filter_var($new_line, FILTER_SANITIZE_STRING);
            if($counter != 0){
                if($new_line != ''){
                    echo '';
                    // array_push($list, $new_line);
                    $item_list = array($counter-1 == 0? 'a': $counter-1 => $new_line);
                    $list[$counter -1] = $new_line;
                    // array_push($list, $item_list);
                }
            }
            
            $counter ++;
        }
        fclose($file);
        return $list;
    }

?>