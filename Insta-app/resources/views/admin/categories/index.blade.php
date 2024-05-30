@extends('layouts.app')

@section('title', 'Admin: Categories')

@section('content')
<form action="{{ route('admin.categories.store')}}" method="post" class="mb-4">
    @csrf
    <div class="d-flex">
        <input type="text" name="name" id="name" class="form-control w-25 me-3" autofocus placeholder="Add a Category...">

        <button type="submit" class="btn btn-primary">
            <i class="fa-solid fa-plus"></i>
        </button>
        
       
    </div>
    @error('name')
        <p class="text-danger small">{{ $message }}</p>
    @enderror
</form>

<table class="table table-hover align-middle bg-white border text-secondary">
    <thead class="small table-warning bg-transparent-50 text-secondary">
        <tr>
            <th>#</th>
            <th>NAME</th>
            <th>COUNT</th>
            <th>LAST UPDATED</th>
            <th></th>
        </tr>
    </thead>

    <tbody>
        @forelse ($all_categories as $category)
            <tr>
                <td>
                    {{ $category->id}}
                </td>
                <td>
                     {{ $category->name }}
                </td>
                <td>
                    {{ $category->categoryPost->count() }}
                </td>

                <td>
                    {{ date('M d, Y', strtotime($category->updated_at)) }}
                </td>

                <td>
                    <button class="btn btn-outline-warning" data-bs-toggle="modal" data-bs-target="#edit-category-{{ $category->id }}">
                        <i class="fa-solid fa-pen-to-square"></i>
                    </button>
                    
                    <button class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#delete-category-{{ $category->id }}">
                        <i class="fa-solid fa-trash-can"></i>
                    </button>
                </td>

                
                    {{-- include deactivate modal --}}
                    @include('admin.categories.modal.edit')
                    @include('admin.categories.modal.delete')
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="lead text-muted text-center">No Categories found.</td>
            </tr>
        @endforelse
        <tr>
            <td></td>
            <td class="text-dark fw-bold">
                Uncategorized
                <p class="xsmall mb-0 text-muted">Hidden posts are not included</p>
            </td>
            <td>{{ $uncategorized_count }}</td>
            <td></td>
            <td></td>
        </tr>
    </tbody>
</table>
 {{ $all_categories->links() }}
@endsection