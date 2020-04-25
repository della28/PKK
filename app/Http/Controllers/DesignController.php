<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Design;
use JWTAuth;
use Auth;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;

class DesignController extends Controller
{
    public function store(Request $request){
      if(Auth::user()->level=="admin"){
      $validator=Validator::make($request->all(),
        [
          'gambar'=>'required',
          'harga_design'=>'required'
        ]
      );

      if($validator->fails()){
        return Response()->json($validator->errors());
      }

      $gambar = $request->file('gambar');
      $name_file = time()."_".$gambar->getClientOriginalName();
      $tujuan_upload = 'gambar';
      $gambar->move($tujuan_upload, $name_file);
      $simpan=Design::create([
        'gambar'=>$name_file,
        'harga_design'=>$request->harga_design
      ]);
      $status=1;
      $message="Design Berhasil Ditambahkan";
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
          'gambar'=>'required',
          'harga_design'=>'required'
        ]
    );

      if($validator->fails()){
      return Response()->json($validator->errors());
    }

      $ubah=Design::where('id',$id)->update([
        'gambar'=>$request->gambar,
        'harga_design'=>$request->harga_design
      ]);
      $status=1;
      $message="Design Berhasil Diubah";
      if($ubah){
        return Response()->json(compact('status','message'));
      }else {
        return Response()->json(['status'=>0]);
      }
    } else{
      return response()->json(['status'=>'anda bukan admin']);
    }
  }

    public function tampil_design(){
      if(Auth::user()->level=="admin"){
      $data_design=Design::get();
      $count=$data_design->count();
      $arr_data=array();
      foreach ($data_design as $dt_ds){
        $arr_data[]=array(
          'id' => $dt_ds->id,
          'gambar design' => $dt_ds->gambar,
          'harga_design' => $dt_ds->harga_design
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
      $hapus=Design::where('id',$id)->delete();
      $status=1;
      $message="Design Berhasil Dihapus";
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
