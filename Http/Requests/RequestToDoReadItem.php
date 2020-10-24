<?php
declare(strict_types=1);

namespace ArtisanCloud\ToDoable\Http\Requests;

use App\Models\Tenants\ToDo;
use ArtisanCloud\ToDoable\ToDoService;
use ArtisanCloud\SaaSFramework\Exceptions\BaseException;
use ArtisanCloud\SaaSFramework\Http\Requests\RequestBasic;
use Illuminate\Validation\Rule;

class RequestToDoReadItem extends RequestBasic
{
    protected ToDoService $todoService;

    function __construct(ToDoService $todoService)
    {
        parent::__construct();

        $this->todoService = $todoService;
    }
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $todo = ToDoService::GetBy(['id'=>$this->input('id')]);
//        dd($todo);
        if(is_null($todo)){
            throw new BaseException(API_ERR_CODE_COMMENT_NOT_EXIST);
        }

        $this->getInputSource()->set('todo', $todo);

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id' => [
                'required',
                'int'
            ]
        ];
    }

    public function messages()
    {
        return [
            'id.required' => __("{$this->m_module}.required"),
            'id.int' => __("{$this->m_module}.int"),
//            'id.exists' => __("{$this->m_module}.exists"),
        ];
    }

}
