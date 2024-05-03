@extends('dashboardAdmin')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Hampers</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="#">Hampers</a>
                    </li>
                    <li class="breadcrumb-item activate">Index</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <a href="{{ route('hampers.create') }}" class="btn btn-md btn-success mb-3">Tambah Hampers</a>
                        <form class="form-inline my-2 my-lg-0 justify-content-end" action="{{ route('hampers') }}" method="GET" class="mb-4">
                            <input type="text" class="form-control mr-sm-2" type="search" placeholder="Cari Hampers" name="keyword" value="{{ $keyword ?? '' }}">
                            <button class="btn btn-outline-secondary" type="submit">Cari</button>
                        </form>
                        @if ($hampers->isEmpty())
                            <div class="alert alert-danger">
                                Pencarian tidak ditemukan.
                            </div>
                        @else
                        <div class="table-responsive p-0">
                            <table class="table table-hover textnowrap">
                                <thead>
                                    <tr>
                                        <th class="text-center">Paket Hampers</th>
                                        <th class="text-center">Nama Paket Hampers</th>
                                        <th class="text-center">Harga</th>
                                        <th class="text-center">Stock</th>
                                        <th class="text-center">Deskripsi Hampers</th>
                                        <th class="text-center">Isi Hampers</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($hampers as $item)
                                    <tr>
                                        <td class="text-center">
                                            <img src="{{ asset('fotoHampers/'.$item->image) }}" alt="" style="width: 100px;">
                                        </td>
                                        <td class="text-center">{{ $item->nama_hampers }}</td>
                                        <td class="text-center">{{ $item->harga }}</td>
                                        <td class="text-center">{{ $item->stock }}</td>
                                        <td class="text-center">{{ $item->deskripsi }}</td>
                                        <td class="text-center">{{ $item->isi }}</td>
                                        <td class="text-center">
                                            <form onsubmit="return confirm('Apakah Anda Yakin ?');" action="{{ route('hampers.destroy', $item->id_hampers) }}" method="POST">
                                                <a href="{{ route('hampers.edit', $item->id_hampers) }}" class="btn btn-sm btn-primary">Edit</a>
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                    @empty
                                    <div class="alert alert-danger">Data Hampers belum tersedia</div>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        {{ $hampers->links() }}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection