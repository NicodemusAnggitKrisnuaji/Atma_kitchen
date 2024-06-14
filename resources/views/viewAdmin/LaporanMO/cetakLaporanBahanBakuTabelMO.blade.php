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
            table-layout: fixed; /* Menambahkan table-layout fixed */
        }

        table.static th, table.static td {
            padding: 8px 10px; /* Mengatur padding sel untuk mengurangi jarak antar kolom */
            text-align: center; /* Pusatkan teks dalam sel */
        }
    </style>
    <title>Cetak Laporan Penggunaan Bahan</title>
</head>

<body>
    <div class="form-group">
        <p><b>Atma Kitchen</b></p>
        <p>Jl. Centralpark No. 10 Yogyakarta</p>
        <p><b>Laporan Penggunaan Bahan Baku</b></p>
        <p>Periode {{ $tglawal }} - {{ $tglakhir }}</p>
        <p>Tanggal Cetak: {{ \Carbon\Carbon::now()->format('j F Y') }}</p>
        <table class="static" align="center" rules="all" border="1px" style="width: 95%;">
            <tr>
                <th>No.</th>
                <th>Nama Bahan</th>
                <th>Satuan</th>
                <th>Digunakan</th>
            </tr>
            @foreach ($cetakPeriode as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>
                    @if ($item->bahanBaku)
                        {{ $item->bahanBaku->nama }}
                    @else
                        Nama Bahan Tidak Tersedia
                    @endif
                </td>
                <td>
                    @if ($item->bahanBaku)
                        {{ $item->bahanBaku->satuan }}
                    @else
                        Satuan Tidak Tersedia
                    @endif
                </td>
                <td>{{ $item->jumlah }}</td>
            </tr>
            @endforeach
        </table>
    </div>
    <script type="text/javascript">
        window.print();

    </script>
</body>


</html>