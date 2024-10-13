@extends('admin.layouts.app')
@section('content')

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
                <h1>Create Product</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="products.html" class="btn btn-primary">Back</a>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</section>
<!-- Main content -->
<section class="content">
    <!-- Default box -->
    <div class="container-fluid">
        <form action="" method="post" id="productForm">
            <div class="row">
                <div class="col-md-8">
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="title">Title</label>
                                        <input type="text" name="title" id="title" class="form-control"
                                            placeholder="Title">
                                        <p class="error"></p>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="title">Slug</label>
                                        <input type="text" readonly name="slug" id="slug" class="form-control"
                                            placeholder="slug">
                                        <p class="error"></p>
                                    </div>

                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="description">Description</label>
                                        <textarea name="description" id="description" cols="30" rows="10"
                                            class="summernote" placeholder="Description"></textarea>
                                        <p class="error"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-3">
                        <div class="card-body">
                            <h2 class="h4 mb-3">Media</h2>
                            <div id="image" class="dropzone dz-clickable">
                                <div class="dz-message needsclick">
                                    <br>Drop files here or click to upload.<br><br>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row" id="product-gallary">

                    </div>
                    <div class="card mb-3">
                        <div class="card-body">
                            <h2 class="h4 mb-3">Pricing</h2>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="price">Price</label>
                                        <input type="text" name="price" id="price" class="form-control"
                                            placeholder="Price">
                                        <p class="error"></p>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="compare_price">Compare at Price</label>
                                        <input type="text" name="compare_price" id="compare_price" class="form-control"
                                            placeholder="Compare Price">
                                        {{-- <p class="error"></p> --}}
                                        <p class="text-muted mt-3">
                                            To show a reduced price, move the product’s original price into Compare at
                                            price. Enter a lower value into Price.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-3">
                        <div class="card-body">
                            <h2 class="h4 mb-3">Inventory</h2>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="sku">SKU (Stock Keeping Unit)</label>
                                        <input type="text" name="sku" id="sku" class="form-control" placeholder="sku">
                                        <p class="error"></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="barcode">Barcode</label>
                                        <input type="text" name="barcode" id="barcode" class="form-control"
                                            placeholder="Barcode">
                                        <p class="error"></p>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <div class="custom-control custom-checkbox">
                                            <input type="hidden" name="track_qty" value="No">
                                            <input class="custom-control-input" type="checkbox" id="track_qty"
                                                name="track_qty" value="Yes" checked>
                                            <label for="track_qty" class="custom-control-label">Track Quantity</label>
                                        </div>

                                    </div>
                                    <div class="mb-3">
                                        <input type="number" min="0" name="qty" id="qty" class="form-control"
                                            placeholder="Qty">
                                        <p class="error"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h2 class="h4 mb-3">Product status</h2>
                            <div class="mb-3">
                                <select name="status" id="status" class="form-control">
                                    <option value="1">Active</option>
                                    <option value="0">Block</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <h2 class="h4  mb-3">Product category</h2>
                            <div class="mb-3">
                                <label for="category">Category</label>
                                <select name="category" id="category" class="form-control">
                                    <option>select a category</option>
                                    @if ($categories->isNotEmpty() )
                                    @foreach ( $categories as $category)
                                    <option value=" {{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach

                                    @endif


                                </select>
                                <p class="error"></p>
                            </div>
                            <div class="mb-3">
                                <label for="sub_category">Sub category</label>
                                <select name="sub_category" id="sub_category" class="form-control">

                                    <option value="">select a sub category</option>


                                </select>

                            </div>
                        </div>
                    </div>
                    <div class="card mb-3">
                        <div class="card-body">
                            <h2 class="h4 mb-3">Product brand</h2>
                            <div class="mb-3">
                                <select name="brand" id="brand" class="form-control">
                                    <option value="">select a brand</option>
                                    @if ($brands->isNotEmpty())
                                    @foreach ( $brands as $brand)
                                    <option value=" {{ $brand->id }}">{{ $brand->name }}</option>
                                    @endforeach
                                    @endif
                                </select>

                            </div>
                        </div>
                    </div>
                    <div class="card mb-3">
                        <div class="card-body">
                            <h2 class="h4 mb-3">Featured product</h2>
                            <div class="mb-3">
                                <select name="is_featured" id="is_featured" class="form-control">
                                    <option value="Yes">Yes</option>
                                    <option value="No">No</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="pb-5 pt-3 d-flex align-items-center">
                <button id="createProductBtn" type="submit" class="btn btn-primary">Create</button>
                <div id="loader" style="display: none;" class="spinner-border text-primary ml-3" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
                <a href="{{ route('products.index') }}"  class="btn btn-outline-dark ml-3">Cancel</a>

        
            </div>

        </form>
    </div>
    <!-- /.card -->
