<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Presensi Karyawan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .report-container {
            border: 1px solid black;
            padding: 20px;
            margin: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
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
    </style>
</head>

<body>
    <div class="report-container">
        <div style="text-align: left;">
            <h2>Atma Kitchen</h2>
            <p>Jl. Centralpark No. 10 Yogyakarta</p>
            <br>
            <h3>LAPORAN PEMASUKAN DAN PENGELUARAN</h3>
            <p>Bulan: {{ \Carbon\Carbon::create()->month($month)->format('F') }}</p>
            <p>Tahun: {{ $year }}</p>
            <p>Tanggal cetak: {{ \Carbon\Carbon::now()->format('j F Y') }}</p>
        </div>

        <table>
            <thead>
                <tr>
                    <th></th>
                    <th>Pemasukan</th>
                    <th>Pengeluaran</th>
                </tr>
            </thead>
            <tbody>
                @php
                $totalPengeluaran = 0;
                $totalPengeluaran = $total_pengeluaran;

                $totalPemasukan = 0;
                $totalPemasukan += $total_penjualan + $total_tip;
                @endphp

                <tr>
                    <td>Penjualan</td>
                    <td>{{ number_format($total_penjualan, 0, ',', '.') }}</td>
                    <td></td>
                </tr>
                <tr>
                    <td>Tip</td>
                    <td>{{ number_format($total_tip, 0, ',', '.') }}</td>
                    <td></td>
                </tr>
                @foreach($pengeluaran_items as $item)
                <tr>
                    <td>{{ $item->nama }}</td>
                    <td></td>
                    <td>{{ number_format($item->harga, 0, ',', '.') }}</td>
                </tr>
                @endforeach
                <tr>
                    <th colspan="1">Total</th>
                    <th>{{ number_format($totalPemasukan, 0, ',', '.') }}</th>
                    <th>{{ number_format($totalPengeluaran, 0, ',', '.') }}</th>
                </tr>
            </tbody>
        </table>
    </div>
</body>

</html>