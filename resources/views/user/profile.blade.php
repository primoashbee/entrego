@extends('layouts.user')
@section('content')
@include('components.errors')
@if(request()->route('id'))
<form action="{{route('users.update', request()->route('id'))}}" method="POST">
@else
<form action="{{route('profile.update')}}" method="POST">
@endif
    @csrf
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-lg-10 position-relative z-index-2">
                <!-- Start Personal Profile -->
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card mb-4 ">
                            <div class="d-flex">
                                <div
                                    class="icon icon-shape icon-lg bg-gradient-success shadow text-center border-radius-xl mt-n3 ms-4">
                                    <i class="material-icons opacity-10" aria-hidden="true">person</i>
                                </div>
                                <h6 class="mt-3 mb-2 ms-3 ">Personal Profile</h6>

                            </div>
                            <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                        <div class="input-group input-group-static my-3">
                                            <label class="">First Name</label>
                                            <input type="text" name="first_name" class="form-control" value="{{$user->first_name}}">
                                        </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="input-group input-group-static my-3">
                                                <label class="">Middle Name</label>
                                            <input type="text" name="middle_name" class="form-control" value="{{$user->middle_name}}">
                                        </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="input-group input-group-static my-3">
                                                <label class="">Last Name</label>
                                                <input type="text" name="last_name" class="form-control" value="{{$user->last_name}}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="input-group input-group-static">
                                                <label>Birthday</label>
                                                <input type="date" class="form-control" name="birthday"  value="{{$user->birthday}}" onfocus="focused(this)" onfocusout="defocused(this)">
                                                </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="input-group input-group-static">
                                                <label for="gender" class="ms-0">Gender</label>
                                                <select class="form-control" id="gender" name="gender" data-gtm-form-interact-field-id="0">
                                                    <option value="">Please select</option>
                                                    <option value="Female"> Female </option>
                                                    <option value="Male"> Male </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="input-group input-group-static">
                                                <label class="">Contact Number</label>
                                                <input type="text" name="contact_number" class="form-control"  value="{{$user->contact_number}}">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="input-group input-group-static">
                                                <label class="">E-mail</label>
                                                <input type="text" name="email" class="form-control"  value="{{$user->email}}" readonly disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="input-group input-group-static my-3">
                                                <label>Street</label>
                                                <input type="text" class="form-control" name="street" value="{{$user->street}}">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="input-group input-group-static my-3">
                                                <label>Landmark</label>
                                                <input type="text" class="form-control" name="landmark" value="{{$user->landmark}}">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="input-group input-group-static my-3">
                                                <label>City</label>
                                                <input type="text" class="form-control" name="city" value="{{$user->city}}">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="input-group input-group-static my-3">
                                                <label>Brgy</label>
                                                <input type="text" class="form-control" name="barangay" value="{{$user->barangay}}">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="input-group input-group-static my-3">
                                                <label>Zip Code</label>
                                                <input type="text" class="form-control" name="zip_code" value="{{$user->zip_code}}">
                                            </div>
                                        </div>
                                    </div>
                            </div>
                        </div>

                    </div>
                </div>
                <!-- End Personal Profile -->
                <!-- Start Work Section -->
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card mb-4 ">
                            <div class="d-flex">
                                <div
                                    class="icon icon-shape icon-lg bg-gradient-success shadow text-center border-radius-xl mt-n3 ms-4">
                                    <i class="material-icons opacity-10" aria-hidden="true">school</i>
                                </div>
                                <h6 class="mt-3 mb-2 ms-3 ">Work Section</h6>

                            </div>
                            <div class="card-body" id="frmWorkSection">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="input-group input-group-static my-3">
                                                <label class="">Company Name</label>
                                                <input type="text" name="company_name[]" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="input-group input-group-static my-3">
                                            <label class="">Job Title</label>
                                            <input type="text" name="job_title[]" class="form-control">
                                        </div>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="input-group input-group-static my-3">
                                                <label class="">Start Date</label>
                                                <input type="date" class="form-control" name="start_date[]" onfocus="focused(this)" onfocusout="defocused(this)">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="input-group input-group-static my-3">
                                                <label class="">End Date</label>
                                                <input type="date" class="form-control" name="end_date[]" onfocus="focused(this)" onfocusout="defocused(this)">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="input-group input-group-static my-3">
                                                <label class="">Accomplishments</label>
                                                <textarea class="form-control" name="accomplishments[]">
                                                </textarea>
                                            </div>
                                        </div>

                                    </div>
                            </div>
                            
                            <div class="col-12  mr-5">
                                <button class="btn btn-success btn-lg mr-5" style="float: right; margin-right:25px" type="button" onclick="addRow()">Add</button>
                            </div>
                        </div>

                    </div>
                </div>
                <!-- End Work Section -->
                <!-- Start Skills and Languages -->
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card mb-4 ">
                            <div class="d-flex">
                                <div
                                    class="icon icon-shape icon-lg bg-gradient-success shadow text-center border-radius-xl mt-n3 ms-4">
                                    <i class="material-icons opacity-10" aria-hidden="true">turned_in</i>
                                </div>
                                <h6 class="mt-3 mb-2 ms-3 ">Skills and Languages</h6>

                            </div>
                            <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="input-group input-group-static">
                                                <label class="">Skills</label>
                                                <textarea  name="skills" class="form-control">{{$user->skills}}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="input-group input-group-static">
                                            <label class="">Languages</label>
                                            <textarea  name="languages" class="form-control">{{$user->languages}}</textarea>
                                        </div>
                                        </div>

                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Skills and Languages -->
                <!-- Accounts Languages -->
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card mb-4 ">
                            <div class="d-flex">
                                <div
                                    class="icon icon-shape icon-lg bg-gradient-success shadow text-center border-radius-xl mt-n3 ms-4">
                                    <i class="material-icons opacity-10" aria-hidden="true">account_circle</i>
                                </div>
                                <h6 class="mt-3 mb-2 ms-3 ">Password</h6>

                            </div>
                            <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="input-group input-group-static">
                                                <label class="">Role</label>
                                                <select class="form-control" name="role" id="role">
                                                    <option value="">Please select</option>
                                                    <option value="ADMINISTRATOR">ADMINISTRATOR</option>
                                                    <option value="SUB_HR">SUB HR</option>
                                                    <option value="APPLICANT">APPLICANT</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="input-group input-group-static">
                                                <label class="">Password</label>
                                                <input type="password" name="password" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
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

                <button class="btn text-right btn-primary" type="submit">Update Profile</button>
            </div>
        </div>
        @include('components.footer')
    </div>
