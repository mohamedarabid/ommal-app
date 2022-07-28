{{-- Extends layout --}}

@extends('layout.default')

@section('title','SalaryType')


@section('content')
<div class="card card-custom">
    <div class="card-header">
        <h3 class="card-title">
          create SalaryType
        </h3>
        <div class="card-toolbar">
            <div class="example-tools justify-content-center">
                <span class="example-toggle" data-toggle="tooltip" title="View code"></span>
                <span class="example-copy" data-toggle="tooltip" title="Copy code"></span>
            </div>
        </div>
    </div>
    <form class="form" method="post" id="create_form">
        @csrf
        <div class="card-body">
            <div class="row">
                <div class="form-group col-md-6">
                    <label>Name:</label>
                    <input type="text" name="name" id="name" value="{{old('name')}}"
                        class="form-control form-control-solid" placeholder="Enter Name" required />
                    </div>
                
            </div>


        </div>

        <div class="card-footer">

            <button type="button" onclick="performStore()" class="btn btn-success mr-2">Save</button>
            <a href="{{route('SalaryType.index')}}"><button type="button"
                    class="btn btn-primary mr-2">Cancel</button></a>
        </div>

</form>
</div>
@endsection
@section('styles')

@endsection
{{-- Scripts Section --}}

@section('scripts')

 <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="{{asset('crudjs/crud.js')}}"></script>

<script>

    function performStore() {
        let formData = new FormData();
        formData.append('name', document.getElementById('name').value);
        store('/cms/admin/SalaryType', formData)
    }
</script>

@endsection
