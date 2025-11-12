<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Pelamar;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AppPelamarController extends Controller
{
    public function index()
    {
        return view('content.user.pelamar.index');
    }

    public function data(Request $request)
    {
        // Ambil semua user yang memiliki role "User"
        $users = User::with('pelamar')
            ->whereHas('roles', function ($q) {
                $q->where('name', 'User');
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
                    $name = ucwords(strtolower($u->name)) ?? '-';
                    $imageUrl = $avatar ?: 'https://placehold.co/600x600';
                    $detilUrl =  url('app/pelamar/detail/'.$u->id);
                    return "
                        <div class='d-flex align-items-center'>
                            <div class='symbol symbol-circle symbol-45px overflow-hidden me-3'>
                                <div class='symbol-label'>
                                    <img src='{$imageUrl}' alt='{$name}' class='w-100'/>
                                </div>
                            </div>
                            <div class='d-flex flex-column'>
                                <a href='{$detilUrl}' title='Detail Pelamar' target='_blank' class='text-gray-800 text-hover-primary mb-1 fw-bold'>{$name}</a>
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

    public function detail($id)
    {
        $profile = Pelamar::firstOrNew(['user_id' => $id]); // bikin objek kosong kalau belum ada
        $profile->loadMissing('user');

        return view('content.user.pelamar.detail_pelamaran',compact('profile'));

    }
}
