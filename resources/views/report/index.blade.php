@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card card-block card-stretch card-height">
                <div class="card-body">
                    <div class="top-block d-flex align-items-center justify-content-between">
                        <h5>Barang Masuk</h5>
                        <div>
                            <a  href="{{ route('report.download.masuk','xls') }}" class="btn btn-outline-success mr-2">
                                <i class="bi bi-filetype-xls"></i>
                                <span>Download Excel</span>
                            </a>
                            <a  href="{{ route('report.download.masuk','pdf')}}" class="btn btn-outline-danger">
                                <i class="bi bi-filetype-pdf"></i>
                                <span>Download PDF</span>
                            </a>
                        </div>
               
                    </div>
                    <h3><span class="counter">{{$barang_masuk['total']}}</span> Perangkat</h3>
                    <div class="d-flex align-items-center justify-content-between mt-1">
                        <p class="mb-0">Total</p>
                        <span class="text-primary">{{$barang_masuk['percentage']}}%</span>
                    </div>
                    <div class="iq-progress-bar bg-primary-light mt-2">
                        <span class="bg-primary iq-progress progress-1" data-percent="{{ $barang_masuk['percentage'] }}"></span>
                        
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card card-block card-stretch card-height">
                <div class="card-body">
                    <div class="top-block d-flex align-items-center justify-content-between">
                        <h5>Barang Keluar</h5>
                        <div>
                            <a  href="{{ route('report.download.keluar','xls') }}" class="btn btn-outline-success mr-2">
                                <i class="bi bi-filetype-xls"></i>
                                <span>Download Excel</span>
                            </a>
                            <a  href="{{ route('report.download.keluar','pdf')}}" class="btn btn-outline-danger">
                                <i class="bi bi-filetype-pdf"></i>
                                <span>Download PDF</span>
                            </a>
                        </div>
                    </div>
                    <h3><span class="counter">{{$barang_keluar['total']}}</span> Perangkat</h3>
                    <div class="d-flex align-items-center justify-content-between mt-1">
                        <p class="mb-0">Total</p>
                        <span class="text-primary">{{$barang_keluar['percentage']}}%</span>
                    </div>
                    <div class="iq-progress-bar bg-danger-light mt-2">
                        <span class="bg-danger iq-progress progress-1" data-percent="{{ $barang_keluar['percentage'] }}"></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card card-block card-stretch card-height">
                <div class="card-body">
                    <div class="top-block d-flex align-items-center justify-content-between">
                        <h5>Peminjaman</h5>
                        <div>
                            <a  href="{{ route('report.download.peminjaman','xls') }}" class="btn btn-outline-success mr-2">
                                <i class="bi bi-filetype-xls"></i>
                                <span>Download Excel</span>
                            </a>
                            <a  href="{{ route('report.download.peminjaman','pdf')}}" class="btn btn-outline-danger">
                                <i class="bi bi-filetype-pdf"></i>
                                <span>Download PDF</span>
                            </a>
                        </div>
                    </div>
                    <h3><span class="counter">{{$barang_peminjaman['total']}}</span> Perangkat</h3>
                    <div class="d-flex align-items-center justify-content-between mt-1">
                        <p class="mb-0">Total</p>
                        <span class="text-primary">{{$barang_peminjaman['percentage']}}%</span>
                    </div>
                    <div class="iq-progress-bar bg-warning-light mt-2">
                        <span class="bg-warning iq-progress progress-1" data-percent="{{ $barang_peminjaman['percentage'] }}"></span>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if(Session::has('error'))
        <div class="alert alert-danger" role="alert">
            {{ Session::get('error') }}
        </div>
    @endif 
    @if(Session::has('success'))
        <div class="alert alert-success" role="alert">
            {{ Session::get('success') }}
        </div>
    @endif 
    <!-- Page end  -->
@endsection
