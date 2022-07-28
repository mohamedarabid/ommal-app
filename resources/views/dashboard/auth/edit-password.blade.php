{{-- Extends layout --}}

@extends('layout.default')

@section('title','Admin')

@section('page_description','Admin')


{{-- Content --}}

@section('content')

<div class="card card-custom">



    <div class="card-header">

        <h3 class="card-title">

            Edit Password

        </h3>

        <div class="card-toolbar">

            <div class="example-tools justify-content-center">

                <span class="example-toggle" data-toggle="tooltip" title="View code"></span>

                <span class="example-copy" data-toggle="tooltip" title="Copy code"></span>

            </div>

        </div>

    </div>

    <form class="form" method="POST" id="password_form">

        @csrf

        <div class="card-body">

          <div class="row">  

            <div class="form-group col-md-4">

                <label>Current Password:</label>

                <input type="password" name="current_password" id="current_password"

                    class="form-control form-control-solid" placeholder="Current Password"/>

            </div>

            <div class="form-group col-md-4">

                <label>New Password:</label>

                <input type="password" name="new_password" id="new_password"

                    class="form-control form-control-solid" placeholder="New Password"/>

            </div>

             <div class="form-group col-md-4">

                <label>New Password Confirmation:</label>

                <input type="password" name="new_password_confirmation" id="new_password_confirmation"

                    class="form-control form-control-solid" placeholder="New Password Confirmation"/>

            </div>
          </div>

     </div>

   </div>

  <div class="card-footer">

    <button type="button" onclick="performUpdate()" class="btn btn-primary mr-2">Submit</button>

    <button type="reset" class="btn btn-secondary">Cancel</button>

</div>



</form>

@endsection

@section('styles')



@endsection



@section('scripts')

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

<script src="{{asset('crudjs/crud.js')}}"></script>



<script>

 

        // update password

        function performUpdate(){

        let data = {

            current_password: document.getElementById('current_password').value,

            new_password: document.getElementById('new_password').value,

            new_password_confirmation: document.getElementById('new_password_confirmation').value,

        }

         store('/cms/admin/password/update', data);

    }



        

    </script>

@endsection

