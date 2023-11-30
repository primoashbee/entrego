@extends('layouts.user')
@section('content')
<div class="container-fluid py-4" id="div-view">
    <div class="row">
        
        <div class="col-lg-10 position-relative z-index-2">
            <div class="row mt-4">

                <div class="col-12">
                    <div class="card mb-4 ">
                        <div class="d-flex">
                            <div
                                class="icon icon-shape icon-lg bg-gradient-success shadow text-center border-radius-xl mt-n3 ms-4">
                                <i class="material-icons opacity-10" aria-hidden="true">assignment_late</i>
                            </div>
                            <h6 class="mt-3 mb-2 ms-3 "> Requirements </h6>
                        </div>

                        <div class="card-body">
                        
                            @if(request()->route()->getName() === "users.index")
                            <a href="{{route('users.create')}}" class="btn btn-success" style="float: right; margin-bottom: 0%">Add New User</a>
                            <div class="float-right">&nbsp;</div><br>
                            @endif
                            <div class="card">
                                <div class="nav-wrapper position-relative end-0">
                                  <ul class="nav nav-pills nav-fill p-1" role="tablist">
                                    <li class="nav-item" onclick="show('locations')">
                                      <a class="nav-link mb-0 px-0 py-1 active" data-bs-toggle="tab"  role="tab" aria-controls="preview" aria-selected="true" >
                                      <span class="material-icons align-middle mb-1">
                                        location_city
                                      </span>
                                      Locations
                                      </a>
                                    </li>
                                    <li class="nav-item" onclick="show('departments')">
                                      <a class="nav-link mb-0 px-0 py-1" data-bs-toggle="tab"  role="tab" aria-controls="code" aria-selected="false" >
                                        <span class="material-icons align-middle mb-1">
                                            group
                                        </span>
                                        Departments
                                      </a>
                                    </li>
                                    <li class="nav-item" onclick="show('job_levels')">
                                      <a class="nav-link mb-0 px-0 py-1" data-bs-toggle="tab"  role="tab" aria-controls="code" aria-selected="false" >
                                        <span class="material-icons align-middle mb-1">
                                            work
                                        </span>
                                        Job Levels
                                      </a>
                                    </li>
                                  </ul>
                                </div>

                                <!-- Locations Table -->
                                <div class="table-responsive" id="tbl_locations">
                                <h1> Locations </h1>
                                <a href="{{route('settings.create', 'location')}}" class="btn btn-success" style="float: right; margin-bottom: 0%">Add New Location</a>
                                  <table class="table align-items-center mb-0">
                                    <thead>
                                      <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Name</th>
                                        {{-- <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Role</th> --}}
                                        {{-- <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">E-mail</th> --}}
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Action</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($locations as $item)
                                        <tr>
                                            <td>{{$item->value}}</td>
                                            <td></td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                  </table>
                                </div>

                                <!-- Departments Table -->
                                <div class="table-responsive" id="tbl_departments" style="display: none;">
                                    <h1> Departments </h1>
                                <a href="{{route('settings.create', 'department')}}" class="btn btn-success" style="float: right; margin-bottom: 0%">Add New Department</a>

                                  <table class="table align-items-center mb-0">
                                    <thead>
                                      <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Name</th>
                                        {{-- <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Role</th> --}}
                                        {{-- <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">E-mail</th> --}}
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Action</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                            @foreach($departments as $item)
                                            <tr>
                                                <td>{{$item->value}}</td>
                                                <td></td>
                                            </tr>
                                            @endforeach
                                    </tbody>
                                  </table>
                                </div>
                                <!-- Job Levels Table -->
                                <div class="table-responsive" id="tbl_job_levels" style="display: none;">
                                    <h1> Job Levels </h1>
                                    <a href="{{route('settings.create', 'job_level')}}" class="btn btn-success" style="float: right; margin-bottom: 0%">Add New Job Level</a>

                                  <table class="table align-items-center mb-0">
                                    <thead>
                                      <tr>
                                        <th class=" text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Name</th>
                                        {{-- <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Role</th> --}}
                                        {{-- <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">E-mail</th> --}}
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Action</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($job_levels as $item)
                                        <tr>
                                            <td>{{$item->value}}</td>
                                            <td></td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                  </table>
                                </div>
                              </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection


@section('scripts')
<script>
function show(div){
  locations = document.getElementById('tbl_locations');
  departments = document.getElementById('tbl_departments');
  job_levels = document.getElementById('tbl_job_levels');
  locations.style.display = 'none'
  departments.style.display = 'none'
  job_levels.style.display = 'none'

  document.getElementById(`tbl_${div}`).style.display = null
}
</script>
@endsection