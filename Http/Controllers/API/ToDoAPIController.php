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
    private $commentService;

    function __construct(Request $request, ToDoService $commentService)
    {

        // init the default value
        // parent will construction automatically
        parent::__construct($request);

        $this->commentService = $commentService;


    }


    public function apiCreate(RequestToDoCreate $request)
    {

        $comment = \DB::connection('pgsql')->transaction(function () use ($request) {

            try {
                $arrayData = $request->all();
                dd($arrayData);

                // check if artisan has registered artisan
                $comment = $this->commentService->createBy($arrayData);
//                dd($comment);
                if (is_null($comment)) {
                    throw new \Exception('', API_ERR_CODE_FAIL_TO_CREATE_PORTFOLIO);
                }

            } catch (\Exception $e) {
//                dd($e);
                throw new BaseException(
                    intval($e->getCode()),
                    $e->getMessage()
                );
            }

            return $comment;

        });

        $this->m_apiResponse->setData(new ToDoResource($comment));

        return $this->m_apiResponse->toResponse();
    }

    public function apiReadItem(RequestToDoReadItem $request)
    {
        $comment = $request->input('comment');

        $this->m_apiResponse->setData(new ToDoResource($comment));

        return $this->m_apiResponse->toResponse();

    }

    public function apiReadList(RequestToDoReadItems $request)
    {
        $object = $request->input('object');
//        dd($object);
        $comments = $object->comments()->get();
//        dd($comments);
        $this->m_apiResponse->setData(ToDoResource::collection($comments));

        return $this->m_apiResponse->toResponse();

    }


}
