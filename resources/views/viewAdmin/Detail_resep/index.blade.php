@extends('dashboardAdmin')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Detail Resep</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="#">Detail Resep</a>
                    </li>
                    <li class="breadcrumb-item activate">Index</li>
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
                        <a href="{{ route('detail_resep.create', $id_resep) }}" class="btn btn-md btn-success mb-3">Tambah Bahan Baku Resep</a>
                        <div class="table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                    <tr>
                                        <th class="text-center">Bahan Baku</th>
                                        <th class="text-center">Jumlah</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($details as $item)
                                        <tr>
                                            <td class="text-center">{{ $item->bahanBaku->nama }}</td>
                                            <td class="text-center">{{ $item->jumlah }}</td>
                                            <td class="text-center">
                                                    <a href="{{ route('detail_resep.edit', $item->id_detail) }}" class="btn btn-sm btn-primary">Edit</a>
                                                    <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal" data-id="{{ $item->id_detail }}">Hapus</button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center">
                                                <div class="alert alert-danger">Detail Resep belum ada</div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        {{ $details->links() }}
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-12">
                <div class="text-center">
                    <!-- Pastikan parameter kunci dimasukkan dalam rute -->
                    <a href="{{ route('resep') }}" class="btn btn-primary">Kembali</a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="confirmDeleteModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #8B5D5D">
                <h1 class="modal-title fs-5" id="confirmDeleteModalLabel" style="color: white;">Apakah Anda Yakin?</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal" style="border: 1px solid;">Batal</button>
                <form id="deleteForm" action=""  method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var confirmDeleteModal = document.getElementById('confirmDeleteModal');
        confirmDeleteModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var id = button.getAttribute('data-id');
            var form = document.getElementById('deleteForm');
            var url="{{ route('detail_resep.destroy', ':id') }}";
            url = url.replace(':id', id);
            form.action = url;
        });
    });
</script>
@endsection
