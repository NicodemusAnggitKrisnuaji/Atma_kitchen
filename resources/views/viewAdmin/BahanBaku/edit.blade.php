@extends('dashboardAdmin')
@section('content')
<div class="content-header">
    <div class="container-fluid"> 
        <div class="row mb-2"> 
            <div class="col-sm-6">
                <h1 class="m-0">Edit Bahan Baku</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="#">Bahan Baku</a>
                    </li>
                    <li class="breadcrumb-item active">Edit</li>
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
                        <form action="{{ route('bahanBaku.update', $bahanBaku->id_bahanBaku) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="form-row"></div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label class="font-weightbold">Nama Produk</label>
                                    <input type="text" class="form-control @error('nama') is-invalid @enderror" name="nama" value="{{ old('nama', $bahanBaku->nama) }}">
                                    @error('nama')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label class="font-weightbold">Satuan</label>
                                    <input type="text" class="form-control @error('satuan') is-invalid @enderror" name="satuan" value="{{ old('satuan', $bahanBaku->satuan) }}">
                                    @error('satuan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div>
                                <div class="form-group col-md-12">
                                    <label class="font-weightbold">Stock</label>
                                    <input type="number" class="form-control @error('stock') is-invalid @enderror" name="stock" value="{{ old('stock', $bahanBaku->stock) }}">
                                    @error('stock')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div>
                            <button type="submit" class="btn btn-md btn-primary">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection