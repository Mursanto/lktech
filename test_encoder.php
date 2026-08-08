<?php
require 'vendor/autoload.php';

use Intervention\Image\ImageManager;
use Intervention\Image\Encoders\WebpEncoder;

$manager = new ImageManager(new Intervention\Image\Drivers\Gd\Driver());
$image = $manager->createImage(100, 100);
$encoded = $image->encode(new WebpEncoder(80));
print_r(get_class($encoded));
