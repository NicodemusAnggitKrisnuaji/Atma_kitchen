@extends('dashboardAdmin')
@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Resep</h1>
            </div>

            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="{{ url('resep')}}">Resep</a>
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
                        <a href="{{ route('resep.create') }}" class="btn btn-md btn-success mb-4">Tambah Resep</a>
                        
                        <!-- Form pencarian -->
                        <form action="{{ route('resep') }}" method="GET" class="mb-4">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Cari resep" name="keyword" value="{{ $keyword ?? '' }}">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="submit">Cari</button>
                                </div>
                            </div>
                        </form>
                        
                        @if ($resep->isEmpty())
                            <div class="alert alert-danger">
                                Pencarian tidak ditemukan.
                            </div>
                        @else
                            <div class="table-responsive p-0">
                                <table class="table table-hover text-no-wrap">
                                    <thead>
                                        <tr>
                                            <th class="text-center">Nama Produk</th>
                                            <th class="text-center">Nama Resep</th>
                                            <th class="text-center">Prosedur</th>
                                            <th class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($resep as $item)
                                            <tr>
                                                <td class="text-center">
                                                    {{$item->produk->nama_produk }}
                                                </td>
                                                <td class="text-center">
                                                    {{$item->nama_resep }}
                                                </td>
                                                <td class="text-center">
                                                    {{$item->prosedur }}
                                                </td>

                                                <td class="text-center">
                                                    <form onsubmit="return confirm('Apakah anda yakin ?');" action="{{ route('resep.destroy', $item->id_resep) }}" method="POST">
                                                    <a href="{{ route('resep.edit', $item->id_resep) }}" class="btn btn-sm btn-primary">Edit</a>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                                </form>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center">Data Resep belum tersedia</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            {{ $resep->links() }}
                        @endif
                    </div>      
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
