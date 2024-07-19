@extends('layouts.app_view');

@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-md-10 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">
                                {{ isset($subject) ? 'Edit' : 'Add New' }} Subject
                                {{ isset($subject) ? 'with The Number: ' . $subject->subject_code : '' }}
                            </h4>
                            <p class="card-description">
                                <!-- You can add a description or leave it blank -->
                            </p>
                            <form class="forms-sample" action="{{ url('/subject/update/' . $subject->id) }}" method="post">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="name">Subject</label>
                                            <input type="text" class="form-control" name="name" id="name"
                                                autofocus placeholder="Name" value="{{ $subject->name }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6" style="display:none;">
                                        <div class="form-group">
                                            <label for="semester">Semester</label>
                                            <select id="semester" name="semester" class="form-control form-control-sm">
                                                @if (isset($subject->semester))
                                                    <option value="0" {{ $subject->semester == 0 ? 'selected' : '' }}>
                                                        First</option>
                                                    <option value="1" {{ $subject->semester == 1 ? 'selected' : '' }}>
                                                        Second</option>
                                                @else
                                                    <option value="0">First</option>
                                                    <option value="1">Second</option>
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="classroom">Class</label>
                                            <select id="classroom" name="classroom" class="form-control form-control-sm"
                                                data-dependent="subject">
                                                <option value="0">Select a Classroom</option>
                                                @if (isset($subject))
                                                    @foreach ($classrooms as $classroom)
                                                        <option value="{{ $classroom->id }}"
                                                            {{ $subject->classroom->id == $classroom->id ? 'selected' : '' }}>
                                                            {{ $classroom->name }}
                                                        </option>
                                                    @endforeach
                                                @else
                                                    @foreach ($classrooms as $classroom)
                                                        <option value="{{ $classroom->id }}">{{ $classroom->name }}
                                                        </option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="teacher">Teacher</label>
                                            <select id="teacher" name="teacher" class="form-control form-control-sm">
                                                <option value="">Select a Teacher</option>
                                                @if (isset($subject))
                                                    @foreach ($teachers as $teacher)
                                                        <option value="{{ $teacher->id }}"
                                                            {{ isset($subject->teacher) && $subject->teacher->id == $teacher->id ? 'selected' : '' }}>
                                                            {{ $teacher->first_name . ' ' . $teacher->surname }}
                                                        </option>
                                                    @endforeach
                                                @else
                                                    @foreach ($teachers as $teacher)
                                                        <option value="{{ $teacher->id }}">
                                                            {{ $teacher->first_name . ' ' . $teacher->surname }}
                                                        </option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="myTextarea">Description</label>
                                            <textarea type="text" style="resize: vertical;" rows="3" class="form-control" name="description"
                                                id="myTextarea" required>{{ $subject->description }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary me-2">Save</button>
                                <a class="btn btn-light" href="/subject">Cancel</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
