@extends('layouts.user')
@section('content')
@include('components.errors')

<form action="{{route('users.create')}}" method="POST">
        @csrf
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-lg-10 position-relative z-index-2">
                    <!-- Accounts Languages -->
                    <div class="row mt-4">
                        <div class="col-6">
                            <div class="card mb-4 ">
                                <div class="d-flex">
                                    <div
                                        class="icon icon-shape icon-lg bg-gradient-success shadow text-center border-radius-xl mt-n3 ms-4">
                                        <i class="material-icons opacity-10" aria-hidden="true">account_circle</i>
                                    </div>
                                    <h6 class="mt-3 mb-2 ms-3 ">Account Information</h6>

                                </div>
                                <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <div class="input-group input-group-static">
                                                    <label class="">Role</label>
                                                    <select class="form-control" name="role" id="role">
                                                        <option value="">Please select</option>
                                                        <option value="ADMINISTRATOR">ADMINISTRATOR</option>
                                                        <option value="SUB_HR">DEPARTMENT HEAD</option>
                                                        <option value="HR">HR</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <div class="input-group input-group-static">
                                                    <label class="">E-mail</label>
                                                    <input type="text" name="email" class="form-control" value="{{old('email')}}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="input-group input-group-static">
                                                    <label class="">Password</label>
                                                    <input type="password" name="password" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-6 ">
                                                <div class="input-group input-group-static">
                                                    <label class="">Password Confirmation</label>
                                                    <input type="password" name="password_confirmation" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Account -->
                    <button class="btn text-right btn-primary" type="submit">Create User</button>

                </div>
            </div>
        </div>
<script>
    (function(){
        role = document.getElementById('role')
        role.value = '{{old('role')}}'
    })()
</script>
@endsection