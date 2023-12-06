@extends('layouts.user')
@section('content')
@include('components.errors')

<form action="{{route('manpower.update', $manpower->id)}}" method="POST">
        @method('PUT')
        @csrf
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-4">
                    <div class="card">
                        <div class="card-body">
                            Logs
                            @foreach($manpower->notes as $log)
                            <ul class="list-group list-group-flush">
                            <figure>

                                <blockquote class="blockquote">
                                    
                                <p class="ps-2" ><small>
                                        Notes: {{$log->notes}}
                                        </small>
                                    </p>
                                </blockquote>
                                <figcaption class="blockquote-footer ps-3">
                                {{$log->doneBy->fullname}} <cite title="Source Title">{{$log->created_at->diffForHumans()}}</cite>
                                </figcaption>
                            </figure>
                            </ul>
                        @endforeach
                        </div>
                    </div>
                </div>
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
                                                    <label class=""> Department</label>
                                                    <select name="department" id="department" class="form-control">
                                                        <option value=""> Please Select</option>
                                                        @foreach($departments as $department)
                                                        <option value="{{$department->key}}"> {{ $department->value }}</option>
                                                        @endforeach

                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-12 mb-3">
                                                <div class="input-group input-group-static">
                                                    <label class="">Job Title</label>
                                                    <input type="text" name="job_title" class="form-control" value="{{$manpower->job_title}}">
                                                </div>
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <div class="input-group input-group-static">
                                                    <input type="checkbox" name="has_sjt" id="has_sjt" onclick="hasSJTClicked()" @if($manpower->has_sjt) checked @endif>
                                                    <label class="pl-2" for="has_sjt"> &nbsp; Has SJT </label> 

                                                </div>
                                            </div>
                                            <div class="col-md-12 mb-3"  id="div-sjt" @if(!$manpower->has_sjt) checked @endif>
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
                                                    <label class="">Job Description</label>
                                                    <textarea  name="description" class="form-control" value=""> {{$manpower->description}} </textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <div class="input-group input-group-static">
                                                    <label class="">Responsibilities</label>
                                                    <textarea  name="responsibilities" class="form-control" value=""> {{$manpower->responsibilities}} </textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <div class="input-group input-group-static">
                                                    <label class="">Qualifications</label>
                                                    <textarea  name="qualifications" class="form-control" value=""> {{$manpower->qualifications}} </textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <div class="input-group input-group-static">
                                                    <label class="">Benefits</label>
                                                    <textarea  name="benefits" class="form-control" value=""> {{$manpower->benefits}} </textarea>
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
                                                        @foreach($job_natures as $key=>$value)
                                                        <option value="{{$value->key}}"> {{$value->value}} </option>
                                                        @endforeach
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
                                                    <input type="date" name="expires_at" class="form-control" value="{{ $manpower->expires_at }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <div class="input-group input-group-static">
                                                    <label class="">Required Experience</label>
                                                    <select name="required_experience"  id="required_experience" class="form-control">
                                                        <option value=""> Please Select</option>
                                                        @foreach($experiences as $key=>$value)
                                                        <option value="{{$value->key}}"> {{$value->value}} </option>
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
                    <button class="btn text-right btn-primary" type="submit">UPDATE</button>

                </div>
            </div>
        </div>
@endsection
@section('scripts')
<script>
    (async function(){


        vacancies = document.getElementById('vacancies')
        vacancies.value = "{{$manpower->vacancies}}"

        job_nature = document.getElementById('job_nature')
        job_nature.value = '{{$manpower->job_nature}}'

        select_location = document.getElementById('location')
        select_location.value = "{{$manpower->location}}"

        required_experience = document.getElementById('required_experience')
        required_experience.value = "{{$manpower->required_experience}}"

        department = document.getElementById('department')
        department.value = "{{$manpower->department}}"

        quiz_id = document.getElementById('quiz_id')
        quiz_id.value = "{{$manpower->quiz_id}}"

        job_level = document.getElementById('job_level')
        job_level.value = "{{$manpower->job_level}}"

        job_nature = document.getElementById('job_nature')
        job_nature.value = "{{$manpower->job_nature}}"

        required_experience = document.getElementById('required_experience')
        required_experience.value = "{{$manpower->required_experience}}"

        @if(session()->has('success'))
            await Swal.fire(
                'Success!',
                'Manpower request updated',
                'success'
                )
        @endif

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