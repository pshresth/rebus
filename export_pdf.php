<?php
require_once('dompdf/autoload.inc.php');
use Dompdf\Dompdf;
echo "etf";

;
   echo $content = file_get_contents("print_puzzle.php");
    if ( get_magic_quotes_gpc() )
        $content = stripslashes($content);  // remove unwanted characters

    $dompdf = new DOMPDF(); // creating dompdf object
    $dompdf->loadhtml($content); // load html data from above form
    $dompdf->setpaper('Letter', 'landscape'); // set print page type
    $dompdf->render(); // generate pdf file

    //$dompdf->stream("mypage.pdf", array("Attachment" => 0)); // save pdf file.I named it "mypage.pdf".
    $dompdf->stream();
    exit(0);

?>