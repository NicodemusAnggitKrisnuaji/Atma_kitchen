<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Stok Bahan Baku</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #fff;
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
        <h2>JL. CentralPark No. 10 Yogyakarta</h2>
    </div>
    <div class="report-details">
        <p><strong>LAPORAN STOK BAHAN BAKU OWNER</strong></p>
        <p>Tanggal Cetak: {{ \Carbon\Carbon::now()->format('j F Y') }}</p>
    </div>
    <table class="report-table">
        <thead>
            <tr>
                <th>Nama Bahan</th>
                <th>Satuan</th>
                <th>Stok</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($bahanBakus as $bahanBaku)
            <tr>
                <td>{{ $bahanBaku->nama }}</td>
                <td>{{ $bahanBaku->satuan }}</td>
                <td>{{ $bahanBaku->stock }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
    
</body>
</html>
