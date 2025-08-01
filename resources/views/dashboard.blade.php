@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-md-6 col-lg-4">
        <div class="card card-block card-stretch card-height">
            <div class="card-body">
                <div class="top-block d-flex align-items-center justify-content-between">
                    <h5>Barang Masuk</h5>
                    <span class="badge badge-primary">Today</span>
                </div>
                <h3><span class="counter">{{ $barang_masuk['total'] }}</span> Barang</h3>
                <div class="d-flex align-items-center justify-content-between mt-1">
                    <p class="mb-0">Total</p>
                    <span class="text-primary">{{ $barang_masuk['percentage'] }}%</span>
                </div>
                <div class="iq-progress-bar bg-primary-light mt-2">
                    <span class="bg-primary iq-progress progress-1" data-percent="{{ $barang_masuk['percentage'] }}"></span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-lg-4">
        <div class="card card-block card-stretch card-height">
            <div class="card-body">
                <div class="top-block d-flex align-items-center justify-content-between">
                    <h5>Barang Keluar</h5>
                    <span class="badge badge-warning">Today</span>
                </div>
                <h3><span class="counter">{{ $barang_keluar['total'] }}</span> Barang</h3>
                <div class="d-flex align-items-center justify-content-between mt-1">
                    <p class="mb-0">Total</p>
                    <span class="text-warning">{{ $barang_keluar['percentage'] }}%</span>
                </div>
                <div class="iq-progress-bar bg-warning-light mt-2">
                    <span class="bg-warning iq-progress progress-1" data-percent="{{ $barang_keluar['percentage'] }}"></span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-lg-4">
        <div class="card card-block card-stretch card-height">
            <div class="card-body">
                <div class="top-block d-flex align-items-center justify-content-between">
                    <h5>Peminjaman</h5>
                    <span class="badge badge-success">Today</span>
                </div>
                <h3><span class="counter">{{ $barang_peminjaman['total'] }}</span> Barang</h3>
                <div class="d-flex align-items-center justify-content-between mt-1">
                    <p class="mb-0">Total</p>
                    <span class="text-success">{{ $barang_peminjaman['percentage'] }}%</span>
                </div>
                <div class="iq-progress-bar bg-success-light mt-2">
                    <span class="bg-success iq-progress progress-1" data-percent="{{ $barang_peminjaman['percentage'] }}"></span>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row mt-4">
    <div class="col-md-12 col-lg-6">
        <div class="card card-block card-stretch card-height">
            <div class="card-body">
                <canvas id="donutChart" style="max-height: 350px;"></canvas>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('donutChart').getContext('2d');

        const data = {
            labels: ['Barang Masuk', 'Barang Keluar', 'Barang Dipinjam'],
            datasets: [{
                label: 'Total Barang',
                data: [
                    {{ $barang_masuk['total'] }},
                    {{ $barang_keluar['total'] }},
                    {{ $barang_peminjaman['total'] }}
                ],
                backgroundColor: [
                    'rgba(54, 162, 235, 0.7)',   // blue
                    'rgba(255, 206, 86, 0.7)',   // yellow
                    'rgba(75, 192, 192, 0.7)'    // green
                ],
                borderColor: [
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)'
                ],
                borderWidth: 1
            }]
        };

        const config = {
            type: 'doughnut',
            data: data,
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'right',
                    },
                    tooltip: {
                        enabled: true,
                    }
                }
            }
        };

        new Chart(ctx, config);
    });
</script>


@endpush

