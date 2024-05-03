@extends('dashboardMO')
@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Karyawan</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="#">Karyawan</a>
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
                            <a href="{{ route('karyawan.create') }}" class="btn btn-md btn-success mb-3">Tambah Karyawan</a>
                            <form class="form-inline my-2 my-lg-0 justify-content-end" action="{{ route('karyawan') }}" method="GET" class="mb-4">
                                <input type="text" class="form-control mr-sm-2" type="search" placeholder="Cari Pembelian" name="keyword" value="{{ $keyword ?? '' }}">
                                <button class="btn btn-outline-secondary" type="submit">Cari</button>
                            </form>
                        </div>
                        @if ($karyawan->isEmpty())
                        <div class="alert alert-danger">
                            Karyawan tidak ditemukan.
                        </div>
                        @else
                        <div class="table-responsive p-0">
                            <table class="table table-hover textnowrap">
                                <thead>
                                    <tr>
                                        <th class="text-center">Nama Karyawan</th>
                                        <th class="text-center">Alamat Karyawan</th>
                                        <th class="text-center">Tanggal Lahir</th>
                                        <th class="text-center">Honor Harian</th>
                                        <th class="text-center">Bonus Rajin</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($karyawan as $item)
                                    <tr>
                                        <td>
                                            {{ $item->nama_karyawan }}
                                        </td>
                                        <td class="text-center">
                                            {{ $item->alamat_karyawan }}
                                        </td>
                                        <td class="text-center">
                                            {{ $item->tanggal_lahir }}
                                        </td>
                                        <td class="text-center">
                                            {{ $item->honor_harian }}
                                        </td>
                                        <td class="text-center">
                                            {{ $item->bonus_rajin }}
                                        </td>
                                        <td class="text-center">
                                            <form onSubmit="return confirm('Apakah anda yakin ?');" action="{{ route('karyawan.destroy', $item->id_karyawan) }}" method="POST">
                                                <a href="{{ route('karyawan.edit', $item->id_karyawan) }}" class="btn btn-sm btn-primary">Edit</a>
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                    @empty
                                    <div class="alert alert-danger">
                                        Data Karyawan belum tersedia
                                    </div>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        {{ $karyawan->links() }}
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