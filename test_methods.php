<?php
require 'vendor/autoload.php';

use Intervention\Image\ImageManager;

$manager = new ImageManager(new Intervention\Image\Drivers\Gd\Driver());
$image = $manager->createImage(100, 100);
$methods = get_class_methods($image);
print_r($methods);
