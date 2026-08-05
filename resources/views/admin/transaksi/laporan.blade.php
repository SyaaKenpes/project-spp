<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Pemasukan SPP EduPay</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 30px;
            color: #333;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #000;
            padding-bottom: 10px;
        }

        .header h1 {
            margin: 0;
            font-size: 22px;
            text-transform: uppercase;
        }

        .header p {
            margin: 5px 0 0 0;
            font-size: 14px;
            color: #666;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table,
        th,
        td {
            border: 1px solid #000;
        }

        th {
            padding: 10px;
            bg-color: #f2f2f2;
            font-size: 12px;
            text-transform: uppercase;
        }

        td {
            padding: 10px;
            font-size: 12px;
        }

        .text-right {
            text-align: right;
        }

        .bold {
            font-weight: bold;
        }

        .ttd-box {
            float: right;
            width: 200px;
            text-align: center;
            margin-top: 5px;
            font-size: 13px;
        }
    </style>
</head>

<body onload="window.print()">

    <div class="header">
        <h1>LAPORAN REALISASI PEMASUKAN SPP EDUPAY</h1>
        <p>SMK NEGERI 7 BALEENDAH - TAHUN AJARAN {{ date('Y') }}</p>
        @if ($request->tgl_mulai && $request->tgl_selesai)
            <p style="font-weight: bold; color: black; margin-top: 8px;">Periode Tanggal:
                {{ date('d/m/Y', strtotime($request->tgl_mulai)) }} s/d
                {{ date('d/m/Y', strtotime($request->tgl_selesai)) }}</p>
        @else
            <p style="font-weight: bold; color: black; margin-top: 8px;">Periode: Semua Riwayat Transaksi</p>
        @endif
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal Bayar</th>
                <th>NISN</th>
                <th>Nama Siswa</th>
                <th>Bulan Tagihan</th>
                <th>Petugas Kasir</th>
                <th>Total Diterima</th>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp
            @forelse($laporan as $l)
                <tr>
                    <td style="text-align: center;">{{ $no++ }}</td>
                    <td style="text-align: center;">{{ date('d-m-Y', strtotime($l->tgl_bayar)) }}</td>
                    <td style="text-align: center;">{{ $l->nisn }}</td>
                    <td>{{ $l->nama_siswa }}</td>
                    <td style="text-align: center;">{{ $l->bulan_dibayar }} {{ $l->tahun_dibayar }}</td>
                    <td>{{ $l->nama_petugas }}</td>
                    <td class="text-right bold">Rp {{ number_format($l->jumlah_bayar, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align: center; padding: 20px;">Tidak ada transaksi pada periode ini.
                    </td>
                </tr>
            @endforelse
            <tr style="background-color: #f9f9f9;">
                <td colspan="6" class="text-right bold" style="font-size: 14px; padding: 12px;">TOTAL KESELURUHAN
                    PEMASUKAN:</td>
                <td class="text-right bold" style="font-size: 14px; color: green; padding: 12px;">Rp
                    {{ number_format($totalPemasukan, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <div style="margin-top: 50px;">
        <div class="ttd-box">
            <p>Bandung, {{ date('d F Y') }}</p>
            <p style="margin-bottom: 70px;">Mengetahui, Kepala Tata Usaha</p>
            <p class="bold" style="text-decoration: underline;">Pasyha Zulfahmi Rochmat</p>
            <p style="margin-top: 2px; font-size: 11px; color: #555;">NIP. 19980312 202412 1 001</p>
        </div>
    </div>

</body>

</html>
