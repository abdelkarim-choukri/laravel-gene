<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeneData extends Model
{
    use HasFactory;

    // By default, Laravel will use the class name as the table name (snake_case), which is "gene_data"
    protected $table = 'gene_data';

    protected $fillable = [
        'id',
        'gene_id',
        'value',
        'SRA',
        'Abbreviation',
        'Expriment',
        'Disease',
    ];
    
}

