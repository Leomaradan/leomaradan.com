<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditRssFluxRequest extends FormRequest
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
                    'title' => 'required|max:255',
                    'url' => 'required|url|max:255|unique:rss_flux',                    
                    'category' => 'max:255',

                ];
            }
            case 'PUT':
            case 'PATCH':
            {
                return [
                    'title' => 'required|max:255',
                    'url' => 'required|url|max:255|unique:rss_flux,url,' . $this->id,
                    'category' => 'max:255',
                ];
            }
            default:break;
        }        
    }
}
