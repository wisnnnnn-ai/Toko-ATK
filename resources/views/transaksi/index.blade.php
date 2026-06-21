@extends('layout.main')

@section('title', 'Transaksi Penjualan')
@section('page-title', 'Transaksi Penjualan')

@section('main-content')
<div class="row mb-4">


        <div class="col-md-6">

        <div class="card h-100">

            <div class="card-header bg-white">
                <h5 class="mb-0">
                    Transaksi
                </h5>
            </div>

            <div class="card-body d-flex flex-column">

                <div class="row g-3">


                    <div class="col-md-12">

                        <label class="form-label">
                            Pilih Barang
                        </label>

                        <select id="barangSelect"
                                class="form-select select2">

                            <option value="">
                                Pilih Barang...
                            </option>

                            @foreach($barangs as $barang)
                            <option value="{{ $barang->id }}"
                                    data-harga="{{ $barang->harga }}"
                                    data-stok="{{ $barang->stok }}"
                                    data-satuan="{{ $barang->satuan ?? 'pcs' }}"
                                    data-kode="{{ $barang->kode_barang }}"
                                    data-nama="{{ $barang->nama_barang }}">
                                {{ $barang->kode_barang }} - {{ $barang->nama_barang }} (Stok: {{ $barang->stok }})
                            </option>
                            @endforeach

                        </select>

                    </div>


                    <div class="col-md-6">

                        <label class="form-label">
                            Harga
                        </label>

                        <div class="input-group">

                            <span class="input-group-text">
                                Rp
                            </span>

                            <input type="text"
                                id="hargaBarang"
                                class="form-control"
                                readonly>

                        </div>

                    </div>


                    <div class="col-md-6">

                        <label class="form-label">
                            Jumlah
                        </label>

                        <div class="input-group">

                            <input type="number"
                                id="jumlahBarang"
                                class="form-control"
                                min="1"
                                value="1">

                            <span class="input-group-text"
                                id="satuanBarang">
                                pcs
                            </span>

                        </div>

                    </div>

                </div>


                <div class="pt-4">

                    <button type="button"
                            class="btn btn-primary w-100"
                            onclick="tambahKeranjang()"
                            id="tambahButton">

                        <i class="fas fa-plus me-2"></i>
                        Tambah ke Keranjang

                    </button>

                </div>

            </div>

        </div>

    </div>

    <div class="col-md-6">

        <div class="card h-100">

            <div class="card-header bg-white">

                <h5 class="mb-0">
                    Keranjang
                </h5>

            </div>

            <div class="card-body d-flex flex-column">


                <div id="keranjang-container"
                    class="keranjang-box flex-grow-1">

                    <p class="text-muted text-center mb-0">
                        Keranjang kosong
                    </p>

                </div>


                <div class="summary-section">

                    <div class="d-flex justify-content-between align-items-center summary-row">

                        <span class="summary-label">
                            Total Item
                        </span>

                        <span class="summary-value"
                            id="totalItem">
                            0
                        </span>

                    </div>

                    <div class="d-flex justify-content-between align-items-center summary-row">

                        <span class="summary-label">
                            Total
                        </span>

                        <span class="summary-total"
                            id="totalKeranjang">
                            Rp 0
                        </span>

                    </div>

                </div>


                <div class="d-grid gap-2 mt-4">

                    <button type="button"
                            class="btn btn-success"
                            onclick="simpanTransaksi()">

                        <i class="fas fa-save me-2"></i>
                        Simpan Transaksi

                    </button>

                    <button type="button"
                            class="btn btn-outline-danger"
                            onclick="kosongkanKeranjang()">

                        <i class="fas fa-trash me-2"></i>
                        Kosongkan

                    </button>

                </div>

            </div>

        </div>

    </div>
</div>


