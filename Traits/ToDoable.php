<?php

namespace ArtisanCloud\ToDoable\Traits;

use ArtisanCloud\ToDoable\Models\ToDo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;


trait ToDoable
{

    /**
     * Get all of the post's comments.
     */
    public function todos()
    {
        return $this->morphMany(ToDo::class, 'todoable');
    }
}
