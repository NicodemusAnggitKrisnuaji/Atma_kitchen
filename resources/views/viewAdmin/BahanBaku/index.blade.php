@extends('dashboardAdmin')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Bahan Baku</h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="#">Bahan Baku</a>
                    </li>
                    <li class="breadcrumb-item activate">Index</li>
                </ol>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <a href="{{ route('bahanBaku.create') }}" class="btn btn-md btn-success mb-3">Tambah Bahan Baku</a>
                        <form class="form-inline my-2 my-lg-0 justify-content-end" action="#" method="GET" class="mb-4">
                            <input type="text" class="form-control mr-sm-2" type="search" placeholder="Cari Produk" name="keyword" value="{{ $keyword ?? '' }}">
                            <button class="btn btn-outline-secondary" type="submit">Cari</button>
                        </form>
                        @if ($bahanBaku->isEmpty())
                            <div class="alert alert-danger">
                                Pencarian tidak ditemukan.
                            </div>
                        @else
                        <div class="table-responsive p-0">
                            <table class="table table-hover textnowrap">
                                <thead>
                                    <tr>
                                        <th class="text-center">Nama Produk</th>
                                        <th class="text-center">Harga Produk</th>
                                        <th class="text-center">Stock</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($bahanBaku as $item)
                                    <tr>
                                        <td class="text-center">{{ $item->nama }}</td>
                                        <td class="text-center">{{ $item->satuan }}</td>
                                        <td class="text-center">{{ $item->stock }}</td>
                                        <td class="text-center">
                                            <form onsubmit="return confirm('Apakah Anda Yakin ?');" action="{{ route('bahanBaku.destroy', $item->id_bahanBaku) }}" method="POST">
                                                <a href="{{ route('bahanBaku.edit', $item->id_bahanBaku) }}" class="btn btn-sm btn-primary">Edit</a>
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
                        {{ $bahanBaku->links() }}
                        @endif
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
@endsection