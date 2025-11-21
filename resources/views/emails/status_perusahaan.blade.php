<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Akun Perusahaan</title>
</head>
<body style="font-family: 'Segoe UI', Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 0;">

@php
    $isActive = $status === 'aktif';
    $color = $isActive ? '#028c73' : '#e11d48';
    $title = $isActive ? 'Akun Anda Telah Diaktifkan 🎉' : 'Akun Anda Dinonaktifkan 🙏';
@endphp

<table align="center" width="100%" cellpadding="0" cellspacing="0"
       style="max-width:600px; margin:auto; background-color:white; border-radius:8px;
              overflow:hidden; box-shadow:0 4px 12px rgba(0,0,0,0.1);">

    <!-- Header -->
    <tr>
        <td style="background-color:#028c73; padding:20px; text-align:center;">
            <img src="https://kerja.bondowosokab.go.id/logo/logo_kerja_berkah.png"
                 alt="Kerja Berkah Bondowoso" width="100" style="margin-bottom:10px;">
            <h1 style="color:white; margin:0; font-size:22px;">Status Akun Perusahaan</h1>
        </td>
    </tr>

    <!-- Body -->
    <tr>
        <td style="padding:30px;">
            <h2 style="color: {{ $color }}; margin-top:0;">{{ $title }}</h2>

            <p style="font-size:16px; line-height:1.6; color:#333;">
                Halo <strong>{{ $perusahaan->name }}</strong>,
            </p>

            @if($isActive)
                <p style="font-size:16px; line-height:1.6; color:#333;">
                    Akun perusahaan Anda telah kami <strong>AKTIFKAN</strong>.
                    Silakan login ke dashboard lowongan kerja menggunakan akun Anda.
                </p>
            @else
                <p style="font-size:16px; line-height:1.6; color:#333;">
                    Akun perusahaan Anda saat ini <strong>DINONAKTIFKAN</strong>.
                    Anda sementara tidak dapat login ke sistem hingga diaktifkan kembali oleh admin.
                </p>
            @endif

            <div style="background-color:#f9fafb; border-left:5px solid {{ $color }};
                        padding:12px 16px; margin:20px 0; border-radius:4px;">
                <strong>Nama Perusahaan:</strong> {{ $perusahaan->name }}<br>
                <strong>Status Baru:</strong>
                <span style="color: {{ $color }}; font-weight:bold;">
                    {{ strtoupper($status) }}
                </span>
            </div>

            @if($isActive)
                <p style="text-align:center; margin-top:30px;">
                    <a href="https://kerja.bondowosokab.go.id/login"
                       style="background-color:#028c73; color:white; padding:12px 24px;
                              border-radius:6px; text-decoration:none; font-weight:bold;">
                        Login Sekarang
                    </a>
                </p>
            @else
                <p style="font-size:15px; color:#333;">
                    Jika menurut Anda ini adalah kesalahan, silakan hubungi admin DPMPTSP Naker Bondowoso.
                </p>
            @endif
        </td>
    </tr>

    <!-- Footer -->
    <tr>
        <td style="background-color:#028c73; color:white; text-align:center; padding:15px; font-size:13px;">
            <p style="margin:0;">Email ini dikirim otomatis oleh sistem
                <strong>Kerja Berkah Bondowoso</strong>.
            </p>
            <p style="margin:5px 0 0 0; font-size:12px; color:#eafff8;">
                Jangan membalas email ini secara langsung.
            </p>
        </td>
    </tr>

</table>
</body>
</html>

