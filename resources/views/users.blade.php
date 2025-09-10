<!DOCTYPE html>
<html>
<head>
    <title>Daftar Pengguna</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <h2>Daftar Pengguna</h2>

    {{-- Untuk menampilkan pesan sukses setelah update/delete --}}
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Aksi</th> {{-- Kolom baru --}}
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>
                    {{-- Tombol Edit --}}
                    <a href="/users/{{ $user->id }}/edit" class="btn btn-warning btn-sm">Edit</a>
                    <a href="/users/{{ $user->id }}/edit" class="btn btn-warning btn-sm">Edit</a>
    
    {{-- Form untuk Tombol Hapus --}}
    <form action="/users/{{ $user->id }}" method="POST" class="d-inline">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Anda yakin ingin menghapus data ini?')">Hapus</button>
    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>