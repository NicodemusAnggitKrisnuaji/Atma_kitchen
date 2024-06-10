<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Penitip</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }

        .penitip-box {
            border: 2px solid #000;
            padding: 15px;
            margin-bottom: 30px;
            page-break-inside: avoid;
        }
    </style>
</head>

<body>
    @foreach ($recap as $data)
    <div class="penitip-box">
        <div style="text-align: left;">
            <h2>Atma Kitchen</h2>
            <p>Jl. Centralpark No. 10 Yogyakarta</p>
            <br>
            <h3>LAPORAN TRANSAKSI PENITIP</h3>
        </div>
        <p><strong>ID Penitip:</strong> {{ $data['penitipId'] }}</p>
        <p><strong>Nama Penitip:</strong> {{ $data['penitipNama'] }}</p>
        <p><strong>Bulan:</strong> {{ \Carbon\Carbon::create()->month($month)->format('F') }}</p>
        <p><strong>Tahun:</strong> {{ $year }}</p>
        <p><strong>Tanggal cetak:</strong> {{ \Carbon\Carbon::now()->format('j F Y') }}</p>

        <table>
            <thead>
                <tr>
                    <th>Nama Produk</th>
                    <th>Qty</th>
                    <th>Harga Jual</th>
                    <th>Total</th>
                    <th>20% Komisi</th>
                    <th>Yang Diterima</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data['transactions'] as $transaksi)
                <tr>
                    <td>{{ $transaksi['nama_produk'] }}</td>
                    <td>{{ $transaksi['qty'] }}</td>
                    <td>{{ number_format($transaksi['harga_jual'], 0, ',', '.') }}</td>
                    <td>{{ number_format($transaksi['total'], 0, ',', '.') }}</td>
                    <td>{{ number_format($transaksi['komisi'], 0, ',', '.') }}</td>
                    <td>{{ number_format($transaksi['total_diterima'], 0, ',', '.') }}</td>
                </tr>
                @endforeach
                <tr>
                    <th colspan="5">Total</th>
                    <th>{{ number_format($data['totalSetelahKomisi'], 0, ',', '.') }}</th>
                </tr>
            </tbody>
        </table>
    </div>
    @endforeach
</body>

</html>