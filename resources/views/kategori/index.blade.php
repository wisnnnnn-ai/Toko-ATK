@extends('layout.main')

@section('title', 'Kategori')
@section('page-title', 'Kategori')

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

    table thead th {
        color: #000000;
        font-weight: 600;
        vertical-align: middle;
        background: #f8fafc;
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
        font-weight: 600;
    }

    .card-header .row {
        margin-left: 0 !important;
        margin-right: 0 !important;
    }

    .card-header .col-md-3 {
        padding-left: 0 !important;
        padding-right: 0.5rem !important;
    }

    .card-header .col-md-9 {
        padding-left: 0.5rem !important;
        padding-right: 0 !important;
    }
        table th {
        color: #000000 !important;
    }

</style>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-white">
                <div class="row align-items-center">


                    <div class="col-md-3">
                        <h5 class="mb-0">
                            Kategori Barang
                        </h5>
                    </div>


                    <div class="col-md-9">
                        <div class="row align-items-center">


                            <div class="col-md-6">
                                <input type="text"
                                    id="searchKategori"
                                    class="form-control form-control-sm"
                                    placeholder="Cari kategori...">
                            </div>


                            <div class="col-md-6">
                                <button class="btn btn-primary btn-sm"
                                        data-bs-toggle="modal"
                                        data-bs-target="#modalKategori">
                                    <i class="fas fa-plus me-1"></i> Tambah Kategori
                                </button>
                            </div>

                        </div>
                    </div>

                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered" id="tableKategori">
                        <thead class="table-light">
                            <tr>
                                <th class="text-center" style="width: 50px">No</th>
                                <th>Kode Kategori</th>
                                <th>Nama Kategori</th>
                                <th class="text-center">Jumlah Barang</th>
                                <th class="text-center">Total Stok</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="tableKategoriBody">
                            @foreach($kategoris as $index => $kategori)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td><span class="text-dark">{{ strtoupper($kategori->kode_kategori ?? 'KTG' . str_pad($kategori->id, 3, '0', STR_PAD_LEFT)) }}</span></td>
                                <td>{{ $kategori->nama_kategori }}</td>
                                <td class="text-center">{{ $kategori->barang->count() }}</td>
                                <td class="text-center">{{ $kategori->barang->sum('stok') }}</td>
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('kategori.show', $kategori->id) }}" class="btn btn-info" title="Lihat selengkapnya">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <button class="btn btn-warning" onclick="editKategori({{ $kategori->id }})" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-danger" onclick="hapusKategori({{ $kategori->id }})" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if($kategoris->count() === 0)
                <div class="text-center py-4">
                    <i class="fas fa-tags fa-3x text-muted mb-3"></i>
                    <p class="text-muted">Belum ada kategori. Silakan tambah kategori terlebih dahulu.</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalKategori" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-primary"><i class="fas fa-plus me-2"></i>Tambah Kategori Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="formKategori">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Kode Kategori</label>
                        <input type="text" name="kode_kategori" id="inputKodeKategori" class="form-control" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama Kategori <span class="text-danger">*</span></label>
                        <input type="text" name="nama_kategori" class="form-control" placeholder="Contoh: Alat Tulis, Buku, Kertas" required>
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

<div class="modal fade" id="modalEditKategori" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-primary"><i class="fas fa-edit me-2"></i>Edit Kategori</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="formEditKategori">
                <input type="hidden" name="id" id="editId">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Kode Kategori</label>
                        <input type="text" name="kode_kategori" id="editKodeKategori" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama Kategori <span class="text-danger">*</span></label>
                        <input type="text" name="nama_kategori" id="editNamaKategori" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    let kategoriData = @json($kategoris);

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#modalKategori').on('show.bs.modal', function() {
        $.get('{{ route("kategori.nextkode") }}', function(response) {
            $('#inputKodeKategori').val(response.kode_kategori);
        });
    });

    $('#searchKategori').on('keyup', function () {

    const search = $(this).val().toLowerCase();

    $('#tableKategoriBody tr').each(function () {

        const row = $(this);

        const kode = row.find('td:nth-child(2)').text().toLowerCase();

        const nama = row.find('td:nth-child(3)').text().toLowerCase();

        if (kode.includes(search) || nama.includes(search)) {
            row.show();
        } else {
            row.hide();
        }

    });

    });

    $('#formKategori').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url: '{{ route("kategori.store") }}',
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                Swal.fire({ icon: 'success', title: 'Berhasil', text: response.message, timer: 2000, showConfirmButton: false });
                $('#modalKategori').modal('hide');
                location.reload();
            },
            error: function(xhr) {
                Swal.fire({ icon: 'error', title: 'Gagal', text: xhr.responseJSON.message });
            }
        });
    });

    function editKategori(id) {
        const kategori = kategoriData.find(k => k.id === id);
        if (kategori) {
            $('#editId').val(kategori.id);
            $('#editKodeKategori').val(kategori.kode_kategori || '');
            $('#editNamaKategori').val(kategori.nama_kategori);
            $('#modalEditKategori').modal('show');
        }
    }

    $('#formEditKategori').on('submit', function(e) {
        e.preventDefault();
        const id = $('#editId').val();
        $.ajax({
            url: '/kategori/' + id,
            method: 'PUT',
            data: $(this).serialize(),
            success: function(response) {
                Swal.fire({ icon: 'success', title: 'Berhasil', text: response.message, timer: 2000, showConfirmButton: false });
                $('#modalEditKategori').modal('hide');
                location.reload();
            },
            error: function(xhr) {
                Swal.fire({ icon: 'error', title: 'Gagal', text: xhr.responseJSON.message });
            }
        });
    });

    function hapusKategori(id) {
        Swal.fire({
            title: 'Hapus Kategori?',
            text: 'Data kategori akan dihapus. Barang dengan kategori ini tidak akan terhapus.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Hapus',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/kategori/' + id,
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
</script>
@endsection
