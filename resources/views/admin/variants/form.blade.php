<div class="modal-header">
    <h5 class="modal-title">Add Variant</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
    <form class="row g-3" id="variantForm">
        @csrf
        <div class="col-md-12">
            <label for="name" class="form-label">Variant Name</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" placeholder="Enter variant name">
            @error('name')
            <div class="invalid-feedback" style="margin-left: 1rem">
                {{ $message }}
            </div>
            @enderror
        </div>



    </form>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
    <button type="button" onclick="saveVariant();" class="btn btn-primary">Save</button>
</div>