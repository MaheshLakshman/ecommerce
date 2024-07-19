<x-admin-layout>
    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <div id="success-msg"></div>
                        <div class="d-flex text-end">

                            <h5 class="mb-3 mt-3">Products</h5>

                            <div class="col mb-3 mt-3">
                                <button type="button" class="btn btn-primary" onclick="openCreateModal();">
                                    Add Product
                                </button>
                            </div>
                        </div>


                        <div id="productData">
                            @include('admin.products.list', ['products' => $products, 'page' => $page])
                        </div>

                    </div>
                </div>

            </div>

        </div>
    </section>

    <div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" id="productModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content" id="productModalContent">

                <div class="d-flex justify-content-center mt-4 mb-4">
                    <div class="spinner-border" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>

            </div>
        </div>
    </div><!-- End Large Modal-->

    <div id="modalDelete"></div>

    @push('js')
    <script>
        var currentPage = 1;
        var page = 0

        const openCreateModal = function() {
            $('#productModal').modal('show');
            $.ajax({
                url: '{{ route("products.create") }}',
                success: function(result) {
                    $('#productModalContent').html(result);
                    preview();
                }
            })
        }

        const saveProduct = function() {
            var formData = new FormData($('#productForm')[0]);
            $.ajax({
                url: '{{ route("products.store") }}',
                method: 'post',
                data: formData,
                contentType: false,
                processData: false,
                success: function(result) {
                    if (result.status === false) {
                        $('#productModalContent').html(result.html);
                        preview();
                    } else {
                        $('#productModal').modal('hide');
                        getData(currentPage);
                        //Alert.show(result.message, 'success');
                    }
                }
            })
        }

        const getData = function(page = 1, pageCount = 10) {
            currentPage = page;
            let query = {
                page: page,
                pageCount: pageCount
            }
            getDataList(query);
        }

        function getDataList(query) {
            $.ajax({
                url: "{{ URL::to('/products/list') }}",
                data: query,
                success: function(result) {
                    $('#productData').html(result);
                }
            })
        }

        const openEditModal = function(id) {
            $('#productModal').modal('show');
            $.ajax({
                url: '{{ url("products/edit") }}/' + id,
                success: function(result) {
                    $('#productModalContent').html(result);
                    preview();
                }
            })
        }

        const saveProductEdit = function(id) {
            var formData = new FormData($('#productForm')[0]);
            $.ajax({
                url: '{{ url("products/edit") }}/' + id,
                method: 'post',
                data: formData,
                contentType: false,
                processData: false,
                success: function(result) {
                    if (result.status === false) {
                        $('#productModalContent').html(result.html);
                        preview();
                    } else {
                        $('#productModal').modal('hide');
                        getData(currentPage);
                    }
                }
            })
        }

        const deleteProduct = function(id) {
            $.ajax({
                url: '{{ url("products/delete") }}/' + id,
                method: 'delete',
                data: {
                    "_token": "{{ csrf_token() }}"
                },
                success: function(result) {
                    if (result.status) {
                        $('#deleteModal' + id).modal('hide');
                        getData(currentPage);
                        Alert.show('#statusMsg', result.message);
                    }
                }
            });

        }

        function preview() {
            var file = document.getElementById("image");
            var prevImage = $("#prod-image").attr("src");
            file.addEventListener("change", function() {
                var filePath = URL.createObjectURL(event.target.files[0]);
                $("#prod-image").attr("src", filePath);
            }, false);
        }
    </script>
    @endpush
</x-admin-layout>