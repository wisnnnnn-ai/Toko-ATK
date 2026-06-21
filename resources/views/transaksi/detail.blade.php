@extends('layout.main')

@section('title', 'Detail Transaksi')
@section('page-title', 'Detail Transaksi')

@section('main-content')

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
        padding-left: 1rem !important;
        padding-right: 1rem !important;
        background: #ffffff;
        border-bottom: 1px solid #e5e7eb !important;
    }

    .card-header h5 {
        padding-left: 0;
        margin-bottom: 0;
        color: #0f172a;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-weight: 600;
    }

    .card-body {
        padding-left: 2rem !important;
        padding-right: 2rem !important;
    }


    table thead th {
        color: #000000;
        font-weight: 600;
        vertical-align: middle;
        background: #f8fafc;
    }

    table td {
        vertical-align: middle;
    }


    .info-box {
        background: #f8fafc;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 24px;
    }

    .info-box p {
        margin-bottom: 10px;
    }

    .total-box {
        text-align: right;
    }

    .total-box h3 {
        color: #000000;
        font-weight: 700;
        margin-bottom: 0;
    }


    .print-header,
    .print-footer {
        display: none;
    }
        table th {
        color: #000000 !important;
    }


    @media print {

        @page {
            size: A4 portrait;
            margin: 15mm;
        }


        .sidebar,
        .main-sidebar,
        .navbar,
        .main-header,
        .content-header,
        footer,
        .btn,
        .no-print {
            display: none !important;
        }

        .content-wrapper,
        .main-content,
        .container-fluid,
        .container,
        .row,
        .col-md-12,
        .card,
        .card-body {
            width: 100% !important;
            margin: 0 !important;
            padding: 0 !important;
            border: none !important;
            box-shadow: none !important;
            background: transparent !important;
        }

        body {
            background: transparent !important;
            font-family: "Times New Roman", serif !important;
            font-size: 12px !important;
            color: #000 !important;
        }


        .print-header {
            display: block !important;
            text-align: center;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .print-header h3 {
            margin: 0;
            font-size: 20px;
            font-weight: bold;
        }

        .print-header p {
            margin: 0;
            font-size: 13px;
        }


        .info-box {
            background: transparent !important;
            padding: 0 !important;
            margin-bottom: 20px !important;
        }

        .info-box p {
            margin: 4px 0;
        }

        .total-box h3 {
            color: #000 !important;
        }


        table {
            width: 100% !important;
            border-collapse: collapse !important;
        }

        table th,
        table td {
            border: 1px solid #d1d5db !important;
            padding: 6px !important;
            font-size: 12px !important;
        }

        table th {
            background: #f8fafc !important;
            text-align: center !important;
        }

        .text-end {
            text-align: right !important;
        }

        .text-center {
            text-align: center !important;
        }


        .print-footer {
            display: block !important;
            margin-top: 25px;
            text-align: center;
            font-size: 11px;
        }


        .card-header {
            display: none !important;
        }
    }

</style>

<div class="row">

    <div class="col-md-12">

        <div class="card">

            {{-- HEADER --}}
            <div class="card-header bg-white d-flex justify-content-between align-items-center no-print">

                <h5>
                    Detail Transaksi
                </h5>

                <div class="d-flex gap-2">

                    {{-- Tombol Cetak --}}
                    <button onclick="window.print()"
                            class="btn btn-primary btn-sm">

                        <i class="fas fa-print me-1"></i>
                        Cetak

                    </button>

                                   {{-- Tombol Kembali --}}
                    <a href="{{ url()->previous() }}"
                    class="btn btn-secondary btn-sm">

                        <i class="fas fa-arrow-left me-1"></i>
                        Kembali

                    </a>


                </div>

            </div>

            <div class="card-body">

                {{-- HEADER PRINT --}}
                <div class="print-header">

                    <h3>ATK ARUM SAKTI</h3>

                    <p>Struk Penjualan</p>

                </div>

                {{-- INFO TRANSAKSI --}}
                <div class="info-box">

                    <div class="row align-items-center">

                        <div class="col-md-6">

                            <p>
                                <strong>Kode Transaksi:</strong>
                                {{ $transaksi->kode_transaksi }}
                            </p>

                            <p>
                                <strong>Tanggal:</strong>
                                {{ \Carbon\Carbon::parse($transaksi->tanggal)->format('d-m-Y H:i') }}
                            </p>

                            <p>
                                <strong>Kasir:</strong>
                                {{ $transaksi->user->name ?? '-' }}
                            </p>

                        </div>

                        <div class="col-md-6 total-box">

                            <small class="text-muted">
                                Total Pembayaran
                            </small>

                            <h3>
                                Rp {{ number_format($transaksi->total, 0, ',', '.') }}
                            </h3>

                        </div>

                    </div>

                </div>

                {{-- TABLE --}}
                <div class="table-responsive">

                    <table class="table table-hover table-bordered">

                        <thead class="table-light">

                            <tr>

                                <th class="text-center" style="width: 50px">
                                    No
                                </th>

                                <th>
                                    Kode Barang
                                </th>

                                <th>
                                    Nama Barang
                                </th>

                                <th class="text-end">
                                    Harga
                                </th>

                                <th class="text-center">
                                    Qty
                                </th>

                                <th class="text-end">
                                    Subtotal
                                </th>

                            </tr>

                        </thead>

                        <tbody>

                            @foreach($transaksi->detailTransaksi as $index => $detail)

                            <tr>

                                <td class="text-center">
                                    {{ $index + 1 }}
                                </td>

                                <td>
                                    {{ $detail->barang->kode_barang ?? '-' }}
                                </td>

                                <td>
                                    {{ $detail->barang->nama_barang ?? '-' }}
                                </td>

                                <td class="text-end">
                                    Rp {{ number_format($detail->harga, 0, ',', '.') }}
                                </td>

                                <td class="text-center">
                                    {{ $detail->qty }}
                                </td>

                                <td class="text-end">
                                    Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
                                </td>

                            </tr>

                            @endforeach

                        </tbody>

                        <tfoot>

                            <tr class="table-light">

                                <th colspan="5" class="text-end">
                                    Total
                                </th>

                                <th class="text-end">
                                    Rp {{ number_format($transaksi->total, 0, ',', '.') }}
                                </th>

                            </tr>

                        </tfoot>

                    </table>

                </div>

                {{-- FOOTER PRINT --}}
                <div class="print-footer">

                    <p>
                        Terima kasih telah berbelanja di ATK Arum Sakti
                    </p>

                    <p>
                        Dicetak pada:
                        {{ \Carbon\Carbon::now()->format('d-m-Y H:i:s') }}
                    </p>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection
