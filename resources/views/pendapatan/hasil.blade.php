@extends('layouts.layout')
@section('content')
    @include('sweetalert::alert')
    <!-- Display validation errors -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"> Transaksi Pendapatan </h1>
    </div>
    <hr>
    <form action="/pendapatan/simpan" method="POST">
        @csrf
        <div class="form-group col-sm-4">
            <label for="exampleFormControlInput1"> No Faktur </label>
            @foreach ($kas as $ks)
                <input type="hidden" name="akun" value="{{ $ks->no_akun }}" class="form-control"
                    id="exampleFormControlInput1">
            @endforeach
            @foreach ($pendapatan as $hasil)
                <input type="hidden" name="no_pen" value="{{ $hasil->no_akun }}" class="form-control"
                    id="exampleFormControlInput1">
            @endforeach
            <input type="hidden" name="no_jurnal" value="{{ $formatj }}" class="form-control"
                id="exampleFormControlInput1">
            <input type="text" name="no_faktur" value="{{ $format }}" class="form-control"
                id="exampleFormControlInput1">
        </div>
        @foreach ($penjualan as $jual)
            <div class="form-group col-sm-4">
                <label for="exampleFormControlInput1">No Penjualan</label>
                <input type="text" name="no_jual" value="{{ $jual->no_jual }}" class="form-control"
                    id="exampleFormControlInput1">
            </div>
            <div class="form-group col-sm-4">
                <label for="exampleFormControlInput1">Tanggal Penjualan</label>
                <input type="date" min="1" name="tgl" value="{{ $jual->tgl }}" id="addtgl"
                    class="form-control" id="exampleFormControlInput1" require>
            </div>
        @endforeach
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered tablestriped" id="dataTable" width="100%" cellspacing="0">
                        <thead class="thead-dark">
                            <tr>
                                <th>Kode Barang</th>
                                <th>Nama Barang</th>
                                <th>Kode Pelanggan</th>
                                <th>Quantity</th>
                                <th>Harga Jasa</th>
                                <th>Sub Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php($total = 0)
                            @foreach ($detail as $temp)
                                <tr>
                                    <td><input name="no_pen[]" class="form-control"type="hidden"
                                            value="{{ $temp->no_jual }}" readonly>
                                        <input name="kd_brg[]" class="form-control" type="hidden"
                                            value="{{ $temp->kd_brg }}" readonly>{{ $temp->kd_brg }}
                                    </td>
                                    <td>{{ $temp->nm_brg }}</td>
                                    <td><input name="kd_pel" class="form-control" type="hidden"
                                            value="{{ $temp->kd_pel }}" readonly>{{ $temp->kd_pel }}</td>
                                    <td><input name="qty_pen[]" class="form-control" type="hidden"
                                            value="{{ $temp->qty_jual }}" readonly>{{ $temp->qty_jual }}</td>
                                    <td><input name="hrg_jasa[]" class="form-control" type="hidden"
                                            value="{{ $temp->hrg_jasa }}" readonly>{{ $temp->hrg_jasa }}</td>
                                    <td><input name="total_pen[]" class="form-control" type="hidden"
                                            value="{{ $temp->total_jual }}" readonly>{{ $temp->total_jual }}</td>
                                    <td align="center">
                                    </td>
                                </tr>
                                @php($total += $temp->total_jual)
                            @endforeach
                            <tr>
                                <td colspan="5"></td>
                                <td><input name="total" class="form-control" type="hidden"
                                        value="{{ $total }}">Total Rp. {{ number_format($total) }}</a>
                                <td></td>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <input type="submit" class="btn btn-primary btn-send" value="Simpan Transaksi">
            </div>
        </div>
    </form>
@endsection
