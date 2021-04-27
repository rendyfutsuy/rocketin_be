<?php

return [
    'layout' => [
        'title_1' => 'Kolom Baris',
        'title_2' => 'Hai, :username',
        'footer_1' => '<p>Email ini dibuat secara otomatis, mohon tidak membalas. Jika butuh bantuan, silakan <br> <a style="color: #000;"><strong>Hubungi Kami</strong></a></p>',
        'footer_2' => '<p><strong>Perhatian!</strong></p> Kata sandi dan kode verifikasi bersifat rahasia. Mohon untuk tidak memberitahukan kepada siapa pun atau pihak mengatasnamakan <a style="color: #000;"><strong>Kolom Baris</strong>.</a>',
    ],
    'reset_password' => [
        'subject' => 'Ubah kata sandi Akun Kolom Baris.',
        'content' => '<h2>Klik tombol di bawah ini untuk melakukan perubahan kata sandi</h2>

        <div class="submit">
            <a style ="text-decoration:none; color: #ffffff;" href=":urlResetForm">Reset Kata Sandi.</a>
        </div>',
    ],
    'activation' => [
        'subject' => 'Aktivasi Akun Kolom Baris.',
        'content' => '<h2>Hai, Saatnya aktivasi akun Kolom Baris</h2>
            <p>
                Masukkan kode verifikasi di bawah ini untuk mengaktifkan akun Anda.
            </p>
        
            <div style="text-align:center;padding: 10px; border: 1px #f0f0f0 solid; border-radius: 10px; width: 175px;margin: auto;">
                <strong>:activationCode</strong>
            </div>
        
            <p>
                <strong> Catatan :</strong> <br>
                kode di atas hanya berlaku 30 menit. Harap untuk tidak menyebarkan kode ini.
            </p>',
    ],
    'reset_email' => [
        'subject' => 'Ubah Email Akun Kolom Baris.',
        'content' => '<h2>Salin Kode atau Klik Reset Email di bawah ini untuk melakukan perubahaan Email</h2>

        <div style="text-align:center;padding: 10px; border: 1px #f0f0f0 solid; border-radius: 10px; width: 175px; margin: auto; margin-bottom: 1.5rem;">
            <strong>:activationCode</strong>
        </div>
        <div class="submit">
            <a style ="text-decoration:none; color: #ffffff;" href=":urlResetForm">Reset Email.</a>
        </div>',
    ],
    'change_password' => [
        'subject' => 'Ubah kata sandi Akun Kolom Baris.',
        'content' => '
        <div class="submit">
            Kata sandi anda sudah diubah.
        </div>',
    ],
    'reset_request_success' => 'Email Reset Berhasil diminta.',
];
