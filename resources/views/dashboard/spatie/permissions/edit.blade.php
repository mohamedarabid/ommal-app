{{-- Extends layout --}}

@extends('layout.default')



@section('title','Permission')





@section('styles')

<link rel="stylesheet" href="{{asset('plugins/toastr/toastr.min.css')}}">

@endsection



{{-- Content --}}

@section('content')





<div class="card card-custom">



    <div class="card-header">

        <h3 class="card-title">

            Edit Permission

        </h3>

        <div class="card-toolbar">

            <div class="example-tools justify-content-center">

                <span class="example-toggle" data-toggle="tooltip" title="View code"></span>

                <span class="example-copy" data-toggle="tooltip" title="Copy code"></span>

            </div>

        </div>

    </div>

    <form >

        @csrf

        <div class="card-body">

            <div class="row">

             <div class="form-group col-md-6">

                <label>Guard:</label>

                   <select class="form-control form-control-solid" name="guards" id="guards">

                        <option value="admin" @if($permission->guard_name == 'admin') selected @endif>Admin

                            </option>

                    </select>

                    </div>

            <div class="form-group col-md-6">

                <label>Permission:</label>

                <input type="text" name="name" id="name" class="form-control form-control-solid" 

                placeholder="Enter Permission" value="{{$permission->name}}"/>

            </div>

        </div>

     </div>

      <div class="card-footer">

         <button type="button" onclick="performUpdate({{$permission->id}})" class="btn btn-primary mr-2">Submit</button>
         <a href="{{route('permissions.index')}}"><button type="button" class="btn btn-primary mr-2">Cancel</button></a>


     </div>

  </div>

</form>

@endsection







{{-- Scripts Section --}}

@section('scripts')

<script src="{{asset('plugins/select2/js/select2.full.min.js')}}"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<script src="{{asset('plugins/toastr/toastr.min.js') }}"></script>

<script src="{{asset('crudjs/crud.js')}}"></script>

<script>

    //Initialize Select2 Elements

    $('.guards').select2({

        theme: 'bootstrap4'

    })

        function performUpdate(id){

        let data = {

            name: document.getElementById('name').value,

            guard_name: document.getElementById('guards').value

        };

        update('/cms/admin/permissions/'+id,data,'/cms/admin/permissions');

    }

</script> 

@endsection

