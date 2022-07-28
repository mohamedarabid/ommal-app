{{-- Extends layout --}}

@extends('layout.default')



@section('title', 'Contractor')

@section('page_description', 'Create contractor')



{{-- Content --}}

@section('content')





    <div class="card card-custom">



        <div class="card-header">

            <h3 class="card-title">

                Add Contractor

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

                        <label>First Name:</label>

                        <input type="text" id="first_name" class="form-control form-control-solid"
                            placeholder="First Name" />

                    </div>
                    <div class="form-group col-md-6">

                        <label>First Name HB:</label>

                        <input type="text" id="first_name_hb" class="form-control form-control-solid"
                            placeholder="First Name" />

                    </div>
                    <div class="form-group col-md-6">

                        <label>father name:</label>

                        <input type="text" id="father_name" class="form-control form-control-solid"
                            placeholder="First Name" />

                    </div>
                    <div class="form-group col-md-6">

                        <label>father name HB:</label>

                        <input type="text" id="father_name_hb" class="form-control form-control-solid"
                            placeholder="First Name" />

                    </div>
                    <div class="form-group col-md-6">

                        <label>grand name:</label>

                        <input type="text" id="grand_name" class="form-control form-control-solid"
                            placeholder="First Name" />

                    </div>
                    <div class="form-group col-md-6">

                        <label>grand name HB:</label>

                        <input type="text" id="grand_name_hb" class="form-control form-control-solid"
                            placeholder="First Name" />

                    </div>
                    <div class="form-group col-md-6">

                        <label>Last Name:</label>

                        <input type="text" id="last_name" class="form-control form-control-solid" placeholder="Last Name" />

                    </div>
                    <div class="form-group col-md-6">

                        <label>Last Name HB:</label>

                        <input type="text" id="last_name_hb" class="form-control form-control-solid"
                            placeholder="Last Name" />

                    </div>
                </div>



                <div class="row">

                    <div class="form-group col-md-6">

                        <label>Email:</label>

                        <input type="email" id="email" class="form-control form-control-solid" placeholder="Email" />

                    </div>

                    <div class="form-group col-md-6">

                        <label>Password:</label>

                        <input type="password" id="password" class="form-control form-control-solid"
                            placeholder="Password" />

                    </div>

                </div>



                <div class="row">

                    <div class="form-group col-md-6">

                        <label>Mobile</label>

                        <input type="number" id="mobile" class="form-control form-control-solid" placeholder="Mobile" />

                    </div>

                    <div class="form-group col-md-6">

                        <label>id number</label>

                        <input type="number" id="id_number" class="form-control form-control-solid" placeholder="id" />

                    </div>
                    <div class="form-group col-md-6">

                        <label>license</label>

                        <input type="number" id="license" class="form-control form-control-solid" placeholder="license" />

                    </div>
                    <div class="form-group col-md-6">
                        <label> Status </label>
                        <select class="form-control form-control-solid" name="status" id="status">
                            <option value="active">Active</option>
                            <option value="deactive">Deactive</option>
                        </select>
                    </div>
                    <div class="form-group col-4">

                        <label class="form-label">city</label>

                        <select class="form-control form-control-solid" name="city_id" id="city_id">

                            @foreach ($cities as $city)
                                @php
                                    $name = json_decode($city->name, true);
                                @endphp

                                <option value="{{ $city->id }}">
                                    @if (session()->get('lang') == 'hb')
                                        {{ $name['hb'] }}
                                    @else
                                        {{ $name['ar'] }}
                                    @endif
                                </option>
                            @endforeach
                        </select>
                    </div>
                  
                </div>




            </div>



            <div class="card-footer">

                <button type="button" onclick="performStore()" class="btn btn-primary mr-2">Submit</button>
                <a href="{{ route('admins.index') }}"><button type="button"
                        class="btn btn-primary mr-2">Cancel</button></a>


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

    <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

    <script src="{{ asset('crudjs/crud.js') }}"></script>


    <script>
        $(document).ready(function(e) {
            $('#image').change(function() {
                let reader = new FileReader();
                reader.onload = (e) => {
                    $('#preview-logo-before-upload').attr('src', e.target.result);
                }
                reader.readAsDataURL(this.files[0]);
            });
        });


        function performStore() {

            let formData = new FormData();
            formData.append('first_name', document.getElementById('first_name').value);
            formData.append('first_name_hb', document.getElementById('first_name_hb').value);

            formData.append('father_name', document.getElementById('father_name').value);
            formData.append('father_name_hb', document.getElementById('father_name_hb').value);

            formData.append('grand_name', document.getElementById('grand_name').value);
            formData.append('grand_name_hb', document.getElementById('grand_name_hb').value);
            formData.append('last_name_hb', document.getElementById('last_name_hb').value);

            formData.append('id_number', document.getElementById('id_number').value);
            formData.append('last_name', document.getElementById('last_name').value);
            formData.append('email', document.getElementById('email').value);
            formData.append('password', document.getElementById('password').value);
            formData.append('mobile', document.getElementById('mobile').value);
            formData.append('status', document.getElementById('status').value);
            formData.append('license', document.getElementById('license').value);
            formData.append('city_id', document.getElementById('city_id').value);

            store('/cms/admin/contractor', formData)

        }
    </script>

    <script type="text/javascript">
        function validate(formData, jqForm, options) {
            var form = jqForm[0];
            if (!form.file.value) {
                alert('File not found');
                return false;
            }
        }

        (function() {

            var bar = $('.bar');
            var percent = $('.percent');
            var status = $('#status');

            $('form').ajaxForm({
                beforeSubmit: validate,
                beforeSend: function() {
                    status.empty();
                    var totalValPercentage = '0%';
                    var posterValue = $('input[name=file]').fieldValue();
                    bar.width(totalValPercentage)
                    percent.html(totalValPercentage);
                },
                uploadProgress: function(event, position, total, percentComplete) {
                    var totalValPercentage = percentComplete + '%';
                    bar.width(totalValPercentage)
                    percent.html(totalValPercentage);
                },
                success: function() {
                    var totalValPercentage = 'Wait, Saving';
                    bar.width(totalValPercentage)
                    percent.html(totalValPercentage);
                },

            });

        })();
    </script>

@endsection
