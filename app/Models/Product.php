<?php

namespace App\Models;
use App\Models\CategoryModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['name',
                            'sku',
                            'brand',
                            'img',
                            'price',
                            'inventory',
                            'description',
                            'category_id'
                        ];
    protected $table = 'products';
    public function category(): BelongsTo
    {
        return $this->belongsTo(CategoryModel::class, 'category_id', 'id');
    }
}
