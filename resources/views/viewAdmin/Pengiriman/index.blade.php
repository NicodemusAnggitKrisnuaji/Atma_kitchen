@extends('dashboardAdmin')
@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Input Jarak Pengiriman</h1>
            </div>

            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="{{ url('pengiriman')}}">Input Jarak Pengiriman</a>
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
                        <!-- Tambahkan kode untuk menampilkan pesan error di sini -->
                        @if(session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif

                        <a href="{{ route('pengiriman.create') }}" class="btn btn-md btn-success mb-4">Tambah Jarak Pengiriman</a>
                        <div class="table-responsive p-0">
                            <table class="table table-hover text-no-wrap">
                                <thead>
                                    <tr>
                                        <th class="text-center">Data Pemesanan</th>
                                        <th class="text-center">Jarak</th>
                                        <th class="text-center">Total</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($pengiriman as $item)
                                    <tr>
                                        <td class="text-center">
                                            {{ strval($item->pemesanan->id_pemesanan) }}
                                        </td>
                                        <td class="text-center">
                                            {{$item->jarak }}
                                        </td>
                                        <td class="text-center">
                                            {{$item->total }}
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('pengiriman.edit', $item->id_pengiriman) }}" class="btn btn-sm btn-primary">Edit</a>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="text-center">Data Pengiriman belum tersedia</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        {{ $pengiriman->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
