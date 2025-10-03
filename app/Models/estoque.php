// Em app/Models/Estoque.php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Estoque extends Model 
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
