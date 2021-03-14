<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;

class Category extends Model
{
    use HasFactory;

    public function subCategory()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }
}
