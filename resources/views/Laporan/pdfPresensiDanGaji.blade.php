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
            <h3>LAPORAN Presensi Karyawan</h3>
            <p>Bulan : {{ \Carbon\Carbon::create()->month($month)->format('F') }}</p>
            <p>Tahun: {{ $year }}</p>
            <p>Tanggal cetak: {{ \Carbon\Carbon::now()->format('j F Y') }}</p>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Jumlah Hadir</th>
                    <th>Jumlah Bolos</th>
                    <th>Honor Harian</th>
                    <th>Bonus Rajin</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @php
                $totalHadir = 0;
                $totalBolos = 0;
                $totalGaji = 0;
                @endphp

                @foreach($employees as $employee)
                @php
                // Menghitung jumlah hadir dan jumlah bolos untuk setiap karyawan
                $hadir = $employee->presensi->where('status', 'Hadir')->count();
                $bolos = $employee->presensi->where('status', 'Bolos')->count();

                // Menghitung total honor harian
                $honorHarian = $hadir * $employee->honor_harian;

                // Menghitung bonus rajin
                // $bonusRajin = ($hadir > 25) ? $employee->bonus_rajin : 0;
                $bonusRajin = $employee->bonus_rajin ;

                $total = $honorHarian + $bonusRajin;

                $totalHadir += $hadir;
                $totalBolos += $bolos;
                $totalGaji += $total;
                @endphp

                <tr>
                    <td>{{ $employee->nama_karyawan }}</td>
                    <td>{{ $hadir }}</td>
                    <td>{{ $bolos }}</td>
                    <td>{{ number_format($honorHarian, 0, ',', '.') }}</td>
                    <td>{{ number_format($bonusRajin, 0, ',', '.') }}</td>
                    <td>{{ number_format($total, 0, ',', '.') }}</td>
                </tr>
                @endforeach

                <tr>
                    <th colspan="5">Total</th>
                    <th>{{ number_format($totalGaji, 0, ',', '.') }}</th>
                </tr>
            </tbody>
        </table>
    </div>
</body>

</html>
