<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Imports\UsersImport;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class AppPerusahaanController extends Controller
{
    public function index()
    {
        return view('content.user.perusahaan.index');
    }

    public function data(Request $request)
    {
        // Ambil semua user yang memiliki role "User"
        $users = User::whereHas('roles', function ($q) {
                $q->where('name', 'Perusahaan');
            })
            ->latest(); // 👉 data baru muncul di atas (urut created_at DESC);


        if ($request->ajax()) {
            return DataTables::of($users)
                ->filter(function ($query) use ($request) {
                    if ($request->has('search') && !empty($request->search['value'])) {
                        $keyword = $request->search['value'];

                        $query->where(function ($q) use ($keyword) {
                            $q->where('name', 'like', "%{$keyword}%")
                                ->orWhere('email', 'like', "%{$keyword}%")
                                ->orWhere('no_hp', 'like', "%{$keyword}%");
                        });
                    }
                })
                ->addIndexColumn()
                ->addColumn('nama', function ($u) {
                    $avatar = $u->avatarUrl ?? null;
                    $name = $u->name ?? '-';
                    $imageUrl = $avatar ?: 'https://placehold.co/600x600';
                    return "
                        <div class='d-flex align-items-center'>
                            <div class='symbol symbol-circle symbol-45px overflow-hidden me-3'>
                                <div class='symbol-label'>
                                    <img src='{$imageUrl}' alt='{$name}' class='w-100'/>
                                </div>
                            </div>
                            <div class='d-flex flex-column'>
                                <span class='text-gray-800 text-hover-primary mb-1 fw-bold'>{$name}</span>
                            </div>
                        </div>
                    ";
                })
                ->addColumn('email', function ($u) {
                    return $u->email ?? '-';
                })
                ->addColumn('no_hp', function ($u) {
                    return $u->no_hp ?? '-';
                })
                ->addColumn('last_login', function ($u) {
                    return $u->last_login
                        ? Carbon::parse($u->last_login)->format('d-m-Y H:i')
                        : '-';
                })
                ->addColumn('tanggal_join', function ($u) {
                    return $u->created_at
                        ? $u->created_at->format('d-m-Y')
                        : '-';
                })
                ->addColumn('status', function ($u) {
                    $status = $u->status ?? 'inactive';

                    if ($status === 'active') {
                        $badgeClass = 'badge-light-success';
                    } elseif ($status === 'inactive') {
                        $badgeClass = 'badge-light-danger';
                    } else {
                        $badgeClass = 'badge-light-warning';
                    }

                    return "<span class='badge {$badgeClass} fw-bold text-uppercase'>{$status}</span>";
                })
                ->addColumn('id', function ($u) {
                    return $u->id;
                })
                ->rawColumns(['nama', 'status'])
                ->make(true);
        }
        // Kalau bukan request AJAX
        return abort(404);
    }
    public function import(Request $request)
    {
        try {
            Excel::import(new UsersImport, $request->file('file'));
            return redirect()->back()->with('success', 'Data pengguna berhasil diimport.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Gagal import: ' . $e->getMessage());
        }
    }
}
