<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    /** @use HasFactory<\Database\Factories\CategoryFactory> */
    use HasFactory , SoftDeletes;
    protected $fillable = [
        'name',
        'image',
        'description'
    ];
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($category) {

            $category->employees()->each(function ($treatments) {
                $treatments->delete();
            });
        });
    }
    public function treatments()
    {
        return $this->hasMany(Treatment::class);
    }

}
