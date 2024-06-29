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

  
    
</section>
<!-- Main content -->
<section class="content">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid my-2">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Create Brand</h1>
                    </div>
                    <div class="col-sm-6 text-right">
                        <a href="brands.html" class="btn btn-primary">Back</a>
                    </div>
                </div>
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- Main content -->
        <section class="content">
            <!-- Default box -->
            <div class="container-fluid">
              <form action=""method="post"  id="brandForm" name="brandForm">
                @csrf
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" id="name" class="form-control" placeholder="Name">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="email">Slug</label>
                                    <input type="text" readonly name="slug" id="slug" class="form-control" placeholder="Slug">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="email">Status</label>
                                    <select name="status" id="status" class="form-control" >
                                        <option value="1">Active </option>
                                        <option value="0">Block</option>
                                    </select>         
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="pb-5 pt-3">
                    <button type="submit" class="btn btn-primary">Create</button>
                    <a href="brands.html" class="btn btn-outline-dark ml-3">Cancel</a>
                </div>
                
            </div>
              </form>
            <!-- /.card -->
        </section>
        <!-- /.content -->
</section>
<!-- /.content -->

@endsection


@section('customsJs')
<script>
    $("#brandForm").submit(function(event){
        event.preventDefault();
        var element=$(this);
        $('button[type=submit]').prop('disabled', true);
        $.ajax({
            type: "POST",
            url : '{{ route("brand.store") }}',
            data : element.serializeArray(),
            datatype:'json',
            success : function(response){
                $('button[type=submit]').prop('disabled', false);
                var errors=response['errors'];
                if (response['status']==true){
                    window.location.href = '{{ route("brands.index") }}';

                          
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

//* for generating slug automaticly 
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

</script>
@endsection