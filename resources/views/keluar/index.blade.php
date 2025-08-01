@extends('layouts.app')

@section('content')
    <div class="container-fluid">

        {{-- Header dan Tombol Aksi --}}
        <div class="row mb-3">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex flex-wrap align-items-center justify-content-between breadcrumb-content">
                            <h5>List Perangkat Keluar</h5>
                            <div class="pl-3 border-left btn-new">
                                <a href="{{ route('report.download.keluar', 'excel') }}" class="btn btn-success">
                                    <i class="bi bi-file-earmark-spreadsheet"></i> <span>Export Excel</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tabel Barang --}}
        <div class="card">
            <div class="card-body">
                <p>
                    <button class="btn btn-info" type="button" data-toggle="collapse" data-target="#advanced-search"
                        aria-expanded="false" aria-controls="collapseExample">
                        <i class="bi bi-search"></i> <span>Advanced Search</span>
                    </button>
                </p>
                <div class="collapse" id="advanced-search">
                    <div id="column-filters" class="row g-4 mb-3">
                        <div class="col-4 mb-2"><input type="text" id="filter-kode_rak" class="form-control"
                                placeholder="Kode Rak"></div>
                        <div class="col-4 mb-2"><input type="text" id="filter-serial_number" class="form-control"
                                placeholder="Serial Number"></div>
                        <div class="col-4 mb-2"><input type="text" id="filter-kode_material" class="form-control"
                                placeholder="Kode Material"></div>
                        <div class="col-4 mb-2"><x-inputs.select-merk  id="filter-merk" selectId="nama"/></div>
                        <div class="col-4 mb-2"><input type="text" id="filter-spesifikasi" class="form-control"
                                placeholder="Spesifikasi"></div>
                        <div class="col-4 mb-2"><x-inputs.select-kategori id="filter-kategori" selectId="nama" /></div>
                        <div class="col-4 mb-2"><x-inputs.select-keadaan id="filter-keadaan" selectId="nama" /></div>
                        <div class="col-4 mb-2"><x-inputs.select-lokasi id="filter-lokasi" selectId="nama" /></div>
                        <div class="col-4 mb-2"><input type="text" id="filter-keterangan" class="form-control"
                                placeholder="Keterangan"></div>
                        <div class="col-4 mb-2"><label>Tanggal Keluar</label><input type="date" id="filter-tanggal_keluar" class="form-control" placeholder="Tanggal Keluar"></div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table id="keluar-table" class="table table-bordered table-striped w-100">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Kode Rak</th>
                                <th>Serial Number</th>
                                <th>Kode Material</th>
                                <th>Merk</th>
                                <th>Spesifikasi</th>
                                <th>Kategori</th>
                                <th>Keadaan</th>
                                <th>Lokasi</th>
                                <th>Status</th>
                                <th>Keterangan</th>
                                <th>Tanggal Keluar</th>
                                <th>Bukti Serah Terima</th>
                                <th>File Berita Acara</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- upload bukti -->
    <div class="modal fade" id="uploadModal" tabindex="-1" role="dialog" aria-labelledby="uploadModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="uploadModalLabel">Upload File</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="close-upload-modal">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('keluar.upload-bukti', ':id') }}" class="dropzone" id="myDropzone"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="dz-message d-flex flex-column">
                            <i class="bi bi-cloud-upload"></i>
                            Drag &amp; Drop here or click
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .dropzone {
            border: 2px dashed #dedede;
            border-radius: 5px;
            background: #f5f5f5;
        }

        .dropzone i {
            font-size: 5rem;
        }

        .dropzone .dz-message {
            color: #75B5FF;
            font-weight: 500;
            font-size: initial;
            text-transform: uppercase;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        const table = $("#keluar-table").DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: {
                url: "{{ url('/keluar') }}",
                type: 'GET',
            },
            lengthMenu: [[10, 25, 50, 100, 1000, 100000], [10, 25, 50, 100, 1000, 100000]],
            columns: [{
                    data: null,
                    name: 'no',
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },

                {
                    data: 'kode_rak',
                    name: 'barang.kode_rak'
                },
                {
                    data: 'serial_number',
                    name: 'barang.serial_number'
                },
                {
                    data: 'kode_material',
                    name: 'barang.kode_material'
                },
                {
                    data: 'merk',
                    name: 'merk.nama'
                },
                {
                    data: 'spesifikasi',
                    name: 'barang.spesifikasi'
                },
                {
                    data: 'kategori',
                    name: 'kategori.nama'
                },
                {
                    data: 'keadaan',
                    name: 'keadaan.nama'
                },
                {
                    data: 'lokasi',
                    name: 'lokasi.nama'
                },
                {
                    data: 'status',
                    name: 'status.nama'
                },
                {
                    data: 'keterangan',
                    name: 'barang.keterangan'
                },
                {
                    data: 'tanggal_keluar',
                    name: 'keluar.tanggal_keluar'
                },
                {
                    data: 'bukti_pengeluaran',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'aksi',
                    orderable: false,
                    searchable: false
                }
            ]
        });

        const columnIndexes = {
            'kode_rak': 1,
            'serial_number': 2,
            'kode_material': 3,
            'merk': 4,
            'spesifikasi': 5,
            'kategori': 6,
            'keadaan': 7,
            'lokasi': 8,
            'status': 9,
            'keterangan': 10,
            'tanggal_keluar': 11,
        };

        table.on('init.dt', function() {
            Object.entries(columnIndexes).forEach(([key, index]) => {
                $(`#filter-${key}`).on('keyup change', function() {
                    table.column(index).search(this.value).draw();
                });
            });
        });
    </script>

    <script>
        table.on('draw.dt', function() {
            $(document).on('click', '.btn-delete-barang', function() {
                const barangId = $(this).data('id');
                Swal.fire({
                    title: "Apakah yakin hapus barang",
                    showCancelButton: true,
                    confirmButtonColor: "#731817",
                    confirmButtonText: "Hapus",
                    denyButtonText: `Batal`,

                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/barang/${barangId}`,
                            method: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                _method: 'DELETE'
                            },
                            success: function(response) {
                                showAlert('success', response.message);
                                table.ajax.reload(null, false);
                            },
                            error: function(xhr) {
                                let errorMessage =
                                    'An error occurred while deleting. Please try again.';
                                if (xhr.responseJSON && xhr.responseJSON.error) {
                                    errorMessage = xhr.responseJSON.error;
                                }
                                showAlert('error', errorMessage);
                            }
                        });
                    }
                });
            });
        });
    </script>
    <script>
        Dropzone.autoDiscover = false;
        let uploadUrl = "{{ route('keluar.upload-bukti', ':id') }}";
        const myDropzone = new Dropzone("#myDropzone", {
            url: uploadUrl, // default, will be replaced on button click
            maxFiles: 1,
            acceptedFiles: 'image/*,application/pdf,.doc,.docx,.xls,.xlsx',
            addRemoveLinks: true,
            dictDefaultMessage: "Drop a file here or click to upload.",
            init: function() {
                this.on("maxfilesexceeded", function(file) {
                    this.removeAllFiles();
                    this.addFile(file);
                });
                this.on("success", function(file, response) {
                    $('#uploadModal').modal('hide');
                    this.removeAllFiles();
                    $("#close-upload-modal").trigger("click")
                    showAlert("success", "File bukti berhasil diupload")
                    table.ajax.reload(null, false);
                });
                this.on("error", function(file, response) {
    let message = "Terjadi kesalahan saat upload.";

    if (typeof response === "object" && response.message) {
        message = response.message;
    } else if (typeof response === "string") {
        message = response;
    }

    showAlert("error", message);
});
            }
        });

        $(document).on('click', '.btn-upload-file', function() {
            let keluarId = $(this).data('keluar-id');
            // Set URL upload sesuai id keluar
            myDropzone.options.url = uploadUrl.replace(":id", keluarId);
            let myModal = new bootstrap.Modal(document.getElementById('uploadModal'));
            myModal.show();
        });
    </script>
    <script>
        $(document).on('click', '.btn-delete-file', function() {
            let keluarId = $(this).data('keluar-id');
            Swal.fire({
                title: 'Yakin hapus file bukti?',
                text: "File yang dihapus tidak dapat dikembalikan.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '/keluar/delete-bukti/' + keluarId,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            showAlert('success', response.message);
                            table.ajax.reload(null, false);
                        },
                        error: function(xhr) {
                            showAlert('error', 'Gagal menghapus file');
                        }
                    });
                }
            });
        });
    </script>
@endpush
