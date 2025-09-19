<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $table = 'kategori';
    protected $primaryKey = 'id_kategori';
    protected $fillable = [
        'nama_kategori',
        'keterangan_kategori',
    ];

    public function surat()
    {
        return $this->hasMany(Surat::class, 'id_kategori', 'id_kategori');
    }
}
