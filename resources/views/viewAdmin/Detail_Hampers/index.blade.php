@extends('dashboardAdmin')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Detail Hampers</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="#">Detail Hampers</a>
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
                        <!-- Tampilkan tautan "Tambah Produk Hampers" selalu -->
                        <a href="{{ route('detail_hampers.create', $id_hampers) }}" class="btn btn-md btn-success mb-3">Tambah Produk Hampers</a>
                        <div class="table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                    <tr>
                                        <th class="text-center">Nama Produk</th>
                                        <th class="text-center">Jumlah</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($details as $item)
                                        <tr>
                                            <td class="text-center">{{ $item->produk->nama_produk }}</td>
                                            <td class="text-center">{{ $item->jumlah }}</td>
                                            <td class="text-center">
                                                <form onsubmit="return confirm('Apakah Anda Yakin ?');" action="{{ route('detail_hampers.destroy', $item->id_detail) }}" method="POST">
                                                    <a href="{{ route('detail_hampers.edit', $item->id_detail) }}" class="btn btn-sm btn-primary">Edit</a>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center">
                                                <div class="alert alert-danger">Detail Hampers belum ada</div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        {{ $details->links() }}
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-12">
                <div class="text-center">
                    <!-- Pastikan parameter kunci dimasukkan dalam rute -->
                    <a href="{{ route('hampers') }}" class="btn btn-primary">Kembali</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
