@extends('dashboardAdmin')
@section('content')
<div class="content-header">
    <div class="container-fluid"> 
        <div class="row mb-2"> 
            <div class="col-sm-6">
                <h1 class="m-0">Edit Detail Resep</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="#">Resep</a>
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
                        <form action="{{ route('detail_resep.update', $id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="form-row"></div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label class="font-weightbold">Nama Bahan Baku</label>
                                    <select class="form-control @error('id_bahanBaku') is-invalid @enderror" name="id_bahanBaku">
                                        <option value="">Pilih Bahan Baku</option>
                                        @foreach($bahanBaku as $p)
                                        <option value="{{ $p->id_bahanBaku }}" {{ old('id_bahanBaku', $detail->id_bahanBaku) == $p->id_bahanBaku ? 'selected' : '' }}>{{ $p->nama }}</option>
                                        @endforeach
                                    </select>
                                    @error('id_bahanBaku')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label class="font-weightbold">Jumlah</label>
                                    <input type="number" class="form-control @error('jumlah') is-invalid @enderror" name="jumlah" value="{{ old('jumlah', $detail->jumlah) }}">
                                    @error('jumlah')
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
