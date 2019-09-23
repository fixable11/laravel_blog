<?php

declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Comment.
 */
class Comment extends Model
{
    /**
     * @var array $fillable The attributes that are mass assignable.
     */
    protected $fillable = [
        'description',
        'user_id',
        'article_id'
    ];
}
