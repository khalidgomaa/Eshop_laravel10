@extends('admin.layouts.app')
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Dashboard</h1>
            </div>
            <div class="col-sm-6">

            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</section>
<!-- Main content -->
<section class="content-header">
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Edit Category</h1>
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
    <!-- Default box -->

    <div class="container-fluid">

        <form action="" method="post" id="categoryForm" name="categoryForm">
            @csrf
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name">Name</label>
                                <input type="text" name="name" id="name" class="form-control" placeholder="Name"
                                    value="{{ $category->name }}">
                                <p></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="email">Slug</label>
                                <input type="text" name="slug" id="slug" class="form-control" placeholder="Slug"
                                    value="{{ $category->slug }}">
                                <p></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <input type="hidden" name="image_id" id="image_id" value="">
                            <label for="image">Image</label>
                            <div id="image" class="dropzone dz-clickable">
                                <div class="dz-message needsclick">
                                    Drop files here or click to upload
                                </div>
                            </div>
                            @if(!empty($category))
                            <div>
                                <img class="m-2" width="120" height="120" src="{{ asset('uploads/category/' . $category->image) }}" alt="">
                            </div>

                            @endif

                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="email">Status</label>
                            <select name="status" id="status" class="form-control">
                                <option value="1" {{ $category->status == 1 ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ $category->status == 0 ? 'selected' : '' }}>Block</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
    </div>
    <div class="pb-5 pt-3">
        <button type="submit" class="btn btn-primary">Update</button>

        <a href="{{ route('categories.index') }}" class="btn btn-outline-dark ml-3">Cancel</a>

    </div>
    </form>
    </div>

    <!-- /.card -->
</section>
<!-- /.content -->

@endsection


@section('customsJs')
<script>
    $("#categoryForm").submit(function(event){
                event.preventDefault();
                var element= $(this);
                $('button[type=submit]').prop('disabled', true);

                $.ajax({
                    url:'{{ route("category.update","$category->id") }}',
                    type:'put',
                    data: element.serializeArray(),
                    datatype:'json',
              
                    success:function(response){
                        $('button[type=submit]').prop('disabled', false);
                         var errors=response['errors']
                        if (response['status']==true){
                            window.location.href='{{ route("categories.index") }}';
                            $("#name").removeClass('is-invalid')
                            .siblings('p').removeClass('invalid-feedback')
                            .html(errors['']); 

                            $("#slug").removeClass('is-invalid')
                            .siblings('p').removeClass('invalid-feedback')
                            .html(errors['']); 
                            window.location.href="{{ route('categories.index') }}";
                        }else{
                        if (errors['name']){
                            $("#name").addClass('is-invalid')
                            .siblings('p').addClass('invalid-feedback')
                            .html(errors['name']);

                        }else{
                            $("#name").removeClass('is-invalid')
                            .siblings('p').removeClass('invalid-feedback')
                            .html(errors['']); 
                        }
                        
                        if (errors['slug']){
                            $("#slug").addClass('is-invalid')
                            .siblings('p').addClass('invalid-feedback')
                            .html(errors['slug']);

                        }else{
                            $("#slug").removeClass('is-invalid')
                            .siblings('p').removeClass('invalid-feedback')
                            .html(errors['']); 
                        }}
                    },
                    error:function(jqxHR,exception){
                        console.log("something went wrong");
                    }


                    })
                }) 

                $("#name").change(function(event) {
                    event.preventDefault();
                    var element = $(this);
                    var title = element.val(); 
                 $('button[type=submit]').prop('disabled', true);


                    $.ajax({
                        url: '{{ route("getSlug") }}',
                        type: 'GET',
                        data: { title: title }, 
                        dataType: 'json',
                        success: function(response) {
                $('button[type=submit]').prop('disabled', false);

                            if (response['status'] == true) {
                                $("#slug").val(response['slug']);
                            }
                        }
                                    });
                                });

             Dropzone.autoDiscover = false;
              /**
     * Setup dropzone
     */
    const dropzone = $('#image').dropzone({
        init: function() 
        {
            // myDropzone = this;

            // when file is dragged in
            this.on('addedfile', function(file) { 
                if(this.files.length>1){
                        // this.removeFile(this.files[0]);
                }
            });
        },
        // previewTemplate: $('#dzPreviewContainer').html(),
        url: "{{ route('temp-image.create') }}",
        addRemoveLinks: true,
        // autoProcessQueue: false,       
        // uploadMultiple: false,
        parallelUploads: 1,
        maxFiles: 1,
        paramName: 'image',
        acceptedFiles: '.jpeg, .jpg, .png, .gif',
        // thumbnailWidth: 900,
        // thumbnailHeight: 600,
        // previewsContainer: "#previews",
        timeout: 0,
        headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
    
        success: function(file, response) 
        {
        $("#image_id").val(response.image_id)
        }
    });

</script>

@endsection