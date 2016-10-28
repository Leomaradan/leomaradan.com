<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use App\Models\Post\Post;

class EditPostRequest extends FormRequest
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
        $post = ($this->id == null) ? Post::findBySlug($this->slug)->first() : $this;

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
                    'title'     => 'required|min:1',
                    'content'   => 'required|min:5',
                    'slug'  => 'required|unique:posts'
                ];
            }
            case 'PUT':
            case 'PATCH':
            {
                return [
                    'title'     => 'required|min:1',
                    'content'   => 'required|min:5',
                    'slug'  => 'required|unique:posts,slug,' . $post->id
                ];
            }
            default:break;
        }          
    }
}
