{{-- Extends layout --}}

@extends('layout.default')

@section('title','Admin')



{{-- Content --}}

@section('content')



<div class="card card-custom">

    <div class="card-header flex-wrap border-0 pt-6 pb-0">

        <div class="card-title">

            <h3 class="card-label">Index Admin
            </h3>



        </div>
        @can('create-admin')


           <div class="card-toolbar">

            <a href="{{route('admins.create')}}" class="btn btn-primary font-weight-bolder">

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

                </span>New Admin</a>

        </div>
        @endcan
    </div>





    <table class="table table-bordered table-hover" id="kt_datatable">

        <thead>

            <tr>

                <th>First Name</th>
                <th>Last Name</th>
                <th>Type</th>
                <th>Email</th>
                <th>Image</th>
                <th>Created At</th>
                <th>Status</th>
                <th>Settings</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($admins as $admin)
            <tr>

                <td>{{$admin->first_name}}</td>
                <td>{{$admin->last_name}}</td>
                <td>
                    <span class="badge badge-primary">{{$admin->getRoleNames()}}</span>
                </td>
                <td>{{$admin->email}}</td>
                <td>
                    <img class="rounded-circle" src="{{url('images/admin/'.$admin->image)}}" width="50" height="50">
                </td>
                <td>{{$admin->created_at}}</td>
                <td> @if ($admin->status=='active')
                    <span class="badge badge-primary">Active</span>
                    @elseif ($admin->status=='deactive')
                    <span class="badge badge-danger">Deactive</span>
                    @endif
                </td>
                <td>
                    <div class="btn-group">
                        @can('edit-admin')
                        <a href="{{route('admins.edit',$admin->id)}}" class="btn btn-primary mr-2"
                            title="Edit Informations"> <i class="fas fa-edit"></i> </a>
                            @endcan
                            
                        <a href="{{route('dashboard.auth.edit-password',$admin->id)}}" class="btn btn-success mr-2"
                            title="Edit Password"> <i class="fas fa-edit"></i> </a>

                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {!! $admins->links() !!}
</div>

@endsection



{{-- Styles Section --}}

@section('styles')

@endsection


@section('scripts')

<script src="{{ asset('js/app.js') }}" type="text/javascript"></script>

<script>
    const showStatus = document.getElementById("showStatus");
    showStatus.style.display = "none";

    const btn = document.getElementById("filter");


    btn.onclick = function () {
        if (showStatus.style.display !== "none") {
            showStatus.style.display = "none";
        } else {
            showStatus.style.display = "block";
        }
    };


    function performDestroy(id, reference) {
        let url = '/cms/admin/admins/' + id;
        confirmDestroy(url, reference);
    }

    $(document).ready(function () {
        $('#master').on('click', function (e) {
            if ($(this).is(':checked', true)) {
                $(".sub_chk").prop('checked', true);
            } else {
                $(".sub_chk").prop('checked', false);
            }
        });
        $('.delete_all').on('click', function (e) {
            var allVals = [];
            $(".sub_chk:checked").each(function () {
                allVals.push($(this).attr('data-id'));
            });
            if (allVals.length <= 0) {
                alert("Please select row.");
            } else {

                Swal.fire({
                    title: 'Are you sure?',
                    text: "The deletion cannot be undone",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'yes',
                    cancelButtonText: 'cancel',
                }).then((result) => {
                    if (result.isConfirmed) {
                        var join_selected_values = allVals.join(",");
                        $.ajax({
                            url: $(this).data('url'),
                            type: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                    'content')
                            },
                            data: 'ids=' + join_selected_values,
                            success: function (data) {
                                if (data['success']) {
                                    $(".sub_chk:checked").each(function () {
                                        $(this).parents("tr").remove();
                                    });
                                    Swal.fire({
                                        position: 'center',
                                        icon: 'success',
                                        title: 'Admin Deleted successfully',
                                        showConfirmButton: false,
                                        timer: 1500
                                    })
                                    location.reload()

                                } else if (data['error']) {
                                    alert(data['error']);
                                } else {
                                    alert('Whoops Something went wrong!!');
                                }
                            },
                            error: function (data) {
                                alert(data.responseText);
                            }
                        });
                        $.each(allVals, function (index, value) {
                            $('table tr').filter("[data-row-id='" + value + "']")
                                .remove();
                        });
                    }
                });
            }
        });
    });


    $(document).ready(function () {
        $('#master').on('click', function (e) {
            if ($(this).is(':checked', true)) {
                $(".sub_chk").prop('checked', true);
            } else {
                $(".sub_chk").prop('checked', false);
            }
        });
        $('.deactive_all').on('click', function (e) {
            var allVals = [];
            $(".sub_chk:checked").each(function () {
                allVals.push($(this).attr('data-id'));
            });
            if (allVals.length <= 0) {
                alert("Please select row.");
            } else {

                var join_selected_values = allVals.join(",");
                $.ajax({
                    url: $(this).data('url'),
                    type: 'post',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                            'content')
                    },
                    data: 'ids=' + join_selected_values,
                    success: function (data) {
                        if (data['success']) {

                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'Admin Deactive successfully',
                                showConfirmButton: false,
                                timer: 1500
                            })
                            location.reload()

                        } else if (data['error']) {
                            alert(data['error']);
                        } else {
                            alert('Whoops Something went wrong!!');
                        }
                    },
                    error: function (data) {
                        alert(data.responseText);
                    }
                });
            }
        });
    });

    $(document).ready(function () {
        $('#master').on('click', function (e) {
            if ($(this).is(':checked', true)) {
                $(".sub_chk").prop('checked', true);
            } else {
                $(".sub_chk").prop('checked', false);
            }
        });
        $('.active_all').on('click', function (e) {
            var allVals = [];
            $(".sub_chk:checked").each(function () {
                allVals.push($(this).attr('data-id'));
            });
            if (allVals.length <= 0) {
                alert("Please select row.");
            } else {

                var join_selected_values = allVals.join(",");
                $.ajax({
                    url: $(this).data('url'),
                    type: 'post',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                            'content')
                    },
                    data: 'ids=' + join_selected_values,
                    success: function (data) {
                        if (data['success']) {

                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'Admin Active successfully',
                                showConfirmButton: false,
                                timer: 1500
                            })
                            location.reload()

                        } else if (data['error']) {
                            alert(data['error']);
                        } else {
                            alert('Whoops Something went wrong!!');
                        }
                    },
                    error: function (data) {
                        alert(data.responseText);
                    }
                });
            }
        });
    });

</script>

@endsection
