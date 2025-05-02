<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Product extends Model
{
    use HasFactory, Notifiable;

    protected $primaryKey = 'id_products';
    protected $fillable = [
        'name',
        'description',
        'quantity',
        'price',
        'category',
        'sku',
    ];
}
