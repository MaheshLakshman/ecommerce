<x-admin-layout>
    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">

                        <div class="d-flex text-end">
                            
                            <h5 class="mb-3 mt-3">Variants</h5>

                            <div class="col mb-3 mt-3">
                            <button type="button" class="btn btn-primary" onclick="openCreateModal();">
                                Add Variant
                            </button>
                        </div>
                        </div>


                        <div id="variantData">
                            @include('admin.variants.list', ['variants' => $variants, 'page' => $page])
                        </div>

                    </div>
                </div>

            </div>

        </div>
    </section>

    <div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" id="variantModal" tabindex="-1">
        <div class="modal-dialog modal-md modal-dialog-scrollable">
            <div class="modal-content" id="variantModalContent">

                <div class="d-flex justify-content-center mt-4 mb-4">
                    <div class="spinner-border" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
                
            </div>
        </div>
    </div><!-- End Large Modal-->

    @push('js')
    <script>
        var currentPage = 1;
        var page = 0

        const openCreateModal = function() {
            $('#variantModal').modal('show');
            $.ajax({
                url: '{{ route("variants.create") }}',
                success: function(result) {
                    $('#variantModalContent').html(result);
                }
            })
        }

        const saveVariant = function() {
            var formData = new FormData($('#variantForm')[0]);
            $.ajax({
                url: '{{ route("variants.store") }}',
                method: 'post',
                data: formData,
                contentType: false,
                processData: false,
                success: function(result) {
                    if (result.status === false) {
                        $('#variantModalContent').html(result.html);
                    } else {
                        $('#variantModal').modal('hide');
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
                url: "{{ URL::to('/variants/list') }}",
                data: query,
                success: function(result) {
                    $('#variantData').html(result);
                }
            })
        }
    </script>
    @endpush
</x-admin-layout>