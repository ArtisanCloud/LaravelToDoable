<?php
declare(strict_types=1);

namespace ArtisanCloud\ToDoable\Http\Requests;


use App\Services\ReleaseService\ReleaseService;
use ArtisanCloud\SaaSFramework\Exceptions\BaseException;
use ArtisanCloud\SaaSFramework\Http\Requests\RequestBasic;
use ArtisanCloud\SaaSFramework\Services\ArtisanCloudService;
use ArtisanCloud\ToDoable\Models\ToDo;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class RequestToDoCreate extends RequestBasic
{
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
        if (is_null($object)) {
            throw new BaseException(API_ERR_CODE_OBJECT_NOT_EXIST);
        }
        $this->getInputSource()->set('todoable_type', $objectClass);
        $this->getInputSource()->set('todoable', $object);

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
                'uuid',
            ],
            'todoableType' => [
                'required',
                'string',
            ],
            'assignedToUserUuid' => [
                'nullable',
                'int',
            ],
            'type' => [
                'int',
                Rule::in(ToDo::ARRAY_TYPE),
            ],
            'name' => 'string|max:50',
            'content' => 'string|max:500',
            'dueDate' => 'nullable|string|max:500',

        ];
    }

    public function messages()
    {
        return [
            'todoableId.string' => __("{$this->m_module}.string"),
            'todoableId.uuid' => __("{$this->m_module}.uuid"),
            'todoableType.required' => __("{$this->m_module}.required"),
            'todoableType.string' => __("{$this->m_module}.string"),
            'content.string' => __("{$this->m_module}.string"),
            'content.max' => __("{$this->m_module}.max"),

        ];
    }


}
