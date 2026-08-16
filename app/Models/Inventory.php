<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;
    protected $table = 'tbl_currentinventory';
    protected $primaryKey = 'inventory_id';
    protected $fillable = ['product_id'];

    public $timestamps = false;

}