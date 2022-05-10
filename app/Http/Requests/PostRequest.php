<?php

// Controller namespacing.
namespace App\Http\Requests;

// Other.
use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
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
        return [
            'title'             =>  'required|string|max:255|unique:posts,title' . (@$this->post->id ? ',' . $this->post->id : null),
            'intro'             =>  'required|string|max:255',
            'content'           =>  'required|string',
            'administrator_id'  =>  'required|numeric|min:1',
            'category_id'       =>  'required|numeric|min:1',

            'meta_title'        =>  'required|string|max:255|unique:pages,meta_title' . (@$this->post->id ? ',' . $this->post->id : null),
            'meta_description'  =>  'required|min:1|max:160',
            'meta_tags'         =>  'required|string|min:1',

            'og_title'          =>  'required|string|max:255',
            'og_description'    =>  'required|string|max:175',
            'og_url'            =>  'required|slug|max:255',
            'og_type'           =>  'required|string',
            'og_locale'         =>  'required|string',

            'status'            =>  'required|string|in:archived,draft,published,unpublished',
            'published_at'      =>  'required|date_format:"Y-m-d H:i:s"',
            'unpublished_at'    =>  'nullable|after:published_at|date_format:"Y-m-d H:i:s"',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'unpublished_at.after' => 'Datum moet na de publicatiedatum liggen.',
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        // Merge into request.
        $this->merge([
            'published'         => ($this->published !== null ? 1 : 0),
            'published_at'      => \Carbon\Carbon::createFromFormat('d-m-Y H:i', $this->published_at)->toDateTimeString(),
            'unpublished_at'    => \Carbon\Carbon::createFromFormat('d-m-Y H:i', $this->unpublished_at)->toDateTimeString(),
        ]);
    }
}
