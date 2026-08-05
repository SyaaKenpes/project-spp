@extends('layouts.app')
@section('title', 'Edit Petugas')

@section('content')
    <div class="max-w-4xl mx-auto mt-8 p-6 bg-white rounded-xl shadow-md">
        <form action="{{ route('petugas.update', $petugas->id_petugas) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid gap-6">
                <div>
                    <label class="block text-sm font-medium">Username (Gak bisa diganti)</label>
                    <input type="text" value="{{ $petugas->username }}" disabled
                        class="mt-1 block w-full bg-gray-100 border-gray-300 rounded-md">
                </div>
                <div>
                    <label class="block text-sm font-medium">Nama Lengkap</label>
                    <input type="text" name="nama_petugas" value="{{ $petugas->nama_petugas }}" required
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-red-500">Password Baru (Kosongkan jika tidak ganti)</label>
                    <input type="password" name="password" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium">Jabatan</label>
                    <select name="level" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        <option value="admin" {{ $petugas->level == 'admin' ? 'selected' : '' }}>ADMIN</option>
                        <option value="petugas" {{ $petugas->level == 'petugas' ? 'selected' : '' }}>PETUGAS</option>
                    </select>
                </div>
            </div>
            <div class="mt-8 flex justify-end space-x-3">
                <a href="{{ route('petugas.index') }}" class="bg-gray-200 px-6 py-2 rounded-lg">Batal</a>
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">Update
                    Data</button>
            </div>
        </form>
    </div>
@endsection
