<?php

require_once('vendor/twig/twig/lib/Twig/Autoloader.php');
Twig_Autoloader::register();

$loader = new Twig_Loader_Filesystem('views');

$twig = new Twig_Environment($loader, array(
  'cache' => false,
  'auto_reload' => true,
));

$category = null;
$category = $_GET['category'];
$set = null;
$set = $_GET['set'];
$hideSetTitles = false;
$setYear = null;
$interview = null;

$file = file_get_contents('./images.json', true);

//var_dump($file);
//var_dump($photoId);

$json = $file;

$obj = json_decode($json);

//print $obj->{'images'};

$setImages = array();

foreach ($obj->{'images'} as &$image) {
    if ($image->set == $set) {
        array_push($setImages, $image);
        $setYear = $image->year;
        if($image->hideTitles == true) {
        	$hideSetTitles = true;
        }
        if($image->interview != null) {
        	$interview = $image->interview;
        }
    };
}

//var_dump($photo);
if($interview == null) {
	$template = $twig->loadTemplate('story.html');
} else {
	$template = $twig->loadTemplate('interview.html');
}

echo $template->render(array(
		'categoryTitle' => $category,
		'setTitle' => $set,
		'setYear' => $setYear,
		'images' => $setImages,
		'interview' => $interview,
		'id' => $id,
		'hideSetTitles' => $hideSetTitles,
		'view' => 'Set',
		'title' => 'Connected Stories - '.$set,
		'description' => 'Photo Essays and Projects'
	));

?>