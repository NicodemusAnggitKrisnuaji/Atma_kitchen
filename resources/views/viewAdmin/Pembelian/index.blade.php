@extends('dashboardMO')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Pembelian</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="#">Pembelian</a>
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
                        <a href="{{ route('pembelian.create') }}" class="btn btn-md btn-success mb-3">Tambah Pembelian</a>
                        <form class="form-inline my-2 my-lg-0 justify-content-end" action="{{ route('pembelian') }}" method="GET" class="mb-4">
                            <input type="text" class="form-control mr-sm-2" type="search" placeholder="Cari Pembelian" name="keyword" value="{{ $keyword ?? '' }}">
                            <button class="btn btn-outline-secondary" type="submit">Cari</button>
                        </form>
                        @if ($pembelian->isEmpty())
                            <div class="alert alert-danger">
                                Pencarian Tidak Ditemukan.
                            </div>
                        @else
                        <div class="table-responsive p-0">
                            <table class="table table-hover textnowrap">
                                <thead>
                                    <tr>
                                        <th class="text-center">Nama Bahan Baku</th>
                                        <th class="text-center">Tanggal Pembelian</th>
                                        <th class="text-center">Jumlah</th>
                                        <th class="text-center">Total Harga</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($pembelian as $item)
                                    <tr>
                                        <td class="text-center">{{ $item->bahanBaku->nama }}</td>
                                        <td class="text-center">{{ $item->tanggal_pembelian }}</td>
                                        <td class="text-center">{{ $item->jumlah }}</td>
                                        <td class="text-center">{{ $item->total_harga }}</td>
                                        <td class="text-center">
                                            <form onsubmit="return confirm('Apakah Anda Yakin ?');" action="{{ route('pembelian.destroy', $item->id_pembelian) }}" method="POST">
                                                <a href="{{ route('pembelian.edit', $item->id_pembelian) }}" class="btn btn-sm btn-primary">Edit</a>
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                    @empty
                                    <div class="alert alert-danger">Data Pembelian belum tersedia</div>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        {{ $pembelian->links() }}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection