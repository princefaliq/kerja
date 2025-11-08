@extends('crafto.master')
@section('title','Daftar Lamaran')
@push('css')
    <style>
        /* Efek hover lembut */
        .table-hover tbody tr:hover {
            background-color: #f6fff8 !important;
            transition: background-color 0.2s ease-in-out;
            transform: none !important; /* Hapus efek scale yang bikin overflow */
        }

        /* Hapus overflow horizontal di seluruh halaman */
        html, body {
            overflow-x: hidden !important;
        }

        /* Pastikan tabel tidak lebih lebar dari container */
        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            width: 100%;
        }

        /* Responsif untuk HP */
        @media (max-width: 768px) {
            h3 {
                font-size: 1.25rem;
            }

            /* Nonaktifkan overflow horizontal di HP */
            .table-responsive {
                overflow-x: hidden !important;
            }

            /* Sembunyikan header tabel */
            .table thead {
                display: none;
            }

            /* Jadikan tiap baris seperti kartu */
            .table tbody tr {
                display: block;
                margin-bottom: 1rem;
                border: 1px solid #eaeaea;
                border-radius: 10px;
                box-shadow: 0 2px 4px rgba(0,0,0,0.05);
                padding: 10px;
                background-color: #fff;
                width: 100% !important;
                box-sizing: border-box;
            }

            /* Atur tampilan sel */
            .table tbody td {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: .5rem 1rem;
                font-size: 0.95rem;
                border: none !important;
                width: 100%;
                box-sizing: border-box;
                overflow-wrap: break-word;
                word-wrap: break-word;
                white-space: normal;
            }

            /* Label di depan nilai */
            .table tbody td::before {
                content: attr(data-label);
                font-weight: 600;
                color: #028c73;
                text-transform: capitalize;
                margin-right: 10px;
                flex-shrink: 0;
            }

            /* Pastikan tidak ada lebar berlebih dari container */
            .container, .container-fluid {
                padding-left: 10px !important;
                padding-right: 10px !important;
                overflow-x: hidden !important;
            }
        }
    </style>
@endpush

@section('content')
    <section class="bg-dark-midnight-blue text-light pt-8 ps-6 pe-6 lg-ps-2 lg-pe-2 sm-ps-0 sm-pe-0">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-12 breadcrumb breadcrumb-style-01 fs-14">
                    <ul>
                        <li><a href="/">Home</a></li>
                        <li>Daftar Lamaran</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <section class="pt-60px pb-0 md-pt-30px">
        <div class="container py-5">
            <h3 class="fw-bold mb-4 text-center">📋 Daftar Lamaran Saya</h3>

            {{-- Statistik --}}
            <div class="row mb-4 text-center">
                <div class="col-md-4 mb-3">
                    <div class="p-3 rounded-4 text-dark shadow-sm" style="background-color:#ffea23;">
                        <h5 class="mb-1 fw-semibold">Dikirim</h5>
                        <span class="fs-4 fw-bold">{{ $statistik['dikirim'] }}</span>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="p-3 rounded-4 text-light shadow-sm" style="background-color:#028c73;">
                        <h5 class="mb-1 fw-semibold">Diterima</h5>
                        <span class="fs-4 fw-bold">{{ $statistik['diterima'] }}</span>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="p-3 rounded-4 text-white shadow-sm" style="background-color:#dc3545;">
                        <h5 class="mb-1 fw-semibold">Ditolak</h5>
                        <span class="fs-4 fw-bold">{{ $statistik['ditolak'] }}</span>
                    </div>
                </div>
            </div>

            {{-- Daftar Lamaran --}}
            <div class="table-responsive shadow-sm rounded-4 bg-white">
                <table class="table align-middle mb-0 table-hover">
                    <thead style="background-color:#ffea23;">
                        <tr class="text-center">
                            <th class="text-dark">Judul Lowongan</th>
                            <th class="text-dark">Perusahaan</th>
                            <th class="text-dark">Tanggal Lamar</th>
                            <th class="text-dark">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($lamarans as $lamaran)
                            <tr class="text-center">
                                <td data-label="Judul Lowongan" class="fw-semibold">{{ $lamaran->lowongan->judul }}</td>
                                <td data-label="Perusahaan">{{ $lamaran->lowongan->user->name ?? '-' }}</td>
                                <td data-label="Tanggal Lamar">{{ $lamaran->created_at->translatedFormat('d M Y') }}</td>
                                <td data-label="Status">
                                    @if($lamaran->status == 'dikirim')
                                        <span class="badge bg-secondary fs-6 p-2 px-3 shadow-sm">✉️ Dikirim</span>
                                    @elseif($lamaran->status == 'diterima')
                                        <span class="badge bg-success fs-6 p-2 px-3 shadow-sm">✅ Diterima</span>
                                    @elseif($lamaran->status == 'ditolak')
                                        <span class="badge bg-danger fs-6 p-2 px-3 shadow-sm">❌ Ditolak</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-5">
                                    <div class="fs-5">Belum ada lamaran yang dikirim 😔</div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </section>

@endsection
