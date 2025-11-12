<?php

namespace App\Http\Controllers\Crafto;

use App\Http\Controllers\Controller;
use App\Models\Lamaran;
use App\Models\Lowongan;
use App\Models\Pelamar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $profile = Pelamar::firstOrNew(['user_id' => $user->id]); // bikin objek kosong kalau belum ada
        $profile->loadMissing('user');
        if ($profile->exists) {
            return view('crafto.profile',compact('profile'));
        }else{
            return view('crafto.create_profile');
        }

    }
    public function store(Request $request)
    {
        // 🔒 Validasi input
        $request->validate([
            'nik'               => 'required|digits:16|unique:pelamar,nik',
            'tgl_lahir'         => 'required|date',
            'jenis_kelamin'     => 'required|in:laki-laki,perempuan',
            'status_pernikahan' => 'required|in:Belum Kawin,Kawin',
            'disabilitas'       => 'required|in:iya,tidak',
            'provinsi'          => 'required|string',
            'kabupaten'         => 'required|string',
            'kecamatan'         => 'required|string',
            'desa'              => 'required|string',
            'alamat'            => 'required|string',
            // 🔹 Pendidikan terakhir
            'pendidikan_terahir' => 'required|in:SD,SMP,SMA,SMK,D1,D2,D3,S1/D4,S2,S3',
            'jurusan'            => 'nullable|string|max:255',
            'nama_sekolah'       => 'required|string|max:255',
            // File wajib
            'ktp'               => 'required|mimes:pdf|max:2048',
            'cv'                => 'required|mimes:pdf|max:2048',
            'ijazah'            => 'required|mimes:pdf|max:2048',
            'ak1'               => 'required|mimes:pdf|max:2048',

            // File opsional
            'sertifikat'        => 'nullable|mimes:pdf|max:2048',
            'syarat_lain'       => 'nullable|mimes:pdf|max:2048',

            // Foto bisa dari file atau hasil crop base64
            'pass_foto'         => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'cropped_pass_foto' => 'nullable|string', // hasil crop dari JS
        ], [
            // 🔸 Pesan error custom
            'nik.required' => 'NIK wajib diisi.',
            'nik.digits' => 'NIK harus 16 angka.',
            'nik.unique' => 'NIK ini sudah terdaftar.',
            'tgl_lahir.required' => 'Tanggal lahir wajib diisi.',
            'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih.',
            'status_pernikahan.required' => 'Status pernikahan wajib dipilih.',
            'disabilitas.required' => 'Status disabilitas wajib dipilih.',
            'provinsi.required' => 'Provinsi wajib dipilih.',
            'kabupaten.required' => 'Kabupaten/Kota wajib dipilih.',
            'kecamatan.required' => 'Kecamatan wajib dipilih.',
            'desa.required' => 'Desa/Kelurahan wajib dipilih.',
            'pendidikan_terahir.required' => 'Pendidikan terakhir wajib dipilih.',
            'pendidikan_terahir.in' => 'Pilihan pendidikan terakhir tidak valid.',
            'nama_sekolah.required' => 'Nama sekolah wajib diisi.',
            'alamat.required' => 'Alamat wajib diisi.',
            'ktp.required' => 'File KTP wajib diunggah.',
            'cv.required' => 'File CV wajib diunggah.',
            'ijazah.required' => 'File Ijazah wajib diunggah.',
            'ak1.required' => 'File AK1 wajib diunggah.',
            'ktp.mimes' => 'File KTP harus berupa PDF.',
            'cv.mimes' => 'File CV harus berupa PDF.',
            'ijazah.mimes' => 'File Ijazah harus berupa PDF.',
            'ak1.mimes' => 'File AK1 harus berupa PDF.',
            'sertifikat.mimes' => 'File sertifikat harus berupa PDF.',
            'syarat_lain.mimes' => 'File syarat lain harus berupa PDF.',
            'pass_foto.mimes' => 'Pass foto harus berupa gambar JPG/PNG.',
        ]);

        // 📁 Path dasar penyimpanan
        $user = Auth::user();
        $basePath = 'uploads/profile/' . Str::slug($user->name, '_') . '_' . $user->id;
        $files = [];

        // 🗂️ File selain foto
        $fileFields = ['ktp', 'cv', 'ijazah', 'ak1', 'sertifikat', 'syarat_lain'];
        foreach ($fileFields as $field) {
            if ($request->hasFile($field)) {
                $extension = $request->file($field)->getClientOriginalExtension();
                $filename = "profile_{$user->id}_" . strtoupper($field) . "_" . Str::random(6) . "." . $extension;
                $path = $request->file($field)->storeAs($basePath, $filename, 'public');
                $files[$field] = $path;
            }
        }

        // 📸 Simpan hasil crop jika ada
        $fotoPath = null;

        if ($request->cropped_pass_foto) {
            // hasil dari cropper.js base64
            $image = $request->cropped_pass_foto;
            $image = str_replace('data:image/jpeg;base64,', '', $image);
            $image = str_replace('data:image/png;base64,', '', $image);
            $image = str_replace(' ', '+', $image);

            $imageName = "foto_{$user->id}_" . Str::random(6) . '.jpg';
            $fotoPath = $basePath . '/' . $imageName;

            Storage::disk('public')->put($fotoPath, base64_decode($image));
        } elseif ($request->hasFile('pass_foto')) {
            // fallback: user upload tanpa crop
            $extension = $request->file('pass_foto')->getClientOriginalExtension();
            $filename = "foto_{$user->id}_" . Str::random(6) . "." . $extension;
            $fotoPath = $request->file('pass_foto')->storeAs($basePath, $filename, 'public');
        }

        // 💾 Simpan ke tabel pelamar
        Pelamar::create([
            'user_id'           => $user->id,
            'nik'               => $request->nik,
            'tgl_lahir'         => $request->tgl_lahir,
            'jenis_kelamin'     => $request->jenis_kelamin,
            'status_pernikahan' => $request->status_pernikahan,
            'disabilitas'       => $request->disabilitas,
            'provinsi'          => $request->provinsi,
            'kabupaten'         => $request->kabupaten,
            'kecamatan'         => $request->kecamatan,
            'desa'              => $request->desa,
            'alamat'            => $request->alamat,
            // 🔹 Pendidikan
            'pendidikan_terahir' => $request->pendidikan_terahir,
            'jurusan'            => $request->jurusan,
            'nama_sekolah'       => $request->nama_sekolah,

            'ktp'               => $files['ktp'] ?? null,
            'cv'                => $files['cv'] ?? null,
            'ijazah'            => $files['ijazah'] ?? null,
            'ak1'               => $files['ak1'] ?? null,
            'sertifikat'        => $files['sertifikat'] ?? null,
            'syarat_lain'       => $files['syarat_lain'] ?? null,
        ]);

        // 🧑‍🎨 Update foto profil user
        if ($fotoPath) {
            $user->update([
                'avatar' => $fotoPath,
            ]);
        }

        return redirect()->back()->with('success', 'Data profil berhasil disimpan!');
    }
    public function updateFoto(Request $request)
    {
        $user = Auth::user();

        try {
            // 📁 Path dasar penyimpanan
            $basePath = 'uploads/profile/' . Str::slug($user->name, '_') . '_' . $user->id;

            // 🔍 Hapus foto lama jika ada
            if ($user->pass_foto && Storage::disk('public')->exists($user->pass_foto)) {
                Storage::disk('public')->delete($user->pass_foto);
            }

            $fotoPath = null;

            // 📸 Jika data dari base64 (cropper)
            if ($request->cropped_pass_foto) {
                $image = $request->cropped_pass_foto;

                // Bersihkan prefix base64
                $image = preg_replace('/^data:image\/\w+;base64,/', '', $image);
                $image = str_replace(' ', '+', $image);

                $imageName = "foto_{$user->id}_" . Str::random(6) . '.jpg';
                $fotoPath = $basePath . '/' . $imageName;

                // Simpan ke storage
                Storage::disk('public')->put($fotoPath, base64_decode($image));
            }
            // 📤 Fallback upload file biasa
            elseif ($request->hasFile('pass_foto')) {
                $file = $request->file('pass_foto');
                $extension = $file->getClientOriginalExtension();
                $filename = "foto_{$user->id}_" . Str::random(6) . "." . $extension;
                $fotoPath = $file->storeAs($basePath, $filename, 'public');
            }

            // 🧾 Update database
            if ($fotoPath) {
                $user->update(['avatar' => $fotoPath]);

                return response()->json([
                    'success' => true,
                    'message' => 'Foto berhasil diperbarui!',
                    'foto_url' => asset('storage/' . $fotoPath)
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Tidak ada foto dikirim.'
            ], 400);

        } catch (\Exception $e) {
            // tangkap error agar JS bisa tahu
            return response()->json([
                'success' => false,
                'message' => 'Gagal upload: ' . $e->getMessage()
            ], 500);
        }
    }
    public function updateNama(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $user = Auth::user();
        $user->name = $request->name;
        $user->save();

        return response()->json(['success' => true, 'name' => $user->name]);
    }
    public function updateData(Request $request)
    {
        $user = Auth::user();
        $profile = Pelamar::where('user_id', $user->id)->firstOrFail();

        $validated = $request->validate([
            'nik'               => 'required|digits:16|unique:pelamar,nik,' . $profile->id,
            'email'             => 'required|email|unique:users,email,' . $user->id,
            'no_hp'             => 'nullable|numeric|digits_between:10,15|unique:users,no_hp,' . $user->id,
            'tgl_lahir'         => 'required|date',
            'jenis_kelamin'     => 'required|in:laki-laki,perempuan',
            'status_pernikahan' => 'required|in:Belum Kawin,Kawin',
            'disabilitas'       => 'required|in:iya,tidak',
            'provinsi'          => 'required|string',
            'kabupaten'         => 'required|string',
            'kecamatan'         => 'required|string',
            'desa'              => 'required|string',
            'alamat'            => 'required|string',
        ], [
            // Pesan error custom
            'nik.required' => 'NIK wajib diisi.',
            'nik.digits' => 'NIK harus 16 angka.',
            'nik.unique' => 'NIK ini sudah terdaftar.',

            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email ini sudah digunakan.',

            'no_hp.numeric' => 'Nomor HP hanya boleh berisi angka.',
            'no_hp.digits_between' => 'Nomor HP minimal 10 dan maksimal 15 digit.',
            'no_hp.unique' => 'Nomor HP ini sudah terdaftar.',

            'tgl_lahir.required' => 'Tanggal lahir wajib diisi.',
            'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih.',
            'status_pernikahan.required' => 'Status pernikahan wajib dipilih.',
            'disabilitas.required' => 'Status disabilitas wajib dipilih.',
            'provinsi.required' => 'Provinsi wajib dipilih.',
            'kabupaten.required' => 'Kabupaten/Kota wajib dipilih.',
            'kecamatan.required' => 'Kecamatan wajib dipilih.',
            'desa.required' => 'Desa/Kelurahan wajib dipilih.',
            'alamat.required' => 'Alamat wajib diisi.',
        ]);

        // ✅ Update data Pelamar
        $profile->update([
            'nik'               => $validated['nik'],
            'tgl_lahir'         => $validated['tgl_lahir'],
            'jenis_kelamin'     => $validated['jenis_kelamin'],
            'status_pernikahan' => $validated['status_pernikahan'],
            'disabilitas'       => $validated['disabilitas'],
            'provinsi'          => $validated['provinsi'],
            'kabupaten'         => $validated['kabupaten'],
            'kecamatan'         => $validated['kecamatan'],
            'desa'              => $validated['desa'],
            'alamat'            => $validated['alamat'],
        ]);

        // ✅ Update data User (email dan no_hp)
        $user->update([
            'email' => $validated['email'],
            'no_hp' => $validated['no_hp'],
        ]);

        // Reload data terbaru
        $profile->refresh();

        return response()->json([
            'success' => true,
            'profile' => $profile,
            'user'    => $user,
        ]);
    }


    public function updateDokumen(Request $request)
    {
        $request->validate([

            // File wajib
            'ktp'               => 'nullable|mimes:pdf|max:2048',
            'cv'                => 'nullable|mimes:pdf|max:2048',
            'ijazah'            => 'nullable|mimes:pdf|max:2048',
            'ak1'               => 'nullable|mimes:pdf|max:2048',

            // File opsional
            'sertifikat'        => 'nullable|mimes:pdf|max:2048',
            'syarat_lain'       => 'nullable|mimes:pdf|max:2048',
        ], [
            // 🔸 Pesan error custom
            'ktp.mimes' => 'File KTP harus berupa PDF.',
            'cv.mimes' => 'File CV harus berupa PDF.',
            'ijazah.mimes' => 'File Ijazah harus berupa PDF.',
            'ak1.mimes' => 'File AK1 harus berupa PDF.',
            'sertifikat.mimes' => 'File sertifikat harus berupa PDF.',
            'syarat_lain.mimes' => 'File syarat lain harus berupa PDF.',
        ]);
        try {
            $user = Auth::user();
            $profile = $user->pelamar; // pastikan relasi ada
            $basePath = 'uploads/profile/' . Str::slug($user->name, '_') . '_' . $user->id;
            $files = [];

            $fileFields = ['ktp', 'cv', 'ijazah', 'ak1', 'sertifikat', 'syarat_lain'];

            foreach ($fileFields as $field) {
                if ($request->hasFile($field)) {
                    // 🔹 Cek file lama (pastikan kolom di DB benar, contoh: ktp, cv, ijazah, ak1, sertifikat, syarat_lain)
                    $oldFile = $profile->{$field};

                    if ($oldFile && Storage::disk('public')->exists($oldFile)) {
                        Storage::disk('public')->delete($oldFile);
                    }

                    $extension = $request->file($field)->getClientOriginalExtension();
                    $filename = "profile_{$user->id}_" . strtoupper($field) . "_" . Str::random(6) . "." . $extension;
                    $path = $request->file($field)->storeAs($basePath, $filename, 'public');

                    $files[$field] = $path;
                }
            }

            // 🔹 Simpan hasil ke database
            $profile->update($files);

            return response()->json([
                'success' => true,
                'message' => 'Dokumen berhasil diperbarui.',
                'files'   => $files
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
                'trace'   => $e->getTraceAsString(),
            ], 500);
        }
    }

    public function hapusDokumen($field)
    {
        $allowedFields = ['sertifikat', 'syarat_lain'];
        if (!in_array($field, $allowedFields)) {
            return response()->json(['success' => false, 'message' => 'Field tidak valid.'], 400);
        }

        $user = Auth::user();
        $pelamar = Pelamar::where('user_id', $user->id)->firstOrFail();

        $filePath = $pelamar->$field;

        if ($filePath && Storage::disk('public')->exists($filePath)) {
            Storage::disk('public')->delete($filePath);
        }

        $pelamar->update([$field => null]);

        return response()->json([
            'success' => true,
            'message' => ucfirst(str_replace('_', ' ', $field)) . ' berhasil dihapus.'
        ]);
    }

    public function updatePendidikan(Request $request)
    {
        $request->validate([
            'pendidikan_terahir' => 'required|string',
            'jurusan' => 'nullable|string|max:255',
            'nama_sekolah' => 'required|string|max:255',
        ]);

        $pelamar = Pelamar::where('user_id', auth()->id())->first();

        if (!$pelamar) {
            return response()->json(['success' => false, 'message' => 'Data tidak ditemukan']);
        }

        $pelamar->update([
            'pendidikan_terahir' => $request->pendidikan_terahir,
            'jurusan' => $request->jurusan,
            'nama_sekolah' => $request->nama_sekolah,
        ]);

        return response()->json([
            'success' => true,
            'profile' => $pelamar
        ]);
    }

}
