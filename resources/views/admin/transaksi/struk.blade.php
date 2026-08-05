<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Struk Pembayaran SPP - {{ $transaksi->nisn }}</title>
    <style>
        body {
            font-family: 'Courier New', Courier, monospace;
            width: 300px;
            margin: 20px auto;
            color: #333;
            font-size: 12px;
        }

        .text-center {
            text-align: center;
        }

        .bold {
            font-weight: bold;
        }

        hr {
            border: none;
            border-top: 1px dashed #000;
            margin: 10px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        .flex-between {
            display: flex;
            justify-content: space-between;
        }

        .mt-4 {
            margin-top: 15px;
        }
    </style>
</head>

<body onload="window.print()">

    <div class="text-center">
        <h2 style="margin: 0; font-size: 16px;">EDUPAY SPP</h2>
        <p style="margin: 5px 0 0 0;">Bukti Pembayaran SPP Resmi</p>
    </div>

    <hr>

    <table>
        <tr>
            <td>No. Trans</td>
            <td>: #{{ $transaksi->id_pembayaran }}</td>
        </tr>
        <tr>
            <td>Tanggal</td>
            <td>: {{ date('d-m-Y', strtotime($transaksi->tgl_bayar)) }}</td>
        </tr>
        <tr>
            <td>Kasir</td>
            <td>: {{ $transaksi->nama_petugas }}</td>
        </tr>
        <tr>
            <td>Siswa</td>
            <td>: {{ $transaksi->nama_siswa }}</td>
        </tr>
        <tr>
            <td>Kelas</td>
            <td>: {{ $transaksi->nama_kelas }}</td>
        </tr>
        <tr>
            <td>NISN</td>
            <td>: {{ $transaksi->nisn }}</td>
        </tr>
    </table>

    <hr>

    <div class="bold text-center" style="font-size: 13px;">DETAIL TAGIHAN</div>
    <div class="flex-between mt-4">
        <span>SPP Bulan {{ $transaksi->bulan_dibayar }} {{ $transaksi->tahun_dibayar }}</span>
        <span>Rp {{ number_format($transaksi->jumlah_bayar - 2000, 0, ',', '.') }}</span>
    </div>
    <div class="flex-between" style="margin-top: 5px;">
        <span>Biaya Admin</span>
        <span>Rp 2.000</span>
    </div>

    <hr>

    <div class="flex-between bold" style="font-size: 14px;">
        <span>TOTAL TAGIHAN</span>
        <span>Rp {{ number_format($transaksi->jumlah_bayar, 0, ',', '.') }}</span>
    </div>

    <hr>

    @php
        // Logika anti-error buat data transaksi lama yang belum ada 'uang_diterima'
        $uang_masuk = $transaksi->uang_diterima ?? $transaksi->jumlah_bayar;
        $kembalian = $uang_masuk - $transaksi->jumlah_bayar;
    @endphp

    <div class="flex-between" style="margin-top: 5px; color: #555;">
        <span>Uang Diterima</span>
        <span>Rp {{ number_format($uang_masuk, 0, ',', '.') }}</span>
    </div>
    <div class="flex-between" style="margin-top: 5px; color: #555;">
        <span>Kembalian</span>
        <span>Rp {{ number_format($kembalian, 0, ',', '.') }}</span>
    </div>

    <hr>

    <div class="text-center mt-4" style="font-style: italic;">
        "Uang yang sudah dibayarkan<br>dinyatakan LUNAS dan Sah.<br>Terima kasih!"
    </div>

</body>

</html>
