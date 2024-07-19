<?php

namespace App\Http\Requests\Product;

use App\Models\Product;
use App\Models\Variant;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required',
            'description' => 'required',
            'image' => 'required|image',
            'variants' => 'nullable|array',
            'variants.*.options.*.price' => 'nullable|numeric',
            'variants.*.options.*.quantity' => 'nullable|numeric',
        ];
    }

     /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'variants.*.options.*.price.numeric' => trans('validation.numeric', [
                'attribute' => 'price'
            ]),
            'variants.*.options.*.quantity.numeric' => trans('validation.numeric', [
                'attribute' => 'quantity'
            ]),
        ];
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function failedValidation(Validator $validator)
    {
        request()->flash();
        throw (new HttpResponseException(
            response()->json([
                'status' => false,
                'html' => view('admin.products.form', [
                    'product' => new Product,
                    'variants' => Variant::has('options')->with('options')->get()
                ])->withErrors($validator)->render()
            ])
        ));
    }


}
