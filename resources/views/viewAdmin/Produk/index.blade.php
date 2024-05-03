@extends('dashboardAdmin')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Produk</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="#">Produk</a>
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
                        <a href="{{ route('produk.create') }}" class="btn btn-md btn-success mb-3">Tambah Produk</a>
                        <form class="form-inline my-2 my-lg-0 justify-content-end" action="{{ route('produk') }}" method="GET" class="mb-4">
                            <input type="text" class="form-control mr-sm-2" type="search" placeholder="Cari Produk" name="keyword" value="{{ $keyword ?? '' }}">
                            <button class="btn btn-outline-secondary" type="submit">Cari</button>
                        </form>
                        @if ($produk->isEmpty())
                            <div class="alert alert-danger">
                                Pencarian tidak ditemukan.
                            </div>
                        @else
                        <div class="table-responsive p-0">
                            <table class="table table-hover textnowrap">
                                <thead>
                                    <tr>
                                        <th class="text-center">Produk</th>
                                        <th class="text-center">Penitip</th>
                                        <th class="text-center">Nama Produk</th>
                                        <th class="text-center">Harga Produk</th>
                                        <th class="text-center">Stock</th>
                                        <th class="text-center">Deskripsi Produk</th>
                                        <th class="text-center">Kateogri</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($produk as $item)
                                    <tr>
                                        <td class="text-center">
                                            <img src="{{ asset('fotoKue/'.$item->image) }}" alt="" style="width: 100px;">
                                        </td>
                                        @if ($item->id_penitip == null)
                                        <td class="text-center">Tidak ada Penitip</td>
                                        @else
                                        <td class="text-center">{{ $item->penitip->nama }}</td>
                                        @endif
                                        <td class="text-center">{{ $item->nama_produk }}</td>
                                        <td class="text-center">{{ $item->harga_produk }}</td>
                                        <td class="text-center">{{ $item->stock }}</td>
                                        <td class="text-center">{{ $item->deskripsi_produk }}</td>
                                        <td class="text-center">{{ $item->kategori }}</td>
                                        <td class="text-center">
                                            <form onsubmit="return confirm('Apakah Anda Yakin ?');" action="{{ route('produk.destroy', $item->id_produk) }}" method="POST">
                                                <a href="{{ route('produk.edit', $item->id_produk) }}" class="btn btn-sm btn-primary">Edit</a>
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                    @empty
                                    <div class="alert alert-danger">Data Produk belum tersedia</div>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        {{ $produk->links() }}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection