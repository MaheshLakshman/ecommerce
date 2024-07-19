<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VariantOption;
use App\Http\Requests\VariantOption\StoreVariantOptionRequest;
use App\Http\Requests\VariantOption\UpdateVariantOptionRequest;

class OptionController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request, $id)
    {
        return view('admin.variant-options.index', [
            'variantOptions' => VariantOption::where('variant_id', $id)->get(),
            'variantId' => $id
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.options.form', [
            'variantOption' => new VariantOption
        ])->render();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreVariantOptionRequest $request
     * @return void
     */
    public function store(StoreVariantOptionRequest $request)
    {
        $data = $request->validated();

        VariantOption::create([
            'name' => $data['name'],
            'variant_id' => $data['variant_id'],
        ]);

       return redirect()->route('options.index', $data['variant_id'])->with('status', "Variant Option Added");
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
        return view('admin.options.form', [
            'variant' => VariantOption::findOrFail($id)
        ])->render();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(UpdateVariantOptionRequest $request, $id)
    {
        $data = $request->validated();
        $updateData = [
            'name' => $data['name']
        ];
        VariantOption::findOrFail($id)->update($updateData);
        return response()->json([
            'status' => true,
            'message' => 'Variant option updated successfully'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        VariantOption::findOrFail($id)->delete();

        return response()->json([
            'status' => true,
            'message' => 'Variant option deleted successfully'
        ]);
    }


    public function table(Request $request)
    {
        $variants = $this->getVariantData();

        return view('admin.options.list', [
            'page' => ($request->page ?? 0) > 1 ? (($request->page - 1) * 10) : 0,
            'pageNum' => ($request->page ?? 0) > 1 ? ($request->page) : 1,
            'variants' => $variants
        ])->render();
    }

    public function getVariantData()
    {
        return VariantOption::orderBy('id', 'desc')->paginate(10);
    }
}
