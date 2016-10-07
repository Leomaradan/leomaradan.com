<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use App\Models\Link;

class EditLinkRequest extends FormRequest
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
                    'title'  => 'required|min:3',
                    'url'  => 'required|url',
                    'description' => 'required'
                ];
            }
            case 'PUT':
            case 'PATCH':
            {
                return [
                    'title'  => 'required|min:3',
                    'url'  => 'required|url',
                    'description' => 'required'
                ];
            }
            default:break;
        }         
    }
}
