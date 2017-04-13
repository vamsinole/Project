<?php
require 'pdfcrowd.php';

    try {
        // build the url and remove the pdf field from the query string
        $url = "http://127.0.0.1:8080" . $_SERVER["PHP_SELF"];
        if (count($_GET) > 1) {
            unset($_GET["pdf"]);
            $url = $url . "?" . http_build_query($_GET, '', '&');
        }

        // call the API
        $client = new Pdfcrowd("vamsinole", "5c014eeebd6ff3fabd732a6d851f8549");
        $pdf = $client->convertURI($url);

        // send the generated pdf to the browser
        header("Content-Type: application/pdf");
        header("Cache-Control: no-cache");
        header("Accept-Ranges: none");
        header("Content-Disposition: attachment; filename=\"created.pdf\"");

        echo $pdf;
    }
    catch(PdfcrowdException $why) {
        echo "PDF creation failed: ".$why."\n";
    }

    return True;
?>
