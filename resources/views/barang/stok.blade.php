@extends('layout.main')

@section('title', 'Stok Barang')
@section('page-title', 'Stok Barang')

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
        padding-left: 32px !important;
        padding-right: 32px !important;
    }


    .card-header h5 {
        padding-left: 0;
        margin-bottom: 0;
        color: #0f172a;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    table th {
        color: #000000 !important;
    }

</style>

<div class="row mb-3">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-white">
                <div class="row align-items-center">


                    <div class="col-md-3">
                        <h5 class="mb-0">
                            Stok Barang
                        </h5>
                    </div>


                    <div class="col-md-9">
                        <div class="row align-items-center">


                            <div class="col-md-4">
                                <input type="text"
                                    id="searchStok"
                                    class="form-control form-control-sm"
                                    placeholder="Cari barang...">
                            </div>


                            <div class="col-md-3">
                                <select id="filterKategoriStok" class="form-select form-select-sm">
                                    <option value="">Semua Kategori</option>
                                    @foreach($kategoris as $kategori)
                                    <option value="{{ $kategori->id }}">{{ $kategori->nama_kategori }}</option>
                                    @endforeach
                                </select>
                            </div>


                            <div class="col-md-2">
                                <select id="filterStatusStok" class="form-select form-select-sm">
                                    <option value="">Semua Status</option>
                                    <option value="rendah">Stok Rendah</option>
                                    <option value="tersedia">Tersedia</option>
                                </select>
                            </div>


                            <div class="col-md-3">
                                <button class="btn btn-primary btn-sm"
                                        data-bs-toggle="modal"
                                        data-bs-target="#modalRestok">
                                    <i class="fas fa-plus me-1"></i> Tambah Stok
                                </button>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered" id="tableStok">
                        <thead class="table-light">
                            <tr>
                                <th class="text-center" style="width: 50px">No</th>
                                <th>Kode</th>
                                <th>Nama Barang</th>
                                <th>Kategori</th>
                                <th>Harga Modal</th>
                                <th>Harga Jual</th>
                                <th class="text-center">Stok</th>
                                <th class="text-center">Satuan</th>
                                <th class>Nilai Stok</th>
                                <th class="text-center">Status</th>
                                <th class="text-center" style="width: 100px">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="tableStokBody">
                            @foreach($barangs as $index => $barang)
                            <tr class="{{ $barang->stok < 10 ? 'table-warning' : '' }}" data-kategori="{{ $barang->kategori_id }}">
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td><span>{{ $barang->kode_barang }}</span></td>
                                <td>{{ $barang->nama_barang }}</td>
                                <td><span class="badge bg-secondary">{{ $barang->kategori->nama_kategori ?? '-' }}</span></td>
                                <td class>Rp {{ number_format($barang->harga_modal ?? 0, 0, ',', '.') }}</td>
                                <td class>Rp {{ number_format($barang->harga, 0, ',', '.') }}</td>
                                <td class="text-center">
                                    @if($barang->stok < 10)
                                    <span class="text-danger">{{ $barang->stok }}</span>
                                    @else
                                    {{ $barang->stok }}
                                    @endif
                                </td>
                                <td class="text-center">{{ $barang->satuan ?? 'pcs' }}</td>
                                <td class>Rp {{ number_format($barang->harga * $barang->stok, 0, ',', '.') }}</td>
                                <td class="text-center">
                                    @if($barang->stok < 10)
                                    <span class="stok-rendah"><i class="fas fa-exclamation-triangle me-1"></i>Rendah</span>
                                    @else
                                    <span class="badge bg-success">Tersedia</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-primary" onclick="restokBarang({{ $barang->id }})">
                                        <i class="fas fa-plus"></i> Restok
                                    </button>
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

