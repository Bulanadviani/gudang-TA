@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card mb-5">
                <div class="card-body">
                    <div class="d-flex flex-wrap align-items-center justify-content-between breadcrumb-content">
                        <h5>Pengaturan</h5>
                    </div>
                </div>
            </div>
            <!-- settings -->

        <a href="{{ route('pengaturan.role.index') }}" class="svg-icon">
            <div class="card mb-2">
                <div class="card-body">
                    <div class="d-flex flex-wrap align-items-center justify-content-center">
                        <h5>Role</h5>
                    </div>
                </div>
            </div>
        </a>
             
        <a href="{{ route('pengaturan.merk.') }}" class="svg-icon">
            <div class="card mb-2">
                <div class="card-body">
                    <div class="d-flex flex-wrap align-items-center justify-content-center">
                        <h5>Merk</h5>
                    </div>
                </div>
            </div>
        </a>
        <a href="{{ route('pengaturan.kategori.') }}" class="svg-icon">
            <div class="card mb-2">
                <div class="card-body">
                    <div class="d-flex flex-wrap align-items-center justify-content-center">
                        <h5>Kategori</h5>
                    </div>
                </div>
            </div>
        </a>
        <a href="{{ route('pengaturan.keadaan.') }}" class="svg-icon">
            <div class="card mb-2">
                <div class="card-body">
                    <div class="d-flex flex-wrap align-items-center justify-content-center">
                        <h5>Keadaan</h5>
                    </div>
                </div>
            </div>
        </a>
        <a href="{{ route('pengaturan.lokasi.') }}" class="svg-icon">
            <div class="card mb-2">
                <div class="card-body">
                    <div class="d-flex flex-wrap align-items-center justify-content-center">
                        <h5>Lokasi</h5>
                    </div>
                </div>
            </div>
        </a>
        <a href="{{ route('pengaturan.status.') }}" class="svg-icon">
            <div class="card mb-2">
                <div class="card-body">
                    <div class="d-flex flex-wrap align-items-center justify-content-center">
                        <h5>Status</h5>
                    </div>
                </div>
            </div>
        </a>

            <!-- end settings -->

        </div>
    </div>
    <!-- Page end  -->
@endsection
