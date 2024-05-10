<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use HasFactory, SoftDeletes;

    const TODO_STATUS = 'todo';
    const DOING_STATUS = 'doing';
    const DONE_STATUS = 'done';
    const ALL_STATUSES = [
        self::TODO_STATUS,
        self::DOING_STATUS,
        self::DONE_STATUS
    ];

    protected $fillable = [
        'status',
        'title',
        'description',
        'creator_id',
    ];

    /**
     * @return BelongsTo
     */
    public function creator()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
