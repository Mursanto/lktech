$p1 = App\Models\WifiVoucher::find(1);
if ($p1) {
    $p1->harga = 18900000;
    $p1->fitur_list = "Kit Starlink: Perangkat satelit lengkap\nInstalasi: Bracket, Cabling, Aksesoris\nAP Outdoor: Access Point High End\nCloud System: Sistem hotspot & manajemen\nBiaya Bulanan: Rp 2.362.500 (Starlink + Support)";
    $p1->save();
}

$p2 = App\Models\WifiVoucher::find(2);
if ($p2) {
    $p2->fitur_list = "Paket voucher disediakan provider\nMargin Owner: Rp 2.100 (6 Jam)\nMargin Owner: Rp 5.250 (12 Jam)\nModal Minimal, Keuntungan dari Margin";
    $p2->save();
}

echo "Database updated successfully.\n";
