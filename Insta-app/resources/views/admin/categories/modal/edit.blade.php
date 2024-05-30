<div class="modal fade" id="edit-category-{{ $category->id }}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header border border-warning">
                <h3 class="h5 modal-title text-dark">
                    <i class="fa-solid fa-pen-to-square"></i> Edit Category
                </h3>
            </div>
            <div class="modal-body border border-warning">
                <form action="{{ route('admin.categories.update', $category->id) }}" method="post">
                     @csrf
                     @method('PATCH')
                     <input type="text" name="updatename" id="name" class="form-control mb-3" value="{{ old('name', $category->name) }}">
                     <div class="text-end">
                        <button type="button" class="btn btn-outline-warning btn-sm me-2" data-bs-dismiss="modal">
                        Cancel
                    </button>
                    <button type="submit" class="btn btn-warning btn-sm">Update</button>
                     </div>
                     
                </form>
            </div>

                    
                
            </div>
        </div>
    </div>
</div>