<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Acara;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AppAcaraController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Acara::select([
                'id',
                'nama_acara',
                'tanggal_mulai',
                'tanggal_selesai',
                'waktu_mulai',
                'waktu_selesai'
            ]);

            return DataTables::of($data)
                ->addIndexColumn()
                ->make(true);
        }
        return view('content.acara.index');
    }

    public function create()
    {
        return view('content.acara.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_acara'      => 'required|string|max:255',
            'tanggal_mulai'   => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'waktu_mulai'     => 'required|date_format:H:i',
            'waktu_selesai'   => 'required|date_format:H:i|after:waktu_mulai',
            'deskripsi'       => 'nullable|string',
        ]);

        Acara::create([
            'nama_acara'      => $request->nama_acara,
            'tanggal_mulai'   => $request->tanggal_mulai,
            'waktu_mulai'     => $request->waktu_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'waktu_selesai'   => $request->waktu_selesai,
            'deskripsi'       => $request->deskripsi,
        ]);

        return redirect()->route('acara.index')
            ->with('success', 'Acara berhasil ditambahkan!');
    }

    public function edit(Acara $acara)
    {

        return view('content.acara.edit', compact('acara'));
    }

    public function update(Request $request, Acara $acara)
    {
        // normalisasi waktu seperti di store
        if ($request->filled('waktu_mulai')) {
            try {
                $request->merge([
                    'waktu_mulai' => Carbon::parse($request->waktu_mulai)->format('H:i')
                ]);
            } catch (\Exception $e) {}
        }

        if ($request->filled('waktu_selesai')) {
            try {
                $request->merge([
                    'waktu_selesai' => Carbon::parse($request->waktu_selesai)->format('H:i')
                ]);
            } catch (\Exception $e) {}
        }
        $request->validate([
            'nama_acara'       => 'required|string|max:255',

            'tanggal_mulai'    => 'required|date',
            'tanggal_selesai'  => 'required|date|after_or_equal:tanggal_mulai',

            'waktu_mulai'      => 'required|date_format:H:i',
            'waktu_selesai'    => 'required|date_format:H:i|after:waktu_mulai',

            'deskripsi'        => 'nullable|string',
        ]);

        $acara->update([
            'nama_acara'       => $request->nama_acara,
            'tanggal_mulai'    => $request->tanggal_mulai,
            'waktu_mulai'      => $request->waktu_mulai,
            'tanggal_selesai'  => $request->tanggal_selesai,
            'waktu_selesai'    => $request->waktu_selesai,
            'deskripsi'        => $request->deskripsi,
        ]);

        return redirect()->route('acara.index')->with('success', 'Acara berhasil diperbarui!');
    }


    public function destroy(Acara $acara)
    {
        $acara->delete();
        return redirect()->route('acara.index')->with('success', 'Acara berhasil dihapus!');
    }
}
