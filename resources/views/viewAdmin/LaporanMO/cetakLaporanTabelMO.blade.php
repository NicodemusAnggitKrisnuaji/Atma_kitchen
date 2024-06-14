<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        table.static {
            position: relative;
            border: 1px solid #543535;
            margin-bottom: 20px;
            height: 300px;
            width: 80%;
            max-width: 800px;
            margin-left: auto;
            margin-right: auto;
            table-layout: fixed;
        }

        table.static th, table.static td {
            padding: 8px 10px;
            text-align: center;
        }

        .chart-container {
            margin-top: 20px;
            height: 300px;
            width: 80%;
            max-width: 800px;
            margin-left: auto;
            margin-right: auto;
        }
    </style>
    <title>Cetak Laporan Penjualan Pertahun</title>
</head>

<body>
    <div class="form-group">
        <p><b>Atma Kitchen</b></p>
        <p>Jl. Centralpark No. 10 Yogyakarta</p>
        <p><b>Laporan Penjualan Bulanan Tahun {{ $tahun }}</b></p>
        <p>Tanggal Cetak: {{ \Carbon\Carbon::now()->format('j F Y') }}</p>
        <table class="static" align="center" rules="all" border="1px" style="width: 95%;">
            <tr>
                <th>No.</th>
                <th>Bulan</th>
                <th>Jumlah Transaksi</th>
                <th>Jumlah Uang</th>
            </tr>
            @php
                $totalUangPerBulan = 0;
                $chartData = [];
            @endphp
            @foreach ($cetakTahun as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ \Carbon\Carbon::create()->month($item->bulan)->translatedFormat('F') }}</td>
                <td>{{ $item->jumlah_transaksi }}</td>
                <td>{{ number_format($item->total_uang, 2) }}</td>
            </tr>
            @php
                $totalUangPerBulan += $item->total_uang;
                $chartData[] = [
                    'label' => \Carbon\Carbon::create()->month($item->bulan)->translatedFormat('F'),
                    'y' => $item->total_uang
                ];
            @endphp
            @endforeach
            <tr>
                <td colspan="3" align="right"><b>Total:</b></td>
                <td>{{ number_format($totalUangPerBulan, 2) }}</td>
            </tr>
        </table>
    </div>

    <div class="chart-container" id="chartContainer" data-chart-data="{{ json_encode($chartData) }}"></div>

    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
    <script>
        window.onload = function () {
            var chartContainer = document.getElementById('chartContainer');
            var chartData = JSON.parse(chartContainer.getAttribute('data-chart-data'));

            var chart = new CanvasJS.Chart("chartContainer", {
                animationEnabled: true,
                data: [{
                    type: "column",
                    dataPoints: chartData
                }]
            });
            chart.render();

            setTimeout(function () {
                window.print();
            }, 1000);
        }
    </script>
</body>

</html>
