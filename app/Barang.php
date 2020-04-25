<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
  protected $table="barang";
  protected $primaryKey="id";
  protected $fillable = [
    'id_kategori',
    'nama_barang',
    'bahan',
    'ukuran',
    'harga_barang',
    'jumlah_produksi',
    'deskripsi'
  ];
}
