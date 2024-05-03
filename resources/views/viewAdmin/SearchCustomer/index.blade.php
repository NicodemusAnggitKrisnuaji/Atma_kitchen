<!-- index.blade.php -->

@extends('dashboardAdmin')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Search Customer</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="#">Search Customer</a>
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
                        <form class="form-inline my-2 my-lg-0 justify-content-end" action="{{ route('searchCus') }}" method="GET" class="mb-4">
                            <input type="text" class="form-control mr-sm-2" type="search" placeholder="Cari User" name="keyword" value="{{ $keyword ?? '' }}">
                            <button class="btn btn-outline-secondary" type="submit">Cari</button>
                        </form>
                        @if ($customers->isEmpty())
                        <div class="alert alert-danger">
                            Pencarian tidak ditemukan.
                        </div>
                        @else
                        <div class="table-responsive p-0">
                            <table class="table table-hover textnowrap">
                                <thead>
                                    <tr>
                                        <th class="text-center">Nama</th>
                                        <th class="text-center">Email</th>
                                        <th class="text-center">Password</th>
                                        <th class="text-center">Nomor Telepon</th>
                                        <th class="text-center">Alamat</th>
                                        <th class="text-center">Tanggal Lahir</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($customers as $item)
                                    <tr>
                                        <td class="text-center">
                                            <!-- Add link to show page -->
                                            <a href="{{ route('searchCus.show', ['id' => $item->id]) }}">{{ $item->nama }}</a>
                                        </td>
                                        <td class="text-center">{{ $item->email }}</td>
                                        <td class="text-center">*********</td>
                                        <td class="text-center">{{ $item->nomor_telepon }}</td>
                                        <td class="text-center">{{ $item->alamat }}</td>
                                        <td class="text-center">{{ $item->tanggal_lahir }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" class="text-center">Data Customer belum tersedia</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        {{ $customers->links() }}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
