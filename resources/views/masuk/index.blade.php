@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if (session('duplikat_serial'))
            <div class="alert alert-warning">
                <strong>Serial Number duplikat:</strong>
                <ul>
                    @foreach (session('duplikat_serial') as $serial)
                        <li>{{ $serial }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('invalid_rows'))
            <div class="alert alert-danger">
                <strong>Baris tidak valid:</strong>
                <ul>
                    @foreach (session('invalid_rows') as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Header dan Tombol Aksi --}}
        <div class="row mb-3">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex flex-wrap align-items-center justify-content-between breadcrumb-content">
                            <h5>List Perangkat Masuk</h5>
                            <div class="pl-3 border-left btn-new">
                                @can('masuk.create')
                                    <a href="{{ route('masuk.create') }}" class="btn btn-primary">Tambah Barang</a>
                                @endcan
                                @can('masuk.create')
                                    <button type="button" class="btn btn-success" data-toggle="modal"
                                        data-target="#importModal">
                                        <i class="bi bi-file-earmark-spreadsheet"></i> <span>Import Excel</span>
                                    </button>
                                @endcan
                                <a href="{{ route('report.download.masuk', 'excel') }}" class="btn btn-success">
                                    <i class="bi bi-file-earmark-spreadsheet"></i> <span>Export Excel</span>
                                </a>
                                @can('masuk.update')
                                    <button class="btn btn-warning" id="btn-multi-edit" data-toggle="modal"
                                        data-target="#multiEditModal" disabled>
                                        <i class="bi bi-pencil"></i> Multi Edit
                                    </button>
                                @endcan
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
                        <div class="col-4 mb-2"><x-inputs.select-merk id="filter-merk" selectId="nama" /></div>
                        <div class="col-4 mb-2"><input type="text" id="filter-spesifikasi" class="form-control"
                                placeholder="Spesifikasi"></div>
                        <div class="col-4 mb-2"><x-inputs.select-kategori id="filter-kategori" selectId="nama" /></div>
                        <div class="col-4 mb-2"><x-inputs.select-keadaan id="filter-keadaan" selectId="nama" /></div>
                        <div class="col-4 mb-2"><x-inputs.select-lokasi id="filter-lokasi" selectId="nama" /></div>
                        <div class="col-4 mb-2"><input type="text" id="filter-keterangan" class="form-control"
                                placeholder="Keterangan"></div>
                        <div class="col-4 mb-2"><label>Tanggal Masuk</label><input type="date" id="filter-tanggal_masuk"
                                class="form-control" placeholder="Tanggal Masuk"></div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table id="barangTable" class="table table-bordered">
                        <thead>
                            <tr>
                                @can('masuk.update')
            <th><input type="checkbox" id="select-all"></th>
        @endcan
                                <th>No</th>
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
                                <th>Tanggal Masuk</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Import -->
    <div class="modal fade" id="importModal" tabindex="-1" role="dialog" aria-labelledby="importModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="{{ route('masuk.import.excel') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="importModalLabel">Import Data Barang Masuk</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <div class="form-group">
                            <label for="fileExcel" class="form-label">Pilih File Excel (.xlsx)</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="fileExcel" name="file"
                                    accept=".xlsx">
                                <label class="custom-file-label" for="fileExcel">Tidak ada file yang dipilih</label>
                            </div>
                        </div>

                        <a href="/assets/docs/template_barang_masuk.xlsx" class="btn btn-info">Download Template Excel</a>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-success">Import</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Multi Edit -->
    <div class="modal fade" id="multiEditModal" tabindex="-1" role="dialog" aria-labelledby="multiEditModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form id="formMultiEdit" method="POST" action="{{ route('masuk.multi-edit') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="barang_ids" id="selectedBarangIds">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Multi Edit - Pindahkan Barang</h5>
                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Pindahkan ke</label>
                            <select class="form-control" name="tujuan" id="tujuanSelect" required>
                                <option value="">-- Pilih Tujuan --</option>
                                <option value="keluar">Barang Keluar</option>
                                <option value="peminjaman">Peminjaman</option>
                            </select>
                        </div>

                        <div id="keluarFields" style="display: none;">
    <div class="form-group">
        <label>Tanggal Keluar</label>
        <input type="date" class="form-control" name="tanggal_keluar">
    </div>

    <div class="form-group">
        <label>Upload Berita Acara (PDF)</label>
        <input type="file" class="form-control-file" name="berita_acara" accept=".pdf">
    </div>

    <div class="form-group">
        <label>Keterangan</label>
        <textarea class="form-control" name="keterangan_keluar" rows="3" placeholder="Tambahkan keterangan jika diperlukan..."></textarea>
    </div>
</div>


                        <div id="peminjamanFields" style="display: none;">
                            <div class="form-group">
                                <label>Tanggal BASTP</label>
                                <input type="date" class="form-control" name="tanggal_bastp">
                            </div>
                            <div class="form-group">
                                <label>Tanggal Selesai</label>
                                <input type="date" class="form-control" name="tanggal_selesai">
                            </div>
                            <div class="form-group">
                                <label>Nomor Surat</label>
                                <input type="text" class="form-control" name="nomor_surat">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        const table = $("#barangTable").DataTable({
            ajax: {
                url: "{{ url('/masuk') }}",
                type: 'GET',
            },
            lengthMenu: [
                [10, 25, 50, 100, 1000, 100000],
                [10, 25, 50, 100, 1000, 100000]
            ],
            columns: [
    @can('masuk.update')
    {
        data: null,
        orderable: false,
        searchable: false,
        render: function(data) {
            return `<input type="checkbox" class="select-barang" value="${data.barang_id}">`;
        }
    },
    @endcan
                {
                    data: null,
                    render: function(data, type, row, meta) {
                        return meta.row + 1;
                    },
                    orderable: false,
                    searchable: false,
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
                    name: 'keterangan'
                },
                {
                    data: 'tanggal_masuk',
                    name: 'masuk.tanggal_masuk'
                },
                {
                    data: null,
                    render: function(data, type, row) {
                        return `
                    <div class="d-flex">
                        @can('masuk.update')
                      <a  href="/masuk/edit/${data.barang_id}"
                        class="btn btn-sm btn-warning text-white btn-edit-barang mr-2"
                            >
                            <i class="bi bi-pencil-square"></i>
                        </a>
                        @endcan
                        @can('masuk.delete')
                        <a href="javascript:void(0)" class="btn btn-sm btn-danger btn-delete-barang" data-id="${data.barang_id}">
                            <i class="bi bi-trash"></i>
                        </a>
                        @endcan
                    </div>
                      `;
                    },
                    orderable: false,
                    searchable: false,
                },
            ],

            createdRow: (row, data, dataIndex) => {
                $(row).find(`.show-action-pop`).on('click', function() {
                    showActionDetail(data);
                });
            },
            language: {
                emptyTable: "Data not found.",
                processing: 'Processing data...',
            },
            responsive: true,
            processing: true,
            serverSide: true,
            orderCellsTop: true,
            initComplete: function() {
                const api = this.api();

                // Mapping column names to indexes (adjust if column order changes)
                const columnIndexes = {
                    'kode_rak': 2,
                    'serial_number': 3,
                    'kode_material': 4,
                    'merk': 5,
                    'spesifikasi': 6,
                    'kategori': 7,
                    'keadaan': 8,
                    'lokasi': 9,
                    'status': 10,
                    'keterangan': 11,
                    'tanggal_masuk': 12,
                };

                Object.entries(columnIndexes).forEach(([key, index]) => {
                    $(`#filter-${key}`).on('keyup change', function() {
                        api.column(index).search(this.value).draw();
                    });
                });
            }

        });
    </script>

    <script>
        document.querySelector('.custom-file-input').addEventListener('change', function(e) {
            var fileName = document.getElementById("fileExcel").files[0].name;
            var nextSibling = e.target.nextElementSibling;
            nextSibling.innerText = fileName;
        });
    </script>
    <script>
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

        // Checkbox logic
        $(document).on('change', '.select-barang, #select-all', function() {
            if (this.id === 'select-all') {
                $('.select-barang').prop('checked', this.checked);
            }

            const anyChecked = $('.select-barang:checked').length > 0;
            $('#btn-multi-edit').prop('disabled', !anyChecked);
        });

        // Tujuan dropdown toggle
        $('#tujuanSelect').on('change', function() {
            const tujuan = $(this).val();
            $('#keluarFields').toggle(tujuan === 'keluar');
            $('#peminjamanFields').toggle(tujuan === 'peminjaman');
        });

        // On submit, inject selected IDs
        $('#formMultiEdit').on('submit', function() {
            const selectedIds = $('.select-barang:checked').map(function() {
                return this.value;
            }).get();
            $('#selectedBarangIds').val(selectedIds.join(','));
        });
        let selectedBarang = new Set();

// Saat checkbox dicentang/di-uncheck
$(document).on('change', '.select-barang', function () {
    const id = $(this).val();
    if (this.checked) {
        selectedBarang.add(id);
    } else {
        selectedBarang.delete(id);
    }

    $('#btn-multi-edit').prop('disabled', selectedBarang.size === 0);
});

// Saat "select all" di klik
$(document).on('change', '#select-all', function () {
    const checked = this.checked;
    $('.select-barang').each(function () {
        const id = $(this).val();
        $(this).prop('checked', checked);
        if (checked) {
            selectedBarang.add(id);
        } else {
            selectedBarang.delete(id);
        }
    });

    $('#btn-multi-edit').prop('disabled', selectedBarang.size === 0);
});

// Saat tabel selesai di-render ulang, tandai checkbox yang sudah dipilih
table.on('draw', function () {
    $('.select-barang').each(function () {
        const id = $(this).val();
        $(this).prop('checked', selectedBarang.has(id));
    });

    // Update "select all" status
    const allVisible = $('.select-barang').length === $('.select-barang:checked').length;
    $('#select-all').prop('checked', allVisible);

    $('#btn-multi-edit').prop('disabled', selectedBarang.size === 0);
});

// Saat submit, masukkan data ID yang tersimpan ke form hidden input
$('#formMultiEdit').on('submit', function () {
    $('#selectedBarangIds').val([...selectedBarang].join(','));
});

    </script>
@endpush
