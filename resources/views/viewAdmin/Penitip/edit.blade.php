@extends('dashboardMO')
@section('content')

<div class="content-header">
    <div class="container-fluid"> <div class="row mb-2"> <div class="col-sm-6">
        <h1 class="m-0">Edit Penitip</h1>
    </div>

    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item">
                <a href="#">Penitip</a>
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
                        <form action="{{ route('penitip.update', $penitip->id_penitip) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="form-row">
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label class="font-weight-bold">Nama Penitip</label>
                                    <input type="text" class="form-control @error('nama') is-invalid @enderror" name="nama" value="{{ old('nama', $penitip->nama) }}">
                                    @error('nama')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label class="font-weight-bold">Alamat </label>
                                    <input type="text" class="form-control @error('alamat') is-invalid @enderror" name="alamat" value="{{ old('alamat', $penitip->alamat) }}">
                                    @error('alamat')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label class="font-weight-bold">Nomor Telepon</label>
                                    <input type="number" class="form-control @error('nomor_telepon') is-invalid @enderror" name="nomor_telepon" value="{{ old('nomor_telepon', $penitip->nomor_telepon) }}">
                                    @error('nomor_telepon')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label class="font-weight-bold">Komisi</label>
                                    <input type="number" class="form-control @error('komisi') is-invalid @enderror" name="komisi" value="{{ old('komisi', $penitip->komisi) }}">
                                    @error('komisi')
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
