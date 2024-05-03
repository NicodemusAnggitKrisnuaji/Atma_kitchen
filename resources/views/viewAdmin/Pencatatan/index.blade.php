@extends('dashboardMO')
@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Pencatatan Pengeluaran Lain-lain</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="#">Pencatatan Pengeluaran Lain-lain</a>
                    </li>
                    <li class="breadcrumb-item active">Index</li>
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
                        <div>
                            <a href="{{ route('pencatatan.create') }}" class="btn btn-md btn-success mb-3">Tambah Pencatatan</a>
                            <form class="form-inline my-2 my-lg-0 justify-content-end" action="{{ route('pencatatan') }}" method="GET" class="mb-4">
                                <input type="text" class="form-control mr-sm-2" type="search" placeholder="Cari Pembelian" name="keyword" value="{{ $keyword ?? '' }}">
                                <button class="btn btn-outline-secondary" type="submit">Cari</button>
                            </form>
                        </div>                  
                        @if ($pencatatan->isEmpty())
                            <div class="alert alert-danger">
                                Karyawan tidak ditemukan.
                            </div>
                        @else
                        <div class="table-responsive p-0">
                            <table class="table table-hover textnowrap">
                                <thead>
                                    <tr>
                                        <th class="text-center">Nama Karyawan</th>
                                        <th class="text-center">Harga</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($pencatatan as $item)
                                    <tr>
                                        <td class="text-center">
                                            {{ $item->nama }}
                                        </td>
                                        <td class="text-center">
                                            {{ $item->harga }}
                                        </td>
                                        <td class="text-center">
                                            <form onSubmit="return confirm('Apakah anda yakin ?');" action="{{ route('pencatatan.destroy', $item->id_pencatatan) }}" method="POST">
                                                <a href="{{ route('pencatatan.edit', $item->id_pencatatan) }}" class="btn btn-sm btn-primary">Edit</a>
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                    @empty
                                    <div class="alert alert-danger">
                                        Data Pencatatan belum tersedia
                                    </div>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        {{ $pencatatan->links() }}
                    @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if(session('error'))
    <div id="errorAlert" class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif

    @if(session('success'))
        <div id="successAlert" class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
</div>
@endsection