@extends('dashboardAdmin')
@section('content')

<div class="content-header">
    <div class="container-fluid"> <div class="row mb-2"> <div class="col-sm-6">
        <h1 class="m-0">Konfirmasi Pembayaran</h1>
    </div>

    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item">
                <a href="#">Konfirmasi Pembayaran</a>
            </li>
        <li class="breadcrumb-item active">Create</li>
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
                        <form action="{{ route('tip.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-row">
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label class="font-weight-bold">Total Pembayaran</label>
                                    <input type="number" class="form-control @error('total') is-invalid @enderror" name="total" value="{{ old('total') }}" placeholder="Masukkan Total Pembayaran">
                                    @error('total')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label class="font-weight-bold">Jumlah Yang Dibayar</label>
                                    <input type="number" class="form-control @error('jumlah') is-invalid @enderror" name="jumlah" value="{{ old('jumlah') }}" placeholder="Masukkan Jumlah Yang Dibayar">
                                    @error('jumlah')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="font-weight-bold">Data Pemesanan</label>
                                    <select name="id_pemesanan" class="form-control @error('id_pemesanan') is-invalid @enderror">
                                    @foreach($pemesanan as $p)
                                    <option value="{{ $p->id_pemesanan }}">{{ $p->id_pemesanan }}</option>
                                    @endforeach
                                    </select>
                                    @error('id_pemesanan')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <button type="submit" class="btn btn-md btn-primary">Hitung Tip</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection