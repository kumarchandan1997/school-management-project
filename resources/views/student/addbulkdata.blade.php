@extends('layouts.app_view');

@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session()->has('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
                <div class="col-md-10 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Add Bulk Student</h4>
                            <form action="{{ route('add-student-Excel') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row align-items-center">
                                    <div class="col-md-3">
                                        <div class="form-group row">
                                            <div class="col-sm-9">
                                                <select id="bulk_add_student_classroom" name="classroom"
                                                    class="form-control form-control-sm">
                                                    @if (Session('classroom') == null)
                                                        @foreach ($classrooms as $classroom)
                                                            <option value="{{ $classroom->id }}">{{ $classroom->name }}
                                                            </option>
                                                        @endforeach
                                                    @else
                                                        @php
                                                            $DB = DB::table('classrooms')
                                                                ->where('id', Session('classroom'))
                                                                ->first();
                                                        @endphp
                                                        <option value="{{ Session('classroom') }}">{{ $DB->name }}
                                                        </option>
                                                        @foreach ($classrooms as $classroom)
                                                            <option value="{{ $classroom->id }}">{{ $classroom->name }}
                                                            </option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="file" name="excelFile" accept=".xlsx, .xls">
                                    </div>
                                    <div class="col-md-3">
                                        <input type="submit" class="btn btn-primary" value="Upload Excel">
                                    </div>
                                    <div class="col-md-3">
                                        <a href="{{ asset('assets/sample-excel-file.xlsx') }}"
                                            class="btn btn-secondary text-white fw-bolder" download>Download Sample
                                            Excel</a>
                                    </div>
                                </div>
                            </form>
                            <br><br><br>
                            <div class="row">
                                <div class="col-md-12 d-flex justify-content-center">
                                    <a href="#" id="downloadStudentDetails"
                                        class="btn btn-primary text-white fw-bolder">
                                        Download Student Details Class Wise
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#downloadStudentDetails').click(function(event) {
                event.preventDefault();

                var classroomId = $('#bulk_add_student_classroom').val();
                if (classroomId === '0') {
                    alert('Please select a classroom.');
                    return;
                }

                $.ajax({
                    url: '/student/download-student-details',
                    method: 'POST',
                    data: {
                        classroom_id: classroomId,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    xhrFields: {
                        responseType: 'blob'
                    },
                    success: function(blob) {
                        console.log("Request successful");
                        var url = window.URL.createObjectURL(blob);
                        var a = document.createElement('a');
                        a.style.display = 'none';
                        a.href = url;
                        a.download = 'student_details_classroom_' + classroomId + '.xlsx';
                        document.body.appendChild(a);
                        a.click();
                        window.URL.revokeObjectURL(url);
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', error);
                    }
                });
            });
        });
    </script>
@endsection
