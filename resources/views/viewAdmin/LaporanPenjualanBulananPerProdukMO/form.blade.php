<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Penjualan Bulanan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            backgroung-color: #fff;
            color: #000;
            margin: 0;
            padding: 20px;
        }
        .report-container {
            border: 1px solid #000;
            padding: 20px;
            background-color: #fff;
        }
        .report-header {
            text-align: center;
            margin-bottom: 20px;
        }
        .report-header h1, .report-header h2 {
            margin: 0;
        }
        .report-details {
            margin-bottom: 20px;
        }
        .report-details p {
            margin: 5px 0;
        }
        .report-table {
            width: 100%;
            border-collapse: collapse;
        }
        .report-table, .report-table th, .report-table td {
            border: 1px solid #000;
        }
        .report-table th, .report-table td {
            padding: 10px;
            text-align: center;
        }
        .report-footer {
            text-align: right;
            margin-top: 20px;
        }
    </style>
</head>
<body>

<div class="report-container">
    <div class="report-header">
        <h1>Atma Kitchen</h1>
        <h2>JL. CentralPark No. 10 Yogykarta</h2>
    </div>
    <div class="report-details">
        <p><strong>LAPORAN PENJUALAN BULANAN MO</strong></p>
        <p>Bulan: {{ \Carbon\Carbon::create()->month($month)->format('F') }}</p>
        <p>Tahun: {{ $year }}</p>
        <p>Tanggal Cetak: {{ \Carbon\Carbon::now()->format('j F Y') }}</p>
    </div>
    <table class="report-table">
        <thead>
            <tr>
                <th>Produk</th>
                <th>Kuantitas</th>
                <th>Harga</th>
                <th>Jumlah Uang</th>
            </tr>
        </thead>
        <tbody>
            @foreach($salesReport as $productName => $report)
            <tr>
                <td>{{ $productName }}</td>
                <td>{{ $report['jumlah_terjual'] }}</td>
                <td>{{ number_format($report['total_pendapatan'] / $report['jumlah_terjual'], 2) }}</td>
                <td>{{ number_format($report['total_pendapatan'], 2) }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3">Total</td>
                <td>{{ number_format(array_sum(array_column($salesReport, 'total_pendapatan')), 2) }}</td>
            </tr>
        </tfoot>
    </table>
    <div class="report-footer">
        <a href="{{ route('laporan.generate-pdfMO', ['bulan' => $month, 'tahun' => $year]) }}" class="btn btn-primary" target="_blank">Cetak PDF</a>
    </div>
</div>
    
</body>
</html>