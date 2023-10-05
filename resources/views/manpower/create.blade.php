@extends('layouts.user')
@section('content')
@include('components.errors')

<form action="{{route('manpower.store')}}" method="POST">
        @csrf
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-4"></div>
                <div class="col-lg-8 position-relative z-index-2">
                    <!-- Accounts Languages -->
                    <div class="row mt-4">
                        <div class="col-6">
                            <div class="card mb-4 ">
                                <div class="d-flex">
                                    <div
                                        class="icon icon-shape icon-lg bg-gradient-success shadow text-center border-radius-xl mt-n3 ms-4">
                                        <i class="material-icons opacity-10" aria-hidden="true">account_circle</i>
                                    </div>
                                    <h6 class="mt-3 mb-2 ms-3 ">Request for Manpower</h6>

                                </div>
                                <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-12 mb-3">
                                                <div class="input-group input-group-static">
                                                    <label class="">Job Group</label>
                                                    <select name="job_group" id="job_group" class="form-control">
                                                        <option value=""> Please Select</option>
                                                        @foreach($job_group as $job)
                                                        <option value="{{$job['value']}}"> {{ $job['label'] }} </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <div class="input-group input-group-static">
                                                    <label class="">Job Title</label>
                                                    <input type="text" name="job_title" class="form-control" value="{{old('job_title')}}">
                                                </div>
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <div class="input-group input-group-static">
                                                    <label class="">Job Description</label>
                                                    <textarea  name="description" class="form-control" value=""> {{old('description')}} </textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <div class="input-group input-group-static">
                                                    <label class="">Responsibilities</label>
                                                    <textarea  name="responsibilities" class="form-control" value=""> {{old('responsibilities')}} </textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <div class="input-group input-group-static">
                                                    <label class="">Qualifications</label>
                                                    <textarea  name="qualifications" class="form-control" value=""> {{old('qualifications')}} </textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <div class="input-group input-group-static">
                                                    <label class="">Benefits</label>
                                                    <textarea  name="benefits" class="form-control" value=""> {{old('benefits')}} </textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <div class="input-group input-group-static">
                                                    <label class="">Vacancy</label>
                                                    <select name="vacancies" id="vacancies" class="form-control">
                                                        <option value=""> Please Select</option>
                                                        <option value="1"> 1 Position</option>
                                                        <option value="2"> 2 Position</option>
                                                        <option value="3"> 3 Position</option>
                                                        <option value="4"> 4 Position</option>
                                                        <option value="5"> 5 Position</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <div class="input-group input-group-static">
                                                    <label class="">Job Nature</label>
                                                    <select name="job_nature" id="job_nature" class="form-control">
                                                        <option value=""> Please Select</option>
                                                        <option value="FULL_TIME"> Full Time</option>
                                                        <option value="PART_TIME"> Part Time</option>
                                                        <option value="CONTRACT"> Contract </option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <div class="input-group input-group-static">
                                                    <label class="">Location</label>
                                                    <select name="location" id="location" class="form-control">
                                                        <option value=""> Please Select</option>
                                                        <option value="DAVAO"> Davao </option>
                                                        <option value="CEBU"> Cebu </option>
                                                        <option value="NCR"> NCR </option>
                                                        <option value="PAMPANGA"> Pampanga </option>
                                                        <option value="LEGAZPI"> Legazpi </option>
                                    
                                                    </select>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-6 mb-3">
                                                <div class="input-group input-group-static">
                                                    <label class="">Deadline</label>
                                                    <input type="date" name="expires_at" class="form-control" value="{{ old("expires_at") }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <div class="input-group input-group-static">
                                                    <label class="">Required Experience</label>
                                                    <select name="required_experience"  id="required_experience" class="form-control">
                                                        <option value=""> Please Select</option>
                                                        @foreach($experiences as $experience)
                                                        <option value="{{$experience['value']}}"> {{ $experience['label'] }}</option>
                                                        @endforeach
                                                        <option value="FRESH"> < 1 Year </option>
                                                        <option value="JUNIOR"> 1-3 Years </option>
                                                        <option value="MID"> 3-5 Years </option>
                                                        <option value="SENIOR"> >5 Years </option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <div class="input-group input-group-static">
                                                    <label class=""> Department</label>
                                                    <select name="department" id="department" class="form-control">
                                                        <option value=""> Please Select</option>
                                                        @foreach($departments as $department)
                                                        <option value="{{$department['value']}}"> {{ $department['label'] }}</option>
                                                        @endforeach

                                                    </select>
                                                </div>
                                            </div>




                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Account -->
                    <button class="btn text-right btn-primary" type="submit">Submit</button>

                </div>
            </div>
        </div>
<script>
    (function(){
        job_group = document.getElementById('job_group')
        job_group.value = "{{old('job_group')}}"

        vacancies = document.getElementById('vacancies')
        vacancies.value = "{{old('vacancies')}}"

        job_nature = document.getElementById('job_nature')
        job_nature.value = '{{old('job_nature')}}'

        select_location = document.getElementById('location')
        select_location.value = "{{old('location')}}"

        required_experience = document.getElementById('required_experience')
        required_experience.value = "{{old('required_experience')}}"

        department = document.getElementById('department')
        department.value = "{{old('department')}}"


    })()
</script>
@endsection