<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Variant;
use Illuminate\Http\Request;
use App\Models\ProductVariant;
use Illuminate\Support\Facades\DB;
use App\Models\VariantOptionProduct;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;

class ProductController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $products = $this->getProductData();
        return view('admin.products.index', [
            'page' => ($request->page ?? 0) > 1 ? ($request->page * 10) : 0,
            'pageNum' => ($request->page ?? 0) > 1 ? ($request->page) : 1,
            'products' => $products
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.products.form', [
            'product' => new Product,
            'variants' => Variant::has('options')->with('options')->get()
        ])->render();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreProductRequest $request
     * @return void
     */
    public function store(StoreProductRequest $request)
    {
        $data = $request->validated();

        if ($request->file('image')) {
            $image_path = $request->file('image')->store('uploads/products', 'public');
        } else {
            $image_path = null;
        }

        DB::transaction(function () use ($data, $image_path) {
            $product = Product::create([
                'name' => $data['name'],
                'description' => $data['description'],
                'image' => $image_path
            ]);
            if ($product) {
                foreach ($data['variants'] ?? [] as $variant) {

                    foreach ($variant['options'] as $optionKey => $option) {
                        if ($option['price']) {
                            $ProductVariant = ProductVariant::create([
                                'product_id' => $product['id'],
                                'price' => $option['price'] ?? 0,
                                'quantity' => $option['quantity'] ?? 0,
                            ]);

                            $variantOptionProduct = new VariantOptionProduct;
                            $variantOptionProduct->variant_option_id = $optionKey;
                            $variantOptionProduct->product_variant_id = $ProductVariant->id;
                            $variantOptionProduct->save();
                        }
                    }
                }
            }
        });

        return response()->json([
            'status' => true,
            'message' => 'Product created successfully'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $products  = Product::with(['variant' => function ($q) {
            $q->with('productOption');
        }])->findOrFail($id)->toArray();
        $productData = $this->formatProduct($products);

        return view('admin.products.form', [
            'product' => Product::findOrFail($id),
            'variants' => Variant::has('options')->with('options')->get(),
            'productData' => $productData
        ])->render();
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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(UpdateProductRequest $request, $id)
    {
        $data = $request->validated();
        $updateData = [
            'name' => $data['name'],
            'description' => $data['description']
        ];
        if ($request->hasFile('image')) {
            $updateData['image'] = $request->file('image')->store('uploads/products', 'public');
        }

        DB::transaction(function () use ($data, $id, $updateData) {
            Product::findOrFail($id)->update($updateData);

            foreach ($data['products'] ?? [] as $productVarKey => $productVar) {
                ProductVariant::where('id', $productVarKey)->update([
                    'price' => $productVar['price'],
                    'quantity' => $productVar['quantity'],
                ]);
            }
            $this->addNewProduct($data['productsNew'] ?? [], $id);
        });

        return response()->json([
            'status' => true,
            'message' => 'Product updated successfully'
        ]);
    }

    public function addNewProduct($variants = [], $id)
    {
        if ($id) {
            foreach ($variants as $variant) {

                foreach ($variant['options'] as $optionKey => $option) {
                    if ($option['price']) {
                        $ProductVariant = ProductVariant::create([
                            'product_id' => $id,
                            'price' => $option['price'] ?? 0,
                            'quantity' => $option['quantity'] ?? 0,
                        ]);

                        $variantOptionProduct = new VariantOptionProduct;
                        $variantOptionProduct->variant_option_id = $optionKey;
                        $variantOptionProduct->product_variant_id = $ProductVariant->id;
                        $variantOptionProduct->save();
                    }
                }
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        Product::findOrFail($id)->delete();

        return response()->json([
            'status' => true,
            'message' => 'Product deleted successfully'
        ]);
    }


    public function table(Request $request)
    {
        $products = $this->getProductData();

        return view('admin.products.list', [
            'page' => ($request->page ?? 0) > 1 ? (($request->page - 1) * 10) : 0,
            'pageNum' => ($request->page ?? 0) > 1 ? ($request->page) : 1,
            'products' => $products
        ])->render();
    }

    public function getProductData()
    {
        return Product::orderBy('id', 'desc')->paginate(10);
    }
}
