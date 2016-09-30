<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditMenuRequest extends FormRequest
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

        //$page = ($this->id == null) ? Menu::findBySlug($this->slug) : $this;
        return [];
        /*switch($this->method())
        {
            case 'GET':
            case 'DELETE':
            {
                return [];
            }
            case 'POST':
            {
                return [
                    'title'     => 'required|min:5',
                    'slug'      => 'required|unique:pages',
                    'content'   => 'required|min:10' 
                ];
            }
            case 'PUT':
            case 'PATCH':
            {
                return [
                    'title'     => 'required|min:5',
                    'slug'      => 'required|unique:pages,slug,' . $page->id,
                    'content'   => 'required|min:10' 
                ];
            }
            default:break;
        }*/
    }
}
