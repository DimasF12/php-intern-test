<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Storage;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'nomor', 'nama', 'jabatan', 'talahir', 'photo_upload_path',
        'created_on', 'updated_on', 'created_by', 'updated_by', 'deleted_on',
    ];

    public $timestamps = false; 

    protected $dates = ['created_on', 'updated_on', 'talahir']; 
}
