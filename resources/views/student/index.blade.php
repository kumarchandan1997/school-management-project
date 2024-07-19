@extends('layouts.app_view');

@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            <!-- Search Form -->
            <div class="row mb-3">
                <div class="col-lg-6">
                    <form action="{{ url('/student/manage') }}" method="GET">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control"
                                placeholder="Search by student number,name,father's name & email...">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit" style="margin-left: 10px;">Search</button>
                                <button class="btn btn-secondary" type="button"
                                    onclick="window.location.href='{{ url('/student/manage') }}'"
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
                            <h4 class="card-title">Students Table</h4>
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Name</th>
                                            <th>Student Number</th>
                                            <th>Parent Phone Number</th>
                                            <th>Father Name</th>
                                            <th>Classroom</th>
                                            {{-- <th>Enrollment Date</th> --}}
                                            <th>Email</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($students as $student)
                                            <tr>
                                                <td>
                                                    {{ $student->id }}
                                                </td>
                                                <td>
                                                    {{ $student->first_name . ' ' . $student->surname }}
                                                </td>
                                                <td>
                                                    {{ $student->student_num }}
                                                </td>
                                                {{-- <td style="white-space: normal;">
                                                First: <a href="tel:{{$student ? encrypt($student->parent_phone_number) : ''}}">{{$student ? decrypt($student->parent_phone_number) : ''}}
                                                </a>
                                                @if ($student->second_phone_number)
                                                    <br>Second: <a href="tel:{{$student->second_phone_number}}">{{$student->second_phone_number}}</a>
                                                @endif
                                            </td> --}}
                                                <td>
                                                    {{-- {{$student ? encrypt($student->parent_phone_number) : ''}} --}}
                                                    {{ $student->parent_phone_number }}
                                                </td>
                                                <td>
                                                    {{ $student->father_name }}
                                                </td>
                                                <td>
                                                    {{ $student->classroom->name }}
                                                </td>
                                                @php
                                                    $DB = DB::table('users')
                                                        ->where('id', $student->school)
                                                        ->get();
                                                    $student->school;
                                                @endphp
                                                {{-- <td>
                                               @foreach ($DB as $item)
                                                   {{ $item->name }}
                                               @endforeach
                                            </td> --}}
                                                {{-- <td>
                                                {{$student->enrollment_date}}
                                            </td> --}}
                                                <td>
                                                    {{ $student->email }}
                                                </td>
                                                <td>
                                                    <div class="btn-group">
                                                        <form action="/student/edit/{{ $student->id }}" method="get">
                                                            @csrf
                                                            <button type="submit"
                                                                class="btn btn-dark ti-pencil-alt btn-rounded">
                                                                Edit</button>
                                                        </form>
                                                        <form action="/student/delete/{{ $student->id }}" method="post">
                                                            @method('DELETE')
                                                            @csrf
                                                            <button
                                                                onclick="return confirm('Are you sure You want to delete this?')"
                                                                type="submit" class="btn btn-danger ti-trash btn-rounded">
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
                                {!! $students->links() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- content-wrapper ends -->
    </div>
@endsection
