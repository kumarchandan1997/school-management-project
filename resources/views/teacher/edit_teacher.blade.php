@extends('layouts.app_view');

@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-md-10 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">{{ isset($teacher) ? 'Edit' : 'Add New' }} Teacher
                                {{ isset($teacher) ? 'with The Number: ' . $teacher->teacher_num : '' }}</h4>
                            <p class="card-description">
                                Assign the teacher a classroom and subject.
                            </p>
                            <form class="forms-sample" action="{{ route('teacher_admin.update', $teacher->id) }}"
                                method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="first_name">First Name1</label>
                                            <input type="text" class="form-control" name="first_name" id="first_name"
                                                autofocus placeholder="First Name" value="{{ $teacher->first_name }}"
                                                required>
                                            @if ($errors->has('first_name'))
                                                <div class="alert alert-danger">
                                                    {{ $errors->first('first_name') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="surname">Last Name</label>
                                            <input type="text" class="form-control" name="surname" id="surname"
                                                placeholder="Last Name" value="{{ $teacher->surname }}" required>
                                            @if ($errors->has('surname'))
                                                <div class="alert alert-danger">
                                                    {{ $errors->first('surname') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="gender">Gender</label>
                                            <select id="gender" name="gender" class="form-control form-control-sm"
                                                required>
                                                @if (isset($teacher->gender))
                                                    <option value="0" {{ $teacher->gender == 0 ? 'selected' : '' }}>
                                                        Male</option>
                                                    <option value="1" {{ $teacher->gender == 1 ? 'selected' : '' }}>
                                                        Female</option>
                                                @else
                                                    <option value="0">Male</option>
                                                    <option value="1">Female</option>
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="birth_date">Date of Birth</label>
                                            <input type="date" class="form-control" name="birth_date" id="birth_date"
                                                min="1950-01-01" value="{{ $teacher->birth_date }}" required>
                                            @if ($errors->has('birth_date'))
                                                <div class="alert alert-danger">
                                                    {{ $errors->first('birth_date') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="phone_number">Phone Number</label>
                                            <input type="text" class="form-control" name="phone_number" id="phone_number"
                                                placeholder="Enter Phone Number" value="{{ $teacher->phone_number }}"
                                                required>
                                            @if ($errors->has('phone_number'))
                                                <div class="alert alert-danger">
                                                    {{ $errors->first('phone_number') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="email">Email</label>
                                            <input type="email" class="form-control" name="email" id="email"
                                                placeholder="Email Address" value="{{ $teacher->email }}" required>
                                            @if ($errors->has('email'))
                                                <div class="alert alert-danger">
                                                    {{ $errors->first('email') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="password">Password</label>
                                            <input type="password" class="form-control" name="password" id="password"
                                                placeholder="Password" required>
                                            @if ($errors->has('password'))
                                                <div class="alert alert-danger">
                                                    {{ $errors->first('password') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="address">Address</label>
                                            <textarea class="form-control" name="address" id="address" rows="3" placeholder="Address" required>{{ $teacher->address }}</textarea>
                                            @if ($errors->has('address'))
                                                <div class="alert alert-danger">
                                                    {{ $errors->first('address') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="photo">Upload Photo</label>
                                            <input type="file" class="form-control" name="photo" id="teacher_photo"
                                                accept="image/*">
                                            @if ($errors->has('photo'))
                                                <div class="alert alert-danger">
                                                    {{ $errors->first('photo') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Preview</label>
                                            <div class="preview-image">
                                                @if (isset($teacher) && $teacher->photo_path)
                                                    <img src="{{ asset('images/' . $teacher->photo_path) }}"
                                                        alt="Photo Preview" class="img-thumbnail"
                                                        style="max-width: 100%; height: auto;">
                                                    <!-- Hidden input to keep track of the existing photo path -->
                                                    <input type="hidden" name="existing_photo_path"
                                                        value="{{ $teacher->photo_path }}">
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <button type="submit" class="btn btn-primary me-2">Save</button>
                                <a class="btn btn-light" href="/teacher">Cancel</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function() {
            //A way to form dependence between two dropboxs using ajax jquery.
            // Todo: ask for the differences between these ways and which one has better performance.
            $('#classroom').change(function() {
                if ($(this).val() !== '') {
                    var classroomId = $(this).val();
                    getClassSubjects(classroomId);
                } else {
                    $('#subject').html('<option value="">Select a Subject</option>');
                }
            });

        });

        function getClassSubjects(classroomId) {
            const xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState === 4 && this.status === 200) {
                    document.getElementById("subject").innerHTML =
                        this.responseText;
                }
            };
            xhttp.open("get", "ajax/fetchSubjects/" + classroomId);
            xhttp.send();
        }
    </script>

    <script>
        document.getElementById('teacher_photo').addEventListener('change', function(event) {
            const file = event.target.files[0];
            const previewImage = document.querySelector('.preview-image img');

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    if (previewImage) {
                        previewImage.src = e.target.result;
                    } else {
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.className = 'img-thumbnail';
                        img.style.maxWidth = '100%';
                        img.style.height = 'auto';
                        document.querySelector('.preview-image').appendChild(img);
                    }
                }
                reader.readAsDataURL(file);
            }
        });
    </script>
@endsection