</section>
<!-- /.content -->
@endsection

@section('customsJs')
<script>
    // Handle form submission
    $("#productForm").submit(function(event) {
        event.preventDefault();
        var element = $(this);
        $("#loader").show();
        $("#createProductBtn").hide();
        // $('#createProductBtn').prop('disabled', true);
        $.ajax({
            url: "{{ route('product.store') }}",
            type: 'post',
            data: element.serializeArray(),
            dataType: 'json',
            success: function(response) {
                if (response['status'] == true) {
                    $("#loader").hide();
                    $("#createProductBtn").show();
                    window.location.href = '{{ route("products.index") }}';

                    $(".error").removeClass("invalid-feedback").html('');
                    $("input[type='text'], select, input[type='number']").removeClass("is-invalid");
                   

                } else {
                    console.log(response.errors);
                    $("#loader").hide();
                    $("#createProductBtn").show();
                    var errors = response['errors'];
                    $("input[type='text'], select, input[type='number']").removeClass("is-invalid");
                    $(".error").removeClass("invalid-feedback").html('');
                    if (errors) {
                        $.each(errors, function(key, error) {
                            $(`#${key}`).addClass("is-invalid").siblings("p").addClass("invalid-feedback").html(error);
                        });
                    }
                }
            },
            error: function(jqXHR, exception) {
                $("#loader").hide();
                $("#createProductBtn").show();
                console.log("Something went wrong", jqXHR);
            }
        });
    });

    // For getting all subcategories related to a specific category
    $("#category").change(function(event) {
        event.preventDefault();
        var category_id = $(this).val();

        $.ajax({
            url: '{{ route("product-subcategories.index") }}',
            type: 'GET',
            data: { category_id: category_id },
            dataType: 'json',
            success: function(response) {
                $("#sub_category").find("option").not(":first").remove();
                $.each(response["sub_categories"], function(key, item) {
                    $("#sub_category").append(`<option value="${item.id}">${item.name}</option>`);
                });
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log('AJAX error:', textStatus, errorThrown);
            }
        });
    });

    // For getting slug
    $("#title").change(function(event) {
        event.preventDefault();
        var element = $(this);
        var title = element.val();

        $.ajax({
            url: '{{ route("getSlug") }}',
            type: 'GET',
            data: { title: title },
            dataType: 'json',
            success: function(response) {
                if (response.status) {
                    $("#slug").val(response.slug);
                }
            },
            error: function() {
                console.log("something went wrong");
            }
        });
    });

    Dropzone.autoDiscover = false;

    /**
     * Setup dropzone
     */
    const dropzone = $('#image').dropzone({
        init: function() {
            // myDropzone = this;

            // when file is dragged in
            // this.on('addedfile', function(file) { 
            //     if(this.files.length>1){
            //             this.removeFile(this.files[0]);
            //     }
            // });
        },
        url: "{{ route('temp-image.create') }}",
        addRemoveLinks: true,
        parallelUploads: 1,
        maxFiles: 10,
        paramName: 'image',
        acceptedFiles: '.jpeg, .jpg, .png, .gif',
        timeout: 0,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(file, response) {
            $("#image_id").val(response.image_id);

            var imagesContainer = `<div class="card" id="imageRow${response.image_id}" style="width: 18rem;">
                <input type="hidden" name="product_gallary[]" value="${response['image_id']}">
                <img src="${response['image-path']}" class="card-img-top" alt="..." width="150" height="150">
                <div class="card-body">
                    <a href="javascript:void(0)" onclick="deleteImage(${response.image_id})" class="btn btn-primary">Delete</a>
                </div>
            </div>`;

            $('#product-gallary').append(imagesContainer);
        },
        complete:function (file){
            this.removeFile(file);
        }
    });



    function deleteImage(imageId) {
 
    var imageElement = $(`#imageRow${imageId}`);
    
    if (imageElement.length) {
        imageElement.remove(); 
    } else {
        console.error(`Element with ID imageRow${imageId} not found.`);
    }
}
</script>


@endsection