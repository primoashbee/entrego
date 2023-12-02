@php
    $user = auth()->user();
@endphp
<aside
class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3   bg-gradient-dark"
id="sidenav-main">

<div class="sidenav-header">
    <i class="fas fa-times p-3 cursor-pointer text-white opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
        aria-hidden="true" id="iconSidenav"></i>
    <a class="navbar-brand m-0" href="{{route('user.dashboard')}}"
        target="_blank">
        <img src="{{ asset('img/logo-ct.png') }}" class="navbar-brand-img h-100" style="max-height: 100%!important; margin-top:-20%" alt="main_logo">
        {{-- <span class="ms-1 font-weight-bold text-white">{{ config('app.name') }}</span> --}}
    </a>
</div>


<hr class="horizontal light mt-0 mb-2">
<div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
    <ul class="navbar-nav">
        @if($user->role != "APPLICANT")
        <li class="nav-item">
            <a class="nav-link text-white " href="{{route('user.dashboard')}}">

                <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                    <i class="material-icons opacity-10">dashboard</i>
                </div>

                <span class="nav-link-text ms-1">Dashboard</span>
            </a>
        </li>
        @endif

        @if($user->role == "ADMINISTRATOR" || $user->role =="SUB_HR" || $user->role == "HR")
        <li class="nav-item">
            <a class="nav-link text-white " href="{{route('manpower.index')}}">

                <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                    <i class="material-icons opacity-10">person_add</i>
                </div>

                <span class="nav-link-text ms-1">Manpower Requests</span>
            </a>
        </li>
        @endif

        @if(in_array($user->role , ['ADMINISTRATOR','SUB_HR','HR']))
        <li class="nav-item">
            <a class="nav-link text-white " href="{{ route('quiz.index') }}">

                <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                    <i class="material-icons opacity-10">attach_file</i>
                </div>

                <span class="nav-link-text ms-1">SJT / CSA</span>
            </a>
        </li>
        @endif


        

        @if($user->role == "ADMINISTRATOR")
        <li class="nav-item">
            <a class="nav-link text-white " href="{{ route('personal-assessments.index') }}">

                <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                    <i class="material-icons opacity-10">person_pin</i>
                </div>

                <span class="nav-link-text ms-1">Personality Assessments</span>
            </a>
        </li>
        @endif

        @if($user->role == "ADMINISTRATOR")
        <li class="nav-item mb-2 mt-0">
            <a data-bs-toggle="collapse" href="#ProfileNav" class="nav-link text-white collapsed" aria-controls="ProfileNav"
                role="button" aria-expanded="false">
                <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                    <i class="material-icons opacity-10">people</i>
                </div>
                <span class="nav-link-text ms-2 ps-1">Users</span>
            </a>
            <div class="collapse" id="ProfileNav" style="">
                <ul class="nav ">
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{route('users.index.type', 'active')}}">
                            {{-- <span class="sidenav-mini-icon"> A </span> --}}
                            <span class="sidenav-normal  ms-3  ps-1"> Active </span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{route('users.index.type', 'archived')}}">
                            {{-- <span class="sidenav-mini-icon"> S </span> --}}
                            <span class="sidenav-normal  ms-3  ps-1"> Archived</span>
                        </a>
                    </li>
                </ul>
            </div>
        </li>
        @endif
        

        {{-- @if($user->role == "ADMINISTRATOR")
        <li class="nav-item">
            <a class="nav-link text-white " href="{{ route('users.index') }}">

                <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                    <i class="material-icons opacity-10">people</i>
                </div>

                <span class="nav-link-text ms-1">Users</span>
            </a>
        </li>
        @endif --}}

        {{-- @if($user->role == "ADMINISTRATOR" || $user->role =="HR")
        <li class="nav-item">
            <a class="nav-link text-white " href="{{route('applicants.index')}}">

                <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                    <i class="material-icons opacity-10">group</i>
                </div>

                <span class="nav-link-text ms-1">Applicants</span>
            </a>
        </li>
        @endif --}}

        @if($user->role == "ADMINISTRATOR" || $user->role =="HR")
        <li class="nav-item mb-2 mt-0">
            <a data-bs-toggle="collapse" href="#ApplicantNav" class="nav-link text-white collapsed" aria-controls="ApplicantNav"
                role="button" aria-expanded="false">
                <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                    <i class="material-icons opacity-10">people</i>
                </div>
                <span class="nav-link-text ms-2 ps-1">Applicants</span>
            </a>
            <div class="collapse" id="ApplicantNav" style="">
                <ul class="nav ">
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{route('users.index.type', 'active-applicant')}}">
                            {{-- <span class="sidenav-mini-icon"> A </span> --}}
                            <span class="sidenav-normal  ms-3  ps-1"> Active </span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{route('users.index.type', 'archived-applicant')}}">
                            {{-- <span class="sidenav-mini-icon"> S </span> --}}
                            <span class="sidenav-normal  ms-3  ps-1"> Archived</span>
                        </a>
                    </li>
                </ul>
            </div>
        </li>
        @endif

        @if($user->role == "ADMINISTRATOR" || $user->role =="APPLICANT" || $user->role ="HR")
        <li class="nav-item">
            <a class="nav-link text-white " href="{{route('user-job.index')}}">
                <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                    <i class="material-icons opacity-10">work</i>
                </div>
                <span class="nav-link-text ms-1">Job Applications</span>
            </a>
        </li>
        @endif

        @if(auth()->user()->role == 'APPLICANT')
        <li class="nav-item">
            <a class="nav-link text-white " href="{{route('job.listing')}}">
                <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                    <i class="material-icons opacity-10">filter_none</i>
                </div>
                <span class="nav-link-text ms-1">Job Listings</span>
            </a>
        </li>
        @endif

        @if(auth()->user()->role == 'ADMINISTRATOR')
        <li class="nav-item">
            <a class="nav-link text-white " href="{{route('requirements.index')}}">
                <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                    <i class="material-icons opacity-10">table_view</i>
                </div>
                <span class="nav-link-text ms-1">Requirements</span>
            </a>
        </li>
        @endif

        @if(auth()->check() && auth()->user()->role == 'ADMINISTRATOR')
        <li class="nav-item">
            <a class="nav-link text-white " href="{{route('audit.index')}}">

                <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                    <i class="material-icons opacity-10">assignment</i>
                </div>

                <span class="nav-link-text ms-1">Audit Logs</span>
            </a>
        </li>
        @endif
        @if(auth()->check() && auth()->user()->role != 'APPLICANT')
        <li class="nav-item">
            <a class="nav-link text-white " href="{{route('report.index','success-rate')}}">

                <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                    <i class="material-icons opacity-10">clear_all</i>
                </div>

                <span class="nav-link-text ms-1">Success Rate</span>
            </a>
        </li>
        @endif
        @if(auth()->check() && auth()->user()->role != 'APPLICANT')
        <li class="nav-item">
            <a class="nav-link text-white " href="{{route('report.index','fulfillment-rate')}}">

                <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                    <i class="material-icons opacity-10">format_list_bulleted</i>
                </div>

                <span class="nav-link-text ms-1">Fulfillment Rate</span>
            </a>
        </li>
        @endif


        <hr class="horizontal light mt-0 mb-2">

        @if(auth()->user()->role !='APPLICANT')
        <li class="nav-item">
            <a class="nav-link text-white " href="{{route('settings.index')}}">
                <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                    <i class="material-icons opacity-10">settings</i>
                </div>
                <span class="nav-link-text ms-1">Settings</span>
            </a>
        </li>

        @endif
        <li class="nav-item">
            <a class="nav-link text-white " href="{{route('profile.edit')}}">
                <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                    <i class="material-icons opacity-10">person</i>
                </div>
                <span class="nav-link-text ms-1">Profile</span>
            </a>
        </li>

        @if(!auth()->check())
        <li class="nav-item">
            <a class="nav-link text-white " href="./sign-in.html">

                <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                    <i class="material-icons opacity-10">login</i>
                </div>

                <span class="nav-link-text ms-1">Sign In</span>
            </a>
        </li>

        
        <li class="nav-item">
            <a class="nav-link text-white " href="./sign-up.html">

                <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                    <i class="material-icons opacity-10">assignment</i>
                </div>

                <span class="nav-link-text ms-1">Sign Up</span>
            </a>
        </li>
        @else

        <li class="nav-item">
            <a class="nav-link text-white" href="javascript:void(0)" onclick="logout()">

                <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                    <i class="material-icons opacity-10">subdirectory_arrow_left</i>
                </div>

                <span class="nav-link-text ms-1">Sign Out</span>
                
            </a>
        </li>
        @endif

        
    </ul>
</div>

</aside>