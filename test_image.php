<?php
require 'vendor/autoload.php';

use Intervention\Image\ImageManager;

$manager = new ImageManager(new Intervention\Image\Drivers\Gd\Driver());
echo "read exists? " . (method_exists($manager, 'read') ? 'yes' : 'no') . "\n";
$methods = get_class_methods($manager);
print_r($methods);
