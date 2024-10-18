@extends('layouts.layout')

@section('content')
    <form action="{{ route('user.store') }}" method="POST" class="card p-5">
        @csrf
        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="mb-3 row">
            <label for="name" class="col-sm-2 col-form-label">Nama Pengguna: </label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" oninput="generatePassword()">
            </div>
        </div>
        <div class="mb-3 row">
            <label for="email" class="col-sm-2 col-form-label">Email: </label>
            <div class="col-sm-10">
                <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" oninput="generatePassword()">
            </div>
        </div>
        <div class="mb-3 row">
            <label for="generated_password" class="col-sm-2 col-form-label">Kata Sandi: </label>
            <div class="col-sm-10">
                <div class="input-group">
                    <input type="password" class="form-control" id="generated_password" name="password" readonly>
                    <button type="button" class="btn btn-outline-secondary" onclick="togglePasswordVisibility()">Lihat</button>
                </div>
            </div>
        </div>
        <div class="mb-3 row">
            <label for="role" class="col-sm-2 col-form-label">Role: </label>
            <div class="col-sm-10">
                <select name="role" id="role" class="form-select">
                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>User</option>
                </select>
                @error('role')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Kirim</button>
    </form>

    <script>
        function generatePassword() {
            const name = document.getElementById('name').value;
            const email = document.getElementById('email').value;

            const namePart = name.slice(0, 3);
            const emailPart = email.split('@')[0].slice(0, 3);

            const password = namePart + emailPart;
            document.getElementById('generated_password').value = password;
        }

        function togglePasswordVisibility() {
            const passwordInput = document.getElementById('generated_password');
            const currentType = passwordInput.type;

            // Ubah tipe input menjadi text untuk menampilkan password
            passwordInput.type = 'text';

            // Kembali ke password setelah 3 detik
            setTimeout(() => {
                passwordInput.type = currentType; // Kembalikan ke tipe semula
            }, 3000);
        }
    </script>
@endsection
