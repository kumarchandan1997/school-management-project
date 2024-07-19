@extends('layouts.app_view');

@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            <!-- Search Form -->
            <div class="row mb-3">
                <div class="col-lg-6">
                    <form action="{{ url('/manager') }}" method="GET">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control"
                                placeholder="Search by School name ,email......">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit" style="margin-left: 10px;">Search</button>
                                <button class="btn btn-secondary" type="button"
                                    onclick="window.location.href='{{ url('/manager') }}'"
                                    style="margin-left: 10px;">Reset</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Schools Table</h4>
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>Logo</th>
                                            <th>School Name</th>
                                            <th>Email</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($managers as $manager)
                                            <tr>
                                                <td class="py-1">
                                                    <img src="{{ url('/images/' . $manager->photo_path) }}"
                                                        alt="image" />
                                                </td>
                                                <td>
                                                    {{ $manager->name }}
                                                </td>
                                                <td>
                                                    {{ $manager->email }}
                                                </td>
                                                <td>
                                                    <div class="btn-group">
                                                        <form action="/manager/edit/{{ $manager->id }}" method="get">
                                                            @csrf
                                                            <button type="submit"
                                                                class="btn btn-dark ti-pencil-alt btn-rounded">
                                                                Edit</button>
                                                        </form>
                                                        <!-- <form action="/manager/delete/{{ $manager->id }}" method="post">
                                                                                                        @method('DELETE')
                                                                                                        @csrf
                                                                                                        <button onclick="return confirm('Are you sure You want to delete this?')" type="submit" class="btn btn-danger ti-trash btn-rounded">
                                                                                                            Delete</button>
                                                                                                    </form> -->
                                                        <!-- // 0 for stop and 1 for active by default-->
                                                        <div class="btn_div" style="margin-left:5px">
                                                            <button type="button" data-school-id="{{ $manager->id }}"
                                                                class="btn 
                                                            @if ($manager->soft_login == 1) btn-success @else btn-danger @endif 
                                                            btn-rounded text-white toggle-btn">
                                                                @if ($manager->soft_login == 1)
                                                                    <i class="fa-regular fa-square-check"></i> Active
                                                                @else
                                                                    <i class="fa-solid fa-ban"></i> Stop
                                                                @endif
                                                            </button>
                                                        </div>
                                                    </div>

                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="d-flex justify-content-center">
                                {!! $managers->links() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- content-wrapper ends -->
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.toggle-btn').on('click', function() {
                var schoolId = $(this).data('school-id');
                var currentStatus = $(this).hasClass('btn-success') ? 1 : 0;
                var newStatus = currentStatus === 1 ? 0 : 1;

                $(this).removeClass('btn-success btn-danger');
                if (newStatus === 1) {
                    $(this).addClass('btn-success').html(
                        '<i class="fa-regular fa-square-check"></i> Active');
                } else {
                    $(this).addClass('btn-danger').html('<i class="fa-solid fa-ban"></i> Stop');
                }

                $.ajax({
                    url: "{{ env('APP_URL') }}/api/school",
                    method: 'POST',
                    data: {
                        id: schoolId,
                        soft_login: newStatus,
                    },
                    success: function(response) {
                        console.log(response);
                        console.log('Status updated successfully');
                    },
                });
            });
        });
    </script>
@endsection
