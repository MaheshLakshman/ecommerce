<table class="table table-bordered">
    <thead>
        <tr>
            <th>#</th>
            <th scope="col">Name</th>
            <th scope="col">Image</th>
            <th>Action</th>
        </tr>
    </thead>

    <tbody>
        @foreach($products as $productKey => $product)
        @php
        $p = $page++;
        @endphp
        <tr>
            <td>{{ $p+1 }}</td>

            <td>
                {{ $product['name'] ?? '' }} <br>
            </td>
            <td>
            <div class="float-start">
                    <img class="img-thumbnail" src="{{ $product->image ?? '' }}" style="min-width: 151px;max-height: 100px;" alt="image">
                </div>
            </td>
            <td>
                <button onclick="openEditModal('{{ $product->id }}');" class="btn btn-secondary btn-sm">Edit</button>
                <button onclick="deleteConfirmItem('{{ $product->id }}', 'Are you sure you want to delete {{ $product->name }} ?');" class="btn btn-danger btn-sm">Delete</button>
            </td>

        </tr>
        @endforeach

        @if(count($products) == 0)
        <tr>
            <td colspan="9" style="text-align: center;">No matching records found.</td>
        </tr>
        @endif
    </tbody>

</table>




<div class="row">
    <div class="cols">
        {{ $products->links('vendor.pagination.list') }}
    </div>
</div>