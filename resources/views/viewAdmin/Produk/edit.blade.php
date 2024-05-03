@extends('dashboardAdmin')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Edit Produk</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="#">Produk</a>
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
                        <form action="{{ route('produk.update', $produk->id_produk) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="form-row"></div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label class="font-weightbold">Image</label>
                                    <input type="file" class="form-control @error('image') is-invalid @enderror" name="image" value="{{ old('image', $produk->image) }}">
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
                                        <option value="{{ $p->id_penitip }}" {{ old('id_penitip', isset($produk) ? $produk->penitip_id : '') == $p->id ? 'selected' : '' }}>{{ $p->nama }}</option>
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
                                    <input type="text" class="form-control @error('nama_produk') is-invalid @enderror" name="nama_produk" value="{{ old('nama_produk', $produk->nama_produk) }}">
                                    @error('nama_produk')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label class="font-weightbold">Harga Produk</label>
                                    <input type="text" class="form-control @error('harga_produk') is-invalid @enderror" name="harga_produk" value="{{ old('harga_produk', $produk->harga_produk) }}">
                                    @error('harga_produk')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div>
                                <div class="form-group col-md-12">
                                    <label class="font-weightbold">Stock</label>
                                    <input type="number" class="form-control @error('stock') is-invalid @enderror" name="stock" value="{{ old('stock', $produk->stock) }}">
                                    @error('stock')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div>
                                <div class="form-group col-md-12">
                                    <label class="font-weightbold">Kategori</label>
                                    <input type="text" class="form-control @error('kategori') is-invalid @enderror" name="kategori" value="{{ old('kategori', $produk->kategori) }}">
                                    @error('kategori')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div>
                                <div class="form-group col-md-12">
                                    <label class="font-weightbold">Deskripsi Produk</label>
                                    <textarea rows="5" class="form-control @error('deskripsi_produk') is-invalid @enderror" name="deskripsi_produk" placeholder="Masukkan Deskripsi Produk" style="resize: none;">{{ old('deskripsi_produk', $produk->deskripsi_produk) }}</textarea>
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