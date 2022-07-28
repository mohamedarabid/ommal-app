{{-- Extends layout --}}

@extends('layout.default')

@section('title','Contractor')




{{-- Content --}}

@section('content')
<div class="card card-custom">
    <div class="card-header flex-wrap border-0 pt-6 pb-0">
        <div class="card-title">
            <h3 class="card-label">Index Contractor
            </h3>

        </div>


        <div class="card-toolbar">

            <a href="{{route('contractor.create')}}" class="btn btn-primary font-weight-bolder">



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

                </span>Create Contractor</a>

        </div>
    </div>

    <div class="card-body">


        <table class="table table-bordered table-hover" id="kt_datatable">
            <thead>
                <tr>
                  <th>ID</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Mobile</th>
                  <th>Status</th>
                  <th>Change Status</th>
                  <th>Created At</th>
                  <th>Info</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($Contractor as $clients)
                <tr>
                    @php
                            $first_name = json_decode($clients->first_name, true);
                            $father_name = json_decode($clients->father_name, true);
                            $family_name = json_decode($clients->family_name, true);
                            @endphp
                  <td>{{$clients->id}}</td>
                  @if(session()->get('lang') == 'hb' )
                 <td>{{$first_name['hb'] .' '. $father_name['hb'] . ' ' . $family_name['hb']}}</td>
                  @else
                 <td>{{$first_name['ar'] .' '. $father_name['ar'] . ' ' . $family_name['ar']}}</td>
                  @endif                  <td>{{$clients->email}}</td>
                  <td>{{$clients->mobile}}</td>

                  <td> @if ($clients->status=='Active')
                        <span class="badge badge-primary">Active</span>
                        @elseif ($clients->status=='Deactive')
                        <span class="badge badge-danger">Deactive</span>
                        @endif
                    </td>
                    <td>     <div class="switch">@if($clients->status == 'Active') On @else Off @endif
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
                    </td>
                  <td>{{$clients->created_at}}</td>
                  <td>
                      <a href="{{route('contractor.show',$clients->id)}} " class="btn btn-primary mr-2">
                            <i class="fas fa-info"></i>
                        </a>
                  </td>

                </tr>
                @endforeach
            </tbody>

        </table>
        <span class="span">
            {!! $Contractor->links() !!}
        </span>
    </div>

</div>

@endsection

{{-- Styles Section --}}

@section('styles')
<link href="{{ asset('plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
@endsection
{{-- Scripts Section --}}

@section('scripts')
{{-- vendors --}}
<script src="{{ asset('plugins/custom/datatables/datatables.bundle.js') }}" type="text/javascript"></script>
{{-- page scripts --}}
<script src="{{ asset('js/pages/crud/datatables/basic/basic.js') }}" type="text/javascript"></script>

<script src="{{ asset('js/app.js') }}" type="text/javascript"></script>


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
            url: "{{route('ajaxStatus.Contractor')}}",
            type: "POST",
            cache: false,
            data: {
                id: id,
                unit_toggle_value: unit_toggle_value,
            },
            dataType: "json",
            success: function (response) {
                window.setTimeout(function () {
                    location.reload()
                }, 100)
            }
        });
    });

</script>
@endsection
