<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Article;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class UpdateArticleRequest.
 */
class UpdateArticleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return boolean
     */
    public function authorize()
    {
        $article = $this->route('article');

        return $article && $this->user()->can('update', $article);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ];
    }
}
