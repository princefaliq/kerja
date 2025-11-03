<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Perusahaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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

        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $path;
            $user->save();
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

}
