<?php

namespace App\Models;

use Database\Factories\TodoFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 *
 *
 * @property int $id
 * @property string $title
 * @property string|null $description
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Todo newModelQuery()
 * @method static Builder|Todo newQuery()
 * @method static Builder|Todo query()
 * @method static Builder|Todo whereCreatedAt($value)
 * @method static Builder|Todo whereDescription($value)
 * @method static Builder|Todo whereId($value)
 * @method static Builder|Todo whereTitle($value)
 * @method static Builder|Todo whereUpdatedAt($value)
 * @property Carbon|null $deleted_at
 * @method static Builder|Todo onlyTrashed()
 * @method static Builder|Todo whereDeletedAt($value)
 * @method static Builder|Todo withTrashed()
 * @method static Builder|Todo withoutTrashed()
 * @method static \Database\Factories\TodoFactory factory($count = null, $state = [])
 * @mixin \Eloquent
 */
class Todo extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'todos';
    protected $fillable = ['title', 'description'];

    public static function factory(): TodoFactory
    {
        return TodoFactory::new();
    }
}
