<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Perusahaan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class AppMyprofileController extends Controller
{
    public function index()
    {
        return view('content.myprofile.index');
    }
    public function edit()
    {
        $user = Auth::user();

        // ambil perusahaan jika ada, kalau tidak buat instance baru (belum disimpan)
        $perusahaan = $user->perusahaan ?? new Perusahaan();

        // pastikan relasi user ter-set supaya di blade bisa $perusahaan->user->avatar dll.
        $perusahaan->setRelation('user', $user);

        return view('content.myprofile.edit', compact('perusahaan'));
    }
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'no_hp' => 'nullable|string|max:15',
            'bidang' => 'nullable|string|max:255',
            'website' => 'nullable|string|max:255',
            'alamat' => 'nullable|string',
            'deskripsi' => 'nullable|string',
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'nib' => 'nullable|mimes:pdf|max:2048', // ✅ PDF max 2MB
        ]);

        // update user
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
        ]);
        if ($user->hasRole('Perusahaan')) {
            // lakukan sesuatu kalau user admin
            if ($request->hasFile('avatar')) {
                $path = $request->file('avatar')->store('uploads/perusahaan', 'public');
                $user->avatar = $path;
                $user->save();
            }
        }else{
            if ($request->hasFile('avatar')) {
                $path = $request->file('avatar')->store('uploads/avatars', 'public');
                $user->avatar = $path;
                $user->save();
            }
        }


        // ambil atau buat perusahaan
        $perusahaan = Perusahaan::updateOrCreate(
            ['user_id' => $user->id],
            [
                'bidang' => $request->bidang,
                'deskripsi' => $request->deskripsi,
                'alamat' => $request->alamat,
                'website' => $request->website,
            ]
        );


        // upload file NIB (jika ada)
        if ($request->hasFile('nib')) {
            if ($perusahaan->nib && Storage::disk('public')->exists($perusahaan->nib)) {
                Storage::disk('public')->delete($perusahaan->nib);
            }
            $pathNIB = $request->file('nib')->store('uploads/nib', 'public');
            $perusahaan->nib = $pathNIB;
            $perusahaan->save();
        }

        return back()->with('success', 'Profil perusahaan berhasil diperbarui.');
    }

    public function show($id)
    {
        $user = User::with('perusahaan')->findOrFail($id);
        return view('content.user.perusahaan.show',compact('user'));
    }
    public function qrcode($slug)
    {
        $perusahaan = Perusahaan::with('user')->where('slug', $slug)->firstOrFail();
        $url = url('perusahaan/' . $perusahaan->slug);

        $svg = QrCode::format('svg')
            ->size(250)
            ->margin(2)
            ->generate($url);
        return view('content.myprofile.qrcode',compact('perusahaan','svg','url'));
    }

    public function downloadQrcode($slug)
    {
        $perusahaan = Perusahaan::with('user')->where('slug', $slug)->firstOrFail();
        $url = url('perusahaan/' . $perusahaan->slug);

        $qrSvg = QrCode::format('svg')
            ->size(200)
            ->margin(1)
            ->generate($url);
        $qrSvg = preg_replace('/<\?xml.*?\?>/', '', $qrSvg);
        // Gabungkan teks + QR jadi satu SVG
        $svg = <<<SVG
        <svg xmlns="http://www.w3.org/2000/svg" width="300" height="320">
            <text x="50%" y="25" text-anchor="middle" font-size="16" font-family="Arial" fill="#000">
                {$perusahaan->user->name}
            </text>
            <g transform="translate(50, 40)">
                {$qrSvg}
            </g>
            <text x="50%" y="310" text-anchor="middle" font-size="10" fill="#666">
                {$url}
            </text>
        </svg>
        SVG;

        $fileName = 'qrcode-' . $perusahaan->slug . '.svg';
        return response($svg, 200, [
            'Content-Type' => 'image/svg+xml',
            'Content-Disposition' => "attachment; filename={$fileName}",
        ]);
    }

}
