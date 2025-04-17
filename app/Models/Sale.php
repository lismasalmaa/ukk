<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'sale_date',
        'sales_products',
        'total_price',
        'discount',
        'total_pay',
        'total_return',
        'member_id',
        'user_id',
        'product_id',
        'point',
        'used_point',
    ];

    public function member()
{
    return $this->belongsTo(Member::class, 'member_id');
}


public function user()
{
    return $this->belongsTo(User::class, 'user_id');
}

public function detail_sales()
{
    return $this->hasMany(\App\Models\Detail_sale::class, 'sale_id');
}


    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
