<?php
use App\Models\GoogleReview;
use Carbon\Carbon;

$dummyReviews = [
    [
        'google_review_id' => 'dummy_1',
        'reviewer_name' => 'Budi Santoso',
        'reviewer_photo_url' => 'https://ui-avatars.com/api/?name=Budi+Santoso&background=random',
        'star_rating' => 5,
        'review_comment' => 'Pelayanan sangat memuaskan. Beli laptop bekas tapi kualitasnya seperti baru. Garansi juga jelas.',
        'review_created_at' => Carbon::now()->subDays(2),
        'is_featured' => true,
        'review_reply' => 'Terima kasih atas ulasan positifnya, Mas Budi! Ditunggu orderan selanjutnya.'
    ],
    [
        'google_review_id' => 'dummy_2',
        'reviewer_name' => 'Siti Aisyah',
        'reviewer_photo_url' => 'https://ui-avatars.com/api/?name=Siti+Aisyah&background=random',
        'star_rating' => 5,
        'review_comment' => 'Service laptop di sini cepat banget. Kemarin mati total, sekarang udah nyala lagi. Harga juga bersahabat.',
        'review_created_at' => Carbon::now()->subDays(5),
        'is_featured' => true,
        'review_reply' => null
    ],
    [
        'google_review_id' => 'dummy_3',
        'reviewer_name' => 'Ahmad Reza',
        'reviewer_photo_url' => 'https://ui-avatars.com/api/?name=Ahmad+Reza&background=random',
        'star_rating' => 4,
        'review_comment' => 'Pilihan aksesorisnya lumayan lengkap. Mungkin bisa ditambah lagi stok untuk mouse gaming-nya.',
        'review_created_at' => Carbon::now()->subWeeks(1),
        'is_featured' => true,
        'review_reply' => 'Terima kasih sarannya, Mas Ahmad. Kami akan usahakan restock mouse gaming secepatnya.'
    ],
    [
        'google_review_id' => 'dummy_4',
        'reviewer_name' => 'Dwi Handayani',
        'reviewer_photo_url' => null, // Test fallback avatar
        'star_rating' => 5,
        'review_comment' => 'Rakit PC di LKTech mantap! Dirakit dengan rapi, kabel manajemennya bagus banget. Suhu PC juga adem.',
        'review_created_at' => Carbon::now()->subMonths(1),
        'is_featured' => true,
        'review_reply' => null
    ],
    [
        'google_review_id' => 'dummy_5',
        'reviewer_name' => 'Doni Kusuma',
        'reviewer_photo_url' => 'https://ui-avatars.com/api/?name=Doni+Kusuma&background=random',
        'star_rating' => 3,
        'review_comment' => 'Lumayan bagus, tapi pengiriman agak lambat karena hujan deras kemarin.',
        'review_created_at' => Carbon::now()->subDays(10),
        'is_featured' => false,
        'review_reply' => 'Mohon maaf atas keterlambatan pengiriman dikarenakan cuaca buruk, Kak Doni. Terima kasih masukannya.'
    ]
];

foreach ($dummyReviews as $data) {
    GoogleReview::updateOrCreate(
        ['google_review_id' => $data['google_review_id']],
        $data
    );
}

echo "Dummy data for Google Reviews seeded successfully.\n";
