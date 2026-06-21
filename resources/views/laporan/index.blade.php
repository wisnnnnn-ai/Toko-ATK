@extends('layout.main')

@section('title', 'Laporan')
@section('page-title', 'Laporan')

@section('main-content')

<style>

     .card{
         border-left: 4px solid #2563eb;
         border-radius: 10px !important;
         overflow: hidden;
         border-top: none !important;
         border-right: none !important;
         border-bottom: none !important;
         box-shadow: 0 16px 35px rgba(15, 23, 42, 0.08);
     }

     .card-header{
         padding-left: 1rem !important;
         padding-right: 1rem !important;
         background: #ffffff;
         border-bottom: 1px solid #e5e7eb !important;
     }

     .card-body{
         padding-left: 2rem !important;
         padding-right: 2rem !important;
     }

     .card-header h5{
         padding-left: 0;
         margin-bottom: 0;
         color: #0f172a;
         font-weight: 600;
     }


     .table thead th{
         color: #000000;
         font-weight: 600;
         vertical-align: middle;
         background: #f8fafc;
     }

     .table-hover tbody tr:hover{
         background: #f3f4f6;
     }

     .table td,
     .table th{
         vertical-align: middle !important;
     }


     .filter-wrapper{
         display: flex;
         align-items: center;
         justify-content: end;
         gap: 10px;
         flex-wrap: wrap;
     }

     .filter-wrapper select{
         width: 130px;
     }


     .btn{
         border-radius: 6px !important;
     }


     .stok-rendah{
         background: #dc2626;
         color: #ffffff;
         padding: 5px 10px;
         border-radius: 6px;
         font-size: 12px;
         font-weight: 500;
     }

 .print-header,
 .print-footer{
     display: none;
 }

 @media print {
      body *{
          visibility: hidden;
      }

      .print-area,
      .print-area *{
          visibility: visible;
      }

      .print-area{
          position: absolute;
          left: 0;
          top: 0;
          width: 100%;
      }

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
      .no-print,
      .modal,
      .mt-2 {
          display: none !important;
      }

      .content-wrapper,
      .main-content,
      .container-fluid,
      .container,
      .card {
          width: 100% !important;
          margin: 0 !important;
          border: none !important;
          box-shadow: none !important;
          background: transparent !important;
      }

      .card {
          overflow: visible !important;
      }

      body {
          background: transparent !important;
          font-family: "Times New Roman", serif !important;
          font-size: 12px !important;
          color: #000 !important;
      }

      .card-header {
          display: none !important;
      }

      .print-header,
      .print-footer {
          display: block !important;
      }

      .print-header {
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

      .table-responsive {
          overflow: visible !important;
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
          color: #000000 !important;
          font-weight: 600 !important;
      }

      .text-center {
          text-align: center !important;
      }

      .text-end {
          text-align: right !important;
      }

      .badge,
      .stok-rendah,
      .text-danger {
          color: #111827 !important;
          background: transparent !important;
          border: none !important;
          font-weight: normal !important;
      }

      /* Hide Aksi column during print */
      table th:last-child,
      table td:last-child {
          display: none !important;
      }

      .print-footer {
          margin-top: 25px;
          text-align: center;
          font-size: 11px;
      }
 }

</style>


<div id="salesReportSection" class="row mb-4">

    <div class="col-md-12">

        <div class="print-header">
            <h3>ATK ARUM SAKTI</h3>
            <p>Laporan Penjualan</p>
        </div>

        <div class="card shadow-sm">

            <div class="card-header bg-white">

                <div class="row align-items-center">


                    <div class="col-md-4">
                        <h5>
                            Laporan Penjualan
                        </h5>
                    </div>


                    <div class="col-md-8">

                        <div class="filter-wrapper">

                            <select id="bulan" class="form-select form-select-sm">

                                @for($i = 1; $i <= 12; $i++)

                                <option value="{{ $i }}"
                                    {{ date('n') == $i ? 'selected' : '' }}>

                                    {{ \Carbon\Carbon::create()->month($i)->format('F') }}

                                </option>

                                @endfor

                            </select>

                            <select id="tahun" class="form-select form-select-sm">

                                @for($y = date('Y'); $y >= date('Y') - 5; $y--)

                                <option value="{{ $y }}"
                                    {{ date('Y') == $y ? 'selected' : '' }}>

                                    {{ $y }}

                                </option>

                                @endfor

                            </select>

                            <button
                                type="button"
                                class="btn btn-primary btn-sm"
                                onclick="cetakLaporan()">

                                <i class="fas fa-print me-1"></i> Cetak

                            </button>

                        </div>

                    </div>

                </div>

            </div>

            <div class="card-body">

                <div class="table-responsive">

                    <table class="table table-hover table-bordered" id="tableLaporan">

                        <thead class="table-light">

                            <tr>
                                <th class="text-center" style="width: 60px">No</th>
                                <th>Kode Transaksi</th>
                                <th class="text-center">Tanggal</th>
                                <th>User</th>
                                <th class="text-end">Total</th>
                            </tr>

                        </thead>

                        <tbody id="laporanBody">

                            @foreach($transaksis as $index => $transaksi)

                            <tr>

                                <td class="text-center">
                                    {{ $index + 1 }}
                                </td>

                                <td>
                                    {{ $transaksi->kode_transaksi }}
                                </td>

                                <td class="text-center">
                                    {{ \Carbon\Carbon::parse($transaksi->tanggal)->format('d-m-Y') }}
                                </td>

                                <td>
                                    {{ $transaksi->user->name ?? '-' }}
                                </td>

                                <td class="text-end">
                                    Rp {{ number_format($transaksi->total, 0, ',', '.') }}
                                </td>

                            </tr>

                            @endforeach

                        </tbody>

                        <tfoot>

                            <tr class="table-light">

                                <th colspan="4" class="text-end">
                                    Total Pendapatan
                                </th>

                                <th class="text-end" id="totalPendapatan">
                                    Rp {{ number_format($transaksis->sum('total'), 0, ',', '.') }}
                                </th>

                            </tr>

                        </tfoot>

                    </table>

                </div>
                    <div class="print-footer">

                        <p>
                            Laporan penjualan dicetak dari sistem ATK Arum Sakti
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


<div id="stockReportSection" class="row mb-4">

    <div class="col-md-12">

        <div class="print-header">
            <h3>ATK ARUM SAKTI</h3>
            <p>Laporan Stok Barang</p>
        </div>

        <div class="card shadow-sm">

            <div class="card-header bg-white">

                <div class="row align-items-center">

                    <div class="col-md-6">
                        <h5>
                            Laporan Stok Barang
                        </h5>
                    </div>

                    <div class="col-md-6 text-end">

                        <button
                            type="button"
                            class="btn btn-primary btn-sm"
                            onclick="cetakLaporanStok()">

                            <i class="fas fa-print me-1"></i> Cetak

                        </button>

                    </div>

                </div>

            </div>

            <div class="card-body">

                <div class="table-responsive">

                    <table class="table table-hover table-bordered" id="tableStok">

                        <thead class="table-light">

                            <tr>
                                <th class="text-center">No</th>
                                <th>Kode Barang</th>
                                <th>Nama Barang</th>
                                <th>Kategori</th>
                                <th class="text-center">Stok</th>
                                <th class="text-center">Status</th>
                            </tr>

                        </thead>

                        <tbody>

                            @foreach($barangs as $index => $barang)

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

                                <td>
                                    <span class="badge bg-secondary">
                                        {{ $barang->kategori->nama_kategori ?? '-' }}
                                    </span>
                                </td>

                                <td class="text-center">
                                    {{ $barang->stok }}
                                </td>

                                <td class="text-center">

                                    @if($barang->stok < 10)

                                    <span class="stok-rendah">
                                        Stok Rendah
                                    </span>

                                    @else

                                    <span class="badge bg-success">
                                        Tersedia
                                    </span>

                                    @endif

                                </td>

                            </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>
                    <div class="print-footer">

                        <p>
                            Laporan stok barang dicetak dari sistem ATK Arum Sakti
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


<div id="activityReportSection" class="row">

    <div class="col-md-12">

        <div class="card shadow-sm">

            <div class="card-header bg-white">

                <h5>
                    Riwayat Aktivitas
                </h5>

            </div>

            <div class="card-body">

                <div class="table-responsive">

                    <table class="table table-hover table-bordered">

                        <thead class="table-light">

                            <tr>
                                <th>Waktu</th>
                                <th>User</th>
                                <th>Aksi</th>
                                <th>Detail</th>
                            </tr>

                        </thead>

                        <tbody>

                            @foreach($activityLogs as $log)

                            <tr>

                                <td>
                                    {{ $log->created_at->format('d/m/Y H:i') }}
                                </td>

                                <td>
                                    {{ $log->user->name ?? '-' }}
                                </td>

                                <td>
                                    {{ $log->aksi }}
                                </td>

                                <td>
                                    {{ $log->detail }}
                                </td>

                            </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        function loadSalesReport(bulan, tahun) {
            const url = new URL("{{ route('laporan.penjualan') }}");
            url.searchParams.set('bulan', bulan);
            url.searchParams.set('tahun', tahun);

            fetch(url)
                .then(response => response.json())
                .then(data => {

                    let tbody = '';
                    data.transaksis.forEach((transaksi, index) => {
                        tbody += `
                            <tr>
                                <td class="text-center">${index + 1}</td>
                                <td>${transaksi.kode_transaksi}</td>
                                <td class="text-center">${new Date(transaksi.tanggal).toLocaleDateString('id-ID')}</td>
                                <td>${transaksi.user?.name ?? '-'}</td>
                                <td class="text-end">Rp ${Number(transaksi.total).toLocaleString('id-ID')}</td>
                            </tr>
                        `;
                    });
                    document.getElementById('laporanBody').innerHTML = tbody;

                    document.getElementById('totalPendapatan').innerHTML = `Rp ${Number(data.totalPendapatan).toLocaleString('id-ID')}`;
                })
                .catch(error => console.error('Error:', error));
        }


        const bulanSelect = document.getElementById('bulan');
        const tahunSelect = document.getElementById('tahun');
        loadSalesReport(bulanSelect.value, tahunSelect.value);


        bulanSelect.addEventListener('change', function() {
            loadSalesReport(this.value, tahunSelect.value);
        });
        tahunSelect.addEventListener('change', function() {
            loadSalesReport(bulanSelect.value, this.value);
        });
    });

function cetakLaporan() {

    const section = document.getElementById('salesReportSection');

    section.classList.add('print-area');

    window.print();

    section.classList.remove('print-area');
}

function cetakLaporanStok() {

    const section = document.getElementById('stockReportSection');

    section.classList.add('print-area');

    window.print();

    section.classList.remove('print-area');
}
</script>
@endsection
