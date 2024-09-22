<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice Bengkel AJM</title>
    <style>
        /* Styling umum untuk struk */
        body {
            font-family: 'Courier', monospace; /* Font mirip struk */
            font-size: 12px;
        }

        .invoice-box {
            width: 100%;
            max-width: 400px; /* Batas lebar seperti kertas struk */
            margin: auto;
            padding: 10px;
            border: 1px solid #ddd;
            line-height: 1.5;
        }

        table {
            width: 100%;
            text-align: left;
            border-collapse: collapse;
        }

        .heading {
            font-weight: bold;
            border-bottom: 1px solid #ddd;
            margin-bottom: 5px;
            padding-bottom: 5px;
        }

        .item {
            padding: 5px 0;
        }

        .total {
            font-weight: bold;
            border-top: 1px dashed #000;
            padding-top: 10px;
            margin-top: 10px;
        }

        td {
            padding: 5px 0;
        }

        .top table, .information table {
            width: 100%;
        }

        .information {
            margin-bottom: 20px;
        }

        .total td {
            padding-top: 10px;
            border-top: 1px dashed black;
        }
    </style>
</head>
<body>
<div class="invoice-box">
    <table cellpadding="0" cellspacing="0">
        <tr class="top">
            <td colspan="2">
                <table>
                    <tr>
                        <td class="title">
                            {{-- <img src="{{ asset('img/ajm_logo.png') }}" width="80px"> --}}
                        </td>
                        <td>
                            Invoice: <strong>#{{ $noorder }}</strong><br>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr class="information">
            <td colspan="2">
                <table>
                    <tr>
                        <td>
                            @if($pelanggan)
                                <strong>PENERIMA</strong><br>
                                {{ $pelanggan->nm_pel }}<br>
                                {{ $pelanggan->alamat_pel }}<br>
                                {{ $pelanggan->telp_pel }}<br>
                            @else
                                <strong>PENERIMA</strong><br>
                                Data tidak ditemukan<br>
                            @endif
                        </td>
                        <td>
                            <strong>PENGIRIM</strong><br>
                            Bengkel Abeck Jaya Motor<br>
                            089788765678<br>
                            Jl Regency<br>
                            Cikampek, Kota Karawang<br>
                            Jawa Barat
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr class="heading">
            <td>Barang</td>
            <td>Harga Jasa</td>
            <td>Subtotal</td>
        </tr>
        @php($total = 0)
        @foreach ($detail as $hasil)
        <tr class="item">
            <td>
                {{ $hasil->nm_brg }}<br>

            </td>
            <td>Rp {{ number_format($hasil->hrg_jasa) }}</td>
            <td>Rp {{ number_format($hasil->total_jual) }}</td>
        </tr>
        @php($total += $hasil->total_jual)
        @endforeach
        <tr class="total">
            <td></td>
            <td>
                Total: Rp {{ number_format($total) }}
            </td>
        </tr>
        <tr>
            <td colspan="3" style="text-align: center;">Terimakasih telah berkunjung</td>
        </tr>
    </table>
</div>
</body>
</html>
