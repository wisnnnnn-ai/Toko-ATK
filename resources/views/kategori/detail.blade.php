@extends('layout.main')

@section('title', 'Detail Kategori')
@section('page-title', 'Detail Kategori')

@section('main-content')

<div class="row">
    <div class="col-md-12">

        <div class="card">


            <div class="card-header bg-white">
                <div class="row align-items-center">


                    <div class="col-md-6">
                        <h5 class="mb-0">
                            Detail Kategori
                        </h5>
                    </div>


                    <div class="col-md-6 d-flex justify-content-end">
                        <a href="{{ route('kategori.index') }}"
                           class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left me-1"></i> Kembali
                        </a>
                    </div>

                </div>
            </div>


            <div class="card-body">


                <div class="table-responsive mb-4">
                    <table class="table table-bordered table-hover">

                        <tr>
                            <th width="250">Kode Kategori</th>
                            <td>
                                {{ strtoupper($kategori->kode_kategori ?? 'KTG' . str_pad($kategori->id, 3, '0', STR_PAD_LEFT)) }}
                            </td>
                        </tr>

                        <tr>
                            <th>Nama Kategori</th>
                            <td>{{ $kategori->nama_kategori }}</td>
                        </tr>

                        <tr>
                            <th>Jumlah Barang</th>
                            <td>{{ $kategori->barang->count() }} Item</td>
                        </tr>

                    </table>
                </div>


                <div class="table-responsive">
                    <table class="table table-bordered table-hover">

                        <thead class="table-light">
                            <tr>
                                <th class="text-center" style="width: 50px">No</th>
                                <th>Kode Barang</th>
                                <th>Nama Barang</th>
                                <th class="text-end">Harga Jual</th>
                                <th class="text-center">Stok</th>
                                <th class="text-center">Status</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($kategori->barang as $index => $barang)
                            <tr>

                                <td class="text-center">
                                    {{ $index + 1 }}
                                </td>

                                <td>
                                    {{ $barang->kode_barang }}
                                </td>

                                <td>
                                    {{ $barang->nama_barang }}
                                </td>

                                <td class="text-end">
                                    Rp {{ number_format($barang->harga, 0, ',', '.') }}
                                </td>

                                <td class="text-center">
                                    @if($barang->stok < 10)
                                        <span class="text-danger fw-semibold">
                                            {{ $barang->stok }}
                                        </span>
                                    @else
                                        {{ $barang->stok }}
                                    @endif
                                </td>

                                <td class="text-center">
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
                            @empty
                            <tr>
                                <td colspan="6"
                                    class="text-center text-muted py-4">
                                    Tidak ada barang pada kategori ini.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>

                    </table>
                </div>

            </div>
        </div>

    </div>
</div>

<style>


    .card {
        border-left: 4px solid #2563eb;
        border-radius: 10px !important;
        overflow: hidden;
        border-top: none !important;
        border-right: none !important;
        border-bottom: none !important;
        box-shadow: 0 16px 35px rgba(15, 23, 42, 0.08);
    }



    .card-header {
        padding-left: 1px !important;
        padding-right: 12px !important;
        background:
        border-bottom: none !important;
    }


    .card-body {
        padding-left: 32px !important;
        padding-right: 32px !important;
    }


    .card-header h5 {
        padding-left: 32px !important;
        margin-bottom: 0;
        color:
        display: flex;
        align-items: center;
    }


    .table th {
        color:
        font-weight: 600;
        vertical-align: middle;
        background-color:
    }

    .table td {
        vertical-align: middle;
    }
        table th {
        color: #000000 !important;
    }


</style>

@endsection
