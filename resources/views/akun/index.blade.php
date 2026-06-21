@extends('layout.main')

@section('title', 'Kelola Akun')
@section('page-title', 'Kelola Akun')

@section('main-content')

<style>

    .action-btn-group .btn{
        width: 32px;
        height: 32px;
        padding: 0 !important;
    }

    .action-btn-group .btn i{
        font-size: 14px;
    }

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


    .form-label {
        font-weight: 500;
        margin-bottom: 6px;
    }

    .form-control,
    .form-select {
        border-radius: 6px !important;
    }


    .btn {
        border-radius: 6px !important;
    }


    .toggle-password {
        top: 38px;
        z-index: 10;
        cursor: pointer;
    }


    .logout-card {
        border-left: 4px solid #dc2626 !important;
        border-radius: 10px !important;
        overflow: hidden;
        border-top: none !important;
        border-right: none !important;
        border-bottom: none !important;
        box-shadow: 0 16px 35px rgba(15, 23, 42, 0.08);
    }

    .logout-card .card-header {
        padding-left: 1rem !important;
        padding-right: 1rem !important;
        background: #ffffff;
        border-bottom: 1px solid #e5e7eb !important;
    }

    .logout-card .card-header h5 {
        color: #000000;
        padding-left: 0;
        font-weight: 600;
    }
    table th {
        color: #000000 !important;
    }

    @media (max-width: 768px) {
        .card-body {
            padding-left: 16px !important;
            padding-right: 16px !important;
        }

        .card-header h5 {
            padding-left: 16px !important;
        }
    }
</style>

<div class="row">

    {{-- FORM TAMBAH AKUN --}}
    @if(Auth::user()->role === 'admin')
    <div class="col-md-4">
        <div class="card mb-4">
            <div class="card-header bg-white">
                <h5>
                    Tambah Akun
                </h5>
            </div>

            <div class="card-body">
                <form method="POST" action="{{ route('akun.store') }}">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Nama</label>
                        <input type="text"
                               name="name"
                               class="form-control"
                               placeholder="Masukkan nama"
                               required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email"
                               name="email"
                               class="form-control"
                               placeholder="Masukkan email"
                               required>
                    </div>

                    <div class="mb-3 position-relative">
                        <label class="form-label">Password</label>

                        <input type="password"
                               name="password"
                               id="passwordAdd"
                               class="form-control pe-5"
                               placeholder="Masukkan password"
                               required>

                        <span class="position-absolute end-0 me-3 text-muted toggle-password"
                              data-target="passwordAdd">
                            <i class="fas fa-eye"></i>
                        </span>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-plus me-1"></i>
                        Tambah Akun
                    </button>
                </form>
            </div>
        </div>
    </div>
    @endif

    {{-- DAFTAR AKUN --}}
    <div class="@if(Auth::user()->role === 'admin') col-md-8 @else col-md-12 @endif">

        <div class="card mb-4">

            <div class="card-header bg-white">
                <h5>
                    Daftar Akun
                </h5>
            </div>

            <div class="card-body">

                <div class="table-responsive">
                    <table class="table table-hover table-bordered">

                        <thead class="table-light">
                            <tr>
                                <th>Nama</th>
                                <th>Email</th>
                                <th class="text-center">Role</th>
                                <th class="text-center" style="width: 120px">
                                    Aksi
                                </th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($users as $user)
                            <tr>

                                <td>{{ $user->name }}</td>

                                <td>{{ $user->email }}</td>

                                <td class="text-center">
                                    @if($user->role === 'admin')
                                        <span class="badge bg-danger">
                                            Admin
                                        </span>
                                    @else
                                        <span class="badge bg-secondary">
                                            Karyawan
                                        </span>
                                    @endif
                                </td>

                                <td class="text-center">

                                    <div class="btn-group btn-group-sm action-btn-group">

                                        @if(Auth::user()->role === 'admin' || Auth::user()->id === $user->id)

                                        <button class="btn btn-warning d-flex align-items-center justify-content-center"
                                                data-bs-toggle="modal"
                                                data-bs-target="#editModal{{ $user->id }}"
                                                title="Edit">

                                            <i class="fas fa-edit"></i>

                                        </button>

                                        @endif

                                        @if(Auth::user()->role === 'admin' && $user->id !== Auth::id())

                                        <form method="POST"
                                            action="{{ route('akun.destroy', $user->id) }}"
                                            class="d-inline"
                                            onsubmit="return confirm('Yakin hapus akun ini?')">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                    class="btn btn-danger d-flex align-items-center justify-content-center"
                                                    title="Hapus">

                                                <i class="fas fa-trash"></i>

                                            </button>

                                        </form>

                                        @endif

                                    </div>

                                </td>

                            </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>

                <div class="mt-2">
                    <small class="text-muted">
                        Total akun:
                        {{ $users->count() }}
                    </small>
                </div>

            </div>
        </div>

    </div>
</div>

{{-- LOGOUT --}}
<div class="row mt-4">

    <div class="col-md-12">

        <div class="card logout-card">

            <div class="card-header bg-white">
                <h5>
                    Logout Sistem
                </h5>
            </div>

            <div class="card-body text-center">

                <p class="text-muted mb-3">
                    Klik tombol di bawah untuk keluar dari sistem
                </p>

                <form action="{{ route('logout') }}"
                      method="GET"
                      class="d-inline">

                    <button type="submit"
                            class="btn btn-danger">

                        <i class="fas fa-sign-out-alt me-1"></i>
                        Logout

                    </button>

                </form>

            </div>

        </div>

    </div>

</div>

{{-- MODAL EDIT --}}
@foreach($users as $user)

<div class="modal fade"
     id="editModal{{ $user->id }}"
     tabindex="-1">

    <div class="modal-dialog">

        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title text-primary">
                    Edit Akun
                </h5>

                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal">
                </button>
            </div>

            <form method="POST"
                  action="{{ route('akun.update', $user->id) }}">

                @csrf
                @method('PUT')

                <div class="modal-body">

                    <div class="mb-3">
                        <label class="form-label">Nama</label>

                        <input type="text"
                               name="name"
                               class="form-control"
                               value="{{ $user->name }}"
                               required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email</label>

                        <input type="email"
                               name="email"
                               class="form-control"
                               value="{{ $user->email }}"
                               required>
                    </div>

                    <div class="mb-3 position-relative">

                        <label class="form-label">
                            Password Baru
                        </label>

                        <input type="password"
                               name="password"
                               id="passwordEdit{{ $user->id }}"
                               class="form-control pe-5"
                               placeholder="Kosongkan jika tidak diubah">

                        <span class="position-absolute end-0 me-3 text-muted toggle-password"
                              data-target="passwordEdit{{ $user->id }}">

                            <i class="fas fa-eye"></i>

                        </span>

                    </div>

                </div>

                <div class="modal-footer">

                    <button type="button"
                            class="btn btn-secondary"
                            data-bs-dismiss="modal">

                        Batal

                    </button>

                    <button type="submit"
                            class="btn btn-primary">

                        <i class="fas fa-save me-1"></i>
                        Simpan

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endforeach

@endsection

@section('scripts')

<script>

    document.querySelectorAll('.toggle-password').forEach(button => {

        button.addEventListener('click', function () {

            const targetId = this.getAttribute('data-target');
            const input = document.getElementById(targetId);
            const icon = this.querySelector('i');

            if (input.type === 'password') {

                input.type = 'text';

                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');

            } else {

                input.type = 'password';

                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');

            }

        });

    });

</script>

@endsection
