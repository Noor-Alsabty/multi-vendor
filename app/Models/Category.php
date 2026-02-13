<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'parent_id',
    ];
    //  Parent Category
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }
    //   Children Categories
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }
public function products()
{
    return $this->hasMany(Product::class);
}


}
