@extends('dashboardAdmin')
@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Resep</h1>
            </div>

            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="{{ url('resep')}}">Resep</a>
                    </li>
                    <li class="breadcrumb-item active">Index</li>
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
                        <a href="{{ route('resep.create') }}" class="btn btn-md btn-success mb-4">Tambah Resep</a>

                        <!-- Form pencarian -->
                        <form action="{{ route('resep') }}" method="GET" class="mb-4">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Cari resep" name="keyword" value="{{ $keyword ?? '' }}">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="submit">Cari</button>
                                </div>
                            </div>
                        </form>

                        @if ($resep->isEmpty())
                        <div class="alert alert-danger">
                            Pencarian tidak ditemukan.
                        </div>
                        @else
                        <div class="table-responsive p-0">
                            <table class="table table-hover text-no-wrap">
                                <thead>
                                    <tr>
                                        <th class="text-center">Nama Produk</th>
                                        <th class="text-center">Nama Resep</th>
                                        <th class="text-center">Prosedur</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($resep as $item)
                                    <tr>
                                        <td class="text-center">
                                            {{$item->produk->nama_produk }}
                                        </td>
                                        <td class="text-center">
                                            {{$item->nama_resep }}
                                        </td>
                                        <td class="text-center">
                                            {{$item->prosedur }}
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('detail_resep', $item->id_resep) }}" class="btn btn-sm btn-dark">Detail</a>
                                            <a href="{{ route('resep.edit', $item->id_resep) }}" class="btn btn-sm btn-primary">Edit</a>
                                            <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal" data-id="{{ $item->id_resep }}">Hapus</button>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="text-center">Data Resep belum tersedia</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        {{ $resep->links() }}
                        @endif
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
            var url = "{{ route('resep.destroy', ':id') }}";
            url = url.replace(':id', id);
            form.action = url;
        });
    });
</script>
@endsection