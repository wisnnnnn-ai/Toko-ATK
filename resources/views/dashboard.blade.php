@extends('layout.main')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('styles')
<style>
    .stat-card {
        transition: all 0.3s ease;
        border: none;
        border-radius: 10px;
        height: 100%;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 28px rgba(15, 23, 42, 0.12) !important;
    }

    .stat-card-link {
        text-decoration: none;
        display: block;
        color: inherit;
    }

    .stat-card .icon {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        background: rgba(59, 130, 246, 0.12);
        color: #2563eb;
    }

    .stat-card .icon i {
        font-size: 1.5rem;
        color: #2563eb;
    }

    .stat-card h3 {
        font-size: 1.75rem;
        line-height: 1.2;
        color: #0f172a;
    }

    .stat-card p,
    .stat-card small {
        font-size: 0.875rem;
        margin-bottom: 0.25rem;
        color: #64748b;
    }

    .border-left-primary { border-left: 4px solid #3b82f6; }
    .border-left-warning { border-left: 4px solid #3b82f6; }
    .border-left-info { border-left: 4px solid #3b82f6; }
    .border-left-success { border-left: 4px solid #3b82f6; }
</style>
@endsection

@section('main-content')
<div class="row mb-4">


    <div class="col-md-3">
        <a href="{{ route('barang.index') }}" class="stat-card-link">
            <div class="stat-card h-100 shadow-sm border-left-primary">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="mb-1">Total Barang</p>
                            <h3 class="mb-0 fw-bold">{{ $totalBarang }}</h3>
                            <small>Total produk</small>
                        </div>
                        <div class="icon">
                            <i class="fas fa-box"></i>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>


    <div class="col-md-3">
        <a href="{{ route('barang.stokrendah') }}" class="stat-card-link">
            <div class="stat-card h-100 shadow-sm border-left-warning">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="mb-1">Stok Menipis</p>

                            @if($stokMenipisCount > 0)
                                <h3 class="mb-0 fw-bold">{{ $stokMenipisCount }}</h3>
                                <small>Item stok ≤ 10</small>
                            @else
                                <h3 class="mb-0 fw-bold">Aman</h3>
                                <small>Tidak ada stok menipis</small>
                            @endif
                        </div>

                        <div class="icon">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>


    <div class="col-md-3">
        <a href="{{ route('transaksi.index', ['tanggal' => now()->format('Y-m-d')]) }}" class="stat-card-link">
            <div class="stat-card h-100 shadow-sm border-left-info">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="mb-1">Transaksi Hari Ini</p>
                            <h3 class="mb-0 fw-bold">{{ $transaksiHariIni }}</h3>
                            <small>{{ now()->format('d M Y') }}</small>
                        </div>

                        <div class="icon">
                            <i class="fas fa-calendar-day"></i>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>


    <div class="col-md-3">
        <a href="{{ route('laporan.index', ['tanggal' => now()->format('Y-m-d')]) }}" class="stat-card-link">
            <div class="stat-card h-100 shadow-sm border-left-success">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="mb-1">Pendapatan Hari Ini</p>
                            <h3 class="mb-0 fw-bold">
                                Rp {{ number_format($pendapatanHariIni, 0, ',', '.') }}
                            </h3>
                            <small>Total hari ini</small>
                        </div>

                        <div class="icon">
                            <i class="fas fa-cash-register"></i>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>

</div>


<div class="row mb-4 g-3">


    <div class="col-md-8">

        <div class="card top-card shadow-sm h-100">

            <div class="card-header bg-white py-3 px-3">
                <h5 class="mb-0 fw-semibold text-dark">
                    Top Produk Terlaris
                </h5>
            </div>


            <div class="card-body py-2 px-3 produk-scroll">

                @if($topProduk->count() > 0)

                    @foreach($topProduk as $index => $produk)

                    <div class="produk-item">

                        <div class="d-flex justify-content-between align-items-center py-3 border-bottom">

                            <div class="d-flex align-items-center">


                                <div class="produk-number me-3">
                                    {{ $index + 1 }}
                                </div>


                                <div class="fw-semibold text-dark">
                                    {{ $produk['nama_barang'] }}
                                </div>

                            </div>


                            <div class="text-muted fw-semibold">
                                {{ $produk['total_terjual'] }} terjual
                            </div>

                        </div>

                    </div>

                    @endforeach

                @else

                    <div class="text-center py-4">

                        <i class="fas fa-box-open text-muted mb-2"></i>

                        <p class="text-muted mb-0">
                            Belum ada data penjualan
                        </p>

                    </div>

                @endif

            </div>

        </div>

    </div>


    <div class="col-md-4">

        <div class="card quick-card shadow-sm h-100">

            <div class="card-header bg-white py-3 px-3">
                <h5 class="mb-0 fw-semibold text-dark">
                    Quick Action
                </h5>
            </div>

            <div class="card-body p-3">

                <div class="d-grid gap-2">


                    <a href="{{ route('transaksi.index') }}"
                       class="quick-action-card text-decoration-none">

                        <div class="d-flex align-items-center">

                            <div class="quick-icon me-3">
                                <i class="fas fa-cash-register text-primary"></i>
                            </div>

                            <div>
                                <div class="fw-semibold text-dark">
                                    Transaksi
                                </div>

                                <small class="text-muted">
                                    Buat transaksi baru
                                </small>
                            </div>

                        </div>

                    </a>


                    <a href="{{ route('barang.index') }}"
                       class="quick-action-card text-decoration-none">

                        <div class="d-flex align-items-center">

                            <div class="quick-icon me-3">
                                <i class="fas fa-box text-primary"></i>
                            </div>

                            <div>
                                <div class="fw-semibold text-dark">
                                    Tambah Barang
                                </div>

                                <small class="text-muted">
                                    Kelola data barang
                                </small>
                            </div>

                        </div>

                    </a>

                </div>

            </div>

        </div>

    </div>

</div>


<style>
    .top-card,
    .quick-card {
        border-radius: 12px;
        border-left: 4px solid #3b82f6;
        box-shadow: 0 10px 30px rgba(15, 23, 42, 0.08);
    }

    .card-header {
        border-bottom: 1px solid #e5e7eb;
    }

    .produk-scroll {
        height: 205px;
        overflow-y: auto;
        overflow-x: hidden;
        padding-right: 4px;
    }

    .produk-scroll::-webkit-scrollbar {
        width: 4px;
    }

    .produk-scroll::-webkit-scrollbar-thumb {
        background: rgba(15, 23, 42, 0.18);
        border-radius: 10px;
    }

    .produk-number {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        background: rgba(59, 130, 246, 0.12);
        color: #2563eb;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 13px;
    }

    .produk-item:last-child .border-bottom {
        border-bottom: none !important;
    }

    .quick-action-card {
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        padding: 12px;
        background: #ffffff;
        transition: 0.2s ease;
    }

    .quick-action-card:hover {
        background: rgba(59, 130, 246, 0.06);
    }

    .quick-icon {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        background: rgba(59, 130, 246, 0.12);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        color: #2563eb;
    }
</style>


<div class="row">
    <div class="col-md-12">

        <div class="card chart-card shadow-sm">


            <div class="card-header bg-white d-flex justify-content-between align-items-center flex-wrap gap-2 py-3 px-3">

                <div>
                    <h5 class="mb-0 fw-semibold text-dark">
                        Grafik Penjualan
                    </h5>
                </div>


                <div class="btn-group chart-filter-group" role="group">

                    <button
                        type="button"
                        class="btn btn-sm {{ $period == 'hari' ? 'btn-primary' : 'btn-light' }} filter-btn"
                        data-period="hari"
                    >
                        Hari
                    </button>

                    <button
                        type="button"
                        class="btn btn-sm {{ $period == 'minggu' ? 'btn-primary' : 'btn-light' }} filter-btn"
                        data-period="minggu"
                    >
                        Minggu
                    </button>

                    <button
                        type="button"
                        class="btn btn-sm {{ $period == 'bulan' ? 'btn-primary' : 'btn-light' }} filter-btn"
                        data-period="bulan"
                    >
                        Bulan
                    </button>

                </div>

            </div>


            <div class="card-body p-3">

                @if(array_sum($chartData) > 0)

                    <div class="chart-container">
                        <canvas id="salesChart"></canvas>
                    </div>

                @else

                    <div class="empty-chart text-center py-5">

                        <div class="empty-icon mb-3">
                            <i class="fas fa-chart-bar"></i>
                        </div>

                        <h6 class="fw-semibold text-dark mb-1">
                            Belum Ada Data
                        </h6>

                        <p class="text-muted mb-0">
                            Data penjualan untuk periode ini belum tersedia
                        </p>

                    </div>

                @endif

            </div>

        </div>

    </div>
</div>
@endsection


<style>
    .chart-card {
        border-radius: 12px;
        border-left: 4px solid #3b82f6;
        box-shadow: 0 10px 30px rgba(15, 23, 42, 0.08);
    }

    .chart-card .card-header {
        border-bottom: 1px solid #e5e7eb;
    }

    .chart-filter-group .btn {
        border-radius: 8px !important;
        padding: 6px 14px;
        font-size: 13px;
        font-weight: 500;
        border: 1px solid #d1d5db;
        transition: 0.2s ease;
    }

    .chart-filter-group .btn-light {
        background: #f8fafc;
        color: #475569;
    }

    .chart-filter-group .btn-light:hover {
        background: #e2e8f0;
    }

    .chart-container {
        position: relative;
        height: 320px;
    }

    .empty-icon {
        width: 60px;
        height: 60px;
        margin: auto;
        border-radius: 14px;
        background: rgba(59, 130, 246, 0.12);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #2563eb;
        font-size: 22px;
    }
</style>

@section('scripts')
<script>

    let salesChart = null;

    function initChart(labels, data) {

        const ctx = document.getElementById('salesChart').getContext('2d');

        if (salesChart) {
            salesChart.destroy();
        }

        const maxValue = Math.max(...data);
        const suggestedMax = maxValue > 0 ? maxValue * 1.1 : 100;

        salesChart = new Chart(ctx, {

            type: 'bar',

            data: {
                labels: labels,

                datasets: [{
                    label: 'Penjualan',

                    data: data,

                    backgroundColor: '#0d6efd',
                    borderRadius: 8,
                    borderSkipped: false,
                    barThickness: 35,
                    hoverBackgroundColor: '#0b5ed7'
                }]
            },

            options: {

                responsive: true,
                maintainAspectRatio: false,

                interaction: {
                    intersect: false,
                    mode: 'index'
                },

                plugins: {

                    legend: {
                        display: false
                    },

                    tooltip: {
                        backgroundColor: '#212529',
                        padding: 10,
                        cornerRadius: 8,

                        callbacks: {
                            label: function(context) {
                                return ' Rp ' + context.raw.toLocaleString('id-ID');
                            }
                        }
                    }
                },

                scales: {

                    x: {
                        grid: {
                            display: false
                        },

                        ticks: {
                            color: '#6c757d',
                            font: {
                                size: 11
                            }
                        }
                    },

                    y: {

                        beginAtZero: true,
                        suggestedMax: suggestedMax,

                        grid: {
                            color: '#f1f1f1'
                        },

                        ticks: {

                            color: '#6c757d',

                            callback: function(value) {
                                return 'Rp ' + value.toLocaleString('id-ID');
                            }
                        }
                    }
                }
            }
        });
    }


    document.addEventListener('DOMContentLoaded', function() {

        initChart(@json($chartLabels), @json($chartData));

        const filterButtons = document.querySelectorAll('.filter-btn');

        filterButtons.forEach(button => {

            button.addEventListener('click', function() {

                const period = this.getAttribute('data-period');


                filterButtons.forEach(btn => {
                    btn.classList.remove('btn-primary');
                    btn.classList.add('btn-light');
                });

                this.classList.remove('btn-light');
                this.classList.add('btn-primary');


                let url = `/dashboard/chart-data?period=${period}`;

                if (period === 'hari') {
                    url += '&jenis=jam';
                }

                fetch(url)
                    .then(response => response.json())
                    .then(data => {
                        initChart(data.labels, data.values);
                    })
                    .catch(error => console.error(error));

            });

        });

    });

</script>
@endsection
