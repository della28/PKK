<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Barang;
use DB;
use JWTAuth;
use Auth;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;

class BarangController extends Controller
{
    public function store(Request $request){
      if(Auth::user()->level=="admin"){
      $validator=Validator::make($request->all(),
        [
          'id_kategori'=>'required',
          'nama_barang'=>'required',
          'bahan'=>'required',
          'ukuran'=>'required',
          'harga_barang'=>'required',
          'jumlah_produksi'=>'required',
          'deskripsi'=>'required'
        ]
      );

      if($validator->fails()){
        return Response()->json($validator->errors());
      }

      $simpan=Barang::create([
        'id_kategori'=>$request->id_kategori,
        'nama_barang'=>$request->nama_barang,
        'bahan'=>$request->bahan,
        'ukuran'=>$request->ukuran,
        'harga_barang'=>$request->harga_barang,
        'jumlah_produksi'=>$request->jumlah_produksi,
        'deskripsi'=>$request->deskripsi
      ]);
      $status=1;
      $message="Data Barang Berhasil Ditambahkan";
      if($simpan){
        return Response()->json(compact('status','message'));
      }else {
        return Response()->json(['status'=>0]);
      }
    } else{
      return response()->json(['status'=>'anda bukan admin']);
    }
  }

    public function update($id,Request $request){
      if(Auth::user()->level=="admin"){
      $validator=Validator::make($request->all(),
        [
          'id_kategori'=>'required',
          'nama_barang'=>'required',
          'bahan'=>'required',
          'ukuran'=>'required',
          'harga_barang'=>'required',
          'jumlah_produksi'=>'required',
          'deskripsi'=>'required'
        ]
    );

      if($validator->fails()){
      return Response()->json($validator->errors());
    }

      $ubah=Barang::where('id',$id)->update([
        'id_kategori'=>$request->id_kategori,
        'nama_barang'=>$request->nama_barang,
        'bahan'=>$request->bahan,
        'ukuran'=>$request->ukuran,
        'harga_barang'=>$request->harga_barang,
        'jumlah_produksi'=>$request->jumlah_produksi,
        'deskripsi'=>$request->deskripsi
      ]);
      $status=1;
      $message="Data Barang Berhasil Diubah";
      if($ubah){
        return Response()->json(compact('status','message'));
      }else {
        return Response()->json(['status'=>0]);
      }
    } else{
      return response()->json(['status'=>'anda bukan admin']);
    }
  }

    public function tampil_barang(){
      if(Auth::user()->level=="admin"){
        $data=DB::table('barang')
        ->join('kategori','kategori.id','=','barang.id_kategori')
        ->select('nama_barang','kategori','bahan','ukuran','harga_barang','jumlah_produksi','deskripsi')
        ->get();
        $count=$data->count();
        $status=1;
        $message="Data Barang Berhasil ditampilkan";
        return response()->json(compact('data','status','message','count'));
    } else{
      return response()->json(['status'=>'anda bukan admin']);
    }
  }

    public function destroy($id){
      if(Auth::user()->level=="admin"){
      $hapus=Barang::where('id',$id)->delete();
      $status=1;
      $message="Data Barang Berhasil Dihapus";
      if($hapus){
        return Response()->json(compact('status','message'));
      }else {
        return Response()->json(['status'=>0]);
      }
    } else{
      return response()->json(['status'=>'anda bukan admin']);
    }
  }
}
