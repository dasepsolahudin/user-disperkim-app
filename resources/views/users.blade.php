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
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
    <a href="{{ route('admin.users.edit', $user->id) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
    </td>
<td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
        @csrf
        @method('DELETE')
        <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
    </form>
</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>