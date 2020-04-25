<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TransaksiController extends Controller
{
  public function report(){
    if(Auth::user()->level=="pembeli"){
      $transaksi=DB::table('transaksi')
      ->join('customer', 'customer.id', '=', 'transaksi.id_customer')
      ->select('transaksi.id', 'tgl_trans', 'nama', 'metode_bayar')
      ->get();

      $datatrans=array(); $no=0;
      foreach ($transaksi as $tr) {
        $datatrans[$no]['id transaksi'] = $tr->id;
        $datatrans[$no]['tgl_trans'] = $tr->tgl_trans;
        $datatrans[$no]['nama pembeli'] = $tr->nama;
        $datatrans[$no]['metode_bayar'] = $tr->metode_bayar;

        $grand=DB::table('detail_trans')->where('id_trans', $tr->id)->groupBy('id_trans')
        ->select(DB::raw('sum(subtotal) as grand_total'))->first();

        $datatrans[$no]['grand_total'] = $grand->grand_total;
        $detail=DB::table('detail_trans')
        ->join('barang','barang.id', '=', 'detail_trans.id_barang')
        ->join('kategori','kategori.id', '=', 'barang.id_kategori')
        ->where('id_trans', $tr->id)
        ->select('nama_barang', 'kategori', 'ukuran', 'harga_barang', 'qty', 'subtotal')
        ->get();

        $datatrans[$no]['detail'] = $detail;
        $no++;
        }
      return response()->json(compact("datatrans"));
    } else{
      return response()->json(['status'=>'anda bukan user']);
    }
      }
}
