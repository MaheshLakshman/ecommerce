<x-admin-layout>
    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">

                        @if(session('status'))
                        <div id="success-msg">
                        <div id="statusMsg" class="alert alert-success alert-dismissible fade show mt-4" role="alert">
                            <i class="bi bi-check-circle me-1"></i>
                            {{ session('status') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        </div>
                        @endif

                        <div class="d-flex text-end">
                            <h5 class="mb-3 mt-3">Add Variant Options</h5>
                        </div>

                        <form id="variantForm" method="post" action="{{ route('options.store') }}">
                            @csrf
                            <div class="col-md-12">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" placeholder="Enter variant name">
                                @error('name')
                                <div class="invalid-feedback" style="margin-left: 1rem">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <input type="hidden" name="variant_id" value="{{ $variantId ?? '' }}">

                            <div class="mt-4">
                                <a href="{{ route('variants.index') }}" class="btn btn-secondary">Cancel</a>
                                <button type="Submit" class="btn btn-primary">Save</button>
                            </div>

                        </form>


                    </div>
                </div>

                <div class="card">
                    <div class="card-body">

                        <div class="d-flex text-end">
                            <h5 class="mb-3 mt-3">Variant Options</h5>
                        </div>


                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th scope="col">Name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @php $no = 1; @endphp
                                @foreach($variantOptions as $variantKey => $variantOption)

                                <tr>
                                    <td>{{ $no++ }}</td>

                                    <td>
                                        {{ $variantOption['name'] ?? '' }} <br>
                                    </td>
                                    <td>
                                        
                                    </td>

                                </tr>
                                @endforeach

                                @if(count($variantOptions) == 0)
                                <tr>
                                    <td colspan="9" style="text-align: center;">No matching records found.</td>
                                </tr>
                                @endif
                            </tbody>

                        </table>

                    </div>
                </div>

            </div>

        </div>
    </section>

    @push('js')
    <script>




    </script>
    @endpush
</x-admin-layout>