<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Lamaran Anda</title>
</head>
<body style="font-family: 'Segoe UI', Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 0;">
    <table align="center" width="100%" cellpadding="0" cellspacing="0" style="max-width:600px; margin:auto; background-color:white; border-radius:8px; overflow:hidden; box-shadow:0 4px 12px rgba(0,0,0,0.1);">
        <!-- Header -->
        <tr>
            <td style="background-color:#028c73; padding:20px; text-align:center;">
                <img src="https://kerja.bondowosokab.go.id/logo/logo_kerja_berkah.png" alt="Kerja Berkah Bondowoso" width="100" style="margin-bottom:10px;">
                <h1 style="color:white; margin:0; font-size:22px;">Status Lamaran Anda</h1>
            </td>
        </tr>

        <!-- Body -->
        <tr>
            <td style="padding:30px;">
                @php
                    $isAccepted = $status === 'diterima';
                    $color = $isAccepted ? '#028c73' : '#e11d48'; // hijau atau merah
                    $title = $isAccepted ? 'Selamat! Anda Diterima 🎉' : 'Informasi Status Lamaran 🙏';
                    $message = $isAccepted
                        ? 'Selamat! Anda telah lolos proses seleksi dan diterima untuk posisi berikut:'
                        : 'Terima kasih telah melamar. Saat ini Anda belum memenuhi kriteria yang dibutuhkan untuk posisi berikut:';
                @endphp

                <h2 style="color: {{ $color }}; margin-top:0;">{{ $title }}</h2>
                <p style="font-size:16px; line-height:1.6; color:#333;">Halo <strong>{{ $namaPelamar }}</strong>,</p>
                <p style="font-size:16px; line-height:1.6; color:#333;">{{ $message }}</p>

                <div style="background-color:#f9fafb; border-left:5px solid {{ $color }}; padding:12px 16px; margin:20px 0; border-radius:4px;">
                    <strong>Perusahaan:</strong> {{ $namaPerusahaan }}<br>
                    <strong>Posisi:</strong> {{ $judulLowongan }}<br>
                    <strong>Status:</strong> <span style="color: {{ $color }}; font-weight:bold;">{{ strtoupper($status) }}</span>
                </div>

                @if($isAccepted)
                    <p style="font-size:15px; color:#333;">
                        Tim kami akan segera menghubungi Anda untuk proses selanjutnya.
                    </p>
                    <p style="text-align:center; margin-top:30px;">
                        <a href="{{ url('/login') }}" style="background-color:#028c73; color:white; padding:12px 24px; border-radius:6px; text-decoration:none; font-weight:bold;">Lihat Detail di Aplikasi</a>
                    </p>
                @else
                    <p style="font-size:15px; color:#333;">
                        Jangan menyerah, masih banyak peluang menarik lainnya menanti Anda di platform kami.
                    </p>
                    <p style="text-align:center; margin-top:30px;">
                        <a href="{{ url('/lowongan-kerja') }}" style="background-color:#ffea23; color:#333; padding:12px 24px; border-radius:6px; text-decoration:none; font-weight:bold;">Lihat Lowongan Lainnya</a>
                    </p>
                @endif
            </td>
        </tr>

        <!-- Footer -->
        <tr>
            <td style="background-color:#028c73; color:white; text-align:center; padding:15px; font-size:13px;">
                <p style="margin:0;">Email ini dikirim otomatis oleh sistem <strong>Kerja Berkah Bondowoso</strong>.</p>
                <p style="margin:5px 0 0 0; font-size:12px; color:#eafff8;">Jangan membalas email ini secara langsung.</p>
            </td>
        </tr>
    </table>
</body>
</html>
