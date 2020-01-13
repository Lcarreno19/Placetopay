<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    /**
    * The table associated with the model.
    *
    * @var string
    */
    protected $table = 'orders';
    protected $primaryKey = 'idorders';
    protected $guarded = [];

    /**
    * The attributes that are mass assignable.
    *
     * @var array
     */
    protected $fillable = [
        'customer_name','customer_email', 'customer_mobile', 'status','requestid','idproducto','iduser','urlgenerada','consultada',
    ];

    public function order_prod(){
        return $this->hasMany(Productos::class,'idproducto','idproducto');
    }
}
