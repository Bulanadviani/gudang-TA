@extends('layouts.app')

@section('content')
<div class="container-fluid">

    {{-- Header dan Tombol Aksi --}}
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex flex-wrap align-items-center justify-content-between breadcrumb-content">
                        <h5>List Peminjaman Perangkat</h5>
                        <div class="pl-3 border-left btn-new">
                            <a href="{{route('report.download.peminjaman','excel')}}" class="btn btn-success">
                                <i class="bi bi-file-earmark-spreadsheet"></i> <span>Export Excel</span>
                            </a>
                            @can('peminjaman.update')
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

    @if($notif_7_hari > 0)
    <div class="alert alert-warning alert-dismissible fade show" id="notif-7-hari" role="alert">
        <i class="bi bi-bell-fill"></i> &nbsp; <span>{{$notif_7_hari}} Perangkat mendekati akhir masa sewa 7 hari kedepan</span>
        <button type="button" class="close text-danger mt-1" data-dismiss="alert" aria-label="Close">
            <i class="bi bi-x-circle"></i>
        </button>
    </div>
    @endif
    @if($notif_terlambat > 0 )
    <div class="alert alert-danger alert-dismissible fade show" id="notif-terlambat" role="alert">
        <i class="bi bi-bell-fill"></i> &nbsp; <span>{{$notif_terlambat}} Perangkat melewati masa peminjaman</span>
        <button type="button" class="close text-danger mt-1" data-dismiss="alert" aria-label="Close">
            <i class="bi bi-x-circle"></i>
        </button>
    </div>
    @endif


    {{-- Tabel Barang --}}
    <div class="card">
        <div class="card-body">
            <p>
                <button class="btn btn-info" type="button" data-toggle="collapse" data-target="#advanced-search" aria-expanded="false" aria-controls="collapseExample">
                    <i class="bi bi-search"></i> <span>Advanced Search</span>
                </button>
            </p>
            <div class="collapse" id="advanced-search">
                <div id="column-filters" class="row g-4 mb-3">
                    <div class="col-4 mb-2"><input type="text" id="filter-nomor_surat" class="form-control" placeholder="Nomor Surat"></div>
                    <div class="col-4 mb-2"><input type="text" id="filter-serial_number" class="form-control" placeholder="Serial Number"></div>
                    <div class="col-4 mb-2"><input type="text" id="filter-kode_material" class="form-control" placeholder="Kode Material"></div>
                    <div class="col-4 mb-2"><x-inputs.select-merk id="filter-merk" selectId="nama"/></div>
                    <div class="col-4 mb-2"><input type="text" id="filter-spesifikasi" class="form-control" placeholder="Spesifikasi"></div>
                    <div class="col-4 mb-2"><x-inputs.select-kategori id="filter-kategori" selectId="nama" /></div>
                    <div class="col-4 mb-2"><label>Tanggal BASTP</label><input type="date" id="filter-tanggal_bastp" class="form-control" placeholder="Tanggal BASTP"></div>
                    <div class="col-4 mb-2"><label>Tanggal Selesai</label><input type="date" id="filter-tanggal_selesai" class="form-control" placeholder="Tanggal selesai"></div>
                    <div class="col-4 mb-2"><input type="text" id="filter-pic" class="form-control" placeholder="PIC"></div>
                    <div class="col-4 mb-2"><input type="text" id="filter-keterangan" class="form-control" placeholder="Keterangan"></div>
                </div>
            </div>

            <div class="table-responsive">
                <table id="barangTable" class="table table-bordered">
                    <thead>
                        <tr>
                            <th><input type="checkbox" id="select-all"></th>
                            <th>Nomor Surat</th>
                            <th>Serial Number</th>
                            <th>Kode Material</th>
                            <th>Merk</th>
                            <th>Spesifikasi</th>
                            <th>Kategori</th>
                            <th>Tanggal BASTP</th>
                            <th>Tanggal Selesai</th>
                            <th>PIC</th>
                            <th>Keterangan</th>
                            <th>Sisa Waktu</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Multi Edit -->
    <div class="modal fade" id="multiEditModal" tabindex="-1" role="dialog" aria-labelledby="multiEditModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form id="formMultiEdit" method="POST" action="{{ route('peminjaman.multi-edit') }}">
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
                                <option value="masuk">Barang Masuk</option>
                                <option value="keluar">Barang Keluar</option>
                            </select>
                        </div>

                        <div id="masukFields" style="display: none;">
                            <div class="form-group">
                                <label>Tanggal Masuk</label>
                                <input type="date" class="form-control" name="tanggal_masuk">
                            </div>
                        </div>

                        <div id="keluarFields" style="display: none;">
                            <div class="form-group">
                                <label>Tanggal Keluar</label>
                                <input type="date" class="form-control" name="tanggal_keluar">
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
        lengthMenu: [[10, 25, 50, 100, 1000, 100000], [10, 25, 50, 100, 1000, 100000]],
        ajax: {
            url: "{{ url('/peminjaman') }}",
            type: 'GET',
        },
        columns: [{
            data: null,
        orderable: false,
        searchable: false,
        render: function(data) {
            return `<input type="checkbox" class="select-barang" value="${data.barang_id}">`;
        }
    },
    {
                data: 'nomor_surat',
                name: 'peminjaman.nomor_surat'
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
                data: 'tanggal_bastp',
                name: 'peminjaman.tanggal_bastp'
            },
            {
                data: 'tanggal_selesai',
                name: 'peminjaman.tanggal_selesai'
            },
            {
                data: 'pic',
                name: 'users.name'
            },
            {
                data: 'keterangan',
                name: 'barang.keterangan'
            },
            {
                data: 'sisa_waktu',
                name: 'sisa_waktu',
                searchable: false
            },
            {
                data: null,
                render: function(data, type, row) {
                    return `
                    <div class="d-flex">
                    @can('peminjaman.update')
                      <a href="/peminjaman/edit/${data.barang_id}"
                        class="btn btn-sm btn-warning text-white btn-edit-barang mr-2"
                            >
                            <i class="bi bi-pencil-square"></i>
                        </a>
                    @endcan
                    </div>
                      `
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
                'nomor_surat': 1,
                'serial_number': 2,
                'kode_material': 3,
                'merk': 4,
                'spesifikasi': 5,
                'kategori': 6,
                'tanggal_bastp': 7,
                'tanggal_selesai': 8,
                'pic': 9,
                'keterangan': 10,
            };

            Object.entries(columnIndexes).forEach(([key, index]) => {
                $(`#filter-${key}`).on('keyup change', function() {
                    api.column(index).search(this.value).draw();
                });
            });
        }

    });

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
            $('#masukFields').toggle(tujuan === 'masuk');
            $('#keluarFields').toggle(tujuan === 'keluar');
        });

        // On submit, inject selected IDs
        $('#formMultiEdit').on('submit', function() {
            const selectedIds = $('.select-barang:checked').map(function() {
                return this.value;
            }).get();
            $('#selectedBarangIds').val(selectedIds.join(','));
        });
</script>
@endpush