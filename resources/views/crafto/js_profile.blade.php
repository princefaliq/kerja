@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- ============================= -->
    <!-- JS EDIT FOTO -->
    <!-- ============================= -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let cropper;
            const btnEditFoto = document.getElementById('btnEditFoto');
            const fotoProfilEl = document.getElementById('foto-profil');
            const cropModalEl = document.getElementById('cropModal');
            const cropModal = new bootstrap.Modal(cropModalEl);
            const previewFoto = document.getElementById('previewFoto');
            const btnCrop = document.getElementById('btnCrop');

            // 🔹 Klik tombol edit foto → pilih gambar baru
            if (btnEditFoto) {
                btnEditFoto.addEventListener('click', function () {
                    const input = document.createElement('input');
                    input.type = 'file';
                    input.accept = 'image/*';

                    input.onchange = function (e) {
                        const file = e.target.files[0];
                        if (!file) return;

                        const reader = new FileReader();
                        reader.onload = function (event) {
                            previewFoto.src = event.target.result;
                            cropModal.show();
                        };
                        reader.readAsDataURL(file);
                    };

                    input.click();
                });
            }

            // 🔹 Saat modal tampil → inisialisasi CropperJS
            cropModalEl.addEventListener('shown.bs.modal', function () {
                cropper = new Cropper(previewFoto, {
                    aspectRatio: 3 / 4,
                    viewMode: 1,
                    autoCropArea: 1,
                    dragMode: 'move',
                    background: false,
                });
            });

            // 🔹 Saat modal ditutup → hancurkan cropper
            cropModalEl.addEventListener('hidden.bs.modal', function () {
                if (cropper) {
                    cropper.destroy();
                    cropper = null;
                }
                previewFoto.src = '';
            });

            // 🔹 Tombol "Crop & Simpan" ditekan
            btnCrop.addEventListener('click', function () {
                if (!cropper) return;

                const canvas = cropper.getCroppedCanvas({
                    width: 300,
                    height: 400,
                });

                const croppedImage = canvas.toDataURL('image/jpeg');

                // kirim via AJAX ke route update foto
                fetch('{{ route("profile.update-foto") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        cropped_pass_foto: croppedImage
                    })
                })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            // ganti foto di halaman tanpa reload
                            fotoProfilEl.src = data.foto_url + '?t=' + new Date().getTime();
                            cropModal.hide();
                        } else {
                            alert('Gagal memperbarui foto.');
                        }
                    })
                    .catch(err => {
                        console.error(err);
                        alert('Terjadi kesalahan saat upload foto.');
                    });
            });
        });
    </script>
    <!-- ============================= -->
    <!-- JS EDIT NAMA -->
    <!-- ============================= -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const btnEditNama = document.getElementById('btnEditNama');
            const displayNama = document.getElementById('display-nama');
            const inputNama = document.getElementById('input-nama');

            let isEditing = false;

            btnEditNama.addEventListener('click', function () {
                if (!isEditing) {
                    // Ganti ke mode edit
                    displayNama.classList.add('d-none');
                    inputNama.classList.remove('d-none');
                    inputNama.focus();

                    // Ganti ikon jadi centang
                    btnEditNama.innerHTML = '<i class="bi bi-check-lg text-success"></i>';
                    isEditing = true;
                } else {
                    // Simpan perubahan
                    const newName = inputNama.value.trim();
                    if (newName === '') {
                        alert('Nama tidak boleh kosong.');
                        return;
                    }

                    fetch('{{ route("profile.update-nama") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ name: newName })
                    })
                        .then(res => res.json())
                        .then(data => {
                            if (data.success) {
                                displayNama.textContent = data.name;
                                displayNama.classList.remove('d-none');
                                inputNama.classList.add('d-none');
                                btnEditNama.innerHTML = '<i class="bi bi-pencil-square text-base-color"></i>';
                                isEditing = false;
                            } else {
                                alert('Gagal menyimpan nama.');
                            }
                        })
                        .catch(err => {
                            console.error(err);
                            alert('Terjadi kesalahan saat menyimpan.');
                        });
                }
            });
        });
    </script>
    <!-- ============================= -->
    <!-- JS EDIT BIODATA -->
    <!-- ============================= -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const editModal = new bootstrap.Modal(document.getElementById('editDataModal'));
            const btnEditData = document.getElementById('btnEditData');
            const btnSimpanData = document.getElementById('btnSimpanData');

            btnEditData.addEventListener('click', () => {
                editModal.show();
            });

            btnSimpanData.addEventListener('click', () => {
                const form = document.getElementById('formEditData');
                const formData = new FormData(form);

                fetch('{{ route("profile.update-data") }}', {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                    body: formData
                })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            const tanggal = data.profile.tgl_lahir;
                            const dateObj = new Date(tanggal);
                            const options = { day: '2-digit', month: 'long', year: 'numeric' };
                            const formattedDate = new Intl.DateTimeFormat('id-ID', options).format(dateObj);
                            // update tampilan tanpa reload
                            document.getElementById('data-nik').textContent = data.profile.nik;
                            document.getElementById('data-tanggal').textContent = formattedDate;
                            document.getElementById('data-jk').textContent = data.profile.jenis_kelamin;
                            document.getElementById('data-status').textContent = data.profile.status_pernikahan;
                            document.getElementById('data-disabilitas').textContent = data.profile.disabilitas;
                            document.getElementById('data-alamat').textContent =
                                `${data.profile.provinsi}, ${data.profile.kabupaten}, ${data.profile.kecamatan}, ${data.profile.desa}, ${data.profile.alamat}`;

                            editModal.hide();
                        } else {
                            alert('Gagal menyimpan data.');
                        }
                    })
                    .catch(err => {
                        console.error(err);
                        alert('Terjadi kesalahan.');
                    });
            });
        });
    </script>
    <!-- ============================= -->
    <!-- JS EDIT DOKUMEN -->
    <!-- ============================= -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const btnEditDokumen = document.getElementById('btnEditDokumen');
            const modalEditDokumen = new bootstrap.Modal(document.getElementById('modalEditDokumen'));
            const btnSimpanDokumen = document.getElementById('btnSimpanDokumen');

            // 🔹 Tampilkan modal saat tombol edit diklik
            btnEditDokumen.addEventListener('click', () => {
                modalEditDokumen.show();
            });

            // 🔹 Simpan dokumen via fetch()
            btnSimpanDokumen.addEventListener('click', () => {
                const form = document.getElementById('formEditDokumen');
                const formData = new FormData(form);

                fetch('{{ route("profile.update-dokumen") }}', {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                    body: formData
                })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            modalEditDokumen.hide();
                            //alert('Dokumen berhasil diperbarui!');
                            location.reload(); // reload agar link dokumen diperbarui
                        } else {
                            alert('Gagal memperbarui dokumen.');
                        }
                    })
                    .catch(err => {
                        console.error(err);
                        alert('Terjadi kesalahan saat upload dokumen.');
                    });
            });
        });
    </script>
    <!-- ============================= -->
    <!-- JS HAPUS DOKUMEN SERTIFIKAT -->
    <!-- ============================= -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const buttons = document.querySelectorAll('.btnHapus');

            buttons.forEach(button => {
                button.addEventListener('click', function () {
                    const field = this.dataset.field;
                    const parent = this.closest('.col-md-4'); // sesuaikan jika struktur beda

                    Swal.fire({
                        title: 'Yakin ingin menghapus?',
                        text: `Dokumen ${field.replace('_', ' ')} akan dihapus permanen.`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal',
                        reverseButtons: true,
                        customClass: {
                            confirmButton: 'btn btn-danger',
                            cancelButton: 'btn btn-secondary'
                        },
                        buttonsStyling: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            fetch(`/profile/hapus-dokumen/${field}`, {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                    'Accept': 'application/json',
                                }
                            })
                                .then(res => res.json())
                                .then(data => {
                                    if (data.success) {
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Berhasil!',
                                            text: data.message,
                                            timer: 1500,
                                            showConfirmButton: false
                                        });

                                        if (parent) {
                                            let iconHTML = '';
                                            let textHTML = '';

                                            if (field === 'sertifikat') {
                                                iconHTML = '<i class="feather icon-feather-award me-1"></i>';
                                                textHTML = 'Sertifikat (tidak tersedia)';
                                            } else if (field === 'syarat_lain') {
                                                iconHTML = '<i class="feather icon-feather-clipboard me-1"></i>';
                                                textHTML = 'Syarat Lain (tidak tersedia)';
                                            } else {
                                                iconHTML = '<i class="feather icon-feather-file me-1"></i>';
                                                textHTML = `${field.replace('_', ' ')} belum diunggah`;
                                            }

                                            parent.innerHTML = `
                                                <span class="text-muted">${iconHTML}${textHTML}</span>
                                            `;
                                        }
                                    } else {
                                        Swal.fire('Gagal!', 'Tidak dapat menghapus dokumen.', 'error');
                                    }
                                })
                                .catch(err => {
                                    console.error(err);
                                    Swal.fire('Kesalahan!', 'Terjadi kesalahan server.', 'error');
                                });
                        }
                    });
                });
            });
        });
    </script>

    <!-- ============================= -->
    <!-- JS WILAYAH -->
    <!-- ============================= -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const provinsiSelect = document.getElementById('provinsi');
            const kabupatenSelect = document.getElementById('kabupaten');
            const kecamatanSelect = document.getElementById('kecamatan');
            const desaSelect = document.getElementById('desa');

            const selectedProvinsi = provinsiSelect.dataset.selected;
            const selectedKabupaten = kabupatenSelect.dataset.selected;
            const selectedKecamatan = kecamatanSelect.dataset.selected;
            const selectedDesa = desaSelect.dataset.selected;

            // --- Provinsi ---
            fetch('/api/wilayah/provinces')
                .then(res => res.json())
                .then(data => {
                    (data.data || []).forEach(prov => {
                        const opt = document.createElement('option');
                        opt.value = prov.name; // value = nama
                        opt.textContent = prov.name;
                        opt.dataset.code = prov.code;
                        provinsiSelect.appendChild(opt);
                    });
                    if (selectedProvinsi) provinsiSelect.value = selectedProvinsi;
                    if (selectedProvinsi) provinsiSelect.dispatchEvent(new Event('change'));
                });

            // --- Kabupaten ---
            provinsiSelect.addEventListener('change', function () {
                const provinceCode = this.selectedOptions[0]?.dataset.code;
                kabupatenSelect.innerHTML = '<option value="">Pilih Kabupaten/Kota</option>';
                kecamatanSelect.innerHTML = '<option value="">Pilih Kecamatan</option>';
                desaSelect.innerHTML = '<option value="">Pilih Desa/Kelurahan</option>';
                if (!provinceCode) return;

                fetch(`/api/wilayah/regencies/${provinceCode}`)
                    .then(res => res.json())
                    .then(data => {
                        (data.data || []).forEach(kab => {
                            const opt = document.createElement('option');
                            opt.value = kab.name; // value = nama
                            opt.textContent = kab.name;
                            opt.dataset.code = kab.code;
                            kabupatenSelect.appendChild(opt);
                        });
                        if (selectedKabupaten) kabupatenSelect.value = selectedKabupaten;
                        if (selectedKabupaten) kabupatenSelect.dispatchEvent(new Event('change'));
                    });
            });

            // --- Kecamatan ---
            kabupatenSelect.addEventListener('change', function () {
                const regencyCode = this.selectedOptions[0]?.dataset.code;
                kecamatanSelect.innerHTML = '<option value="">Pilih Kecamatan</option>';
                desaSelect.innerHTML = '<option value="">Pilih Desa/Kelurahan</option>';
                if (!regencyCode) return;

                fetch(`/api/wilayah/districts/${regencyCode}`)
                    .then(res => res.json())
                    .then(data => {
                        (data.data || []).forEach(kec => {
                            const opt = document.createElement('option');
                            opt.value = kec.name; // value = nama
                            opt.textContent = kec.name;
                            opt.dataset.code = kec.code;
                            kecamatanSelect.appendChild(opt);
                        });
                        if (selectedKecamatan) kecamatanSelect.value = selectedKecamatan;
                        if (selectedKecamatan) kecamatanSelect.dispatchEvent(new Event('change'));
                    });
            });

            // --- Desa ---
            kecamatanSelect.addEventListener('change', function () {
                const districtCode = this.selectedOptions[0]?.dataset.code;
                desaSelect.innerHTML = '<option value="">Pilih Desa/Kelurahan</option>';
                if (!districtCode) return;

                fetch(`/api/wilayah/villages/${districtCode}`)
                    .then(res => res.json())
                    .then(data => {
                        (data.data || []).forEach(des => {
                            const opt = document.createElement('option');
                            opt.value = des.name; // value = nama
                            opt.textContent = des.name;
                            opt.dataset.code = des.code;
                            desaSelect.appendChild(opt);
                        });
                        if (selectedDesa) desaSelect.value = selectedDesa;
                    });
            });
        });

    </script>
@endpush
