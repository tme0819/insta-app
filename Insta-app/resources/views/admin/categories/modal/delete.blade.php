<div class="modal fade" id="delete-category-{{ $category->id }}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header border border-danger">
                <h3 class="h5 modal-title text-danger">
                    <i class="fa-solid fa-trash-can"></i> Delete Category
                </h3>
            </div>
            <div class="modal-body border border-danger">
                <p>Are you sure you want to delete <span class="fw-bold">{{ $category->name }} ?</span></p>

                <p class="text-muted">This action will affect all the posts under this category. Posts without category will fall under Uncategorized</p>

                <form action="{{ route('admin.categories.destroy', $category->id) }}" method="post">
                     @csrf
                     @method('Delete')
                     <div class="text-end">
                        <button type="button" class="btn btn-outline-danger btn-sm me-2" data-bs-dismiss="modal">
                        Cancel
                    </button>
                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                     </div>
                     
                </form>
            </div>

                    
                
            </div>
        </div>
    </div>
</div>