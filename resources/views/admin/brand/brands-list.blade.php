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

					<!-- /.card -->
				</section>
          
        </section>
        <!-- Main content -->
        <section class="content">
            <!-- Default box -->
         
                <!-- Content Header (Page header) -->
                <section class="content-header">					
                    <div class="container-fluid my-2">
                        
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1>Brands</h1>
                            </div>
                            <div class="col-sm-6 text-right">
                                <a href="{{ route('brand.create') }}" class="btn btn-primary">New Brand</a>
                            </div>
                        </div>
                    </div>
                    <!-- /.container-fluid -->
                </section>
                <!-- Main content -->
                <section class="content">
                    <!-- Default box -->
                    <div class="container-fluid">
                        <p> @include('admin.message')</p>
                        <div class="card">
                            <div class="card-header">
                                <div class="card-tools">
                                    <div class="input-group input-group" style="width: 250px;">
                                        <input type="text" name="table_search" class="form-control float-right" placeholder="Search">
                    
                                        <div class="input-group-append">
                                          <button type="submit" class="btn btn-default">
                                            <i class="fas fa-search"></i>
                                          </button>
                                        </div>
                                      </div>
                                </div>
                            </div>
                            <div class="card-body table-responsive p-0">								
                                <table class="table table-hover text-nowrap">
                                    <thead>
                                        <tr>
                                            <th width="60">ID</th>
                                            <th>Name</th>
                                            <th>Slug</th>
                                            <th width="100">Status</th>
                                            <th width="100">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                 @if (!empty($brands))
                                     @foreach ( $brands as $brand )
                                         
                             
                               
                                        <tr>
                                            <td>{{ $brand->id }}</td>
                                            <td>{{ $brand->name }}</td>
                                            <td>{{ $brand->slug }}</td>
                                            {{-- <td>{{ $brand->status }}</td> --}}
                                        
                                            <td>
                                                <svg class="text-success-500 h-6 w-6 text-success" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                            </td>
                                            <td>
                                                <a href="{{ route('brand.edit',$brand->id) }}">
                                                    <svg class="filament-link-icon w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
                                                    </svg>
                                                </a>
                                                <a onclick="deletebrand({{ $brand->id }})" class="text-danger w-4 h-4 mr-1">
                                                    <svg wire:loading.remove.delay="" wire:target="" class="filament-link-icon w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                        <path	ath fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                                      </svg>
                                                </a>
                                            </td>
                                           
                                        </tr>
                                        @endforeach
                                        @else
                                        <tr>
                                            <td colspan="5" style="text-align: center;">
                                                Records Not Found
                                            </td>
                                        </tr>
                                        @endif
                                    </tbody>
                                </table>										
                            </div>
                            <div class="card-footer clearfix">
                            
                                {{ $brands->links() }}
                            </div>
                        </div>
                    </div>
     
            <!-- /.card -->
        </section>
        <!-- /.content -->

        @endsection


        @section('customsJs')
<script>
    function deletebrand(brand_id){
        var url = "{{ route('brand.delete', 'ID') }}";
        url = url.replace('ID', brand_id);
        $.ajax({
            url: url,
            type: 'DELETE',
            data: {}, 
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response){
                if (response.status == true){
                    window.location.href = '{{ route("brands.index") }}';
                }
            },
            error: function(jqXHR, exception){
                console.log("Something went wrong");
            }
        });
    }
</script>
        @endsection