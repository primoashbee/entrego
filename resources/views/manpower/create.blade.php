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
                                                    <input type="checkbox" name="has_sjt" id="has_sjt" onclick="hasSJTClicked()" value='chcked' >
                                                    <label class="pl-2" for="has_sjt"> &nbsp; Has SJT </label>

                                                </div>
                                            </div>
                                            <div class="col-md-12 mb-3" id="div-sjt" style="display:none">
                                                <div class="input-group input-group-static">
                                                    <label class=""> SJT/ CSA </label>
                                                    <select name="quiz_id" id="quiz_id" class="form-control">
                                                        <option value=""> Please Select</option>
                                                        @foreach($quizzes as $quiz)
                                                        <option value="{{$quiz['id']}}"> {{ $quiz['name'] }} </option>
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
                                            <div class="col-md-6 mb-3">
                                                <div class="input-group input-group-static">
                                                    <label class="">Vacancy</label>
                                                    {{-- <select name="vacancies" id="vacancies" class="form-control">
                                                        <option value=""> Please Select</option>
                                                        @foreach($vacancies as $vacancy)
                                                        <option value="{{$vacancy['value']}}"> {{$vacancy['label']}}</option>
                                                        @endforeach
                                                    </select> --}}
                                                    <input type="number" class="form-control" id="vacancies" name="vacancies" min="1" step="1" />

                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <div class="input-group input-group-static">
                                                    <label class="">Job Nature</label>
                                                    <select name="job_nature" id="job_nature" class="form-control">
                                                        <option value=""> Please Select</option>
                                                        <option value="FULL_TIME"> Full Time</option>
                                                        <option value="PART_TIME"> Part Time</option>
                                                        <option value="CONTRACT"> Contract </option>
                                                        <option value="PROJECT_BASED"> Project Based </option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <div class="input-group input-group-static">
                                                    <label class="">Job Level</label>
                                                    <select name="job_level" id="job_level" class="form-control">
                                                        <option value=""> Please Select</option>
                                                        @foreach($levels as $loc)
                                                        <option value="{{$loc->key}}"> {{ $loc->value }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <div class="input-group input-group-static">
                                                    <label class="">Location</label>
                                                    <select name="location" id="location" class="form-control">
                                                        <option value=""> Please Select</option>
                                                        @foreach($locations as $loc)
                                                        <option value="{{$loc->key}}"> {{ $loc->value }}</option>
                                                        @endforeach
                                    
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
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <div class="input-group input-group-static">
                                                    <label class=""> Department</label>
                                                    <select name="department" id="department" class="form-control">
                                                        <option value=""> Please Select</option>
                                                        @foreach($departments as $department)
                                                        <option value="{{$department->key}}"> {{ $department->value }}</option>
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

        job_level = document.getElementById('job_level')
        job_level.value = "{{old('job_level')}}"

        job_nature = document.getElementById('job_nature')
        job_nature.value = "{{old('job_nature')}}"

        quiz_id = document.getElementById('quiz_id')
        quiz_id.value = "{{old('quiz_id')}}"




    })()
    function hasSJTClicked()
    {
        sjt = document.getElementById('div-sjt')
        has_sjt = document.getElementById('has_sjt')
        if(has_sjt.checked===true){
            sjt.style.display = null
        }else{
            sjt.style.display = 'none'
        }
    }

</script>
@endsection