<div class="row mb-4">

    <div class="col-md-12">

        <div class="card">


            <div class="card-header bg-white">

                <div class="row align-items-center">


                    <div class="col-md-6">

                        <h5 class="mb-0">
                            Riwayat Transaksi
                        </h5>

                    </div>


                    <div class="col-md-6 d-flex justify-content-end">

                        <input type="date"
                               id="filterTanggal"
                               class="form-control form-control-sm w-auto"
                               value="{{ date('Y-m-d') }}">

                    </div>

                </div>

            </div>


            <div class="card-body">

                <div class="table-responsive">

                    <table class="table table-hover table-bordered align-middle"
                           id="tableTransaksi">

                        <thead class="table-light">

                            <tr>

                                <th class="text-center"
                                    style="width: 50px">
                                    No
                                </th>

                                <th>Kode Transaksi</th>

                                <th>Waktu</th>

                                <th>Items</th>

                                <th>Total</th>

                                <th>User</th>

                                <th class="text-center">
                                    Aksi
                                </th>

                            </tr>

                        </thead>

                        <tbody id="transaksiBody">

                            @foreach($transaksis as $index => $transaksi)

                            <tr>

                                <td class="text-center">
                                    {{ $index + 1 }}
                                </td>

                                <td>
                                    <span style="color:#222; font-weight:400;">{{ $transaksi->kode_transaksi }}</span>
                                </td>

                                 <td>
                                     {{ \Carbon\Carbon::parse($transaksi->tanggal)->format('d-m-Y H:i') }}
                                 </td>

                                <td>
                                    {{ $transaksi->detailTransaksi->count() }} item
                                </td>

                                <td>
                                    Rp {{ number_format($transaksi->total, 0, ',', '.') }}
                                </td>

                                <td>
                                    {{ $transaksi->user->name ?? '-' }}
                                </td>

                                <td class="text-center">

                                    <a href="{{ route('transaksi.show', $transaksi->id) }}"
                                    class="btn btn-info btn-sm d-inline-flex align-items-center justify-content-center gap-1 px-2"
                                    style="height: 32px; font-size: 12px;">

                                        <i class="fas fa-eye"></i>
                                        <span>Detail</span>

                                    </a>

                                </td>

                            </tr>

                            @endforeach

                        </tbody>

                        <tfoot>

                            <tr class="table-light">

                                <th colspan="4"
                                    class="text-end">
                                    Total:
                                </th>

                                <th class="text-end">
                                    Rp {{ number_format($transaksis->sum('total'), 0, ',', '.') }}
                                </th>

                                <th colspan="2"></th>

                            </tr>

                        </tfoot>

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

    .form-control,
    .form-select,
    .input-group-text {
        border-radius: 8px !important;
        border: 1px solid #e5e7eb !important;
    }

    .btn {
        border-radius: 8px;
    }

    .form-label {
        font-size: 14px;
        font-weight: 500;
        margin-bottom: 6px;
        color: #374151;
    }

    .form-control,
    .form-select,
    .input-group-text {
        height: 44px;
        border-radius: 8px !important;
        font-size: 14px;
    }

    .keranjang-box {
        min-height: 180px;
        max-height: 250px;
        overflow-y: auto;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        padding: 12px;
        background: #f8fafc;
    }

    .keranjang-box::-webkit-scrollbar {
        width: 4px;
    }

    .keranjang-box::-webkit-scrollbar-thumb {
        background: rgba(15, 23, 42, 0.18);
        border-radius: 10px;
    }

    .keranjang-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 12px 0;
        border-bottom: 1px solid #e5e7eb;
        gap: 14px;
    }

    .keranjang-item:last-child {
        border-bottom: none;
    }

    .keranjang-info {
        flex: 1;
        min-width: 0;
    }

    .keranjang-nama {
        font-size: 15px;
        font-weight: 500;
        color: #0f172a;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .keranjang-satuan {
        font-size: 13px;
        color: #64748b;
        margin-left: 4px;
    }

    .qty-box {
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .qty-btn {
        width: 28px;
        height: 28px;
        border: 1px solid #d1d5db;
        background: #ffffff;
        border-radius: 6px;
        font-size: 14px;
        font-weight: 500;
        color: #0f172a;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .qty-btn:hover {
        border-color: #2563eb;
        background: #eff6ff;
        color: #2563eb;
    }

    .qty-number {
        min-width: 18px;
        text-align: center;
        font-size: 14px;
        font-weight: 500;
    }

    .keranjang-harga {
        min-width: 95px;
        text-align: right;
        font-size: 15px;
        font-weight: 600;
        color: #000000;
    }

    .hapus-btn {
        width: 26px !important;
        height: 26px !important;
        min-width: 26px;
        padding: 0 !important;
        border-radius: 6px !important;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        border: 1px solid #fee2e2 !important;
        background: #dc2626!important;
        color: #ffffff !important;
        transition: all 0.2s ease;
    }

    .hapus-btn:hover {
        border-color: #dc2626 !important;
        background: #dc2626 !important;
        color: #ffffff !important;
    }

    .hapus-btn i {
        font-size: 11px;
    }


.summary-label{
    font-size: 18px;
    color:
}

.summary-section{
    padding-top: 10px;
}

.summary-row{
    margin-bottom: 4px;
}

.summary-value{
    font-size: 18px;
    color:
}

.summary-total{
    font-size: 20px;
    font-weight: 700;
}


.btn {
        height: 44px;
        font-weight: 500;
    }


        font-size: 20px;
    }

.card-body {
    padding-top: 24px !important;
    padding-bottom: 24px !important;
}
    table th {
        color: #000000 !important;
    }

</style>
@endsection

