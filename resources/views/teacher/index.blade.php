@extends('layouts.app_view');

@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            <!-- Search Form -->
            <div class="row mb-3">
                <div class="col-lg-6">
                    <form action="{{ url('/teacher') }}" method="GET">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" placeholder="Search by teacher number & name...">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit" style="margin-left: 10px;">Search</button>
                                <button class="btn btn-secondary" type="button" onclick="window.location.href='{{ url('/teacher') }}'" style="margin-left: 10px;">Reset</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Teachers Table</h4>
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead>
                                    <tr>
                                        <th></th>
                                        <th>Teacher Number</th>
                                        <th>Name</th>
                                        <th style="width: 30%">Subjects Assigned</th>
                                        <th>Phone Number</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($teachers as $teacher)
                                        <tr>
                                            <td class="py-1">
                                                <img src="{{url('/images/'.$teacher->photo_path)}}" alt="image"/>
                                            </td>
                                            <td>
                                                {{$teacher->teacher_num}}
                                            </td>
                                            <td>
                                                {{$teacher->first_name.' '.$teacher->surname}}
                                            </td>
                                            <td style="white-space: normal;">
                                                {{$teacher->subjects->implode('name', ', ')}}
                                            </td>
                                            <td>
                                                <a href="tel:{{$teacher->phone_number}}">{{$teacher->phone_number}}</a>
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    <form action="/teacher/edit/{{ $teacher->id }}" method="get">
                                                        @csrf
                                                        <button type="submit" class="btn btn-dark ti-pencil-alt btn-rounded">
                                                            Edit</button>
                                                    </form>
                                                    <form action="/teacher/delete/{{ $teacher->id }}" method="post">
                                                        @method('DELETE')
                                                        @csrf
                                                        <button onclick="return confirm('Are you sure You want to delete this?')" type="submit" class="btn btn-danger ti-trash btn-rounded">
                                                            Delete</button>
                                                    </form>
                                                </div>

                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="d-flex justify-content-center">
                                {!! $teachers->links() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- content-wrapper ends -->
    </div>

@endsection
