@extends('dashboardAdmin')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Tambah Produk</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="#">Produk</a>
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
                            <form action="{{ route('produk.store') }}" method="POST" enctype="multipart/form-data">
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
                                        <label class="font-weight-bold">Penitip</label>
                                        <select class="form-control @error('id_penitip') is-invalid @enderror" name="id_penitip">
                                            <option value="">Pilih Penitip</option>
                                            @foreach($penitip as $p)
                                            <option value="{{ $p->id_penitip }}">{{ $p->nama }}</option>
                                            @endforeach
                                        </select>
                                        @error('id_penitip')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                        <label class="font-weightbold">Nama Produk</label>
                                        <input type="text" class="form-control @error('nama_produk') is-invalid @enderror" name="nama_produk" value="{{ old('nama_produk') }}" placeholder="Masukkan Nama Produk">
                                        @error('nama_produk')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                        <label class="font-weightbold">Harga Produk</label>
                                        <input type="text" class="form-control @error('harga_produk') is-invalid @enderror" name="harga_produk" value="{{ old('harga_produk') }}" placeholder="Masukkan Harga Produk">
                                        @error('harga_produk')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div>
                                    <div class="form-group col-md-12">
                                        <label class="font-weightbold">Stock</label>
                                        <input type="number" class="form-control @error('stock') is-invalid @enderror" name="stock" value="{{ old('stock') }}" placeholder="Masukkan Stock">
                                        @error('stock')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div>
                                    <div class="form-group col-md-12">
                                        <label class="font-weightbold">Kategori</label>
                                        <input type="text" class="form-control @error('kategori') is-invalid @enderror" name="kategori" value="{{ old('kategori') }}" placeholder="Masukkan Kategori">
                                        @error('kategori')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div>
                                    <div class="form-group col-md-12">
                                        <label class="font-weightbold">Deskripsi Produk</label>
                                        <textarea rows="5" class="form-control @error('deskripsi_produk') is-invalid @enderror" name="deskripsi_produk" placeholder="Masukkan Deskripsi Produk" style="resize: none;">{{ old('deskripsi_produk') }}</textarea>
                                        @error('deskripsi_produk')
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