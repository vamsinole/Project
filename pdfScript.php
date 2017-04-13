<?php
require 'pdfcrowd.php';

try
{
    // create an API client instance
    $client = new Pdfcrowd("vamsinole", "5c014eeebd6ff3fabd732a6d851f8549");

    // convert a web page and store the generated PDF into a $pdf variable
    $pdf = $client->convertURI('http://mynewsite.local/');

    // set HTTP response headers
    header("Content-Type: application/pdf");
    header("Cache-Control: max-age=0");
    header("Accept-Ranges: none");
    header("Content-Disposition: attachment; filename=\"output.pdf\"");

    // send the generated PDF
    echo $pdf;
}
catch(PdfcrowdException $why)
{
    echo "Pdfcrowd Error: " . $why;
}
?>
