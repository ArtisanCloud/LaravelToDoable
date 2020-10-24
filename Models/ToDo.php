<?php
declare(strict_types=1);

namespace ArtisanCloud\ToDoable\Models;

use ArtisanCloud\SaaSFramework\Models\ArtisanCloudModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ToDo extends ArtisanCloudModel
{
    protected $connection = 'pgsql';
    const TABLE_NAME = 'todos';
    protected $table = self::TABLE_NAME;

    protected $primaryKey = 'id';
    protected $keyType = 'int';
    public $incrementing = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'content',
        'type',
        'status',
        'todoable_id',
        'todoable_type',
        'due_date',
        'created_by',
        'assigned_to_user_uuid',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'id',
    ];

    const TYPE_NORMAL = 1;
    const TYPE_REPLY = 2;

    const ARRAY_TYPE = [
        self::TYPE_NORMAL,
        self::TYPE_REPLY,
    ];


    /**--------------------------------------------------------------- relation functions  -------------------------------------------------------------*/
    /**
     * Get the owning todoable model.
     */
    public function todoable()
    {
        return $this->morphTo();
    }
    

}
