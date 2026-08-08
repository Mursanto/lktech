<?php
require 'vendor/autoload.php';

use Intervention\Image\ImageManager;

$manager = new ImageManager(new Intervention\Image\Drivers\Gd\Driver());
$image = $manager->createImage(100, 100);
$encoded = $image->toWebp(80);
print_r($encoded);
