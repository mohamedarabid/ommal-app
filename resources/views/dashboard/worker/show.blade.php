{{-- Extends layout --}}

@extends('layout.default')

@section('title','العملاء')

{{-- Content --}}
@section('styles')
<style>
    ul {
        list-style-type: none;
        margin: 0;
        padding: 0;
    }

</style>


@endsection
@section('content')
<div class="d-flex flex-column-fluid">
    <div class="container">
        <div class="d-flex flex-column-fluid">
            <!--begin::Container-->
            <div class="container">
                <!--begin::Profile 4-->
                <div class="d-flex flex-row">

                    <div class="card card-custom gutter-b">
                        <!--begin::Body-->
                        <div class="card-body pt-4">
                            <!--begin::Toolbar-->
                              @php
                        $first_name = json_decode($clients->first_name, true);
                        $father_name = json_decode($clients->father_name, true);
                        $family_name = json_decode($clients->family_name, true);
                    @endphp

                            <h5>@if(session()->get('lang') == 'hb' )
                 {{$first_name['hb'] .' '. $father_name['hb'] . ' ' . $family_name['hb']}}
                  @else
                 {{$first_name['ar'] .' '. $father_name['ar'] . ' ' . $family_name['ar']}}
                  @endif</h5>
                             <div class="switch">@if($clients->status == 'Active') On @else Off @endif
                                    <label>
                                        <input type="checkbox" class="toggle-switch  btn-sm"
                                            data-toggle="toggle" data-on="active" data-off="deactive"
                                            id="{{$clients->id}}" @if($clients->status == 'Active')
                                        checked="checked"
                                        value= 'Active'
                                        @else
                                        value="Deactive"
                                        @endif
                                        >
                                        <span> </span>
                                    </label>
                                </div>
                            <div class="symbol symbol-60 symbol-xxl-100 mr-5 align-self-start align-self-xxl-center">
                                <div class="symbol-label"
                                    style="background-image:url('{{asset('images/client/'.$clients->image)}}')"></div>
                            </div>
                            <div class="body">
                                <div class="row clearfix">
                                    <ul>
                                        <li>
                                            <a href="{{route('worker.index.email',['id'=>$clients->id])}}">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                    height="24px" viewBox="0 0 24 24" version="1.1">
                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                        <rect x="0" y="0" width="24" height="24" />
                                                        <rect fill="#000000" x="4" y="4" width="7" height="7"
                                                            rx="1.5" />
                                                        <path
                                                            d="M5.5,13 L9.5,13 C10.3284271,13 11,13.6715729 11,14.5 L11,18.5 C11,19.3284271 10.3284271,20 9.5,20 L5.5,20 C4.67157288,20 4,19.3284271 4,18.5 L4,14.5 C4,13.6715729 4.67157288,13 5.5,13 Z M14.5,4 L18.5,4 C19.3284271,4 20,4.67157288 20,5.5 L20,9.5 C20,10.3284271 19.3284271,11 18.5,11 L14.5,11 C13.6715729,11 13,10.3284271 13,9.5 L13,5.5 C13,4.67157288 13.6715729,4 14.5,4 Z M14.5,13 L18.5,13 C19.3284271,13 20,13.6715729 20,14.5 L20,18.5 C20,19.3284271 19.3284271,20 18.5,20 L14.5,20 C13.6715729,20 13,19.3284271 13,18.5 L13,14.5 C13,13.6715729 13.6715729,13 14.5,13 Z"
                                                            fill="#000000" opacity="0.3" />
                                                    </g>
                                                </svg>
                                                <span STYLE="font-size:10.0pt">Emails({{$clients->email_count}})</span>
                                            </a>
                                        </li>
                                        <br>

                                         <li>
                                            <a href="{{route('worker.index.mobile',['id'=>$clients->id])}}">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                    height="24px" viewBox="0 0 24 24" version="1.1">
                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                        <rect x="0" y="0" width="24" height="24" />
                                                        <rect fill="#000000" x="4" y="4" width="7" height="7"
                                                            rx="1.5" />
                                                        <path
                                                            d="M5.5,13 L9.5,13 C10.3284271,13 11,13.6715729 11,14.5 L11,18.5 C11,19.3284271 10.3284271,20 9.5,20 L5.5,20 C4.67157288,20 4,19.3284271 4,18.5 L4,14.5 C4,13.6715729 4.67157288,13 5.5,13 Z M14.5,4 L18.5,4 C19.3284271,4 20,4.67157288 20,5.5 L20,9.5 C20,10.3284271 19.3284271,11 18.5,11 L14.5,11 C13.6715729,11 13,10.3284271 13,9.5 L13,5.5 C13,4.67157288 13.6715729,4 14.5,4 Z M14.5,13 L18.5,13 C19.3284271,13 20,13.6715729 20,14.5 L20,18.5 C20,19.3284271 19.3284271,20 18.5,20 L14.5,20 C13.6715729,20 13,19.3284271 13,18.5 L13,14.5 C13,13.6715729 13.6715729,13 14.5,13 Z"
                                                            fill="#000000" opacity="0.3" />
                                                    </g>
                                                </svg>
                                                <span STYLE="font-size:10.0pt"> Mobiles ({{$clients->mobile_count}})</span>
                                            </a>
                                        </li>
                                        <br>

                                        <li>
                                            <a href="{{route('worker.index.Doc',['id'=>$clients->id])}}">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                    height="24px" viewBox="0 0 24 24" version="1.1">
                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                        <rect x="0" y="0" width="24" height="24" />
                                                        <rect fill="#000000" x="4" y="4" width="7" height="7"
                                                            rx="1.5" />
                                                        <path
                                                            d="M5.5,13 L9.5,13 C10.3284271,13 11,13.6715729 11,14.5 L11,18.5 C11,19.3284271 10.3284271,20 9.5,20 L5.5,20 C4.67157288,20 4,19.3284271 4,18.5 L4,14.5 C4,13.6715729 4.67157288,13 5.5,13 Z M14.5,4 L18.5,4 C19.3284271,4 20,4.67157288 20,5.5 L20,9.5 C20,10.3284271 19.3284271,11 18.5,11 L14.5,11 C13.6715729,11 13,10.3284271 13,9.5 L13,5.5 C13,4.67157288 13.6715729,4 14.5,4 Z M14.5,13 L18.5,13 C19.3284271,13 20,13.6715729 20,14.5 L20,18.5 C20,19.3284271 19.3284271,20 18.5,20 L14.5,20 C13.6715729,20 13,19.3284271 13,18.5 L13,14.5 C13,13.6715729 13.6715729,13 14.5,13 Z"
                                                            fill="#000000" opacity="0.3" />
                                                    </g>
                                                </svg>
                                                <span STYLE="font-size:10.0pt"> Docs</span>
                                            </a>
                                        </li>
                                        <br>

                                        <li>
                                            <a href="{{route('index.requestsWorker',['id'=>$clients->id])}}">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                    height="24px" viewBox="0 0 24 24" version="1.1">
                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                        <rect x="0" y="0" width="24" height="24" />
                                                        <rect fill="#000000" x="4" y="4" width="7" height="7"
                                                            rx="1.5" />
                                                        <path
                                                            d="M5.5,13 L9.5,13 C10.3284271,13 11,13.6715729 11,14.5 L11,18.5 C11,19.3284271 10.3284271,20 9.5,20 L5.5,20 C4.67157288,20 4,19.3284271 4,18.5 L4,14.5 C4,13.6715729 4.67157288,13 5.5,13 Z M14.5,4 L18.5,4 C19.3284271,4 20,4.67157288 20,5.5 L20,9.5 C20,10.3284271 19.3284271,11 18.5,11 L14.5,11 C13.6715729,11 13,10.3284271 13,9.5 L13,5.5 C13,4.67157288 13.6715729,4 14.5,4 Z M14.5,13 L18.5,13 C19.3284271,13 20,13.6715729 20,14.5 L20,18.5 C20,19.3284271 19.3284271,20 18.5,20 L14.5,20 C13.6715729,20 13,19.3284271 13,18.5 L13,14.5 C13,13.6715729 13.6715729,13 14.5,13 Z"
                                                            fill="#000000" opacity="0.3" />
                                                    </g>
                                                </svg>
                                                <span STYLE="font-size:10.0pt"> Job Requests</span>
                                            </a>
                                        </li>

                                    </ul>
                                </div>

                            </div>
                        </div>
                        <!--end::Body-->
                    </div>

                    <div class="flex-row-fluid ml-lg-8">

                        <!--end::Row-->
                        <!--begin::Advance Table Widget 8-->
                        <div class="card card-custom gutter-b">
                            <!--begin::Header-->
                            <div class="card-header border-0 py-5">
                                <h3 class="card-title align-items-start flex-column">
                                    <span class="card-label font-weight-bolder text-dark">Worker Info</span>

                                </h3>
                                <div class="card-toolbar">

                                </div>
                            </div>
                            <!--end::Header-->
                            <!--begin::Body-->
                            <div class="card-body pt-0 pb-3">
                                <div class="row clearfix">

                                    <!--begin::Table-->
                                    <div class="form-group col-md-6">
                                        <label>Name:</label>
                                        <input type="text" value="@if(session()->get('lang') == 'hb' )
                 {{$first_name['hb'] .' '. $father_name['hb'] . ' ' . $family_name['hb']}}
                  @else
                 {{$first_name['ar'] .' '. $father_name['ar'] . ' ' . $family_name['ar']}}
                  @endif"
                                            class="form-control form-control-solid"  disabled />
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>ID Number:</label>
                                        <input value="{{$clients->id_number}}"
                                            class="form-control form-control-solid" placeholder="Enter Phone"
                                            disabled />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-6">
                                        <label class="form-label">Status:</label>
                                        <select class="form-control form-control-solid"value="{{$clients->status}}" disabled>
                                            <option value="Active">Active</option>
                                            <option value="Deactive">Deactive</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-6">
                                        <label class="form-label">Email:</label>
                                        <input value="{{$clients->email}}" class="form-control form-control-solid"
                                            disabled />
                                    </div>


                                </div>

                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label>Created At</label>
                                        <input type="datetime" name="created_at" id="created_at"
                                            value="{{$clients->created_at}}" class="form-control form-control-solid"
                                            placeholder="Enter Disclaimer" disabled />
                                    </div>

                                    <div class="form-group col-6">
                                        <label class="form-label">Mobile:</label>
                                        <input value="{{$clients->mobile}}" class="form-control form-control-solid"
                                            disabled />
                                    </div>
                                </div>

                                 <div class="row">
                                        @php
                        $experiences = json_decode($clients->experiences, true);

                    @endphp
                                    <div class="form-group col-6">
                                        <label class="form-label">Experiences:</label>
                                        <input value="@if(session()->get('lang') == 'hb' )
                 {{$experiences['hb']}}
                  @else
                 {{$experiences['ar'] }}
                  @endif" class="form-control form-control-solid"
                                            disabled />
                                    </div>

                                    <div class="form-group col-6">
                                        <label class="form-label">Years Experiences:</label>
                                        <input value="{{$clients->years_experiences ?? null}}" class="form-control form-control-solid"
                                            disabled />
                                    </div>

                    </div>

                </div>
            </div>
            <!--end::Table-->
        </div>
        <!--end::Body-->
    </div>
    <!--end::Advance Table Widget 8-->
</div>
<!--end::Content-->
</div>
<!--end::Profile 4-->
</div>
<!--end::Container-->
</div>
</div>
</div>

@endsection



@section('scripts')

<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&key=AIzaSyDL_Iurzw7shb69C_H4GLxzETOgHWrzHEw"></script>



<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

<script src="{{asset('crudjs/crud.js')}}"></script>






<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $("input.toggle-switch").change(function () {
        var id = $(this).attr('id');
        var unit_toggle_value = $(this).attr('value');
        if (unit_toggle_value == "Active") {
            unit_toggle_value = "Deactive";
        } else {
            unit_toggle_value = 'Active';
        }
        $.ajax({
            url: "{{route('ajaxStatus.worker')}}",
            type: "POST",
            cache: false,
            data: {
                id: id,
                unit_toggle_value: unit_toggle_value,
            },
            dataType: "json",
            // success: function (response) {
            //     window.setTimeout(function () {
            //         location.reload()
            //     }, 100)
            // }
        });
    });

</script>
@endsection
