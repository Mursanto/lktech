<?php
require 'vendor/autoload.php';

use Intervention\Image\ImageManager;
use Intervention\Image\Encoders\WebpEncoder;
use Intervention\Image\Drivers\Gd\Driver;

try {
    $manager = new ImageManager(new Driver());
    
    // Create a dummy file
    file_put_contents('dummy.txt', 'not an image');
    
    // test decodePath on a non-image to see if decodePath exists
    if(method_exists($manager, 'read')) {
        echo "read exists\n";
    } else {
        echo "read does not exist\n";
    }
    
    if(method_exists($manager, 'decodePath')) {
        echo "decodePath exists\n";
    }
    
    // We can't really test on an uploaded file, but we can test on a generic image path
    $image = $manager->createImage(100, 100);
    $encoded = $image->encode(new WebpEncoder(80));
    file_put_contents('dummy.webp', (string) $encoded);
    echo "Saved dummy.webp successfully";
} catch (\Exception $e) {
    echo "Exception: " . $e->getMessage();
}
