@extends('dashboardAdmin')
@section('content')

<div class="content-header">
    <div class="container-fluid"> <div class="row mb-2"> <div class="col-sm-6">
        <h1 class="m-0">Tambah Resep</h1>
    </div>

    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item">
                <a href="#">Resep</a>
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
                        <form action="{{ route('resep.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-row">
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label class="font-weight-bold">Nama Resep</label>
                                    <input type="text" class="form-control @error('nama_resep') is-invalid @enderror" name="nama_resep" value="{{ old('nama_resep') }}" placeholder="Masukkan Nama Resep">
                                    @error('nama_resep')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label class="font-weight-bold">Prosedur</label>
                                    <textarea rows="5" class="form-control @error('prosedur') is-invalid @enderror" name="prosedur" placeholder="Masukkan Prosedur" style="resize: none;">{{ old('prosedur') }}</textarea>
                                    @error('prosedur')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="font-weight-bold">Produk</label>
                                    <select name="id_produk" class="form-control @error('id_produk') is-invalid @enderror">
                                    @foreach($produk as $p)
                                    <option value="{{ $p->id_produk }}">{{ $p->nama_produk }}</option>
                                    @endforeach
                                    </select>
                                    @error('id_produk')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <button type="submit" class="btn btn-md btn-primary">SIMPAN</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
