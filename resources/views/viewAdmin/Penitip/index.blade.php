@extends('dashboardMO')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Penitip</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="#">Penitip</a>
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
                        <a href="{{ route('penitip.create') }}" class="btn btn-md btn-success mb-3">Tambah Penitip</a>
                        <form class="form-inline my-2 my-lg-0 justify-content-end" action="{{ route('penitip') }}" method="GET" class="mb-4">
                                <input type="text" class="form-control mr-sm-2" type="search" placeholder="Cari Pembelian" name="keyword" value="{{ $keyword ?? '' }}">
                                <button class="btn btn-outline-secondary" type="submit">Cari</button>
                            </form>
                        <div class="table-responsive p-0">
                            <table class="table table-hover textnowrap">
                                <thead>
                                    <tr>
                                        <th class="text-center">Nama Penitip</th>
                                        <th class="text-center">Alamat Penitip</th>
                                        <th class="text-center">Nomor Telepon</th>
                                        <th class="text-center">Komisi</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($penitip as $item)
                                    <tr>
                                        <td class="text-center">{{ $item->nama }}</td>
                                        <td class="text-center">{{ $item->alamat }}</td>
                                        <td class="text-center">{{ $item->nomor_telepon }}</td>
                                        <td class="text-center">{{ $item->komisi }}</td>
                                        <td class="text-center">
                                            <form onsubmit="return confirm('Apakah Anda Yakin ?');" action="{{ route('penitip.destroy', $item->id_penitip) }}" method="POST">
                                                <a href="{{ route('penitip.edit', $item->id_penitip) }}" class="btn btn-sm btn-primary">Edit</a>
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                    @empty
                                    <div class="alert alert-danger">Data Penitip belum tersedia</div>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        {{ $penitip->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection