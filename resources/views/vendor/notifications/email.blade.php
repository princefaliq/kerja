@php
    $appName = config('app.name', 'Aplikasi Pencari Kerja');
@endphp
    <!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $appName }} - Reset Password</title>
    <style>
        body {
            font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            background-color: #eef2f3;
            margin: 0;
            padding: 0;
            color: #333;
        }
        .email-container {
            max-width: 600px;
            margin: 40px auto;
            background-color: #ffffff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 6px 18px rgba(0,0,0,0.08);
        }
        .email-header {
            background-color: #028c73;
            padding: 25px 20px;
            text-align: center;
            color: #fff;
        }
        .email-header img {
            max-width: 100px;
            height: auto;
            margin-bottom: 10px;
        }
        .email-header h1 {
            margin: 0;
            font-size: 22px;
            letter-spacing: 0.5px;
        }
        .email-body {
            padding: 35px 30px;
        }
        .email-body h2 {
            font-size: 20px;
            color: #028c73;
            margin-bottom: 15px;
        }
        .email-body p {
            font-size: 15px;
            line-height: 1.6;
            margin-bottom: 15px;
        }
        .btn {
            display: inline-block;
            padding: 12px 28px;
            background-color: #028c73;
            color: #fff !important;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 600;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            margin: 20px 0;
        }
        .divider {
            border: none;
            border-top: 1px solid #e2e8f0;
            margin: 30px 0;
        }
        .email-footer {
            background-color: #f9fafb;
            text-align: center;
            padding: 20px;
            font-size: 13px;
            color: #666;
        }
        .email-footer a {
            color: #028c73;
            text-decoration: none;
            font-weight: 600;
        }
    </style>
</head>
<body>
<div class="email-container">
    <div class="email-header">
        <img src="https://kerja.bondowosokab.go.id/logo/logo_kerja_berkah.png" alt="Logo {{ $appName }}">
        <h1>{{ strtoupper($appName) }}</h1>
    </div>

    <div class="email-body">
        <h2>Reset Password Akun Anda</h2>

        <p>Halo{{ isset($user->name) ? ', ' . $user->name : '' }} 👋</p>
        <p>Kami menerima permintaan untuk mengatur ulang kata sandi akun Anda.</p>

        @isset($actionText)
            <p style="text-align:center;">
                <a href="{{ $actionUrl }}" class="btn">{{ $actionText }}</a>
            </p>
        @endisset

        <p>Tautan ini akan kedaluwarsa dalam 60 menit.</p>
        <p>Jika Anda tidak meminta reset password, abaikan email ini.</p>

        <p>Terima kasih,<br><strong>{{ $appName }}</strong></p>

        <hr class="divider">

        <p style="font-size:13px; color:#777;">
            Jika Anda kesulitan mengklik tombol “{{ $actionText }}”, salin dan tempel URL berikut ke browser Anda:<br>
            <a href="{{ $actionUrl }}">{{ $actionUrl }}</a>
        </p>
    </div>

    <div class="email-footer">
        &copy; {{ date('Y') }} {{ $appName }}. Semua hak dilindungi.<br>
        <a href="{{ url('/') }}">Kunjungi Situs</a>
    </div>
</div>
</body>
</html>
