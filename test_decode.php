<?php
require 'vendor/autoload.php';

use Intervention\Image\ImageManager;

$manager = new ImageManager(new Intervention\Image\Drivers\Gd\Driver());
$image = $manager->decode('https://via.placeholder.com/150');
$methods = get_class_methods($image);
print_r($methods);
