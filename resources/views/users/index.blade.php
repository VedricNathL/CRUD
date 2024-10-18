@extends('layouts.layout')

@section('content')
    <div class="container">
        @if (Session::get('success'))
            <div class="alert alert-success">{{ Session::get('success') }}</div>
        @endif
        @if (Session::get('failed'))
            <div class="alert alert-danger">{{ Session::get('failed') }}</div>
        @endif

        <form action="" method="GET" class="d-flex justify-content-end mb-2">
            <input type="text" class="form-control" placeholder="Cari Pengguna..." name="search_user">
            <button type="submit" class="btn btn-primary">Cari</button>
        </form>
        <a href="{{ route('user.create') }}" class="btn btn-primary me-2">Tambah</a>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama Pengguna</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @if ($users->isEmpty())
                    <tr>
                        <td colspan="5" class="text-center">Data Pengguna Kosong</td>
                    </tr>
                @else
                    @foreach ($users as $index => $user)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->role }}</td>
                            <td class="d-flex">
                                <a href="{{ route('user.edit', $user->id) }}" class="btn btn-primary me-2">Edit</a>
                                <button type="button" class="btn btn-danger"
                                    onclick="showModalDelete('{{ $user->id }}', '{{ $user->name }}')">
                                    Hapus
                                </button>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>

        <div class="d-flex justify-content-center my-3">
            {{ $users->links() }} <!-- For pagination -->
        </div>
    </div>
    <div class="modal fade" id="modalDelete" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form class="modal-content" method="POST" id="deleteForm">
                @csrf
                @method('DELETE')
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Konfirmasi Hapus</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Apakah kamu yakin menghapus Akun <b id="name-medicine"></b>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Confirm</button>
                </div>
            </form>
        </div>
    </div>
    
@endsection

@push('script')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    <script>
        function showModalDelete(id, name) {
            $('#name-medicine').text(name);
            $('#modalDelete').modal('show');

            let url = "{{ route('user.delete', ':id') }}";
            url = url.replace(':id', id);
            $("#deleteForm").attr('action', url); // Ensure this is correctly set to the delete route
        }
    </script>
@endpush