@section('scripts')
<script>
    let keranjang = [];
    const barangData = @json($barangs);

    $(document).ready(function () {

        $('#barangSelect').select2({
            placeholder: "Ketik nama barang...",
            allowClear: true,
            width: '100%'
        });

    });

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });


    $('#barangSelect').on('change', function() {
        const selected = $(this).find(':selected');
        const harga = selected.data('harga');
        const stok = selected.data('stok');
        const satuan = selected.data('satuan') || 'pcs';

        $('#hargaBarang').val(harga ? parseInt(harga).toLocaleString('id-ID') : '0');
        $('#satuanBarang').text(satuan);
        $('#jumlahBarang').attr('max', stok);
        $('#jumlahBarang').val(1);
    });

    function renderSelectedBarangList() {
        const list = $('#selectedBarangList');
        const items = $('#selectedBarangListItems');

        if (keranjang.length === 0) {
            list.hide();
            items.html('');
            return;
        }

        let html = '';
        keranjang.forEach((item, index) => {
            html += `<div class="list-group-item">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div><strong>${index + 1}. ${item.kode_barang} - ${item.nama_barang}</strong></div>
                        <div class="small text-muted">Harga: Rp ${item.harga.toLocaleString('id-ID')} | Stok: ${item.stok} ${item.satuan}</div>
                        <div class="small">Jumlah: ${item.qty} ${item.satuan} | Subtotal: Rp ${item.subtotal.toLocaleString('id-ID')}</div>
                    </div>
                    <button class="btn btn-sm btn-outline-danger ms-2" onclick="hapusKeranjang(${index})">Hapus</button>
                </div>
            </div>`;
        });

        items.html(html);
        list.show();
    }

    function tambahKeranjang() {
        const select = document.getElementById('barangSelect');
        const barangId = select.value;
        const jumlah = parseInt($('#jumlahBarang').val());

        if (!barangId) {
            Swal.fire({ icon: 'warning', title: 'Pilih barang terlebih dahulu' });
            return;
        }

        if (jumlah < 1) {
            Swal.fire({ icon: 'warning', title: 'Jumlah minimal 1' });
            return;
        }

        const barang = barangData.find(b => b.id == barangId);
        if (jumlah > barang.stok) {
            Swal.fire({ icon: 'warning', title: 'Stok tidak mencukupi', text: 'Stok tersedia: ' + barang.stok });
            return;
        }

        const existingIndex = keranjang.findIndex(k => k.barang_id == barangId);
        if (existingIndex >= 0) {
            const newQty = keranjang[existingIndex].qty + jumlah;
            if (newQty > barang.stok) {
                Swal.fire({ icon: 'warning', title: 'Stok tidak mencukupi' });
                return;
            }
            keranjang[existingIndex].qty = newQty;
            keranjang[existingIndex].subtotal = newQty * barang.harga;
        } else {
            keranjang.push({
                barang_id: barangId,
                kode_barang: barang.kode_barang,
                nama_barang: barang.nama_barang,
                harga: barang.harga,
                stok: barang.stok,
                qty: jumlah,
                subtotal: jumlah * barang.harga,
                satuan: barang.satuan || 'pcs'
            });
        }

        renderKeranjang();
        select.value = '';
        $('#hargaBarang').val('');
        $('#jumlahBarang').val(1);


        setTimeout(() => {
            document.querySelector('.col-md-4 .card').scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        }, 100);
    }

