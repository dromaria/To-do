<?php

namespace App\Models;

use Database\Factories\TaskFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 *
 *
 * @method static Builder|Task newModelQuery()
 * @method static Builder|Task newQuery()
 * @method static Builder|Task query()
 * @property int $id
 * @property int $todo_id
 * @property string $title
 * @property string|null $description
 * @property bool $state
 * @property string|null $estimation
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read Todo $todo
 * @method static Builder|Task whereCreatedAt($value)
 * @method static Builder|Task whereDeletedAt($value)
 * @method static Builder|Task whereDescription($value)
 * @method static Builder|Task whereEstimationDate($value)
 * @method static Builder|Task whereId($value)
 * @method static Builder|Task whereState($value)
 * @method static Builder|Task whereTitle($value)
 * @method static Builder|Task whereTodoId($value)
 * @method static Builder|Task whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Task extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'tasks';
    protected $fillable = ['todo_id','title', 'description', 'state', 'estimation'];

    public function todo(): BelongsTo
    {
        return $this->belongsTo(Todo::class);
    }

    public static function factory(): TaskFactory|Factory
    {
        return TaskFactory::new();
    }
}
