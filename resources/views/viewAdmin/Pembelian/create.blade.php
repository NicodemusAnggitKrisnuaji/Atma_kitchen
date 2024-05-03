@extends('dashboardMO')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Tambah Pembelian</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="#">Pembelian</a>
                    </li>
                    <li class="breadcrumb-item active">Create</li>
                </ol>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('pembelian.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="form-row"></div>
                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                        <label class="font-weightbold">Nama Bahan Baku</label>
                                        <select class="form-control @error('id_bahanBaku') is-invalid @enderror" name="id_bahanBaku">
                                            <option value="">Pilih Bahan Baku</option>
                                            @foreach($bahanBaku as $p)
                                            <option value="{{ $p->id_bahanBaku }}">{{ $p->nama }}</option>
                                            @endforeach
                                        </select>
                                        @error('id_bahanBaku')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                        <label class="font-weightbold">Tanggal Pembelian</label>
                                        <input type="date" class="form-control @error('tanggal_pembelian') is-invalid @enderror" name="tanggal_pembelian" value="{{ old('tanggal_pembelian') }}" placeholder="Masukkan Tanggal Pembelian">
                                        @error('tanggal_pembelian')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div>
                                    <div class="form-group col-md-12">
                                        <label class="font-weightbold">Jumlah</label>
                                        <input type="number" class="form-control @error('jumlah') is-invalid @enderror" name="jumlah" value="{{ old('jumlah') }}" placeholder="Masukkan Jumlah">
                                        @error('jumlah')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div>
                                    <div class="form-group col-md-12">
                                        <label class="font-weightbold">Total Harga</label>
                                        <input type="text" class="form-control @error('total_harga') is-invalid @enderror" name="total_harga" value="{{ old('total_harga') }}" placeholder="Masukkan Total Harga">
                                        @error('total_harga')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-md btn-primary">Simpan</button>
                            </form>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col-md-6 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    @endsection