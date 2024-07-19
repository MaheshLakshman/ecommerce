<div class="modal-header">
    <h5 class="modal-title">@if($product->id) Edit @else Add @endif Product</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
    <form class="row g-3" id="productForm">
        @csrf
        <div class="col-md-12">
            <label for="name" class="form-label">Name<span class="text-danger"> *</span></label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" placeholder="Enter product name" value="{{ old('name', $product->name) }}">
            @error('name')
            <div class="invalid-feedback" style="margin-left: 1rem">
                {{ $message }}
            </div>
            @enderror
        </div>

        <div class="col-md-12">
            <label for="description" class="form-label">Description<span class="text-danger"> *</span></label>
            <textarea class="form-control @error('description') is-invalid @enderror" name="description" id="description" cols="30" rows="3">{{ old('name', $product->description) }}</textarea>
            @error('description')
            <div class="invalid-feedback" style="margin-left: 1rem">
                {{ $message }}
            </div>
            @enderror
        </div>

        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6">
                    <label for="image" class="form-label">Image @if($product->id) @else<span class="text-danger"> *</span>@endif </label>
                    <input class="form-control @error('image') is-invalid @enderror" type="file" name="image" id="image">
                    @error('image')
                    <div class="invalid-feedback" style="margin-left: 1rem">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <div class="float-start">
                        <img class="img-thumbnail" src="{{ $product->image ?? '' }}" id="prod-image" style="min-width: 151px;max-height: 100px;" alt="image">
                    </div>
                </div>
            </div>
        </div>

        @foreach($variants ?? [] as $keyVariant => $variant)
        <h6 class="fs-5" style="font-weight: bold; color:crimson">{{ $variant->name ?? '' }}</h6>

        @foreach($variant['options'] as $optionKey => $option)
        @php
            if($product->id)
            {
                if($productData[$option->id]['product_variant_id'] ?? 0)
                {
                    $namePrice = 'products['.$productData[$option->id]['product_variant_id'].'][price]';
                    $nameOld = 'products.'.$productData[$option->id]['product_variant_id'].'.price';

                    $nameQty = 'products['.$productData[$option->id]['product_variant_id'].'][quantity]';
                    $oldQty = 'products.'.$productData[$option->id]['product_variant_id'].'.quantity';
                }
                else{
                    $namePrice = 'productsNew['.$variant->id.'][options]['.$option->id.'][price]';
                    $nameOld = 'productsNew.'.$variant->id.'.options.'.$option->id.'.price';

                    $nameQty = 'productsNew['.$variant->id.'][options]['.$option->id.'][quantity]';
                    $oldQty = 'productsNew.'.$variant->id.'.options.'.$option->id.'.quantity';
                }
               
            }
            else {
                $namePrice = 'variants['.$variant->id.'][options]['.$option->id.'][price]';
                $nameOld = 'variants.'.$variant->id.'.options.'.$option->id.'.price';

                $nameQty = 'variants['.$variant->id.'][options]['.$option->id.'][quantity]';
                $oldQty = 'variants.'.$variant->id.'.options.'.$option->id.'.quantity';
            }
        @endphp
        <div class="col-md-12 mb-1">
            <div class="row">

                <div class="col mt-4">
                    <h6 class="fs-6" style="font-weight: bold;">{{ $option->name ?? '' }}</h6>
                </div>


                <div class="col">
                    <label for="price" class="form-label">Price</label>
                    <input type="text" class="form-control @error($nameOld) is-invalid @enderror" name="{{ $namePrice }}" 
                    id="price" placeholder="Enter product price" value="{{ old($nameOld, ($productData[$option->id]['price'] ?? '')) }}">
                    @error($nameOld)
                    <div class="invalid-feedback" style="margin-left: 1rem">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="col">
                    <label for="quantity" class="form-label">Quantity</label>
                    <input type="text" class="form-control @error($oldQty) is-invalid @enderror" 
                    name="{{ $nameQty }}" id="quantity" 
                    placeholder="Enter product quantity" value="{{ old($oldQty, ($productData[$option->id]['quantity'] ?? '')) }}">
                    @error($oldQty)
                    <div class="invalid-feedback" style="margin-left: 1rem">
                        {{ $message }}
                    </div>
                    @enderror
                </div>


            </div>
        </div>
        @endforeach

        @endforeach



    </form>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
    @if($product->id)
    <button type="button" onclick="saveProductEdit('{{ $product->id }}');" class="btn btn-primary">Update</button>
    @else
    <button type="button" onclick="saveProduct();" class="btn btn-primary">Save</button>
    @endif

</div>