</form>

<script>
    (function () {
        gender = document.getElementById("gender")
        gender.value = '{{$user->gender}}'
        role = document.getElementById("role")
        role.value = '{{$user->role}}'
        role.disabled = true
        role.readonly = true

    })();
    function addRow(){
        document.getElementById('frmWorkSection').innerHTML += 
        `
        <hr class="ct-docs-hr">
        <div class="row">
            <div class="col-md-6">
                <div class="input-group input-group-static my-3">
                    <label class="">Company Name</label>
                    <input type="text" name="company_name[]" class="form-control">
                </div>
            </div>
            <div class="col-md-6">
                <div class="input-group input-group-static my-3">
                <label class="">Job Title</label>
                <input type="text" name="job_title[]" class="form-control">
            </div>
            </div>

        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="input-group input-group-static my-3">
                    <label class="">Start Date</label>
                    <input type="date" class="form-control" name="start_date[]" onfocus="focused(this)" onfocusout="defocused(this)">
                </div>
            </div>
            <div class="col-md-6">
                <div class="input-group input-group-static my-3">
                    <label class="">End Date</label>
                    <input type="date" class="form-control" name="end_date[]" onfocus="focused(this)" onfocusout="defocused(this)">
                </div>
            </div>
            <div class="col-md-12">
                <div class="input-group input-group-static my-3">
                    <label class="">Accomplishments</label>
                    <textarea class="form-control" name="accomplishments[]">
                    </textarea>
                </div>
            </div>

        </div>
        `
    }
    
</script>
@endsection