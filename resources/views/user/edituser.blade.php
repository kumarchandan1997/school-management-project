@extends('layouts.app_view');

@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-md-10 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">

                            <h4 class="card-title">Edit School With School Id: {{$user->id}}</h4>
                            <p class="card-description">
                            </p>
                            <form class="forms-sample" action="/manager/update/{{ $user->id }}"method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label for="name" class="col-sm-3 col-form-label">School Name</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="name" id="name" autofocus
                                                       placeholder="Name" value="{{$user->name}}">
                                                @if ($errors->has('name'))
                                                    <div class="alert alert-danger">
                                                        {{$errors->first('name')}}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label for="password" class="col-sm-3 col-form-label">Phone No.</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="phone_number" id="phone_number" autofocus
                                                       placeholder="phone No." value="{{ $user->phone_number}}">
                                                @if($errors->has('phone_number'))
                                                    <div class="alert alert-danger">
                                                        {{$errors->first('phone_number')}}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label for="email" class="col-sm-3 col-form-label">Email</label>
                                            <div class="col-sm-9">
                                                <input type="email" class="form-control" name="email" id="email" autofocus
                                                       placeholder="Email" value="{{ $user->email}}">
                                                @if ($errors->has('email'))
                                                    <div class="alert alert-danger">
                                                        {{$errors->first('email')}}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label for="password" class="col-sm-3 col-form-label">Password</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="password" id="password" autofocus
                                                       placeholder="Password" value="">
                                                @if ($errors->has('password'))
                                                    <div class="alert alert-danger">
                                                        {{$errors->first('password')}}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary me-2">Save</button>
                                <a class="btn btn-light" href="/manager">Cancel</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
