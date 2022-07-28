{{-- Extends layout --}}

@extends('layout.default')
@section('title','Tender')

{{-- Content --}}
@section('content')
<div class="card card-custom">
    <div class="card-header">
        <h3 class="card-title">
            Add Tender

        </h3>

        <div class="card-toolbar">

            <div class="example-tools justify-content-center">

                <span class="example-toggle" data-toggle="tooltip" title="View code"></span>

                <span class="example-copy" data-toggle="tooltip" title="Copy code"></span>

            </div>

        </div>

    </div>



    <form class="form" method="post" id='create_form'>

        @csrf

        <div class="card-body">

            <div class="row">


            </div>



            <div class="row">

                <div class="form-group col-md-6">

                    <label> Name:</label>

                    <input type="text" id="name" class="form-control form-control-solid" placeholder="First Name" />

                </div>
                <div class="form-group col-md-6">

                    <label> Name Hb:</label>

                    <input type="text" id="name_hb" class="form-control form-control-solid" placeholder="First Name" />

                </div>
                <div class="form-group col-md-6">

                    <label>desc:</label>

                    <textarea type="text" id="desc" class="form-control form-control-solid"
                        placeholder="desc"> </textarea>

                </div>

                <div class="form-group col-md-6">

                    <label>desc Hb:</label>

                    <textarea type="text" id="desc_hb" class="form-control form-control-solid"
                        placeholder="desc"> </textarea>

                </div>
                <div class="form-group col-md-4">
                    <label> Status </label>
                    <select class="form-control form-control-solid" name="status" id="status">
                        <option value="active">Active</option>
                        <option value="deactive">Deactive</option>
                    </select>
                </div>
                <div class="gst form-group">
                    <label>image</label>
                    <div class="form-group">
                        <input name="file" id="file" type="file" class="form-control">
                        @error('image')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-12 mb-2">
                        <img id="preview-logo-before-upload"
                            src="https://www.riobeauty.co.uk/images/product_image_not_found.gif" alt="preview image"
                            style="max-height: 250px;">
                    </div>
                    <br />
                    <div class="progress">
                        <div class="bar"></div>
                        <div class="percent">0%</div>
                    </div>
                </div>
                   <div class="form-group col-4">

                    <label class="form-label">city</label>

                    <select class="form-control form-control-solid" name="city_id" id="city_id">

                        @foreach ($cities as $city)


                        <option value="{{$city->id}}">{{$city->name}}</option>


                    @endforeach
                      </select>
                </div>

            </div>
            </div>



            <div class="row clearfix">


            <input type="text" value="{{$id}}" hidden class="form-control" placeholder="Ex: 27,85487" id="contractor_id"
                name="contractor_id">




        </div>







        <div class="card-footer">

            <button type="button" onclick="performStore()" class="btn btn-primary mr-2">Submit</button>
            <a href="{{route('admins.index')}}"><button type="button" class="btn btn-primary mr-2">Cancel</button></a>


        </div>

</div>

</form>
@endsection


@section('styles')
<style>
    .progress {
        position: relative;
        width: 100%;
        border: 1px solid #7F98B2;
        padding: 1px;
        border-radius: 3px;
    }

    .bar {
        background-color: #00df00;
        width: 0%;
        height: 25px;
        border-radius: 3px;
    }

    .percent {
        position: absolute;
        display: inline-block;
        top: 3px;
        left: 48%;
        color: #7F98B2;
    }

</style>
@endsection

{{-- Scripts Section --}}

@section('scripts')

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.js"></script>

<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&key=AIzaSyCZ1R13uqV5VpKRcWAN8YpL5T3XsBASBXo"></script>


<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>


<script src="{{asset('crudjs/crud.js')}}"></script>


<script>

    function performStore() {

        let formData = new FormData();
        formData.append('name', document.getElementById('name').value);
                formData.append('name_hb', document.getElementById('name_hb').value);
        formData.append('desc_hb', document.getElementById('desc_hb').value);

        formData.append('desc', document.getElementById('desc').value);
        formData.append('city_id', document.getElementById('city_id').value);
        formData.append('contractor_id', document.getElementById('contractor_id').value);
        formData.append('status', document.getElementById('status').value);
        formData.append('file', document.getElementById('file').files[0]);
        store('/cms/admin/tender', formData)

    }

</script>



@endsection
