<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Validation\Rules;
class UserController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::eloquent(User::with('roles'))
                ->addColumn('role_names', fn($user) => $user->roles->pluck('name')->implode(', '))
                ->addColumn('created_at_formatted', fn($user) => $user->created_at->format('d/m/Y H:i'))
                ->toJson();
        }
        $role=Role::all();
        return view('content.user.index',compact('role'));
    }
    public function create()
    {
        $role=Role::all();
        return view('content.user.create',compact('role'));
    }
    public function store(Request $request)
    {
        //return $request;
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'no_hp' => ['required','string', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'avatar' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg'],
            'role' => ['required', 'array'],
        ]);

        if ($request->hasFile('avatar')) {
            // Ambil file yang diupload
            $file = $request->file('avatar');

            // Buat objek gambar
            $img = Image::make($file);

            // Resize gambar
            $img->resize(300, 300);

            // Tentukan lokasi dan nama file untuk disimpan
            $destinationPath = public_path('uploads'); // Ganti dengan path yang sesuai
            $fileName = 'avatar_' . time() . '.png'; // Nama file baru

            // Simpan gambar ke lokasi baru
            $img->save($destinationPath . '/' . $fileName);

            // Kembalikan response (jika diperlukan)
            //return response()->json(['message' => 'Gambar berhasil diupload dan diproses.', 'file' => $fileName]);
        } else {
            return response()->json(['message' => 'Tidak ada file yang diupload.'], 400);
        }
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
            'avatar' => 'uploads/' . $fileName,
            'password' => Hash::make($request->password),
        ]);
        $user->syncRoles($request->role);
        //return $img->response('png');
        return redirect()->route('user.index')->with('success', 'User created successfully.');
    }
    public function destroy(Request $request)
    {
        if($request->pilih !=null) {
            foreach ($request->pilih as $value) {
                $data=User::findOrFail($value);
                if ($data->avatar) {
                    $imagePath = public_path($data->avatar);
                    if (file_exists($imagePath)) {
                        unlink($imagePath);
                    }
                    //Storage::delete($data->avatar);
                }
                $data->delete();
            }
            return response()->json('sukses', 200);
        }else{
            return response()->json($request->pilih, 400);
        }
    }
    public function edit($id)
    {
        $role=Role::all();
        $user=User::find($id);
        //return $user->roles->pluck('name');
        return view('content.user.edit',compact('role','user','id'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
            'avatar' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg'],
            'role' => ['required', 'array'],
        ]);
        // Temukan pengguna
        $user = User::findOrFail($id);

        // Update avatar jika ada file baru
        if ($request->hasFile('avatar')) {
            if ($user->avatar) {
                $imagePath = public_path($user->avatar);
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }
            $file = $request->file('avatar');
            $img = Image::make($file)->resize(300, 300);
            $fileName = 'avatar_' . time() . '.png';
            $img->save(public_path('uploads/' . $fileName));
            $user->avatar = 'uploads/' . $fileName;
        }

        // Update nama jika ada
        if ($request->filled('name')) {
            $user->name = $request->name;
        }

        // Update password jika ada
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        // Simpan perubahan
        $user->save();
        $user->syncRoles($request->role);
        return redirect()->route('user.index')->with('success', 'User created successfully.');
    }
}
