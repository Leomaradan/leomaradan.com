<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use App\Models\Post\Tag;

class EditTagRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        $tag = ($this->id == null) ? Tag::findBySlug($this->slug)->first() : $this;

        switch($this->method())
        {
            case 'GET':
            case 'DELETE':
            {
                return [];
            }
            case 'POST':
            {
                return [
                    'name'  => 'required|min:3|unique:tags',
                    'slug'  => 'required|unique:tags'
                ];
            }
            case 'PUT':
            case 'PATCH':
            {
                return [
                    'name'  => 'required|min:3|unique:tags,name,' . $tag->id,
                    'slug'  => 'required|unique:tags,slug,' . $tag->id
                ];
            }
            default:break;
        }         
    }
}
