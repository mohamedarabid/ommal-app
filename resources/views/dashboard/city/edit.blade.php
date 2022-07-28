{{-- Extends layout --}}

@extends('layout.default')



@section('title', 'Cities')





@section('styles')

    <link rel="stylesheet" href="{{ asset('plugins/toastr/toastr.min.css') }}">

@endsection



{{-- Content --}}

@section('content')





    <div class="card card-custom">



        <div class="card-header">

            <h3 class="card-title">

                Edit city

            </h3>

            <div class="card-toolbar">

                <div class="example-tools justify-content-center">

                    <span class="example-toggle" data-toggle="tooltip" title="View code"></span>

                    <span class="example-copy" data-toggle="tooltip" title="Copy code"></span>

                </div>

            </div>

        </div>

        <form>

            @csrf

            <div class="card-body">
                @php
                    $name = json_decode($city->name, true);
                @endphp
                <div class="row">
                    <div class="form-group col-md-6">
                        <label>Name:</label>

                        <input type="text" name="name" id="name" class="form-control form-control-solid"
                            placeholder="Enter Permission" value="{{ $name['ar'] }}" />
                    </div>
                    <div class="form-group col-md-6">
                        <label>Name hb:</label>

                        <input type="text" name="name_hb" id="name_hb" class="form-control form-control-solid"
                            placeholder="Enter Permission" value="{{ $name['hb'] }}" />
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-4">

                        <label class="form-label">location</label>

                        <select class="form-control form-control-solid" name="location" id="location">


                            <option @if ($city->location == 'center') selected @endif value="center">center</option>
                            <option @if ($city->location == 'north') selected @endif value="north">north</option>
                            <option @if ($city->location == 'south') selected @endif value="south">south</option>

                        </select>
                    </div>
                </div>

            </div>

            <div class="card-footer">

                <button type="button" onclick="performUpdate({{ $city->id }})"
                    class="btn btn-success mr-2">Edit</button>
                <a href="{{ route('city.index') }}"><button type="button" class="btn btn-primary mr-2">Cancel</button></a>


            </div>

    </div>

    </form>

@endsection







{{-- Scripts Section --}}

@section('scripts')

    <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <script src="{{ asset('crudjs/crud.js') }}"></script>

    <script>
        //Initialize Select2 Elements




        function performUpdate(id) {


            let data = {
                name: document.getElementById("name").value,
                name_hb: document.getElementById("name_hb").value,
            };

            update('/cms/admin/city/' + id, data, '/cms/admin/city');

        }
    </script>

@endsection
