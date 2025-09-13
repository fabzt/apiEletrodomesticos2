<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produtos extends Model
{
    protected $fillable = [
        'nomeprod',
        'marcaprod',
        'descprod',
        'qtdprod',
        'dtentradaprod',
        'dtsaidaprod',
    ];
}