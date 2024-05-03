<!-- show.blade.php -->

@extends('dashboardAdmin')
@section('content')
<div class="content-header">
    <!-- Header content -->
</div>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <!-- Display customer information -->
                        <h3>Customer Information</h3>
                        <table class="table table-hover">
                            <tbody>
                                <tr>
                                    <th>Nama</th>
                                    <td>{{ $customers->nama }}</td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td>{{ $customers->email }}</td>
                                </tr>
                                <!-- Add more fields as needed -->
                            </tbody>
                        </table>

                        <!-- Display customer history -->
                        <h3>Customer History</h3>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Nama Produk</th>
                                        <th>Tanggal</th>
                                        <th>Harga</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($history as $item)
                                    <tr>
                                        <td>{{ $item->nama_produk }}</td>
                                        <td>{{ $item->tanggal }}</td>
                                        <td>{{ $item->harga }}</td>
                                        <td>{{ $item->status }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4">No history found</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Add div for navigation back to index -->
        <div class="row mt-3">
            <div class="col-12">
                <div class="text-center">
                    <!-- Make sure the keyword parameter is included in the route -->
                    <a href="{{ route('searchCus', ['keyword' => $keyword ?? '']) }}" class="btn btn-primary">Kembali</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
