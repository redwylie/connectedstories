<?php

require_once('vendor/twig/twig/lib/Twig/Autoloader.php');
Twig_Autoloader::register();

$loader = new Twig_Loader_Filesystem('views');

$twig = new Twig_Environment($loader, array(
  'cache' => false,
  'auto_reload' => true,
));


$file = file_get_contents('./images.json', true);

//var_dump($file);

$json = $file;

$story = null;

$images = json_decode($json);

$categories = array();

foreach ($images->{'images'} as &$image) {
    if ($image->viewOnCategories) {
        array_push($categories, $image);
        $story = $images->story;
    };
}

$template = $twig->loadTemplate('sets.html');
echo $template->render(array(
    'categories' => $categories,
    'title' => 'Connected Stories',
    'story' => $story,
	'description' => 'Headshots, Portraits, Flowers'
));

// $template = $twig->loadTemplate('index.html');
// echo $template->render(array(
//     'images' => $images->{'images'}
// ));


//include ("cards.php")

?>