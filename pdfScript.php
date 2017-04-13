<?php
require 'pdfcrowd.php';

try
{
    // create an API client instance
    $pageWidth = 1050;
    $client = new Pdfcrowd("vamsinole", "5c014eeebd6ff3fabd732a6d851f8549");
    $pdf = $client->setPageWidth($pageWidth);
    $pdf = $client->setPageMargins(10, 10, 10, 10);
    // convert a web page and store the generated PDF into a $pdf variable
    $pdf = $client->convertURI('https://vamsinole.github.io/Project/');
    // $pdf = $client->setPageBackgroundColor('00FF00');

    // set HTTP response headers
    header("Content-Type: application/pdf");
    header("Cache-Control: max-age=0");
    header("Accept-Ranges: none");
    header("Content-Disposition: attachment; filename=\"solution.pdf\"");

    // send the generated PDF
    echo $pdf;
}
catch(PdfcrowdException $why)
{
    echo "Pdfcrowd Error: " . $why;
}
?>
