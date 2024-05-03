@extends('dashboardOwner')
@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Edit Gaji Karyawan</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="#">Gaji Karyawan</a>
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
                        <form action="{{ route('gaji.update', $karyawan->id_karyawan) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="id" value="{{ $karyawan->id_karyawan }}">
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label class="font-weight-bold">Honor Harian</label>
                                    <input type="number" class="form-control @error('honor_harian') is-invalid @enderror" name="honor_harian" value="{{ old('honor_harian', $karyawan->honor_harian) }}">
                                    @error('honor_harian')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label class="font-weight-bold">Bonus Rajin</label>
                                    <input type="number" class="form-control @error('bonus_rajin') is-invalid @enderror" name="bonus_rajin" value="{{ old('bonus_rajin', $karyawan->bonus_rajin) }}">
                                    @error('bonus_rajin')
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
