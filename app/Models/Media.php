<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use HasFactory;
    protected $fillable = [
        'file_name_1',
        'file_path_1',
        'file_type_1',
        'mime_type_1',
        'file_size_1',
        'file_name_2',
        'file_path_2',
        'file_type_2',
        'mime_type_2',
        'file_size_2',
    ];
}
