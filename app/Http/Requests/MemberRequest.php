<?php

// Controller namespacing.
namespace App\Http\Requests;

// Other.
use Illuminate\Foundation\Http\FormRequest;

class MemberRequest extends FormRequest
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
            'name'      =>  'required|string|max:255',
            'birthday'  =>  'required|before:'  . date('d-m-Y') . '|date_format:"Y-m-d"',
            'street'    =>  'required|string|max:255',
            'zip_code'  =>  'required|string|postal_code:NL,BE|max:6',
            'location'  =>  'required|string|max:255',
            'country'   =>  'required|string|min:2|max:2',
            'email'     =>  'required|email:rfc,dns|max:255',
            'phone'     =>  'nullable|string|phone|max:255',
            'mobile'    =>  'required|string|phone|max:255',
            'team_id'   =>  'required|numeric|min:1',
            'membership_id'   =>  'required|numeric|min:1',
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
            'birthday.before'       => 'Geboortedatum moet een dag voor vandaag zijn',
            'zip_code.postal_code'  => 'Postcode is ongeldig.',
            'zip_code.max'          => 'Postcode mag niet uit meer dan 6 tekens bestaan.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [

        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'birthday'      => \Carbon\Carbon::createFromFormat('d-m-Y', $this->birthday)->format('Y-m-d'),
            'zip_code'      => \Str::upper($this->zip_code),
        ]);
    }
}
