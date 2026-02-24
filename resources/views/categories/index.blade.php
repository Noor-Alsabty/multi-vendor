@extends('layouts.admin')

@section('title', 'Departments')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 fw-bold">Departments</h1>
            <p class="text-muted">List of all university departments</p>
        </div>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">
            <i class="fas fa-plus me-2"></i>Create New Department
        </button>
    </div>

    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Parent Department</th>
                        <th>Created At</th>

                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($categories as $categorie)
                        <tr>
                            <td>{{ $categorie->id }}</td>
                            <td>{{ $categorie->name }}</td>
                            <td>{{ $categorie->parent->name ?? '-' }}</td>
                            <td> {{ $categorie->created_at?->format('d/m/Y') ?? '-' }}</td>
<!-- 
<td>
    <img src="{{ $categorie->getFirstMediaUrl('category_images') ?: asset('images/default.png') }}"
         style="width:50px; height:50px; object-fit:cover; border-radius:5px;" />
</td> -->
                         
<td>
    @if($categorie->getFirstMediaUrl('category_images'))
        <img src="{{ $categorie->getFirstMediaUrl('category_images') }}" 
             alt="{{ $categorie->name }}" 
             style="width:50px; height:50px; object-fit:cover; border-radius:5px;">
    @else
        -
    @endif
</td>


                                            <td class="text-end">
                                <button class="btn btn-sm btn-info" data-bs-toggle="modal"
                                    data-bs-target="#viewModal{{ $categorie->id }}">
                                    <i class="fas fa-eye"></i> View
                                </button>
                                <button class="btn btn-sm btn-success" data-bs-toggle="modal"
                                    data-bs-target="#editModal{{ $categorie->id }}">
                                    <i class="fas fa-edit"></i> Edit
                                </button>
                                <button class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                    data-bs-target="#deleteModal{{ $categorie->id }}">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </td>
                        </tr>

                        <!-- View Modal -->
                        <div class="modal fade" id="viewModal{{ $categorie->id }}" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Department Details</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <dl class="row">
                                            <dt class="col-sm-3">ID </dt>
                                            <dd class="col-sm-9">{{ $categorie->id }}</dd>
                                            <dt class="col-sm-3">Name</dt>
                                            <dd class="col-sm-9">{{ $categorie->name }}</dd>
                                            <dt class="col-sm-3">Parent</dt>
                            
                                            <dd class="col-sm-9">{{ $categorie->parent->name ?? '-' }}</dd>
                                            <dt class="col-sm-3">Created</dt>
                                            <dd class="col-sm-9">{{ $categorie->created_at?->format('d/m/Y') ?? '-'}}</dd>
                                        </dl>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Edit Modal -->
                        <div class="modal fade" id="editModal{{ $categorie->id }}" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form method="POST" action="{{ route('categories.update', $categorie->id) }}"  enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-header">
                                            <h5 class="modal-title">Edit Department</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label class="form-label">category Name</label>
                                                <input type="text" name="name" class="form-control"
                                                    value="{{ $categorie->name }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Parent catgory</label>
                                                <select name="parent_id" class="form-select">
    <!-- خيار افتراضي بدون أب -->
    <option value="" {{ old('parent_id', $categorie->parent_id) == null ? 'selected' : '' }}>None</option>

    @foreach ($categories as $parent)
        <!-- منع اختيار نفسه كأب -->
        @if($parent->id != $categorie->id)
            <option value="{{ $parent->id }}" {{ old('parent_id', $categorie->parent_id) == $parent->id ? 'selected' : '' }}>
                {{ $parent->name }}
            </option>
        @endif
    @endforeach
</select>
   <div class="mb-3">
                                                <label class="form-label">Choose Image</label>
                                                <input type="file" name="image" class="form-control"
                                                    accept="image/*">
                                            </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-success">Update</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            </div>


   
<!-- Delete Modal -->
                        <div class="modal fade" id="deleteModal{{ $categorie->id }}" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form method="POST" action="{{ route('categories.delete', $categorie->id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <div class="modal-header">
                                            <h5 class="modal-title">Delete Department</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p>Are you sure you want to delete <strong></strong>?
                                            </p>
                                            <p class="text-danger small">This action cannot be undone.</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-danger">Delete</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="card-footer d-flex justify-content-between align-items-center">
            <small class="text-muted">Showing 1 to 7 of 7 results</small>
            <nav>
                <ul class="pagination pagination-sm mb-0">
                    <li class="page-item disabled"><a class="page-link" href="#">Previous</a></li>
                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                    <li class="page-item disabled"><a class="page-link" href="#">Next</a></li>
                </ul>
            </nav>
        </div>
    </div>

    <!-- Create Modal -->
    <div class="modal fade" id="createModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">

                <form method="POST" action="{{ route('categories.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Create New category</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">category Name</label>
                            <input type="text" name="name" class="form-control"
                                placeholder="Enter department name" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Parent category</label>
                            <select name="parent_id" class="form-select">

    <option value="">None</option>

    @foreach ($categories as $categori)
        <option value="{{ $categori->id }}">
            {{ $categori->name }}
        </option>
    @endforeach

</select>

                           <div class="mb-3">
                            <label class="form-label">Choose Image</label>
                            <input type="file" name="image" class="form-control" accept="image/*" >
                        </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
  <!-- رسائل بعد حذف الصنف -->
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
@endsection
