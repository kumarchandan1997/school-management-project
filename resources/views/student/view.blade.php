@extends('layouts.app_view');

@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-md-10 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">
                                {{ isset($student) ? 'Edit' : 'Add New' }} Student
                                {{ isset($student) ? 'with The Number: ' . $student->student_num : '' }}
                            </h4>
                            <p class="card-description">
                                <!-- You can add description or leave it blank -->
                            </p>
                            <form class="forms-sample" action="{{ url('/student/store') }}" method="post">
                                @csrf

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="classroom">Class</label>
                                            <select id="classroom" name="classroom" class="form-control form-control-sm">
                                                @if (Session('classroom') == null)
                                                    @foreach ($classrooms as $classroom)
                                                        <option value="{{ $classroom->id }}">{{ $classroom->name }}</option>
                                                    @endforeach
                                                @else
                                                    @php
                                                        $DB = DB::table('classrooms')
                                                            ->where('id', Session('classroom'))
                                                            ->first();
                                                    @endphp
                                                    <option value="{{ Session('classroom') }}">{{ $DB->name }}</option>
                                                    @foreach ($classrooms as $classroom)
                                                        <option value="{{ $classroom->id }}">{{ $classroom->name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="enrollment_date">Enrolling Date</label>
                                            <input type="date" class="form-control" name="enrollment_date"
                                                id="enrollment_date" placeholder="dd/mm/yyyy" value="">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="email">User ID</label>
                                            <input type="text" class="form-control" name="email" id="email"
                                                autofocus placeholder="Email" value="" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="password">Password</label>
                                            <input type="text" class="form-control" name="password" id="password"
                                                autofocus placeholder="Please enter password" value="" readonly>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="first_name">First Name</label>
                                            <input type="text" class="form-control" name="first_name" id="first_name"
                                                autofocus placeholder="First Name" value="">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="surname">Last Name</label>
                                            <input type="text" class="form-control" name="surname" id="surname"
                                                placeholder="Last Name" value="">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="gender">Gender</label>
                                            <select id="gender" name="gender" class="form-control form-control-sm">
                                                <option value="0">Male</option>
                                                <option value="1">Female</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="birth_date">Date of Birth</label>
                                            <input type="date" class="form-control" name="birth_date" id="birth_date"
                                                placeholder="dd/mm/yyyy" value="">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="parent_phone_number">Parent Phone Number</label>
                                            <input type="text" class="form-control" name="parent_phone_number"
                                                id="parent_phone_number" placeholder="Enter Phone Number like *** *** ** **"
                                                value="">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="father_name">Father Name</label>
                                            <input type="text" class="form-control" name="father_name"
                                                id="father_name" placeholder="Father Name" value="">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="address">Address</label>
                                            <textarea class="form-control" name="address" id="address" rows="3" placeholder="Address"></textarea>
                                        </div>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary me-2">Save</button>
                                <a class="btn btn-light" href="/student">Cancel</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
