@extends('dashboardAdmin')
@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Penarikan Saldo</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="#">Penarikan Saldo</a>
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
                        @if ($history->isEmpty())
                        <div class="alert alert-danger">
                            Kosong
                        </div>
                        @else
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th class="text-center">Nama Pengguna</th>
                                        <th class="text-center">Tanggal</th>
                                        <th class="text-center">Jumlah</th>
                                        <th class="text-center">Bank</th>
                                        <th class="text-center">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($history as $item)
                                    <tr>
                                        <td class="text-center">{{ $item->user->nama }}</td>
                                        <td class="text-center">
                                            @if($item->tanggal_ditarik == null)
                                            Masih menunggu Konfirmasi
                                            @else
                                            {{ $item->tanggal_ditarik }}
                                            @endif
                                        </td>
                                        <td class="text-center">{{ number_format($item->saldo_ditarik, 0, ',', '.') }}</td>
                                        <td class="text-center">{{ $item->bank }}</td>
                                        <td class="text-center">
                                            <form action="{{ route('ConfirmTransfer', $item->id_history) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <select name="status" class="form-control" onchange="this.form.submit()">
                                                    <option class="text-center" value="menunggu" {{ $item->status == 'menunggu' ? 'selected' : '' }} disabled>Menunggu</option>
                                                    <option class="text-center" value="diterima" {{ $item->status == 'diterima' ? 'selected' : '' }}>Diterima</option>
                                                </select>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        {{ $history->links() }}
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