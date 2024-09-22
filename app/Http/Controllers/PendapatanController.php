<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;
use App\DetailPendapatan;
use App\Pendapatan;
use DB;
use Alert;
use PDF;
use App\Jurnal;

class PendapatanController extends Controller
{
    //
    public function index()
    {
        $jual = \App\Penjualan::All();

        //perintah SQL untuk menghilangkan data penjualan ketika sudah dijual
        $jual = DB::select('SELECT * FROM penjualan where not exists (select * from pendapatan where penjualan.no_jual=pendapatan.no_jual)');
        return view('pendapatan.pendapatan', ['penjualan' => $jual]);
    }

    public function edit($id)
    {
        $AWAL = 'FP';
        $bulanRomawi = array("", "I", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX", "X", "XI", "XII");
        $noUrutAkhir = \App\Pendapatan::max('no_pen');
        $no = 1;
        $format = sprintf("%03s", abs((int)$noUrutAkhir + 1)) . '/' . $AWAL . '/' . $bulanRomawi[date('n')] . '/' . date('Y');
        $AWALJurnal = 'JRU';
        $bulanRomawij = array("", "I", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX", "X", "XI", "XII");
        $noUrutAkhirj = \App\Jurnal::max('no_jurnal');
        $noj = 1;
        $formatj = sprintf("%03s", abs((int)$noUrutAkhirj + 1)) . '/' . $AWALJurnal . '/' . $bulanRomawij[date('n')] . '/' . date('Y');
        $decrypted = Crypt::decryptString($id);
        $detail = DB::table('tampil_penjualan')->where('no_jual', $decrypted)->get();
        $penjualan = DB::table('penjualan')->where('no_jual', $decrypted)->get();
        $akunkas = DB::table('setting')->where('nama_transaksi', 'Kas')->get();
        $akunpendapatan = DB::table('setting')->where('nama_transaksi', 'Pendapatan')->get();
        return view('pendapatan.hasil', ['detail' => $detail, 'format' => $format, 'no_jual' => $decrypted, 'penjualan' => $penjualan, 'formatj' => $formatj, 'kas' => $akunkas, 'pendapatan' => $akunpendapatan]);
    }
    public function pdf($id)
    {
        $decrypted = Crypt::decryptString($id);

        // Ambil detail penjualan berdasarkan no_jual
        $detail = DB::table('tampil_penjualan')
            ->where('no_jual', $decrypted)
            ->get();

        // Ambil data pelanggan
        $pelanggan = DB::table('pelanggan')
            ->join('penjualan', 'pelanggan.kd_pel', '=', 'penjualan.kd_pel')
            ->where('penjualan.no_jual', $decrypted)
            ->first(); // Menggunakan first() untuk mendapatkan satu objek

        // Mengirim data ke view
        $pdf = PDF::loadView('laporan.faktur', [
            'detail' => $detail,
            'pelanggan' => $pelanggan,
            'noorder' => $decrypted
        ]);

        return $pdf->stream();
    }


    public function simpan(Request $request)
{
    try {
        if (Pendapatan::where('no_jual', $request->no_jual)->exists()) {
            Alert::warning('Pesan', 'Penjualan telah dilakukan');
            return redirect('pendapatan');
        } else {
            // Validasi data sebelum disimpan
            $request->validate([
                'no_jual' => 'required|exists:penjualan,no_jual' // Pastikan no_jual ada di tabel Penjualan
            ]);

            // Simpan ke tabel pendapatan
            $tambah_pendapatan = new \App\Pendapatan;
            $tambah_pendapatan->no_pen = $request->no_faktur;
            $tambah_pendapatan->kd_pel = $request->kd_pel;
            $tambah_pendapatan->tgl_pen = $request->tgl;
            $tambah_pendapatan->no_faktur = $request->no_faktur;
            $tambah_pendapatan->no_jual = $request->no_jual;
            $tambah_pendapatan->save();

            // Cek apakah array kd_brg ada dan tidak null
            if (!empty($request->kd_brg) && is_array($request->kd_brg)) {
                DB::transaction(function () use ($request) {
                    foreach ($request->kd_brg as $key => $kd_brg) {
                        // Pastikan elemen-elemen lain juga ada sebelum diakses
                        if (isset($request->qty_pen[$key], $request->hrg_jasa[$key], $request->sub_pen[$key])) {
                            DetailPendapatan::create([
                                'no_pen' => $request->no_faktur,
                                'kd_brg' => $kd_brg, // Akses elemen array $request->kd_brg
                                'kd_pel' => $request->kd_pel,
                                'qty_pen' => $request->qty_pen[$key], // Akses elemen array $request->qty_pen
                                'hrg_jasa' => $request->hrg_jasa[$key], // Akses elemen array $request->hrg_jasa
                                'sub_pen' => $request->sub_pen[$key], // Akses elemen array $request->sub_pen
                            ]);
                        }
                    }
                });
            }

            // Simpan ke tabel jurnal bagian debet
            Jurnal::create([
                'no_jurnal' => $request->no_jurnal,
                'keterangan' => 'Kas',
                'tgl_jurnal' => $request->tgl,
                'no_akun' => 101,
                'debet' => $request->total,
                'kredit' => 0,
            ]);

            // Simpan ke tabel jurnal bagian kredit
            Jurnal::create([
                'no_jurnal' => $request->no_jurnal,
                'keterangan' => 'Pendapatan',
                'tgl_jurnal' => $request->tgl,
                'no_akun' => 501,
                'debet' => 0,
                'kredit' => $request->total,
            ]);

            Alert::success('Pesan', 'Data berhasil disimpan');
            return redirect('/pendapatan');
        }
    } catch (\Exception $e) {
        // Tangani error di sini, misalnya tampilkan pesan error
        Alert::error('Pesan', 'Terjadi kesalahan: ' . $e->getMessage());
        return redirect()->back();
    }
}


}
