<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RT extends Model
{
    use HasFactory;

    protected $fillable = ['nama_rt', 'alamat', 'ketua_rt'];
    protected $table = 'rts';
    protected $primaryKey = 'id';

    public static function rules()
    {
        return [
            'nama_rt' => 'required|numeric|unique:rts,nama_rt',
            'alamat' => 'required|string|max:200',
            'ketua_rt' => 'required|string|max:100',
        ];
    }
}
