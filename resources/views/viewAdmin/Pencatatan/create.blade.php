@extends('dashboardMO')
@section('content')

<div class="content-header">
    <div class="container-fluid"> <div class="row mb-2"> <div class="col-sm-6">
        <h1 class="m-0">Tambah Pencatatan</h1>
    </div>

    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item">
                <a href="#">Pencatatan Pengeluaran Lain-lain</a>
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
                        <form action="{{ route('pencatatan.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-row">
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label class="font-weight-bold">Nama</label>
                                    <input type="text" class="form-control @error('nama') is-invalid @enderror" name="nama" value="{{ old('nama') }}" placeholder="Masukkan Nama pencatatan">
                                    @error('nama')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label class="font-weight-bold">Harga</label>
                                    <input type="number" class="form-control @error('harga') is-invalid @enderror" name="harga" value="{{ old('harga') }}" placeholder="Masukkan Harga">
                                    @error('harga')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
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
