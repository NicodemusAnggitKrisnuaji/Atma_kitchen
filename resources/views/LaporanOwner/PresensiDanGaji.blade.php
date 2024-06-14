@extends('dashboardOwner')
@section('content')

<style>
    body {
        font-family: Arial, sans-serif;
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

<div style="text-align: center;">
    <h2>Atma Kitchen</h2>
    <p>Jl. Centralpark No. 10 Yogyakarta</p>
    <h3>LAPORAN Presensi Karyawan</h3>
    <form method="GET" action="{{ route('PresensiDanGajiOwner') }}">
        <label for="bulan">Bulan: </label>
        <select id="bulan" name="bulan">
            @for ($m = 1; $m <= 12; $m++)
                <option value="{{ $m }}" {{ $m == $month ? 'selected' : '' }}>{{ \Carbon\Carbon::create()->month($m)->format('F') }}</option>
            @endfor
        </select>
        <label for="tahun">Tahun: </label>
        <input type="number" id="tahun" name="tahun" value="{{ $year }}">
        <button type="submit">Generate Laporan</button>
        <button type="submit" name="download" value="pdf">Download PDF</button>
    </form>
    <p>Bulan: {{ \Carbon\Carbon::create()->month($month)->format('F') }}</p>
    <p>Tahun: {{ $year }}</p>
    <p>Tanggal cetak: {{ \Carbon\Carbon::now()->format('j F Y') }}</p>
    <button onclick="window.print()" style="margin-bottom: 20px;">Print</button>
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
@endsection
