@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Manajemen Lingkungan</h1>
    <a href="{{ route('lingkungans.create') }}" class="btn btn-primary">Tambah Lingkungan</a>
    <table class="table">
        <thead>
            <tr>
                <th>Nama Lingkungan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($lingkungans as $lingkungan)
            <tr>
                <td>{{ $lingkungan->nama }}</td>
                <td>
                    <a href="{{ route('lingkungans.edit', $lingkungan->id) }}" class="btn btn-warning">Edit</a>
                    <form action="{{ route('lingkungans.destroy', $lingkungan->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
