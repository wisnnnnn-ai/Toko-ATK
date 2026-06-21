@extends('layout.app')

 @section('content')
 <style>
     .login-page {
         background: url('{{ asset('img/bg login.png') }}') center/cover no-repeat !important;
     }
     .login-page::before,
     .login-page::after {
         display: none !important;
     }
    .login-logo{
    background: transparent !important;
    box-shadow: none !important;
    padding:0 !important;
    border-radius:0 !important;
    }
    .login-card{
    width:100%;
    max-width:400px;
    padding:55px 40px;
    border-radius:22px;
    min-height: 500px;
    }
    .login-logo img{
    width:110px;
    height:110px;
    object-fit:contain;
    margin-bottom:12px;
    }
    .toggle-password{
    position:absolute;
    right:15px;
    top:70%;
    transform:translateY(-50%);
    display:flex;
    align-items:center;
    justify-content:center;
    cursor:pointer;
    color:#6c757d;
    z-index:5;
    }


 </style>
 <div class="login-page" style="min-height: 100vh; display: flex; align-items: center; justify-content: center; position: relative; overflow: hidden;">
     <div class="bg-accent"></div>
     <div class="login-card">
         <div class="text-center mb-4">
             <div class="login-logo">
                 <img src="{{ asset('img/logo 2.png') }}" alt="Logo" style="width: 120px; height: 120px; object-fit: contain;">
             </div>
         </div>

         <form method="POST" action="{{ route('login') }}">
             @csrf
             <div class="mb-3">
                 <label class="form-label">Username</label>
                 <input type="text" name="email" class="form-control @error('email') is-invalid @enderror"
                        placeholder="Masukkan username" required autofocus>
                 @error('email')
                     <div class="invalid-feedback">{{ $message }}</div>
                 @enderror
             </div>

            <div class="mb-3 position-relative">
                <label class="form-label">Password</label>

                <input
                    type="password"
                    name="password"
                    id="passwordLogin"
                    class="form-control pe-5 @error('password') is-invalid @enderror"
                    placeholder="Masukkan password"
                    required>

                <span class="toggle-password"
                    data-target="passwordLogin">
                    <i class="fas fa-eye"></i>
                </span>

                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

             <button type="submit" class="btn btn-primary w-100 py-2">
                 <i class="fas fa-sign-in-alt me-2"></i> Login
             </button>
         </form>
     </div>
 </div>

 @section('scripts')
 <script>
     document.querySelectorAll('.toggle-password').forEach(button => {
         button.addEventListener('click', function() {
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
