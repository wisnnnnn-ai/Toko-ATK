@extends('layout.main')

@section('title', 'Detail Barang')
@section('page-title', 'Detail Barang')

@section('main-content')

<div class="row">
    <div class="col-md-12">
           <div class="row">
    <div class="col-md-12">

        <div class="card">


            <div class="card-header bg-white">
                <div class="row align-items-center">


                    <div class="col-md-6">
                        <h5 class="mb-0">
                            Detail Barang
                        </h5>
                    </div>


                    <div class="col-md-6 text-end">
                        <a href="{{ route('barang.index') }}"
                           class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left me-1"></i> Kembali
                        </a>
                    </div>

                </div>
            </div>


            <div class="card-body">


                <div class="table-responsive">
                    <table class="table table-bordered table-hover">

                        <tr>
                            <th width="250">Kode Barang</th>
                            <td>{{ $barang->kode_barang }}</td>
                        </tr>

                        <tr>
                            <th>Nama Barang</th>
                            <td>{{ $barang->nama_barang }}</td>
                        </tr>

                        <tr>
                            <th>Kategori</th>
                            <td>
                                <span class="badge bg-secondary">
                                    {{ $barang->kategori->nama_kategori ?? '-' }}
                                </span>
                            </td>
                        </tr>

                        <tr>
                            <th>Stok</th>
                            <td>
                                @if($barang->stok < 10)
                                    <span class="text-danger fw-semibold">
                                        {{ $barang->stok }}
                                    </span>
                                @else
                                    {{ $barang->stok }}
                                @endif
                            </td>
                        </tr>

                        <tr>
                            <th>Satuan</th>
                            <td>{{ $barang->satuan ?? '-' }}</td>
                        </tr>

                        <tr>
                            <th>Harga Modal</th>
                            <td>
                                Rp {{ number_format($barang->harga_modal ?? 0, 0, ',', '.') }}
                            </td>
                        </tr>

                        <tr>
                            <th>Harga Jual</th>
                            <td>
                                Rp {{ number_format($barang->harga, 0, ',', '.') }}
                            </td>
                        </tr>

                        <tr>
                            <th>Total Modal</th>
                            <td>
                                Rp {{ number_format(($barang->harga_modal ?? 0) * $barang->stok, 0, ',', '.') }}
                            </td>
                        </tr>

                        <tr>
                            <th>Total Jual</th>
                            <td>
                                Rp {{ number_format($barang->harga * $barang->stok, 0, ',', '.') }}
                            </td>
                        </tr>

                        <tr>
                            <th>Estimasi Keuntungan</th>
                            <td class="text-success fw-semibold">
                                Rp {{ number_format((($barang->harga - ($barang->harga_modal ?? 0)) * $barang->stok), 0, ',', '.') }}
                            </td>
                        </tr>

                        <tr>
                            <th>Status</th>
                            <td>
                                @if($barang->stok < 10)
                                    <span class="badge bg-danger">
                                        Stok Rendah
                                    </span>
                                @else
                                    <span class="badge bg-success">
                                        Tersedia
                                    </span>
                                @endif
                            </td>
                        </tr>

                    </table>
                </div>

            </div>
        </div>
    </div>
</div>

<style>
    .card {
        border: none !important;
        border-left: 4px solid #2563eb !important;
        border-radius: 10px !important;
        overflow: hidden !important;
        box-shadow: 0 16px 35px rgba(15, 23, 42, 0.08) !important;
    }

    .card-header {
        padding-left: 1rem !important;
        padding-right: 1rem !important;
        background: #ffffff;
        border-bottom: 1px solid #e5e7eb !important;
    }

    .card-body {
        padding-left: 2rem !important;
        padding-right: 2rem !important;
    }

    .card-header h5 {
        padding-left: 0;
        margin-bottom: 0;
        color: #0f172a;
        display: flex;
        align-items: center;
    }

    .table th {
        color: #334155;
        font-weight: 600;
        vertical-align: middle;
        background-color: #f8fafc;
        width: 250px;
    }

    .table td {
        vertical-align: middle;
    }
</style>

@endsection
