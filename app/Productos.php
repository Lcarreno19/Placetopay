<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Productos extends Model
{
    /**
    * The table associated with the model.
    *
    * @var string
    */
    protected $table = 'productos';
    protected $primaryKey = 'idproducto';
    public $timestamps = false;
    protected $guarded = [];

    /**
    * The attributes that are mass assignable.
    *
     * @var array
     */
    protected $fillable = [
        'nombre_producto','codigo_producto','price_producto','tax_producto', 'cantidad_stock',
    ];

    public function ord_prd(){
        return $this->belongsTo(Orders::class);
    }
}
