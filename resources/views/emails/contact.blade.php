<p>Halo Tim Sales LKTech,</p>

<p>Anda menerima pesan baru dari pengunjung Katalog Publik LKTech TN SEREAL.</p>

<table style="width: 100%; border-collapse: collapse; margin-top: 10px;">
    <tr>
        <td style="padding: 8px; border: 1px solid #ddd; width: 150px;"><strong>Nama Lengkap</strong></td>
        <td style="padding: 8px; border: 1px solid #ddd;">{{ $data['name'] }}</td>
    </tr>
    <tr>
        <td style="padding: 8px; border: 1px solid #ddd;"><strong>Alamat Email</strong></td>
        <td style="padding: 8px; border: 1px solid #ddd;">{{ $data['email'] }}</td>
    </tr>
    <tr>
        <td style="padding: 8px; border: 1px solid #ddd;" colspan="2"><strong>Pesan & Kebutuhan:</strong></td>
    </tr>
    <tr>
        <td style="padding: 12px; border: 1px solid #ddd; background-color: #f9f9f9;" colspan="2">
            {!! nl2br(e($data['message'])) !!}
        </td>
    </tr>
</table>

<p>Silakan balas (reply) email ini untuk langsung terhubung dengan pengirim.</p>
