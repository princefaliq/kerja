<div class="menu menu-rounded menu-column menu-lg-row menu-root-here-bg-desktop menu-active-bg menu-state-primary menu-title-gray-800 menu-arrow-gray-500 align-items-stretch flex-grow-1 my-5 my-lg-0 px-2 px-lg-0 fw-semibold fs-6" id="#kt_header_menu" data-kt-menu="true">
    <!--begin:Menu item-->
    <div data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="bottom-start" class="menu-item @if(View::hasSection('dashboard')) here show @endif me-0 me-lg-2">
        <!--begin:Menu link-->
        <a href="{{ url('app') }}" class="menu-link py-3">
            <span class="menu-title">Dashboards</span>
            <span class="menu-arrow d-lg-none"></span>
        </a>
        <!--end:Menu link-->
    </div>
    @role('Admin|Perusahaan')
        <div data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="bottom-start" class="menu-item @if(View::hasSection('lowongan')) here show @endif me-0 me-lg-2">
            <!--begin:Menu link-->
            <a href="{{ url('app/lowongan') }}" class="menu-link py-3">
                <span class="menu-title">Lowongan</span>
                <span class="menu-arrow d-lg-none"></span>
            </a>
            <!--end:Menu link-->
        </div>
    @endrole
    @role('Admin|Perusahaan')
    <div data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="bottom-start" class="menu-item @if(View::hasSection('lamaran')) here show @endif me-0 me-lg-2">
        <!--begin:Menu link-->
        <a href="{{ url('app/lamaran') }}" class="menu-link py-3">
            <span class="menu-title">Lamaran</span>
            <span class="menu-arrow d-lg-none"></span>
        </a>
        <!--end:Menu link-->
    </div>
    @endrole
    <!--end:Menu item-->
    @role('Admin')
        <div data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="bottom-start" class="menu-item @if(View::hasSection('absen')) here show @endif me-0 me-lg-2">
            <!--begin:Menu link-->
            <a href="{{ url('app/absen/qr') }}" class="menu-link py-3">
                <span class="menu-title">Absen</span>
                <span class="menu-arrow d-lg-none"></span>
            </a>
            <!--end:Menu link-->
        </div>
    <div data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="bottom-start" class="menu-item @if(View::hasSection('testimoni')) here show @endif me-0 me-lg-2">
        <!--begin:Menu link-->
        <a href="{{ route('testimoni.index') }}" class="menu-link py-3">
            <span class="menu-title">Testimoni</span>
            <span class="menu-arrow d-lg-none"></span>
        </a>
        <!--end:Menu link-->
    </div>
        <div data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="bottom-start" class="menu-item @if(View::hasSection('user')) here show @endif me-0 me-lg-2">
            <!--begin:Menu link-->
            <span class="menu-link py-3">
                <span class="menu-title">User</span>
                <span class="menu-arrow d-lg-none"></span>
            </span>
            <div class="menu-sub menu-sub-lg-down-accordion menu-sub-lg-dropdown px-lg-2 py-lg-4 w-lg-250px">
                <div data-kt-menu-trigger="{default:'click', lg: 'hover'}" data-kt-menu-placement="right-start" class="menu-item here show menu-lg-down-accordion">
                    <div class="menu-item py-3">
                        <!--begin:Menu link-->
                        <a class="menu-link py-3 @if(View::getSection('title')=== 'List User') active @endif" href="{{ url('app/pelamar') }}">
                            <span class="menu-icon">
                                <i class="ki-duotone ki-security-user fs-2">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                            </span>
                                <span class="menu-title">Pelamar</span>
                        </a>
                        <!--end:Menu link-->
                        <!--begin:Menu link-->
                        <a class="menu-link py-3 @if(View::getSection('title')=== 'List Perusahaan') active @endif" href="{{ url('app/perusahaan') }}">
                            <span class="menu-icon">
                                <i class="ki-duotone ki-scan-barcode fs-2">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                    <span class="path3"></span>
                                    <span class="path4"></span>
                                    <span class="path5"></span>
                                    <span class="path6"></span>
                                    <span class="path7"></span>
                                    <span class="path8"></span>
                                </i>
                            </span>
                                <span class="menu-title">Perusahaan</span>
                        </a>
                        <!--end:Menu link-->
                        <!--begin:Menu link-->
                        <a class="menu-link py-3" href="{{ url('app/user') }}">
                        <span class="menu-icon">
                            <i class="ki-duotone ki-shield-tick fs-2">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                        </span>
                            <span class="menu-title">User All</span>
                        </a>
                        <!--end:Menu link-->
                    </div>
                </div>

            </div>
            {{--<a href="{{ url('app/user') }}" class="menu-link py-3">
                <span class="menu-title">User</span>
                <span class="menu-arrow d-lg-none"></span>
            </a>--}}
            <!--end:Menu link-->
        </div>
    @endrole
</div>
@push('js')
    <script>
        const menuItems = document.querySelectorAll('.menu-link');

        menuItems.forEach(item => {
            item.addEventListener('click', function() {
                menuItems.forEach(i => i.parentElement.classList.remove('active'));
                this.parentElement.classList.add('active');
            });
        });
    </script>
@endpush
