<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\User
 *
 * @property-read int $id
 * @property string $text
 * @property-read \Carbon\Carbon $created_at
 * @property-read \Carbon\Carbon $updated_at
 * @property-read \Carbon\Carbon $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[] $users
 * @method static \Illuminate\Database\Eloquent\Builder where($column, $operator = null, $value = null)
 * @mixin \Eloquent
 */
class Article extends Model
{
    use SoftDeletes;

    protected $table = 'articles';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'text'
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'users_articles_pivot', 'article_id', 'user_id');
    }

    public function checkAuthor(User $objUser): ?bool
    {
        return $this->users()->newPivotStatementForId($objUser)->exists();
    }
}
