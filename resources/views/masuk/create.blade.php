@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <div class="row mb-3">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex flex-wrap align-items-center justify-content-between breadcrumb-content">
                        <h5>Tambah Perangkat</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="card">
        <div class="card-body">
            <form id="addBarangForm" method="POST" action="{{ route('barang.store') }}">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Kode Rak</label>
                            <input type="text" name="kode_rak" class="form-control @error('kode_rak') is-invalid @enderror" value="{{ old('kode_rak') }}">
                            @error('kode_rak') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="form-group">
                            <label>Serial Number</label>
                            <input type="text" name="serial_number" class="form-control @error('serial_number') is-invalid @enderror" value="{{ old('serial_number') }}">
                            @error('serial_number') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="form-group">
                            <label>Kode Material</label>
                            <input type="text" name="kode_material" class="form-control @error('kode_material') is-invalid @enderror" value="{{ old('kode_material') }}">
                            @error('kode_material') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="form-group">
                            <label>Merk</label>
                            <x-inputs.select-merk id="merk" :selected="old('merk')" :class="($errors->has('merk') ? 'is-invalid' : '')"/>
                            @error('merk') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="form-group">
                            <label>Spesifikasi</label>
                            <input type="text" name="spesifikasi" class="form-control @error('spesifikasi') is-invalid @enderror" value="{{ old('spesifikasi') }}">
                            @error('spesifikasi') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Kategori</label>
                            <x-inputs.select-kategori id="kategori" :selected="old('kategori')" :class="($errors->has('kategori') ? 'is-invalid' : '')"/>
                            @error('kategori') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="form-group">
                            <label>Keadaan</label>
                            <x-inputs.select-keadaan id="keadaan" :selected="old('keadaan')" :class="($errors->has('keadaan') ? 'is-invalid' : '')"/>
                            @error('keadaan') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="form-group">
                            <label>Lokasi</label>
                            <x-inputs.select-lokasi id="lokasi" :selected="old('lokasi')" :class="($errors->has('lokasi') ? 'is-invalid' : '')"/>
                            @error('lokasi') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="form-group">
                            <label>Status</label>
                            <x-inputs.select-status id="status" :selected="old('status')"  :onchange="'function() { toggleStatusForm(); }'" :class="($errors->has('status') ? 'is-invalid' : '')"/>
                            @error('status') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="form-group">
                            <label>Keterangan</label>
                            <textarea name="keterangan" class="form-control @error('keterangan') is-invalid @enderror">{{ old('keterangan') }}</textarea>
                            @error('keterangan') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>
                </div>

                <!-- Form tambahan berdasarkan status -->
                <div class="row">
                    <!-- Masuk -->
                    <div class="col-md-12 status-form" id="form-masuk" style="display: none;">
                        <p class="h5">Masuk</p>
                        <div class="form-group">
                            <label>Tanggal Masuk</label>
                            <input type="date" name="tanggal_masuk" class="form-control @error('tanggal_masuk') is-invalid @enderror" value="{{ old('tanggal_masuk') }}">
                            @error('tanggal_masuk') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>

                    <!-- Keluar -->
                    <div class="col-md-12 status-form" id="form-keluar" style="display: none;">
                        <p class="h5">Keluar</p>
                        <div class="form-group">
                            <label>Tanggal Keluar</label>
                            <input type="date" name="tanggal_keluar" class="form-control @error('tanggal_keluar') is-invalid @enderror" value="{{ old('tanggal_keluar') }}">
                            @error('tanggal_keluar') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>

                    <!-- Pinjam -->
                    <div class="col-md-12 status-form"  id="form-peminjaman" style="display: none;">
                        <p class="h5">Peminjaman</p>
                        <div class="form-group">
                            <label>Tanggal BASTP</label>
                            <input type="date" name="tanggal_bastp" class="form-control @error('tanggal_bastp') is-invalid @enderror" value="{{ old('tanggal_bastp') }}">
                            @error('tanggal_bastp') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="form-group">
                            <label>Tanggal Selesai</label>
                            <input type="date" name="tanggal_selesai" class="form-control @error('tanggal_selesai') is-invalid @enderror" value="{{ old('tanggal_selesai') }}">
                            @error('tanggal_selesai') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="form-group">
                            <label>Nomor Surat</label>
                            <input type="text" name="nomor_surat" class="form-control @error('nomor_surat') is-invalid @enderror" value="{{ old('nomor_surat') }}">
                            @error('nomor_surat') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end mt-2 mb-2">
                    <button type="submit" class="btn btn-success mr-2">Save</button>
                    <a href="{{ route('masuk.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function toggleStatusForm() {
        const status = $("#status").select2('data')[0];
                console.log(status?.jenis);
        document.querySelectorAll(`#form-masuk, #form-keluar, #form-peminjaman`).forEach(el => el.style.display = 'none');
        if (status?.jenis === 'masuk') {
            document.getElementById(`form-masuk`).style.display = 'block';
        } else if (status?.jenis === 'keluar') {
            document.getElementById(`form-keluar`).style.display = 'block';
        } else if (status?.jenis === 'peminjaman') {
    
            document.getElementById(`form-peminjaman`).style.display = 'block';
        }
    }

    // Inisialisasi saat halaman dimuat, tampilkan form berdasarkan old('status')
    document.addEventListener("DOMContentLoaded", function() {
        toggleStatusForm();
    });
</script>
@endpush
