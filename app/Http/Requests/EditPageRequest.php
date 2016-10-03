<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use App\Models\Page;

class EditPageRequest extends FormRequest
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

        $page = ($this->id == null) ? Page::findBySlug($this->slug)->first() : $this;

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
                    'title'     => 'required|min:3',
                    'slug'      => 'required|unique:pages',
                    'content'   => 'required' 
                ];
            }
            case 'PUT':
            case 'PATCH':
            {
                return [
                    'title'     => 'required|min:3',
                    'slug'      => 'required|unique:pages,slug,' . $page->id,
                    'content'   => 'required' 
                ];
            }
            default:break;
        }
    }
}
