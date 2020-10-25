<?php
declare(strict_types=1);

namespace ArtisanCloud\ToDoable\Http\Requests;

use ArtisanCloud\ToDoable\Models\Tenants\ToDo;
use ArtisanCloud\ToDoable\ToDoService;
use ArtisanCloud\SaaSFramework\Exceptions\BaseException;
use ArtisanCloud\SaaSFramework\Http\Requests\RequestBasic;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class RequestToDoReadItems extends RequestBasic
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
        $strModelsNameSpace = config('artisancloud.framework.model_namespace');
        $objectClass = $strModelsNameSpace . Str::ucfirst($this->input('todoableType'));
        $object = $objectClass::where('uuid', $this->input('todoableId'))->first();
//        dd($object);
        if (is_null($object)) {
            throw new BaseException(API_ERR_CODE_OBJECT_NOT_EXIST);
        }

        $this->getInputSource()->set('object', $object);

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
            'todoableId' => [
                'required',
                'uuid'
            ],
            'todoableType' => [
                'required',
                'string'
            ]
        ];
    }

    public function messages()
    {
        return [
            'todoableId.required' => __("{$this->m_module}.required"),
            'todoableId.uuid' => __("{$this->m_module}.uuid"),
            'todoableType.required' => __("{$this->m_module}.required"),
            'todoableType.string' => __("{$this->m_module}.string"),
//            'todoUuid.exists' => __("{$this->m_module}.exists"),
        ];
    }

}