<div class="modal fade" id="modalRestok" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-primary"><i class="fas fa-plus me-2"></i>Tambah Stok Barang</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="formRestok">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Pilih Barang <span class="text-danger">*</span></label>
                        <select name="barang_id" id="restokBarangId" class="form-select select2" required>
                            <option value="">Pilih Barang...</option>
                            @foreach($barangs as $barang)
                            <option value="{{ $barang->id }}">{{ $barang->kode_barang }} - {{ $barang->nama_barang }} (Stok: {{ $barang->stok }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jumlah Stok <span class="text-danger">*</span></label>
                        <input type="number" name="jumlah" class="form-control" min="1" value="1" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Update Harga (Opsional)</label>
                        <div class="row">
                            <div class="col-md-6">
                                <input type="number" name="harga_modal" class="form-control" placeholder="Harga Modal Baru">
                            </div>
                            <div class="col-md-6">
                                <input type="number" name="harga" class="form-control" placeholder="Harga Jual Baru">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalRestokItem" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-primary"><i class="fas fa-plus me-2"></i>Restok Barang</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="formRestokItem">
                <input type="hidden" name="barang_id" id="restokId">
                <div class="modal-body">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Barang:</strong> <span id="restokNamaBarang"></span><br>
                        <strong>Stok Saat Ini:</strong> <span id="restokStokSekarang"></span><br>
                        <strong>Harga Jual:</strong> <span id="restokHargaJual"></span>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jumlah Stok Ditambahkan <span class="text-danger">*</span></label>
                        <input type="number" name="jumlah" class="form-control form-control-lg" min="1" value="1" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Update Harga (Opsional)</label>
                        <div class="row">
                            <div class="col-md-6">
                                <input type="number" name="harga_modal" class="form-control" placeholder="Harga Modal Baru">
                            </div>
                            <div class="col-md-6">
                                <input type="number" name="harga" class="form-control" placeholder="Harga Jual Baru">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-plus me-1"></i> Tambah Stok</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    let barangData = @json($barangs);

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#formRestok').on('submit', function(e) {
        e.preventDefault();
        const barangId = $('#restokBarangId').val();
        const jumlah = $('#formRestok input[name="jumlah"]').val();
        const hargaModal = $('#formRestok input[name="harga_modal"]').val();
        const harga = $('#formRestok input[name="harga"]').val();

        let data = { barang_id: barangId, jumlah: jumlah };
        if (hargaModal) data.harga_modal = hargaModal;
        if (harga) data.harga = harga;

        $.ajax({
            url: '/barang/restock',
            method: 'POST',
            data: data,
            success: function(response) {
                Swal.fire({ icon: 'success', title: 'Berhasil', text: response.message, timer: 2000, showConfirmButton: false });
                $('#modalRestok').modal('hide');
                location.reload();
            },
            error: function(xhr) {
                Swal.fire({ icon: 'error', title: 'Gagal', text: xhr.responseJSON.message });
            }
        });
    });

    function restokBarang(id) {
        const barang = barangData.find(b => b.id === id);
        if (barang) {
            $('#restokId').val(barang.id);
            $('#restokNamaBarang').text(barang.nama_barang + ' (' + barang.kode_barang + ')');
            $('#restokStokSekarang').text(barang.stok + ' ' + (barang.satuan || 'pcs'));
            $('#restokHargaJual').text('Rp ' + parseInt(barang.harga).toLocaleString('id-ID'));
            $('#modalRestokItem').modal('show');
        }
    }

    function filterTableStok() {
        const search = $('#searchStok').val().toLowerCase();
        const kategoriFilter = $('#filterKategoriStok').val();
        const statusFilter = $('#filterStatusStok').val();

        $('#tableStokBody tr').each(function () {
            const row = $(this);
            const kode = row.find('td:nth-child(2)').text().toLowerCase();
            const nama = row.find('td:nth-child(3)').text().toLowerCase();
            const kategoriId = row.attr('data-kategori') || '';
            const stok = parseInt(row.find('td:nth-child(7)').text().trim());

            let searchMatch = kode.includes(search) || nama.includes(search);
            let kategoriMatch = !kategoriFilter || kategoriId === kategoriFilter;
            let statusMatch = !statusFilter ||
                (statusFilter === 'rendah' && stok < 10) ||
                (statusFilter === 'tersedia' && stok >= 10);

            if (searchMatch && kategoriMatch && statusMatch) {
                row.show();
            } else {
                row.hide();
            }
        });
    }

    $('#searchStok').on('keyup', function () {
        filterTableStok();
    });

    $('#filterKategoriStok').on('change', function () {
        filterTableStok();
    });

    $('#filterStatusStok').on('change', function () {
        filterTableStok();
    });

    $('#formRestokItem').on('submit', function(e) {
        e.preventDefault();
        const barangId = $('#restokId').val();
        const jumlah = $('#formRestokItem input[name="jumlah"]').val();
        const hargaModal = $('#formRestokItem input[name="harga_modal"]').val();
        const harga = $('#formRestokItem input[name="harga"]').val();

        let data = { barang_id: barangId, jumlah: jumlah };
        if (hargaModal) data.harga_modal = hargaModal;
        if (harga) data.harga = harga;

        $.ajax({
            url: '/barang/restock',
            method: 'POST',
            data: data,
            success: function(response) {
                Swal.fire({ icon: 'success', title: 'Berhasil', text: response.message, timer: 2000, showConfirmButton: false });
                $('#modalRestokItem').modal('hide');
                location.reload();
            },
            error: function(xhr) {
                Swal.fire({ icon: 'error', title: 'Gagal', text: xhr.responseJSON.message });
            }
        });
    });
</script>
@endsection
