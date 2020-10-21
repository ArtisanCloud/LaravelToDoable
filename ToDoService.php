<?php

namespace ArtisanCloud\ToDoable;

use ArtisanCloud\SaaSFramework\Services\ArtisanCloudService;
use ArtisanCloud\ToDoable\Contracts\ToDoServiceContract;
use ArtisanCloud\ToDoable\Models\ToDo;

/**
 * Class ToDoService
 * @package ArtisanCloud\ToDoable
 */
class ToDoService extends ArtisanCloudService implements ToDoServiceContract
{
    //
    //
    //
    public function __construct()
    {
        parent::__construct();
        $this->m_model = new ToDo();
    }

    /**
     * make a model
     *
     * @param array $arrayData
     *
     * @return mixed
     */
    public function makeBy(array $arrayData)
    {
        $this->m_model = $this->m_model->create(
            [
                'created_by' => $arrayData['user_uuid'],
                'name' => $arrayData['name'],
                'content' => $arrayData['content'],
                'type' => $arrayData['type'],
                'is_public' => $arrayData['is_public'],
                'commentable_id' => $arrayData['commentable_id'],
                'commentable_type' => $arrayData['commentable_type'],
                'due_date' => $arrayData['due_date'],
            ]
        );
//        dd($this->m_model);
        return $this->m_model;
    }

    /**
     * create list by
     *
     * @param Workzone $workzone
     *
     * @return mixed
     */
    public function getListBy(Workzone $workzone)
    {
        $releases = $workzone->epics()->get();
//        dd($releases);
        return $releases;
    }
}
