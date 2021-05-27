<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasFactory;

    protected $fillable = [
        'author',
        'user_id',
        'title',
        'status',
        'content'
    ];

    public function categories()
    {
        return $this->hasMany(Category::class);
    }
}
