<?php

namespace App\Imports;

use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UsersImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // Pastikan kolom wajib ada
        if (!isset($row['email']) || !isset($row['name'])) {
            throw new Exception('Kolom "email" atau "name" tidak ditemukan dalam file Excel.');
        }

        // Bersihkan data
        $email = trim($row['email']);
        $name  = trim($row['name']);

        // Validasi email
        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception('Format email tidak valid pada kolom email: ' . $email);
        }

        // Validasi nama
        if (empty($name)) {
            throw new Exception('Nama tidak boleh kosong untuk email: ' . $email);
        }

        // Buat user baru
        $user = new User([
            'name'              => $row['name'],
            'email'             => $row['email'],
            'no_hp'             => $row['no_hp'] ?? null,
            'email_verified_at' => now(),
            'password'          => Hash::make($row['password']),
            'avatar'            => $row['avatar'] ?? null,
            'status'            => $row['status'] ?? 'aktif',
        ]);

        $user->save();
        $user->assignRole('Perusahaan');

        return $user;
    }
    public function headingRow(): int
    {
        return 1; // pastikan baris pertama adalah header
    }
    public function rules(): array
    {
        return [
            'name'     => 'required|string|max:255',
            'email'    => ['required', 'email', Rule::unique('users', 'email')],
            'password' => 'required|min:6',
        ];
    }
    public function customValidationMessages()
    {
        return [
            'name.required'     => 'Kolom nama wajib diisi.',
            'email.required'    => 'Kolom email wajib diisi.',
            'email.email'       => 'Format email tidak valid.',
            'email.unique'      => 'Email sudah terdaftar.',
            'password.required' => 'Kolom password wajib diisi.',
            'password.min'      => 'Password minimal 6 karakter.',
        ];
    }
}
