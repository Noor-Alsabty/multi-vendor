<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;


class Category extends Model  implements HasMedia
{
    use InteractsWithMedia;
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
  public function registerMediaCollections(): void
    {
        $this->addMediaCollection("category_images")
        ->useDisk("public");
    }

}
