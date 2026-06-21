@extends('layout.main')

@section('title', 'Data Barang')
@section('page-title', 'Data Barang')

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
        gap: 0.5rem;
    }

    .print-header,
    .print-footer,
    .print-info {
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

<div class="row mb-3">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-white">
                <div class="row align-items-center">
                    <div class="col-md-3">
                        <h5 class="mb-0 "></i>Data Barang</h5>
                    </div>
                        <div class="col-md-9">
                            <div class="row align-items-center">
                                <div class="col-md-4">
                                    <input type="text" id="searchBarang" class="form-control form-control-sm" placeholder="Cari barang...">
                                </div>
                                <div class="col-md-3">
                                    <select id="filterKategori" class="form-select form-select-sm">
                                        <option value="">Semua Kategori</option>
                                        @foreach($kategoris as $kategori)
                                        <option value="{{ $kategori->id }}">{{ $kategori->nama_kategori }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <select id="filterStatus" class="form-select form-select-sm">
                                        <option value="">Semua Status</option>
                                        <option value="rendah">Stok Rendah</option>
                                        <option value="tersedia">Tersedia</option>
                                    </select>
                                </div>
                                <div class="col-md-3 d-flex gap-2">
                                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalBarang">
                                        <i class="fas fa-plus me-1"></i> Tambah
                                    </button>
                                    <button type="button"
                                            onclick="window.print()"
                                            class="btn btn-primary btn-sm no-print">
                                        <i class="fas fa-print me-1"></i>
                                        Cetak
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
            <div class="card-body">
                {{-- PRINT HEADER --}}
                <div class="print-header">

                    <h3>ATK ARUM SAKTI</h3>

                    <p>Laporan Data Barang</p>

                </div>
                <div class="table-responsive">
                    <table class="table table-hover table-bordered" id="tableBarang">
                        <thead class="table-light">
                            <tr>
                                <th class="text-center" style="width: 50px">No</th>
                                <th>Kode</th>
                                <th>Nama Barang</th>
                                <th>Kategori</th>
                                <th class>Harga Jual</th>
                                <th class="text-center">Stok</th>
                                <th class="text-center">Status</th>
                                <th class="text-center" style="width: 140px">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="tableBody">
                            @foreach($barangs as $index => $barang)
                            <tr data-kategori="{{ $barang->kategori_id }}" data-stok="{{ $barang->stok }}">
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td><span>{{ $barang->kode_barang }}</span></td>
                                <td>{{ $barang->nama_barang }}</td>
                                <td><span class="badge bg-secondary">{{ $barang->kategori->nama_kategori ?? '-' }}</span></td>
                                <td class>Rp {{ number_format($barang->harga, 0, ',', '.') }}</td>
                                <td class="text-center">
                                    @if($barang->stok < 10)
                                    <span class="text-danger">{{ $barang->stok }}</span>
                                    @else
                                    {{ $barang->stok }}
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if($barang->stok < 10)
                                    <span class="stok-rendah"><i class="fas fa-exclamation-triangle me-1"></i>Stok Rendah</span>
                                    @else
                                    <span class="badge bg-success">Tersedia</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('barang.show', $barang->id) }}" class="btn btn-info" title="Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <button class="btn btn-warning" onclick="editBarang({{ $barang->id }})" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-danger" onclick="hapusBarang({{ $barang->id }})" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            @php
                                $totalJual = $barangs->sum(function($b) { return $b->harga * $b->stok; });
                                $totalStok = $barangs->sum('stok');
                            @endphp
                            <tr class="table-light">
                                <th colspan="4" class="text-end">Total</th>
                                <th class="text-end">Rp {{ number_format($totalJual, 0, ',', '.') }}</th>
                                <th class="text-center">{{ $totalStok }}</th>
                                <th colspan="2"></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                                {{-- PRINT FOOTER --}}
                <div class="print-footer">

                    <p>
                        Data barang dicetak dari sistem ATK Arum Sakti
                    </p>

                    <p>
                        Dicetak pada:
                        {{ \Carbon\Carbon::now()->format('d-m-Y H:i:s') }}
                    </p>

                </div>
                <div class="mt-2">
                    <small class="text-muted">Menampilkan {{ $barangs->count() }} dari {{ $barangs->count() }} barang | Stok Rendah: {{ $barangs->where('stok', '<', 10)->count() }}</small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<div class="modal fade" id="modalBarang" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-primary"><i class="fas fa-plus me-2"></i>Tambah Barang Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="formBarang">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Kode Barang</label>
                                <input type="text" name="kode_barang" id="inputKodeBarang" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Nama Barang <span class="text-danger">*</span></label>
                                <input type="text" name="nama_barang" class="form-control" placeholder="Pensil 2B" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Kategori <span class="text-danger">*</span></label>
                                <select name="kategori_id" class="form-select" required>
                                    <option value="">Pilih Kategori</option>
                                    @foreach($kategoris as $kategori)
                                    <option value="{{ $kategori->id }}">{{ $kategori->nama_kategori }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Satuan</label>
                                <select name="satuan" class="form-select">
                                    <option value="pcs">pcs</option>
                                    <option value="box">Box</option>
                                    <option value="rim">Rim</option>
                                    <option value="pack">Pack</option>
                                    <option value="lusin">Lusin</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Harga Modal (Rp) <span class="text-danger">*</span></label>
                                <input type="number" name="harga_modal" class="form-control" placeholder="0" min="0" value="0">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Harga Jual (Rp) <span class="text-danger">*</span></label>
                                <input type="number" name="harga" class="form-control" placeholder="0" min="0" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Stok Awal <span class="text-danger">*</span></label>
                                <input type="number" name="stok" class="form-control" placeholder="0" min="0" value="0" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Simpan Barang</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalEditBarang" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-primary"><i class="fas fa-edit me-2"></i>Edit Harga Barang</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="formEditBarang">
                <input type="hidden" name="id" id="editId">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Barang</label>
                        <input type="text" id="editNamaBarang" class="form-control" readonly>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Harga Modal (Rp)</label>
                                <input type="number" name="harga_modal" id="editHargaModal" class="form-control" min="0">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Harga Jual (Rp)</label>
                                <input type="number" name="harga" id="editHarga" class="form-control" min="0" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Update Harga</button>
                </div>
            </form>
        </div>
    </div>
</div>

@section('scripts')
<script>
    let barangData = @json($barangs);

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#modalBarang').on('show.bs.modal', function() {
        $.get('{{ route("barang.nextkode") }}', function(response) {
            $('#inputKodeBarang').val(response.kode_barang);
        });
    });

    $('#searchBarang').on('keyup', function() {
        filterTable();
    });

    $('#filterKategori, #filterStatus').on('change', function() {
        filterTable();
    });

    function filterTable() {
        const search = $('#searchBarang').val().toLowerCase();
        const kategori = $('#filterKategori').val();
        const status = $('#filterStatus').val();

        $('#tableBody tr').each(function() {
            const row = $(this);
            const kode = row.find('td:nth-child(2)').text().toLowerCase();
            const nama = row.find('td:nth-child(3)').text().toLowerCase();
            const rowKategori = row.data('kategori');
            const stok = parseInt(row.data('stok'));

            let show = true;

            if (search && !kode.includes(search) && !nama.includes(search)) {
                show = false;
            }

            if (kategori && rowKategori != kategori) {
                show = false;
            }

            if (status === 'rendah' && stok >= 10) {
                show = false;
            }

            if (status === 'tersedia' && stok < 10) {
                show = false;
            }

            row.toggle(show);
        });
    }

    $('#formBarang').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url: '{{ route("barang.store") }}',
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                Swal.fire({ icon: 'success', title: 'Berhasil', text: response.message, timer: 2000, showConfirmButton: false });
                $('#modalBarang').modal('hide');
                location.reload();
            },
            error: function(xhr) {
                Swal.fire({ icon: 'error', title: 'Gagal', text: xhr.responseJSON.message });
            }
        });
    });

    function editBarang(id) {
        const barang = barangData.find(b => b.id === id);
        if (barang) {
            $('#editId').val(barang.id);
            $('#editNamaBarang').val(barang.nama_barang);
            $('#editHargaModal').val(barang.harga_modal || 0);
            $('#editHarga').val(barang.harga);
            $('#modalEditBarang').modal('show');
        }
    }

    $('#formEditBarang').on('submit', function(e) {
        e.preventDefault();
        const id = $('#editId').val();
        $.ajax({
            url: '/barang/' + id,
            method: 'PUT',
            data: $(this).serialize(),
            success: function(response) {
                Swal.fire({ icon: 'success', title: 'Berhasil', text: response.message, timer: 2000, showConfirmButton: false });
                $('#modalEditBarang').modal('hide');
                location.reload();
            },
            error: function(xhr) {
                Swal.fire({ icon: 'error', title: 'Gagal', text: xhr.responseJSON.message });
            }
        });
    });

    function hapusBarang(id) {
        Swal.fire({
            title: 'Hapus Barang?',
            text: 'Data barang akan dihapus permanen!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Hapus',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/barang/' + id,
                    method: 'DELETE',
                    success: function(response) {
                        Swal.fire({ icon: 'success', title: 'Berhasil', text: response.message, timer: 2000, showConfirmButton: false });
                        location.reload();
                    },
                    error: function(xhr) {
                        Swal.fire({ icon: 'error', title: 'Gagal', text: xhr.responseJSON.message });
                    }
                });
            }
        });
    }

    function printBarang() {
        window.print();
    }
</script>
@endsection

