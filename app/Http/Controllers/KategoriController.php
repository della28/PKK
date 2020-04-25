<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Kategori;
use JWTAuth;
use Auth;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;

class KategoriController extends Controller
{
    public function store(Request $request){
      if(Auth::user()->level=="admin"){
      $validator=Validator::make($request->all(),
        [
          'kategori'=>'required',

        ]
      );

      if($validator->fails()){
        return Response()->json($validator->errors());
      }

      $simpan=Kategori::create([
        'kategori'=>$request->kategori,

      ]);
      $status=1;
      $message="Kategori Berhasil Ditambahkan";
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
          'kategori'=>'required',

        ]
    );

      if($validator->fails()){
      return Response()->json($validator->errors());
    }

      $ubah=Kategori::where('id',$id)->update([
        'kategori'=>$request->kategori,

      ]);
      $status=1;
      $message="Kategori Berhasil Diubah";
      if($ubah){
        return Response()->json(compact('status','message'));
      }else {
        return Response()->json(['status'=>0]);
      }
    } else{
      return response()->json(['status'=>'anda bukan admin']);
    }
  }

    public function tampil_kategori(){
      if(Auth::user()->level=="admin"){
      $data_kat=Kategori::get();
      $count=$data_kat->count();
      $arr_data=array();
      foreach ($data_kat as $dt_kt){
        $arr_data[]=array(
          'id' => $dt_kt->id,
          'kategori' => $dt_kt->kategori,
          
        );
      }
      $status=1;
      return Response()->json(compact('status','count','arr_data'));
    } else{
      return response()->json(['status'=>'anda bukan admin']);
    }
  }

    public function destroy($id){
      if(Auth::user()->level=="admin"){
      $hapus=Kategori::where('id',$id)->delete();
      $status=1;
      $message="Kategori Berhasil Dihapus";
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
