@extends('dashboardAdmin')
@section('content')
<div class="content-header">
    <div class="container-fluid"> 
        <div class="row mb-2"> 
            <div class="col-sm-6">
                <h1 class="m-0">Tambah Hampers</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="#">Hampers</a>
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
                        <form action="{{ route('hampers.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-row"></div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label class="font-weightbold">Image</label>
                                    <input type="file" class="form-control @error('image') is-invalid @enderror" name="image" value="{{ old('image') }}">
                                    @error('image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label class="font-weightbold">Nama Paket Hampers</label>
                                    <input type="text" class="form-control @error('nama_hampers') is-invalid @enderror" name="nama_hampers" value="{{ old('nama_hampers') }}" placeholder="Masukkan Nama Paket Hampers">
                                    @error('nama_hampers')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label class="font-weightbold">Harga</label>
                                    <input type="text" class="form-control @error('harga') is-invalid @enderror" name="harga" value="{{ old('harga') }}" placeholder="Masukkan Harga">
                                    @error('harga')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label class="font-weightbold">Isi Hampers</label>
                                    <input type="text" class="form-control @error('isi') is-invalid @enderror" name="isi" value="{{ old('isi') }}" placeholder="Masukkan Isi Hampers">
                                    @error('isi')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label class="font-weightbold">Stock</label>
                                    <input type="text" class="form-control @error('isi') is-invalid @enderror" name="stock" value="{{ old('stock') }}" placeholder="Masukkan Isi Hampers">
                                    @error('stock')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div>
                                <div class="form-group col-md-12">
                                    <label class="font-weightbold">Deskripsi Hampers</label>
                                    <textarea rows="5" class="form-control @error('deskripsi') is-invalid @enderror" name="deskripsi" placeholder="Masukkan Deskripsi Hampers" style="resize: none;">{{ old('deskripsi') }}</textarea>
                                    @error('deskripsi')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <button type="submit" class="btn btn-md btn-primary">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection