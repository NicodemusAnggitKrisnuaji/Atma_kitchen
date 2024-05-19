@extends('dashboardMO')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Penitip</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="#">Penitip</a>
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
                        <a href="{{ route('penitip.create') }}" class="btn btn-md btn-success mb-3">Tambah Penitip</a>
                        <form class="form-inline my-2 my-lg-0 justify-content-end" action="{{ route('penitip') }}" method="GET" class="mb-4">
                            <input type="text" class="form-control mr-sm-2" type="search" placeholder="Cari Pembelian" name="keyword" value="{{ $keyword ?? '' }}">
                            <button class="btn btn-outline-secondary" type="submit">Cari</button>
                        </form>
                        <div class="table-responsive p-0">
                            <table class="table table-hover textnowrap">
                                <thead>
                                    <tr>
                                        <th class="text-center">Nama Penitip</th>
                                        <th class="text-center">Alamat Penitip</th>
                                        <th class="text-center">Nomor Telepon</th>
                                        <th class="text-center">Komisi</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($penitip as $item)
                                    <tr>
                                        <td class="text-center">{{ $item->nama }}</td>
                                        <td class="text-center">{{ $item->alamat }}</td>
                                        <td class="text-center">{{ $item->nomor_telepon }}</td>
                                        <td class="text-center">{{ $item->komisi }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('penitip.edit', $item->id_penitip) }}" class="btn btn-sm btn-primary">Edit</a>
                                            <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal" data-id="{{ $item->id_penitip }}">Hapus</button>
                                        </td>
                                    </tr>
                                    @empty
                                    <div class="alert alert-danger">Data Penitip belum tersedia</div>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        {{ $penitip->links() }}
                    </div>
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
                <form id="deleteForm" action="" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var confirmDeleteModal = document.getElementById('confirmDeleteModal');
        confirmDeleteModal.addEventListener('show.bs.modal', function(event) {
            var button = event.relatedTarget;
            var id = button.getAttribute('data-id');
            var form = document.getElementById('deleteForm');
            var url = "{{ route('penitip.destroy', ':id') }}";
            url = url.replace(':id', id);
            form.action = url;
        });
    });
</script>
@endsection