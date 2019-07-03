<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

class TopicRequest extends Request
{
    public function rules()
    {
        switch($this->method())
        {
            // CREATE
            case 'POST':
            {
                return [
                    'title' => 'required|min:2',
                    'category_id' => ['required', Rule::exists('categories', 'id')],
                    'body' => 'required|min:3'
                ];
            }
            // UPDATE
            case 'PUT':
            case 'PATCH':
            {
                return [
                    // UPDATE ROLES
                ];
            }
            case 'GET':
            case 'DELETE':
            default:
            {
                return [];
            };
        }
    }

    public function attributes()
    {
        return [
            'title' => '帖子标题',
            'category_id' => '分类',
            'body' => '帖子内容',
        ];
    }
}
