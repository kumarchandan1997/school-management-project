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
                            <form class="forms-sample" action="{{ url('/student/student-update', $student->id) }}"
                                method="post">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="classroom">Class</label>
                                            <select id="classroom" name="classroom" class="form-control form-control-sm">
                                                @foreach ($classrooms as $classroom)
                                                    <option value="{{ $classroom->id }}"
                                                        {{ $classroom->id == $student->classroom_id ? 'selected' : '' }}>
                                                        {{ $classroom->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('classroom')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="enrollment_date">Enrolling Date</label>
                                            <input type="date" class="form-control" name="enrollment_date"
                                                id="enrollment_date" value="{{ $student->enrollment_date }}">
                                            @error('enrollment_date')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="email">User ID</label>
                                            <input type="text" class="form-control" name="email" id="email"
                                                placeholder="Email" value="{{ $student->email }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="password">Password</label>
                                            <input type="text" class="form-control" name="password" id="password"
                                                placeholder="Please enter password" value="{{ $student->password }}"
                                                readonly>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="first_name">First Name</label>
                                            <input type="text" class="form-control" name="first_name" id="first_name"
                                                placeholder="First Name" value="{{ $student->first_name }}">
                                            @error('first_name')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="surname">Last Name</label>
                                            <input type="text" class="form-control" name="surname" id="surname"
                                                placeholder="Last Name" value="{{ $student->surname }}">
                                            @error('surname')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="gender">Gender</label>
                                            <select id="gender" name="gender" class="form-control form-control-sm">
                                                <option value="0" {{ $student->gender == 0 ? 'selected' : '' }}>Male
                                                </option>
                                                <option value="1" {{ $student->gender == 1 ? 'selected' : '' }}>Female
                                                </option>
                                            </select>
                                            @error('gender')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="birth_date">Date of Birth</label>
                                            <input type="date" class="form-control" name="birth_date" id="birth_date"
                                                value="{{ $student->birth_date }}">
                                            @error('birth_date')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="parent_phone_number">Parent Phone Number</label>
                                            <input type="text" class="form-control" name="parent_phone_number"
                                                id="parent_phone_number" placeholder="Enter Phone Number"
                                                value="{{ $student->parent_phone_number }}">
                                            @error('parent_phone_number')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="father_name">Father Name</label>
                                            <input type="text" class="form-control" name="father_name"
                                                id="father_name" placeholder="Father Name"
                                                value="{{ $student->father_name }}">
                                            @error('father_name')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="address">Address</label>
                                            <textarea class="form-control" name="address" id="address" rows="3" placeholder="Address">{{ $student->address }}</textarea>
                                            @error('address')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
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
