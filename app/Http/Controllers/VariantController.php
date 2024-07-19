<?php

namespace App\Http\Controllers;

use App\Models\Variant;
use Illuminate\Http\Request;
use App\Http\Requests\Variant\StoreVariantRequest;
use App\Http\Requests\Variant\UpdateVariantRequest;

class VariantController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $variants = $this->getVariantData();
        return view('admin.variants.index', [
            'page' => ($request->page ?? 0) > 1 ? ($request->page * 10) : 0,
            'pageNum' => ($request->page ?? 0) > 1 ? ($request->page) : 1,
            'variants' => $variants
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.variants.form', [
            'variant' => new Variant
        ])->render();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreVariantRequest $request
     * @return void
     */
    public function store(StoreVariantRequest $request)
    {
        $data = $request->validated();

        Variant::create([
            'name' => $data['name']
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Variant created successfully'
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
        return view('admin.variants.form', [
            'variant' => Variant::findOrFail($id)
        ])->render();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(UpdateVariantRequest $request, $id)
    {
        $data = $request->validated();
        $updateData = [
            'name' => $data['name']
        ];
        Variant::findOrFail($id)->update($updateData);
        return response()->json([
            'status' => true,
            'message' => 'Variant updated successfully'
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
        Variant::findOrFail($id)->delete();

        return response()->json([
            'status' => true,
            'message' => 'Variant deleted successfully'
        ]);
    }


    public function table(Request $request)
    {
        $variants = $this->getVariantData();

        return view('admin.variants.list', [
            'page' => ($request->page ?? 0) > 1 ? (($request->page - 1) * 10) : 0,
            'pageNum' => ($request->page ?? 0) > 1 ? ($request->page) : 1,
            'variants' => $variants
        ])->render();
    }

    public function getVariantData()
    {
        return Variant::orderBy('id', 'desc')->paginate(10);
    }
}
