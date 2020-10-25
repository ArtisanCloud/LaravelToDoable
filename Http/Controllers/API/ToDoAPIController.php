<?php
declare(strict_types=1);

namespace ArtisanCloud\ToDoable\Http\Controllers\API;

use ArtisanCloud\ToDoable\Http\Requests\{
    RequestToDoCreate,
    RequestToDoReadItem,
    RequestToDoReadItems
};

use ArtisanCloud\ToDoable\Http\Resources\ToDoResource;
use App\Models\Tenants\ToDo;

use ArtisanCloud\ToDoable\ToDoService;

use App\Services\UserService\UserService;
use ArtisanCloud\SaaSFramework\Exceptions\BaseException;
use ArtisanCloud\SaaSFramework\Http\Controllers\API\APIController;

use ArtisanCloud\SaaSFramework\Http\Controllers\API\APIResponse;
use Illuminate\Http\Request;


class ToDoAPIController extends APIController
{
    private $todoService;

    function __construct(Request $request, ToDoService $todoService)
    {

        // init the default value
        // parent will construction automatically
        parent::__construct($request);

        $this->todoService = $todoService;


    }


    public function apiCreate(RequestToDoCreate $request)
    {

        $todo = \DB::connection('pgsql')->transaction(function () use ($request) {

            try {
                $arrayData = $request->all();
//                dd($arrayData);

                // check if artisan has registered artisan
                $todo = $this->todoService->createBy($arrayData);
//                dd($todo);
                if (is_null($todo)) {
                    throw new \Exception('', API_ERR_CODE_FAIL_TO_CREATE_TO_DO);
                }

            } catch (\Exception $e) {
//                dd($e);
                throw  new BaseException(
                    intval($e->getCode()),
                    $e->getMessage(),
                    TODOABLE_LANG
                );
            }

            return $todo;

        });

        $this->m_apiResponse->setData(new ToDoResource($todo));

        return $this->m_apiResponse->toResponse();
    }

    public function apiReadItem(RequestToDoReadItem $request)
    {
        $todo = $request->input('todo');

        $this->m_apiResponse->setData(new ToDoResource($todo));

        return $this->m_apiResponse->toResponse();

    }

    public function apiReadList(RequestToDoReadItems $request)
    {
        $object = $request->input('object');
//        dd($object);
        $todos = $object->todos()->get();
//        dd($todos);
        $this->m_apiResponse->setData(ToDoResource::collection($todos));

        return $this->m_apiResponse->toResponse();

    }


}
