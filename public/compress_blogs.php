<?php
// Script ini digunakan untuk mengkompresi gambar blog (.png / .jpg) menjadi .webp langsung di server hosting
// Cukup kunjungi https://lktech.online/compress_blogs.php

ini_set('max_execution_time', 300); // 5 menit
ini_set('memory_limit', '256M');

$directory = __DIR__ . '/../storage/app/public/blogs';

if (!is_dir($directory)) {
    die("Direktori tidak ditemukan: $directory");
}

$files = scandir($directory);
$count = 0;
$totalBefore = 0;
$totalAfter = 0;

echo "<h2>Mulai Kompresi Gambar Blog ke WebP</h2><ul>";

foreach ($files as $file) {
    if (in_array($file, ['.', '..'])) continue;
    
    $filePath = $directory . '/' . $file;
    $info = pathinfo($filePath);
    $ext = strtolower($info['extension'] ?? '');
    
    if (in_array($ext, ['png', 'jpg', 'jpeg'])) {
        $webpPath = $directory . '/' . $info['filename'] . '.webp';
        
        // Skip jika versi webp sudah ada
        if (file_exists($webpPath)) {
            continue;
        }
        
        $beforeSize = filesize($filePath);
        $image = null;
        
        if ($ext === 'png') {
            $image = @imagecreatefrompng($filePath);
            if ($image) {
                imagepalettetotruecolor($image);
                imagealphablending($image, true);
                imagesavealpha($image, true);
            }
        } else {
            $image = @imagecreatefromjpeg($filePath);
        }
        
        if ($image) {
            // Resize jika kebesaran (maksimal 800px)
            $width = imagesx($image);
            $height = imagesy($image);
            
            if ($width > 800) {
                $ratio = 800 / $width;
                $newHeight = $height * $ratio;
                $newImage = imagecreatetruecolor(800, $newHeight);
                
                // Transparansi untuk PNG
                if ($ext === 'png') {
                    imagealphablending($newImage, false);
                    imagesavealpha($newImage, true);
                    $transparent = imagecolorallocatealpha($newImage, 255, 255, 255, 127);
                    imagefilledrectangle($newImage, 0, 0, 800, $newHeight, $transparent);
                }
                
                imagecopyresampled($newImage, $image, 0, 0, 0, 0, 800, $newHeight, $width, $height);
                $image = $newImage;
            }
            
            // Save as WebP with 80 quality
            if (imagewebp($image, $webpPath, 80)) {
                $afterSize = filesize($webpPath);
                $totalBefore += $beforeSize;
                $totalAfter += $afterSize;
                $count++;
                
                $beforeKb = round($beforeSize / 1024);
                $afterKb = round($afterSize / 1024);
                
                echo "<li>OK: <b>$file</b> ($beforeKb KB &rarr; $afterKb KB)</li>";
            } else {
                echo "<li><span style='color:red'>Gagal menyimpan: $file</span></li>";
            }
            
            imagedestroy($image);
        } else {
            echo "<li><span style='color:red'>Gagal membaca: $file</span></li>";
        }
    }
}

echo "</ul>";

if ($count > 0) {
    $saved = round(($totalBefore - $totalAfter) / 1024);
    echo "<h3>Selesai! $count gambar berhasil dikompresi.</h3>";
    echo "<p>Total penghematan: <b>$saved KB</b></p>";
    echo "<p>Silakan uji kembali di PageSpeed Insights.</p>";
} else {
    echo "<h3>Tidak ada gambar baru yang perlu dikompresi.</h3>";
}
