<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BlogPost extends Model
{
    use SoftDeletes;

    /**
     * Категория статьи
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {   // статья принадлежит категории
        //return $this->belongsTo(BlogCategory::class, 'id', 'category_id');
        return $this->belongsTo(BlogCategory::class);
    }

    /**
     * Автор статьи.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {    // статья принадлежит пользователю
        //return $this->belongsTo(User::class, 'id', 'user_id');
        return $this->belongsTo(User::class);
    }
}

