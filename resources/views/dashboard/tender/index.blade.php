{{-- Extends layout --}}

@extends('layout.default')

@section('title','Contractor')

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
                            <div class="symbol symbol-60 symbol-xxl-100 mr-5 align-self-start align-self-xxl-center">
                                <div class="symbol-label"
                                    style="background-image:url('{{asset('images/client/'.$clients->image)}}')"></div>
                            </div>
                            <div class="body">
                                <div class="row clearfix">
                                    <ul>
                                        <li>
                                            <a href="{{route('index.email',['id'=>$clients->id])}}">
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
                                                <span STYLE="font-size:10.0pt">{{ __('Emails') }}</span>
                                            </a>
                                        </li>
                                        <br>

                                        <li>
                                            <a href="{{route('index.mobile',['id'=>$clients->id])}}">
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
                                                <span STYLE="font-size:10.0pt"> {{ __('Mobiles') }}</span>
                                            </a>
                                        </li>
                                        <br>

                                        <li>
                                            <a href="{{route('index.Doc',['id'=>$clients->id])}}">
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
                                                <span STYLE="font-size:10.0pt"> {{ __('Docs') }}</span>
                                            </a>
                                        </li>
                                        <br>
                                        <li>
                                            <a href="{{route('index.tender',['id'=>$clients->id])}}">
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
                                                <span STYLE="font-size:10.0pt"> {{ __('Own Tenders') }}</span>
                                            </a>
                                        </li>
                                        <br>
                                        <li>
                                            <a href="{{route('index.tenderRequests',['id'=>$clients->id])}}">
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
                                                <span STYLE="font-size:10.0pt"> {{ __('Requests Tenders') }}</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{route('index.job',['id'=>$clients->id])}}">
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
                                                <span STYLE="font-size:10.0pt"> {{ __('Jobs') }}</span>
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
                                    <span class="card-label font-weight-bolder text-dark">{{ __('Tender Info') }}</span>

                                </h3>
                                <div class="card-toolbar">
                                    <div class="card-toolbar">
                                        <a href="{{route('tender.create.id',['id'=>$clients->id])}}"
                                            class="btn btn-primary font-weight-bolder">
                                            <span class="svg-icon svg-icon-md">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px"
                                                    viewBox="0 0 24 24" version="1.1">
                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                        <rect x="0" y="0" width="24" height="24" />
                                                        <circle fill="#000000" cx="9" cy="15" r="6" />
                                                        <path
                                                            d="M8.8012943,7.00241953 C9.83837775,5.20768121 11.7781543,4 14,4 C17.3137085,4 20,6.6862915 20,10 C20,12.2218457 18.7923188,14.1616223 16.9975805,15.1987057 C16.9991904,15.1326658 17,15.0664274 17,15 C17,10.581722 13.418278,7 9,7 C8.93357256,7 8.86733422,7.00080962 8.8012943,7.00241953 Z"
                                                            fill="#000000" opacity="0.3" />
                                                    </g>
                                                </svg>
                                            </span>Create Tender</a>
                                    </div>
                                </div>
                            </div>
                            <div id="table" class="card-body fs-6 py-15 px-10 py-lg-15 px-lg-15 text-gray-700">

                                <table
                                    class="datatable table datatable-bordered datatable-head-custom  table-row-bordered gy-5 gs-7"
                                    id="kt_datatable">
                                    <thead>

                                        <tr>
                                            <th>{{ __('ID') }}</th>
                                            <th>{{ __('Name') }}</th>
                                            <th>{{ __('desc') }}</th>
                                            <th>{{ __('long') }}</th>
                                            <th>{{ __('lat') }}</th>
                                            <th>{{ __('file') }}</th>
                                            <th>{{ __('Status') }}</th>
                                            <th>{{ __('Created At') }}</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($Tender as $Tenders)
                                        <tr>
                                            @php
                                            $name = json_decode($Tenders->name, true);
                                            $desc = json_decode($Tenders->desc, true);
                                            @endphp
                                            <td>{{$Tenders->id}}</td>
                                            <td>@if(session()->get('lang') == 'hb' )
                                                {{$name['hb'] }}
                                                @else
                                                {{$name['ar'] }}
                                                @endif</td>
                                            <td>@if(session()->get('lang') == 'hb' )
                                                {{$desc['hb'] }}
                                                @else
                                                {{$desc['ar'] }}
                                                @endif</td>
                                            <td>{{$Tenders->long}}</td>
                                            <td>{{$Tenders->lat}}</td>
                                            <td><a href="{{asset($Tenders->file)}}">show</a></td>
                                            <td> @if ($Tenders->status=='active')
                                                <span class="badge badge-primary">Active</span>
                                                @elseif ($Tenders->status=='deactive')
                                                <span class="badge badge-danger">Deactive</span>
                                                @endif
                                            </td>

                                            <td>{{$Tenders->created_at}}</td>
                                            {{-- <td>
                            <a href="{{route('contractor.show',$clients->id)}} " class="btn btn-primary mr-2">
                                            <i class="fas fa-info"></i>
                                            </a>
                                            </td> --}}

                                        </tr>
                                        @endforeach
                                    </tbody>

                                </table>
                            </div>
                            <span class="span">
                                {!! $Tender->links() !!}
                            </span>
                        </div>

                    </div>

                </div>
            </div>

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
    //map

    var map, marker, infoWindow;

    initMap();

    function initMap() {

        map = new google.maps.Map(document.getElementById('mapGoogle'), {

            zoom: 18,

            center: {

                lat: 59.909144,

                lng: 10.7436936

            },

        });



        marker = new google.maps.Marker({

            map: map,

            draggable: true,

            //icon: image,

            animation: google.maps.Animation.DROP,

            position: {

                lat: 59.909144,

                lng: 10.7436936

            }

        });



        marker.addListener('click', toggleBounce);



        //END CUSTOM MARKER ICON

        google.maps.event.addListener(marker, 'dragend', function (evt) {

            $('#latitude').val(evt.latLng.lat());

            $('#longitude').val(evt.latLng.lng());

        });



        // GET POSITION

        infoWindow = new google.maps.InfoWindow;



        // Try HTML5 geolocation.

        if (navigator.geolocation)

        {

            navigator.geolocation.getCurrentPosition(function (position) {

                var pos = {

                    lat: position.coords.latitude,

                    lng: position.coords.longitude

                };



                $('#latitude').val(position.coords.latitude);

                $('#longitude').val(position.coords.longitude);

                marker.setPosition(pos);

                marker.setTitle('Your position is ' + (Math.round(pos.lat * 100) / 100) + ", " + (Math
                    .round(pos.lng * 100) / 100));

                map.setCenter(pos);

            }, function () {

                handleLocationError(true, infoWindow, map.getCenter());

            });

        } else

        {

            // Browser doesn't support Geolocation

            handleLocationError(false, infoWindow, map.getCenter());

        }

        //END GET POSITION

    }



    //BOUNCE WHEN MARKER IS PRESSED

    function toggleBounce() {

        if (marker.getAnimation() !== null)

        {

            marker.setAnimation(null);

        } else {

            marker.setAnimation(google.maps.Animation.BOUNCE);

        }

    }



    //END BOUNCE WHEN MARKER IS PRESSED

    function handleLocationError(browserHasGeolocation, infoWindow, pos) {

        infoWindow.setPosition(pos);

        infoWindow.setContent(browserHasGeolocation ?

            'Error: The Geolocation service failed.' :

            'Error: Your browser doesn\'t support geolocation.');

        infoWindow.open(map);

    }

</script>

@endsection
