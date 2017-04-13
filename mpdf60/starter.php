<?php

//include the mpdf.php main file
include("/mpdf.php");

//get the URL people will be printing from. It changes every time so we do a PHP request
$url = urldecode($_REQUEST['url']);

// To prevent anyone else using our script to create PDF files, we allow only a domain-based action
//change the url to yours
if (!preg_match('/^http:\/\/www\.your-website\.com/', $url)) { die("Access denied"); }

// For $_POST i.e. forms with fields
if (count($_POST)>0) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_HEADER, 0);
      curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1 );
    foreach($_POST AS $name=>$post) {
        $formvars = array($name=>$post." \n");
    }
    curl_setopt($ch, CURLOPT_POSTFIELDS, $formvars);
    $html = curl_exec($ch);
    curl_close($ch);
}
else if (ini_get('allow_url_fopen')) {
    $html = file_get_contents($url);
}
else {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_HEADER, 0);
      curl_setopt ( $ch , CURLOPT_RETURNTRANSFER , 1 );
    $html = curl_exec($ch);
    curl_close($ch);
}

//here we initialize mPDF, and choose 'c' to include core PDF fonts
$mpdf=new mPDF('c');

//we call the stylesheet we'll be using. Change it to your URL. In this case we place the stylesheet on the theme's directory.
$stylesheet = file_get_contents('http://your-website/wp-content/themes/my-theme/css/mpdf.css');

//now let's queue the stylesheet. The parameter 1 tells that this is a css/style only inclusion (no html)
$mpdf->WriteHTML($stylesheet,1);

//let's add some pagination
$mpdf->SetHeader($url.'||Page {PAGENO}');  // optional - just as an example

//we retrieve the URL
$mpdf->setBasePath($url);

//we load the page's HTML: caution! very large pages won't parse properly and may result in an error. make sure your HTML is well-written, and compact enough
$mpdf->WriteHTML($html,0);

//we find the page's title
if (preg_match('/<title>(.+)<\/title>/', file_get_contents($url),$matches) && isset($matches[1]) ){
 $title = $matches[1];
}else{
 $title = $url;
}

//we finally Output everything. We add title, extension, and the 'D' parameter, that means generating a file ready for download -instead of, for example, inlining the PDF on the browser, which is possible as well
$mpdf->Output($title.'.pdf','D');

exit;

?>
