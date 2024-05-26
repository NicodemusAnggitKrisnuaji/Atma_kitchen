<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nota Transaksi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .nota-container {
            width: 60%;
            margin: auto;
            padding: 20px;
            border: 1px solid #000;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .nota-header,
        .nota-footer {
            text-align: center;
            margin-bottom: 20px;
        }

        .nota-details {
            margin-bottom: 20px;
        }

        .nota-details p {
            margin: 5px 0;
        }

        .nota-table {
            width: 100%;
            border-collapse: collapse;
        }

        .nota-table th,
        .nota-table td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }

        .nota-summary {
            margin-top: 20px;
        }

        .nota-summary p {
            margin: 5px 0;
        }
    </style>
</head>
<body>
    <div class="nota-container">
        <div class="nota-header">
            <h2>Atma Kitchen</h2>
            <p>Jl. CentralPark No. 10 Yogyakarta</p>
        </div>

        <div class="nota-details">
            <p>No Nota: {{ $pemesanan->id_pemesanan }}</p>
            <p>Tanggal Pesan: {{ $pemesanan->tanggal_pesan }}</p>
            <p>Lunas Pada: {{ $pemesanan->tanggal_lunas }}</p>
            <p>Tanggal Ambil: {{ $pemesanan->tanggal_ambil }}</p>
        </div>

        <div class="nota-details">
            <p>Customer: {{ $pemesanan->user->email }}</p>
            <p>{{ $pemesanan->user->alamat }}</p>
            <p>Delivery: {{ $pemesanan->jenis_pengiriman }}</p>
        </div>

        <table class="nota-table">
            <thead>
                <tr>
                    <th>Item</th>
                    <th>Harga</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pemesanan->details as $detail)
                    <tr>
                        <td>{{ $detail->quantity }} {{ $detail->produk->nama_produk }}</td>
                        <td>{{ number_format($detail->produk->harga_produk, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
                <tr>
                    <td>Ongkos Kirim (rad. 5 Km)</td>
                    <td>{{ number_format($pemesanan->ongkos_kirim, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td>Potongan {{ $pemesanan->poin }} Poin</td>
                    <td>-{{ number_format($pemesanan->potongan_poin, 0, ',', '.') }}</td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <th>Total</th>
                    <th>{{ number_format($pemesanan->total_harga, 0, ',', '.') }}</th>
                </tr>
            </tfoot>
        </table>
        <div class="nota-summary">
            <p>Poin Dari Pesanan Ini: {{ $pemesanan->poin_dari_pesan }}</p>
            <p>Total Poin Customer: {{ $pemesanan->user->total_poin }}</p>
        </div>
        <div class="nota-footer">
            <p>Terima Kasih Telah Berbelanja di Atma Kitchen :3</p>
        </div>
    </div>
</body>
</html>