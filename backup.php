<?php

//$username = "prashant";
//$password = "password$2";
//$hostname = "localhost";
//$dbName   = "ics325";
//
//// if mysqldump is on the system path you do not need to specify the full path
//// simply use "mysqldump --add-drop-table ..." in this case
//$dumpFileName = $dbName . "_" . date("Y-m-d_H-i-s").".sql";
//$command = "C:\\xampp\\htdocs --add-drop-table --host=$hostname
//    --user=$username ";
//if ($password)
//    $command.= "--password=". $password ." ";
//$command.= $dbName;
//$command.= " > " . $dumpFileName;
//system($command);
//
//// zip the dump file
//$zipFileName = $dbName . "_" . date("Y-m-d_H-i-s").".zip";
//$zip = new ZipArchive();
//if($zip->open($zipFileName,ZIPARCHIVE::CREATE))
//{
//    $zip->addFile($dumpFileName,$dumpFileName);
//    $zip->close();
//}
//
//// read zip file and send it to standard output
//if (file_exists($zipFileName)) {
//    header('Content-Description: File Transfer');
//    header('Content-Type: application/octet-stream');
//    header('Content-Disposition: attachment; filename='.basename($zipFileName));
//    flush();
//    readfile($zipFileName);
//    exit;
//}

backup_tables('localhost','prashant','password$2','ics325');

/* backup the db OR just a table */
function backup_tables($host,$user,$pass,$name,$tables = '*')
{

    $link = mysqli_connect($host,$user,$pass);
    mysqli_select_db($link,$name);

    //get all of the tables
    if($tables == '*')
    {
        $tables = array();
        $result = mysqli_query($link,'SHOW TABLES');
        while($row = mysqli_fetch_row($result))
        {
            $tables[] = $row[0];
        }
    }
    else
    {
        $tables = is_array($tables) ? $tables : explode(',',$tables);
    }

    $return='';
    //cycle through
    foreach($tables as $table)
    {
        $result = mysqli_query($link,'SELECT * FROM '.$table);
        $num_fields = mysqli_num_fields($result);

        $return.= 'DROP TABLE '.$table.';';
        $row2 = mysqli_fetch_row(mysqli_query($link,'SHOW CREATE TABLE '.$table));
        $return.= "\n\n".$row2[1].";\n\n";

        for ($i = 0; $i < $num_fields; $i++)
        {
            while($row = mysqli_fetch_row($result))
            {
                $return.= 'INSERT INTO '.$table.' VALUES(';
                for($j=0; $j < $num_fields; $j++)
                {
                    $row[$j] = addslashes($row[$j]);
                    $row[$j] = preg_replace("#\n#", "\\n", $row[$j]);
                    if (isset($row[$j])) { $return.= '"'.$row[$j].'"' ; } else { $return.= '""'; }
                    if ($j < ($num_fields-1)) { $return.= ','; }
                }
                $return.= ");\n";
            }
        }
        $return.="\n\n\n";
    }

    //save file
    $today = date("m.d.y");
    $handle = fopen('c:\\xampp\\htdocs\\Backup_'.$today.'.sql','w+');
    fwrite($handle,$return);
    fclose($handle);
}
header('Location: ' . $_SERVER['HTTP_REFERER']);
?>