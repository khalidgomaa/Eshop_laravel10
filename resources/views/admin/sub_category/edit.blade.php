@extends('admin.layouts.app')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Dashboard</h1>
            </div>


        </div>
    </div>
    <!-- /.container-fluid -->
</section>
<section class="content-header">
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Edite Sub_Category</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{ route('categories.index') }}" class="btn btn-primary">Back</a>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</section>
<!-- Main content -->
<section class="content">
    <!-- Create Sub Category -->
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('sub_category.store') }}" method="post" id="sub_categoryForm"
                    name="sub_categoryForm">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">

                                <label for="category">Category</label>
                                <select name="category_id" id="category" class="form-control">
                                    @foreach ($categories as $category)

                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                <p></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name">Name</label>
                                <input type="text" name="name" id="name" class="form-control" placeholder="Name"
                                value="{{ $sub_category->name }}">
                                <p></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="slug">Slug</label>
                                <input type="text" name="slug" id="slug" class="form-control" placeholder="Slug"
                                value="{{ $sub_category->slug }}">
                                <p></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="email">Status</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="1" {{ $sub_category->status == 1 ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ $sub_category->status == 0 ? 'selected' : '' }}>Block</option>
          
                                </select>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="pb-5 pt-3">
            <button type="submit" class="btn btn-primary" id="editSubCategoryBtn">Create</button>
            <a href="{{ route('sub_categories.index') }}" class="btn btn-outline-dark ml-3">Cancel</a>
        </div>
    </div>
    <!-- /.card -->
</section>
<!-- /.content -->
@endsection

@section('customsJs')
<script>
    $(document).ready(function() {
            $("#editSubCategoryBtn").click(function(event) {
                event.preventDefault();
                $(this).prop('disabled', true);

                $.ajax({
                    url:'{{ route("sub_category.update","$sub_category->id") }}',
                    type: 'put',
                    data: $('#sub_categoryForm').serialize(),
                    dataType: 'json',
                    success: function(response) {
                        $("#createSubCategoryBtn").prop('disabled', false);
                        if (response.status==true) {
                            window.location.href = '{{ route("sub_categories.index") }}';
                        } else {
                            if (response.errors) {
                                $.each(response.errors, function(key, value) {
                                    $("#" + key).addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(value);
                                });
                            }
                        }
                    },
                    error: function(jqXHR, exception) {
                        console.log("Something went wrong");
                    }
                });
            });

            $("#name").change(function(event) {
                event.preventDefault();
                var element = $(this);
                var title = element.val(); 
                $('#createSubCategoryBtn').prop('disabled', true);

                $.ajax({
                    url: '{{ route("getSlug") }}',
                    type: 'GET',
                    data: { title: title }, 
                    dataType: 'json',
                    success: function(response) {
                        $('#editSubCategoryBtn').prop('disabled', false);
                        if (response.status) {
                            $("#slug").val(response.slug);
                        }
                    }
                });
            });
        });
</script>
@endsection