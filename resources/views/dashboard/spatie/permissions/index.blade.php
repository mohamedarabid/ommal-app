{{-- Extends layout --}}
@extends('layout.default')


{{-- Content --}}
@section('content')

    <div class="card card-custom">
        <div class="card-header flex-wrap border-0 pt-6 pb-0">
            <div class="card-title">
                <h3 class="card-label">Permissions View
                </h3>
            </div>
            <div class="card-toolbar">
                <a href="{{route('permissions.create')}}" class="btn btn-primary font-weight-bolder">
                <span class="svg-icon svg-icon-md">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                            <rect x="0" y="0" width="24" height="24"/>
                            <circle fill="#000000" cx="9" cy="15" r="6"/>
                            <path d="M8.8012943,7.00241953 C9.83837775,5.20768121 11.7781543,4 14,4 C17.3137085,4 20,6.6862915 20,10 C20,12.2218457 18.7923188,14.1616223 16.9975805,15.1987057 C16.9991904,15.1326658 17,15.0664274 17,15 C17,10.581722 13.418278,7 9,7 C8.93357256,7 8.86733422,7.00080962 8.8012943,7.00241953 Z" fill="#000000" opacity="0.3"/>
                        </g>
                    </svg>
                </span>New Permission</a>
            </div>
        </div>

        <div class="card-body">



            <table class="table table-bordered table-hover" id="kt_datatable">
                <thead>
                <tr>
                   
                  <th>Record ID</th>
                  <th>Name</th>
                  <th>Guard</th>
                  <th>Settings</th>
               
                </tr>
                </thead>
                      <tbody>

                @foreach ($permissions as $permission)
                <tr>
                  <td>{{$permission->id}}</td>
                  <td>{{$permission->name}}</td>
                  <td><span class="badge bg-success">{{$permission->guard_name}}</span></td>
                  <td>
                    <div class="btn-group">
                      <a href="{{route('permissions.edit',$permission->id)}}" class="btn btn-primary mr-2">
                        <i class="fas fa-edit"></i>
                      </a>
                      <a href="#" onclick="performDestroy({{$permission->id}}, this)" class="btn btn-danger mr-2">
                        <i class="fas fa-trash"></i>
                      </a>
                    </div>
                  </td>
                </tr>
                @endforeach
              </tbody>
          
            </table>
            {!! $permissions->links() !!}
        </div>
    </div>

@endsection

{{-- Styles Section --}}
@section('styles')
    <link href="{{ asset('plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css"/>
@endsection


{{-- Scripts Section --}}
@section('scripts')
    {{-- vendors --}}
    <script src="{{ asset('plugins/custom/datatables/datatables.bundle.js') }}" type="text/javascript"></script>
    {{-- page scripts --}}
    <script src="{{ asset('js/pages/crud/datatables/basic/basic.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/app.js') }}" type="text/javascript"></script>
    <script src="{{asset('crudjs/crud.js')}}"></script>
<script>
    function performDestroy(id, ref){
    confirmDestroy('/cms/admin/permissions/'+id, ref);
   }
</script>
@endsection
