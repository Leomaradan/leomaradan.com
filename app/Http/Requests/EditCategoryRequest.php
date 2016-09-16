<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use App\Models\Post\Category;

class EditCategoryRequest extends FormRequest
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

        $category = ($this->id == null) ? Category::findBySlug($this->slug) : $this;

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
                    'name'  => 'required|min:3|unique:categories',
                    'slug'  => 'required|unique:categories' 
                ];
            }
            case 'PUT':
            case 'PATCH':
            {
                return [
                    'name'  => 'required|min:3|unique:categories,name,' . $category->id,
                    'slug'  => 'required|unique:categories,slug,' . $category->id 
                ];
            }
            default:break;
        }
    }
}
