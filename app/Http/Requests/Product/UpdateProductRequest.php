<?php

namespace App\Http\Requests\Product;

use App\Models\Product;
use App\Models\Variant;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateProductRequest extends FormRequest
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
            'image' => 'nullable|image',

            'products' => 'nullable|array',
            'products.*.price' => 'nullable|numeric',
            'products.*.quantity' => 'nullable|numeric',

            'productsNew' => 'nullable|array',
            'productsNew.*.options.*.price' => 'nullable|numeric',
            'productsNew.*.options.*.quantity' => 'nullable|numeric',
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
            'products.*.price.numeric' => trans('validation.numeric', [
                'attribute' => 'price'
            ]),

            'products.*.quantity.numeric' => trans('validation.numeric', [
                'attribute' => 'price'
            ]),

            'productsNew.*.options.*.price.numeric' => trans('validation.numeric', [
                'attribute' => 'price'
            ]),
            'productsNew.*.options.*.quantity.numeric' => trans('validation.numeric', [
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
        $products  = Product::with(['variant' => function ($q) {
            $q->with('productOption');
        }])->findOrFail(request()->route('id'))->toArray();
        $productData = $this->formatProduct($products);

        request()->flash();
        throw (new HttpResponseException(
            response()->json([
                'status' => false,
                'html' => view('admin.products.form', [
                    'product' => Product::findOrFail(request()->route('id')),
                    'variants' => Variant::has('options')->with('options')->get(),
                    'productData' => $productData
                ])->withErrors($validator)->render()
            ])
        ));
    }

    public function formatProduct(array $product)
    {
        $data = [];
        foreach ($product['variant'] ?? [] as $variant) {
            $variantOptId = $variant['product_option'][0]['id'] ?? null;
            if ($variantOptId) {
                $data[$variantOptId] = [
                    'product_variant_id' => $variant['id'],
                    'price' => $variant['price'],
                    'quantity' => $variant['quantity'],
                    'variant_id' => $variant['product_option'][0]['variant_id'] ?? null,
                    'variant_opt_id' => $variant['product_option'][0]['id'] ?? null,
                ];
            }
        }
        return $data;
    }


}
