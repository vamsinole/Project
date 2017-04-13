<?php

require ('mpdf60/mpdf.php');
// $mpdf->setBasePath('http://localhost:8080');
$html_data = file_get_contents('connectors.html');
$script = file_get_contents('script.js');
// $html_data = preparePreText($html_data);
$style_data = file_get_contents("style.css");
$mpdf = new mPDF('A4','','' , 0 , 0 , 0 , 0 , 0 , 0);
// $mpdf->StartProgressBarOutput(2);
$mpdf->javascript.=$script;
$mpdf->mirrorMargins = 1;
$mpdf->bleedMargin = 4;
// Set right to left text
// $mpdf->SetDirectionality('rtl');
// Generate the table of contents from H3 elements
$mpdf->h2toc = array('H3'=>0);
// Write the stylesheet
$mpdf->WriteHTML($style_data, 1);        // The parameter 1 tells mPDF that this is CSS and not HTML
// Write the main text
$mpdf->WriteHTML($html_data, 2);
// Set the metadata
// $mpdf->SetTitle("An Example Title");
// $mpdf->SetAuthor("Cicero");
// $mpdf->SetCreator("mPDF 6.1.2");
// $mpdf->SetSubject("Lorem Ipsum");
// $mpdf->SetKeywords("Lorem, Ipsum");
// Generate the PDF file
$mpdf->Output('output.pdf', 'D');
// $page->pdfs->add("output/invoice.pdf");
// unlink("output.pdf");
exit;
?>
