<?php

declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Article.
 */
class Article extends Model
{
    /**
     * @var array $fillable The attributes that are mass assignable.
     */
    protected $fillable = [
        'title',
        'description',
        'user_id',
    ];

    /**
     * Get the owner of article.
     *
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Article has many comments.
     *
     * @return HasMany
     */
    public function comments()
    {
        return $this->hasMany('App\Comment');
    }
}
