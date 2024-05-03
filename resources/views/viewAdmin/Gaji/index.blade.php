@extends('dashboardOwner')
@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Gaji Karyawan</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="#">Gaji Karyawan</a>
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
                            <div class="table-responsive p-0">
                                <table class="table table-hover text-no-wrap">
                                    <thead>
                                        <tr>
                                            <th class="text-center">Nama Karyawan</th>
                                            <th class="text-center">Honor Harian</th>
                                            <th class="text-center">Bonus Rajin</th>
                                            <th class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($karyawan as $item)
                                            <tr>
                                                <td class="text-center">
                                                    {{$item->nama_karyawan }}
                                                </td>
                                                <td class="text-center">
                                                    {{$item->honor_harian }}
                                                </td>
                                                <td class="text-center">
                                                    {{$item->bonus_rajin }}
                                                </td>

                                                <td class="text-center">
                                                    <a href="{{ route('gaji.edit', $item->id_karyawan) }}" class="btn btn-sm btn-primary">Edit</a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center">Data Karyawan belum tersedia</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            {{ $karyawan->links() }}
                    </div>      
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
