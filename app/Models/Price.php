<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Pricecheck;
class Price extends Model
{
    use HasFactory; 
    protected $fillable = ['id', 'product_id', 'price', 'date'];

}