function renderKeranjang() {

    const container = document.getElementById('keranjang-container');

    if (keranjang.length === 0) {

        container.innerHTML = `
            <p class="text-muted text-center mb-0">
                Keranjang kosong
            </p>
        `;

        document.getElementById('totalKeranjang').innerHTML =
            '<span class="summary-total">Rp 0</span>';

        document.getElementById('totalItem').textContent = '0';

        return;
    }

    let html = '';

    let total = 0;
    let totalItem = 0;

    keranjang.forEach((item, index) => {

        total += item.subtotal;
        totalItem += item.qty;

        html += `
            <div class="keranjang-item">

                <div class="keranjang-info">

                    <div class="keranjang-nama">
                        <span class="me-1 text-muted">
                            ${index + 1}.
                        </span>

                        ${item.nama_barang}

                        <span class="keranjang-satuan">
                            • ${item.satuan}
                        </span>
                    </div>

                </div>

                <div class="qty-box">

                    <button
                        class="qty-btn"
                        onclick="kurangiKeranjang(${index})">

                        -

                    </button>

                    <span class="qty-number">
                        ${item.qty}
                    </span>

                    <button
                        class="qty-btn"
                        onclick="tambahKeranjangItem(${index})">

                        +

                    </button>

                </div>

                <div class="keranjang-harga">
                    Rp ${item.subtotal.toLocaleString('id-ID')}
                </div>

                <button
                    class="btn btn-danger hapus-btn"
                    onclick="hapusKeranjang(${index})">

                    <i class="fas fa-times"></i>

                </button>

            </div>
        `;
    });

    container.innerHTML = html;

    document.getElementById('totalKeranjang').innerHTML =
        '<span class="summary-total">Rp ' +
        total.toLocaleString('id-ID') +
        '</span>';

    document.getElementById('totalItem').textContent = totalItem;
}

    function tambahKeranjangItem(index) {
        const item = keranjang[index];
        if (item.qty < item.stok) {
            item.qty += 1;
            item.subtotal = item.qty * item.harga;
            renderKeranjang();
        } else {
            Swal.fire({ icon: 'warning', title: 'Stok tidak mencukupi', text: 'Stok tersedia: ' + item.stok });
        }
    }

    function kurangiKeranjang(index) {
        const item = keranjang[index];
        if (item.qty > 1) {
            item.qty -= 1;
            item.subtotal = item.qty * item.harga;
            renderKeranjang();
        } else {
            Swal.fire({ icon: 'warning', title: 'Jumlah minimal 1', text: 'Gunakan tombol hapus jika ingin menghapus item' });
        }
    }

    function hapusKeranjang(index) {
        keranjang.splice(index, 1);
        renderKeranjang();
    }

    function kosongkanKeranjang() {
        if (keranjang.length === 0) return;

        Swal.fire({
            title: 'Kosongkan Keranjang?',
            text: 'Semua item akan dihapus dari keranjang',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya, Kosongkan',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                keranjang = [];
                renderKeranjang();
            }
        });
    }

    function simpanTransaksi() {
        if (keranjang.length === 0) {
            Swal.fire({ icon: 'warning', title: 'Keranjang masih kosong' });
            return;
        }

        Swal.fire({
            title: 'Simpan Transaksi?',
            text: 'Total: ' + $('#totalKeranjang').text(),
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Simpan',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '{{ route("transaksi.store") }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        items: keranjang
                    },
                    success: function(response) {
                        Swal.fire({ icon: 'success', title: 'Berhasil', text: response.message, timer: 1000, showConfirmButton: false });
                        keranjang = [];
                        renderKeranjang();
                        location.reload();
                    },
                    error: function(xhr) {
                        Swal.fire({ icon: 'error', title: 'Gagal', text: xhr.responseJSON.message });
                    }
                });
            }
        });
    }

    function reloadTransaksi() {
        fetch('{{ route("transaksi.data") }}')
            .then(response => response.json())
            .then(data => {
                if (!Array.isArray(data) || data.length === 0) {
                    location.reload();
                    return;
                }

                let html = '';
                data.forEach((transaksi, index) => {
                    const waktu = new Date(transaksi.tanggal).toLocaleTimeString('id-ID', {hour: '2-digit', minute:'2-digit'});
                    const itemsCount = Array.isArray(transaksi.detail_transaksis) ? transaksi.detail_transaksis.length : 0;
                    html += `<tr>
                         <td class="text-center">${index + 1}</td>
                         <td><span class="text-primary">${transaksi.kode_transaksi}</span></td>
                         <td>${waktu}</td>
                         <td>${itemsCount} item</td>
                         <td class="text-end">Rp ${parseInt(transaksi.total).toLocaleString('id-ID')}</td>
                         <td>${transaksi.user?.name || '-'}</td>
                         <td class="text-center">
                             <a href="/transaksi/${transaksi.id}" class="btn btn-sm btn-info" title="Lihat detail">
                                 <i class="fas fa-eye"></i> Detail
                             </a>
                         </td>
                    </tr>`;
                });
                document.getElementById('transaksiBody').innerHTML = html;
            })
            .catch(error => {
                console.error('Error reloading transaksi:', error);
                location.reload();
            });
    }

     $('#filterTanggal').on('change', function() {
         const tanggal = $(this).val();
         window.location.href = '{{ route("transaksi.index") }}?tanggal=' + tanggal;
     });

     function hapusSemuaTransaksi() {
        Swal.fire({
            title: 'Hapus Semua Transaksi?',
            text: 'Semua data transaksi akan dihapus secara permanen!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus Semua',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '{{ route("transaksi.destroyAll") }}',
                    method: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        Swal.fire({ icon: 'success', title: 'Berhasil', text: response.message, timer: 2000, showConfirmButton: false });
                        setTimeout(() => location.reload(), 2000);
                    },
                    error: function(xhr) {
                        Swal.fire({ icon: 'error', title: 'Gagal', text: xhr.responseJSON.message });
                    }
                });
            }
        });
    }
</script>
@endsection
