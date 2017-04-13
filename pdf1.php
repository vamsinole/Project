use Screen\Capture;

$url = 'https://github.com';

$screenCapture = new Capture($url);
// or
$screenCapture = new Capture();
$screenCapture->setUrl($url);
$screenCapture->setWidth(1200);
$screenCapture->setHeight(800);
$screenCapture->setTop(100);
$screenCapture->setLeft(100);
$screenCapture->setClipWidth(1200);
$screenCapture->setClipHeight(800);
$screenCapture->setBackgroundColor('#ffffff');
$screenCapture->setUserAgentString('Some User Agent String');
$screenCapture->setImageType('pdf');
$localFilePath = 'script.js';
$screenCapture->includeJs(new \Screen\Injection\LocalPath($localFilePath));
$fileLocation = 'output/test';
$screenCapture->save($fileLocation);
echo $screenCapture->getImageLocation();
