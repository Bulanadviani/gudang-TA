@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <div class="row mb-3">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex flex-wrap align-items-center justify-content-between breadcrumb-content">
                        <h5>Edit Perangkat - {{ $barang->serial_number }}</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="card">
        <div class="card-body">
            <form id="editBarangForm" method="POST" action="{{ route('barang.update', $barang->id) }}">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-12"> {{-- Gunakan satu kolom penuh jika hanya ada sedikit field terlihat --}}
                        {{-- Hidden fields untuk data yang tidak ditampilkan, tapi tetap dikirim --}}
                        <input type="hidden" name="kode_rak" value="{{ old('kode_rak', $barang->kode_rak) }}">
                        <input type="hidden" name="serial_number" value="{{ old('serial_number', $barang->serial_number) }}">
                        <input type="hidden" name="kode_material" value="{{ old('kode_material', $barang->kode_material) }}">
                        <input type="hidden" name="merk" value="{{ old('merk', $barang->merk_id) }}"> {{-- Pastikan ini merk_id, bukan merk --}}
                        <input type="hidden" name="spesifikasi" value="{{ old('spesifikasi', $barang->spesifikasi) }}">
                        <input type="hidden" name="kategori" value="{{ old('kategori', $barang->kategori_id) }}"> {{-- Pastikan ini kategori_id --}}
                        <input type="hidden" name="keadaan" value="{{ old('keadaan', $barang->keadaan_id) }}"> {{-- Pastikan ini keadaan_id --}}
                        <input type="hidden" name="lokasi" value="{{ old('lokasi', $barang->lokasi_id) }}"> {{-- Pastikan ini lokasi_id --}}

                        {{-- Field Status (yang ingin ditampilkan) --}}
                        <div class="form-group">
                            <label>Status</label>
                            <x-inputs.select-status id="status" :selected="old('status', $barang->status_id)" :onchange="'function() { toggleStatusForm(); }'" :class="($errors->has('status') ? 'is-invalid' : '')"/>
                            @error('status') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        
                        {{-- Field Keterangan (yang ingin ditampilkan) --}}
                        <div class="form-group">
                            <label>Keterangan</label>
                            <textarea name="keterangan" class="form-control @error('keterangan') is-invalid @enderror">{{ old('keterangan', $barang->keterangan) }}</textarea>
                            @error('keterangan') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 status-form" id="form-masuk" style="display: none;">
                        <p class="h5">Masuk</p>
                        <div class="form-group">
                            <label>Tanggal Masuk</label>
                            <input type="date" name="tanggal_masuk" class="form-control @error('tanggal_masuk') is-invalid @enderror" value="{{ old('tanggal_masuk', optional($barang->masuk)->tanggal_masuk) }}">
                            @error('tanggal_masuk') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>

                    <div class="col-md-12 status-form" id="form-keluar" style="display: none;">
                        <p class="h5">Keluar</p>
                        <div class="form-group">
                            <label>Tanggal Keluar</label>
                            <input type="date" name="tanggal_keluar" class="form-control @error('tanggal_keluar') is-invalid @enderror" value="{{ old('tanggal_keluar', optional($barang->keluar)->tanggal_keluar) }}">
                            @error('tanggal_keluar') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>

                    <div class="col-md-12 status-form" id="form-peminjaman" style="display: none;">
                        <p class="h5">Peminjaman</p>
                        <div class="form-group">
                            <label>Tanggal BASTP</label>
                            <input type="date" name="tanggal_bastp" class="form-control @error('tanggal_bastp') is-invalid @enderror" value="{{ old('tanggal_bastp', optional($barang->peminjaman)->tanggal_bastp) }}">
                            @error('tanggal_bastp') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="form-group">
                            <label>Tanggal Selesai</label>
                            <input type="date" name="tanggal_selesai" class="form-control @error('tanggal_selesai') is-invalid @enderror" value="{{ old('tanggal_selesai', optional($barang->peminjaman)->tanggal_selesai) }}">
                            @error('tanggal_selesai') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="form-group">
                            <label>Nomor Surat</label>
                            <input type="text" name="nomor_surat" class="form-control @error('nomor_surat') is-invalid @enderror" value="{{ old('nomor_surat', optional($barang->peminjaman)->nomor_surat) }}">
                            @error('nomor_surat') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end mt-2 mb-2">
                    <button type="submit" class="btn btn-success mr-2">Simpan</button>
                    <a href="{{ route('masuk.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function toggleStatusForm() {
        const statusSelect = document.getElementById("status");
        let selectedStatusJenis = null;
        
        // Cek apakah select2 sudah aktif
        if ($(statusSelect).data('select2')) {
            selectedStatusJenis = $(statusSelect).select2('data')[0]?.jenis;
        } else {
            // Fallback jika select2 belum aktif, ambil dari data-jenis di option yang terpilih
            const selectedOption = statusSelect.options[statusSelect.selectedIndex];
            selectedStatusJenis = selectedOption ? selectedOption.dataset.jenis : null;
        }
        
        console.log("Selected Status Jenis:", selectedStatusJenis);

        document.querySelectorAll(`#form-masuk, #form-keluar, #form-peminjaman`).forEach(el => el.style.display = 'none');
        if (selectedStatusJenis === 'masuk') {
            document.getElementById(`form-masuk`).style.display = 'block';
        } else if (selectedStatusJenis === 'keluar') {
            document.getElementById(`form-keluar`).style.display = 'block';
        } else if (selectedStatusJenis === 'peminjaman') {
            document.getElementById(`form-peminjaman`).style.display = 'block';
        }
    }

    document.addEventListener("DOMContentLoaded", function() {
        toggleStatusForm();
    });
</script>
@endpush