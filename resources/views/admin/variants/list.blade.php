<table class="table table-bordered">
    <thead>
        <tr>
            <th>#</th>
            <th scope="col">Name</th>
            <th>Action</th>
        </tr>
    </thead>

    <tbody>
        @foreach($variants as $variantKey => $variant)
        @php
        $p = $page++;
        @endphp
        <tr>
            <td>{{ $p+1 }}</td>

            <td>
                {{ $variant['name'] ?? '' }} <br>
            </td>
            <td>
                <a href="{{ route('options.index', $variant->id) }}" class="btn btn-secondary btn-sm">Add Option</a>
            </td>

        </tr>
        @endforeach

        @if(count($variants) == 0)
        <tr>
            <td colspan="9" style="text-align: center;">No matching records found.</td>
        </tr>
        @endif
    </tbody>

</table>




<div class="row">
    <div class="cols">
        {{ $variants->links('vendor.pagination.list') }}
    </div>
</div>