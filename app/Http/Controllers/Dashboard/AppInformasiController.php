<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Informasi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AppInformasiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\JsonResponse|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $query = Informasi::query()->latest();

            return DataTables::eloquent($query)

                ->filter(function ($query) use ($request) {

                    if (!empty($request->search['value'])) {

                        $search = $request->search['value'];

                        $query->where(function ($q) use ($search) {

                            $q->where('judul', 'like', "%{$search}%")
                                ->orWhere('slug', 'like', "%{$search}%")
                                ->orWhere('ringkasan', 'like', "%{$search}%");

                        });
                    }

                    if (
                        $request->filled('status') &&
                        ($request->status === '1' || $request->status === '0')
                    ) {
                        $query->where('is_active', $request->status);
                    }
                })

                ->editColumn('published_at', function ($row) {

                    return $row->published_at
                        ? Carbon::parse($row->published_at)->format('d/m/Y H:i')
                        : '-';

                })

                ->toJson();
        }

        return view('content.informasi.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
