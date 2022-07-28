{{-- Extends layout --}}

@extends('layout.default')

@section('title', 'Cities')

@section('styles')
    <style>
        ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
        }

        #showStatus {
            display: none;
        }
    </style>
@endsection

{{-- Content --}}

@section('content')



    <div class="card card-custom">

        <div class="card-header flex-wrap border-0 pt-6 pb-0">

            <div class="card-title">


                <div class="card-title">
                    <h3 class="card-label">Index
                    </h3>

                </div>
            </div>

            <div class="card-toolbar">




                <a href="{{ route('city.create') }}" class="btn btn-primary font-weight-bolder">

                    <span class="svg-icon svg-icon-md">

                        <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24"
                            version="1.1">

                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">

                                <rect x="0" y="0" width="24" height="24" />

                                <circle fill="#000000" cx="9" cy="15" r="6" />

                                <path
                                    d="M8.8012943,7.00241953 C9.83837775,5.20768121 11.7781543,4 14,4 C17.3137085,4 20,6.6862915 20,10 C20,12.2218457 18.7923188,14.1616223 16.9975805,15.1987057 C16.9991904,15.1326658 17,15.0664274 17,15 C17,10.581722 13.418278,7 9,7 C8.93357256,7 8.86733422,7.00080962 8.8012943,7.00241953 Z"
                                    fill="#000000" opacity="0.3" />

                            </g>

                        </svg>

                    </span>Add city</a>

            </div>

        </div>



        <div class="card-body">

            <table class="datatable table datatable-bordered datatable-head-custom  table-row-bordered gy-5 gs-7"
                id="kt_datatable">
                <thead>

                    <tr>



                        {{-- <th>اختيار</th> --}}
                        <th>{{ __('Name') }}</th>
                        <th>{{ __('Settings') }}</th>
                    </tr>

                </thead>


                <tbody>



                    @foreach ($city as $workers)
                        <tr>

                            {{-- <td><input type="checkbox" class="sub_chk" data-id="{{$skills->id}}"></td> --}}
                            @php
                                $name = json_decode($workers->name, true);
                            @endphp
                            <td>
                                @if (session()->get('lang') == 'hb')
                                    {{ $name['hb'] }}
                                @else
                                    {{ $name['ar'] }}
                                @endif
                            </td>


                            <td>

                                <div class="btn-group">

                                    <a href="{{ route('city.edit', $workers->id) }}" class="btn btn-primary mr-2">

                                        <i class="fas fa-edit"></i>

                                    </a>

                                    <a href="#" onclick="performDestroy({{ $workers->id }}, this)"
                                        class="btn btn-danger mr-2">

                                        <i class="fas fa-trash"></i>

                                    </a>

                                </div>

                            </td>

                        </tr>
                    @endforeach

                </tbody>



            </table>

            {!! $city->links() !!}

        </div>



    </div>



@endsection





{{-- Scripts Section --}}

@section('scripts')

    {{-- vendors --}}


    {{-- page scripts --}}


    <script src="{{ asset('js/app.js') }}" type="text/javascript"></script>

    <script src="{{ asset('crudjs/crud.js') }}"></script>

    <script>
        function performDestroy(id, reference) {

            let url = '/cms/admin/city/' + id;

            confirmDestroy(url, reference);

        }
    </script>



@endsection
