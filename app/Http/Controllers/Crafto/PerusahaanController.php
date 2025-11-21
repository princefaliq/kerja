<?php

namespace App\Http\Controllers\Crafto;

use App\Http\Controllers\Controller;
use App\Models\Lowongan;
use App\Models\Perusahaan;
use App\Models\User;
use Illuminate\Http\Request;

class PerusahaanController extends Controller
{
    public function show($slug)
    {
        // Cari perusahaan berdasarkan slug
        $perusahaan = Perusahaan::where('slug', $slug)->firstOrFail();

        // Ambil relasi user dari perusahaan
        $user = $perusahaan->user;

        // Ambil lowongan yang aktif berdasarkan user_id perusahaan tersebut
        $lowongans = Lowongan::where('user_id', $perusahaan->user_id)
            ->where('status', 1)
            ->get();

        // Kirim data ke view
        return view('crafto.perusahaan', compact('user', 'perusahaan', 'lowongans'));
    }
    public function register()
    {
        return view('crafto.register_perusahaan');
    }
    public function store(Request $request)
    {
        // Validasi
        $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|unique:users,email',
            'no_hp'     => 'required|string|max:20',
            'password'  => 'required|min:8',
            'bidang'    => 'required|string|max:255',
            'alamat'    => 'required',
            'deskripsi' => 'required',
            'website'   => 'nullable|string',
            'nib'       => 'required|mimes:pdf|max:2048', // PDF < 2MB
            'cropped_foto' => 'nullable|string', // base64 avatar
        ]);

        try {

            /** ===================================================
             * 1️⃣ SIMPAN AVATAR JIKA ADA (BASE64 TO FILE)
             * ===================================================*/
            $avatarPath = null;

            if ($request->cropped_foto) {

                // base64 → file
                $imageData = $request->cropped_foto;

                // Hapus prefix base64
                $imageData = preg_replace('#^data:image/\w+;base64,#i', '', $imageData);

                $imageData = str_replace(' ', '+', $imageData);
                $imageBinary = base64_decode($imageData);

                // Nama file unik
                $fileName = 'avatar_' . time() . '.png';

                // Simpan ke storage/app/public/uploads/avatar/
                \Storage::disk('public')->put('uploads/avatar/' . $fileName, $imageBinary);

                // Simpan path
                $avatarPath = 'uploads/avatar/' . $fileName;
            }


            /** ===================================================
             * 2️⃣ SIMPAN USER
             * ===================================================*/
            $user = User::create([
                'name'     => $request->name,
                'email'    => $request->email,
                'no_hp'    => $request->no_hp,
                'password' => bcrypt($request->password),
                'status'   => 'nonaktif', // menunggu verifikasi admin
                'avatar'   => $avatarPath,
            ]);

            // Assign role perusahaan
            $user->assignRole('Perusahaan');


            /** ===================================================
             * 3️⃣ UPLOAD FILE NIB (PDF)
             * ===================================================*/
            $nibPath = null;
            if ($request->hasFile('nib')) {
                $nibPath = $request->file('nib')->store('uploads/nib', 'public');
            }


            /** ===================================================
             * 4️⃣ SIMPAN DATA PERUSAHAAN
             * ===================================================*/
            Perusahaan::create([
                'user_id'   => $user->id,
                'bidang'    => $request->bidang,
                'alamat'    => $request->alamat,
                'website'   => $request->website,
                'deskripsi' => $request->deskripsi,
                'nib'       => $nibPath,
            ]);


            /** ===================================================
             * 5️⃣ REDIRECT DENGAN SUCCESS
             * ===================================================*/
            return redirect('login')->with('success', 'Pendaftaran perusahaan berhasil! Silakan tunggu email (inbox/spam) jika telah diverifikasi admin.');

        } catch (\Exception $e) {

            return redirect('login')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }



}
