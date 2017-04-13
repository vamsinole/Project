$pdfFilePath = FCPATH."/downloads/reports/$filename.pdf";
$data['page_title'] = 'Hello world'; // pass data to the view
if (file_exists($pdfFilePath) == FALSE)
{
	ini_set('memory_limit','32M'); // boost the memory limit if it's low ;)
	$html = $this->load->view('pdf_report', $data, true); // render the view into HTML
	$this->load->library('pdf');
	$pdf = $this->pdf->load();
	$pdf->SetFooter($_SERVER['HTTP_HOST'].'|{PAGENO}|'.date(DATE_RFC822)); // Add a footer for good measure ;)
	$pdf->WriteHTML($html); // write the HTML into the PDF
	$pdf->Output($pdfFilePath, 'F'); // save to file because we can
}
redirect("/downloads/reports/$filename.pdf");
