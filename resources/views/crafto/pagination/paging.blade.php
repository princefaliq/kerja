@if ($paginator->hasPages())
    <div class="col-12 mt-4 d-flex justify-content-center">
        {{-- Desktop Pagination --}}
        <ul class="pagination pagination-style-01 fs-13 fw-500 mb-0 d-none d-md-flex">

            {{-- Tombol Previous --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled">
                    <a class="page-link" href="javascript:void(0);">←</a>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->previousPageUrl() }}">←</a>
                </li>
            @endif

            {{-- Halaman --}}
            @php
                $start = max($paginator->currentPage() - 1, 1);
                $end = min($paginator->currentPage() + 1, $paginator->lastPage());
            @endphp

            {{-- Tampilkan halaman pertama jika perlu --}}
            @if ($start > 1)
                <li class="page-item"><a class="page-link" href="{{ $paginator->url(1) }}">1</a></li>
                @if ($start > 2)
                    <li class="page-item disabled"><a class="page-link">…</a></li>
                @endif
            @endif

            {{-- Tampilkan halaman sekitar --}}
            @for ($i = $start; $i <= $end; $i++)
                @if ($i == $paginator->currentPage())
                    <li class="page-item active"><a class="page-link" href="#">{{ $i }}</a></li>
                @else
                    <li class="page-item"><a class="page-link" href="{{ $paginator->url($i) }}">{{ $i }}</a></li>
                @endif
            @endfor

            {{-- Tampilkan halaman terakhir jika perlu --}}
            @if ($end < $paginator->lastPage())
                @if ($end < $paginator->lastPage() - 1)
                    <li class="page-item disabled"><a class="page-link">…</a></li>
                @endif
                <li class="page-item"><a class="page-link" href="{{ $paginator->url($paginator->lastPage()) }}">{{ $paginator->lastPage() }}</a></li>
            @endif

            {{-- Tombol Next --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->nextPageUrl() }}">→</a>
                </li>
            @else
                <li class="page-item disabled"><a class="page-link" href="javascript:void(0);">→</a></li>
            @endif

        </ul>

        {{-- Mobile Pagination --}}
        <ul class="pagination pagination-style-01 fs-13 fw-500 mb-0 d-flex d-md-none">
            {{-- Tombol Prev --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled"><a class="page-link" href="javascript:void(0);">←</a></li>
            @else
                <li class="page-item"><a class="page-link" href="{{ $paginator->previousPageUrl() }}">←</a></li>
            @endif

            <li class="page-item disabled">
                <a class="page-link" href="javascript:void(0);">
                    {{ $paginator->currentPage() }}/{{ $paginator->lastPage() }}
                </a>
            </li>

            {{-- Tombol Next --}}
            @if ($paginator->hasMorePages())
                <li class="page-item"><a class="page-link" href="{{ $paginator->nextPageUrl() }}">→</a></li>
            @else
                <li class="page-item disabled"><a class="page-link" href="javascript:void(0);">→</a></li>
            @endif
        </ul>
    </div>
@endif
