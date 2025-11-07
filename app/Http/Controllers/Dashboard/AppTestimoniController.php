<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Testimoni;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;

class AppTestimoniController extends Controller
{
    public function index()
    {
        return view('content.testimoni.index');
    }
    public function data(Request $request)
    {
        $query = Testimoni::with('pelamar.user')->select('testimoni.*');

        return DataTables::eloquent($query)
            ->addColumn('pelamar', function ($row) {
                $user = $row->pelamar->user ?? null;
                if (!$user) return '-';
                return '
                    <div class="d-flex align-items-center">
                        <img src="' . ($user->avatarUrl ?? 'https://placehold.co/50x50') . '"
                            class="rounded-circle me-3" width="45" height="45" alt="">
                        <div>
                            <div class="fw-bold text-dark">' . e($user->name) . '</div>
                            <small class="text-muted">' . e($user->email ?? '') . '</small>
                        </div>
                    </div>';
            })
            ->addColumn('isi', fn($row) => e(Str::limit($row->isi, 100)))
            ->addColumn('status', function ($row) {
                return $row->is_approved
                    ? '<span class="badge badge-light-success">Diterima</span>'
                    : '<span class="badge badge-light-warning">Menunggu</span>';
            })
            ->addColumn('aksi', function ($row) {
                return '
                    <button class="btn btn-icon btn-sm btn-light-success me-2 btn-approve"
                        data-id="' . $row->id . '" data-status="1">
                       <i class="bi bi-check-circle-fill"></i>
                    </button>
                    <button class="btn btn-icon btn-sm btn-light-danger btn-reject"
                        data-id="' . $row->id . '" data-status="0">
                       <i class="bi bi-x-circle-fill"></i>
                    </button>';
            })
            ->rawColumns(['pelamar', 'status', 'aksi'])
            ->make(true);
    }

    public function updateStatus(Request $request, $id)
    {
        $testimoni = Testimoni::findOrFail($id);
        $testimoni->is_approved = $request->is_approved;
        $testimoni->save();

        return response()->json(['success' => true, 'message' => 'Status testimoni berhasil diperbarui.']);
    }
}
