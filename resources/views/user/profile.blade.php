@extends('layouts.user')
@section('content')
@include('components.errors')
    <div id="app">
        @if (request()->route('id'))
            <form action="{{ route('users.update', request()->route('id')) }}" method="POST" id="frmSubmit"
                enctype="multipart/form-data">
            @else
                <form action="{{ route('profile.update') }}" method="POST" id="frmSubmit" enctype="multipart/form-data">
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
                                                <input type="text" name="first_name" class="form-control"
                                                    v-model="profile.first_name"
                                                    
                                                    >
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="input-group input-group-static my-3">
                                                <label class="">Middle Name</label>
                                                <input type="text" name="middle_name" class="form-control"
                                                    v-model="profile.middle_name"
                                                    >
                                                    
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="input-group input-group-static my-3">
                                                <label class="">Last Name</label>
                                                <input type="text" name="last_name" class="form-control"
                                                    v-model="profile.last_name"

                                                    >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="input-group input-group-static">
                                                <label>Birthday</label>
                                                <input type="date" class="form-control" name="birthday"
                                                   onfocus="focused(this)"
                                                    onfocusout="defocused(this)" 
                                                    v-model="profile.birthday"
                                                    >
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="input-group input-group-static">
                                                <label for="gender" class="ms-0">Gender</label>
                                                <select class="form-control" id="gender" name="gender" v-model="profile.gender"
                                                    data-gtm-form-interact-field-id="0">
                                                    <option >Please select</option>
                                                    <option value="Female"> Female </option>
                                                    <option value="Male"> Male </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="input-group input-group-static">
                                                <label class="">Contact Number</label>
                                                <input type="text" name="contact_number" class="form-control"
                                                    v-model="profile.contact_number"
                                                    >
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="input-group input-group-static">
                                                <label class="">E-mail</label>
                                                <input type="text" name="email" class="form-control"
                                                     readonly disabled
                                                    v-model="profile.email"

                                                    >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="input-group input-group-static my-3">
                                                <label>Street</label>
                                                <input type="text" class="form-control" name="street"
                                                    v-model="profile.street"
                                                    >
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="input-group input-group-static my-3">
                                                <label>Landmark</label>
                                                <input type="text" class="form-control" name="landmark"
                                                    v-model="profile.landmark"

                                                    >
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="input-group input-group-static my-3">
                                                <label>City</label>
                                                <input type="text" class="form-control" name="city"
                                                    v-model="profile.city"

                                                    >
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="input-group input-group-static my-3">
                                                <label>Brgy</label>
                                                <input type="text" class="form-control" name="barangay"
                                                    v-model="profile.barangay"

                                                    >
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="input-group input-group-static my-3">
                                                <label>Zip Code</label>
                                                <input type="text" class="form-control" name="zip_code"
                                                    v-model="profile.zip_code"

                                                    >
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
                                <div class="card-body" id="frmWorkSection" v-for="(work, key) in works">
                                    <button type="button" class="btn btn-warning" style="float: right;" @click="removeWork(key)">X</button>
                                   
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="input-group input-group-static my-3">
                                                <label class="">Company Name</label>
                                                <input type="text" name="company_name[]" v-model="work.company_name" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="input-group input-group-static my-3">
                                                <label class="">Job Title</label>
                                                <input type="text"  name="job_title[]" v-model="work.job_title" class="form-control">
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="input-group input-group-static my-3">
                                                <label class="">Start Date</label>
                                                <input type="date" class="form-control"  v-model="work.start_date" name="start_date[]"
                                                    onfocus="focused(this)" onfocusout="defocused(this)">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="input-group input-group-static my-3">
                                                <label class="">End Date</label>
                                                <input type="date" class="form-control" v-model="work.end_date" name="end_date[]"
                                                    onfocus="focused(this)" onfocusout="defocused(this)">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="input-group input-group-static my-3">
                                                <label class="">Accomplishments</label>
                                                <textarea class="form-control" v-model="work.accomplishments"  name="accomplishments[]">
                                                    </textarea>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div class="col-12  mr-5">
                                    <button class="btn btn-success btn-lg mr-5" style="float: right; margin-right:25px"
                                        type="button" @click="addWork">Add</button>
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
                                                <textarea name="skills" class="form-control"
                                                    v-model="profile.skills"
                                                >{{ $user->skills }}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="input-group input-group-static">
                                                <label class="">Languages</label>
                                                <textarea name="languages" class="form-control"
                                                    v-model="profile.languages"
                                                >{{ $user->languages }}</textarea>
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
                                    <h6 class="mt-3 mb-2 ms-3 ">Attachments</h6>

                                </div>
                                <div class="card-body">

                                    <div class="form-group">
                                        <label for="cv">Resume / CV (.pdf, .doc, docx)</label><br>
                                        <input 
                                            type="file" 
                                            name="cv" 
                                            id="cv" 
                                            accept=".pdf, .doc, .docx" 
                                            
                                            @change="uploadFile('cv')" ref="cv"
                                            >

                                    </div>
                                    @if ($user->has_cv)
                                        <a href="{{ route('download.cv', $user->id) }}" target="_blank">
                                            Download uploaded
                                            <i class="material-icons">file_download</i>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="card mb-4 ">
                                <div class="d-flex">
                                    <div
                                        class="icon icon-shape icon-lg bg-gradient-success shadow text-center border-radius-xl mt-n3 ms-4">
                                        <i class="material-icons opacity-10" aria-hidden="true">vpn_key</i>
                                    </div>
                                    <h6 class="mt-3 mb-2 ms-3 ">Password</h6>

                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="input-group input-group-static">
                                                <label class="">Role</label>
                                                <select class="form-control" name="role" id="role" v-model="profile.role">
                                                    <option >Please select</option>
                                                    <option value="ADMINISTRATOR">ADMINISTRATOR</option>
                                                    <option value="SUB_HR">SUB HR</option>
                                                    <option value="APPLICANT">APPLICANT</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="input-group input-group-static">
                                                <label class="">Password</label>
                                                <input type="password" name="password" class="form-control" v-model="profile.password">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="input-group input-group-static">
                                                <label class="">Password Confirmation</label>
                                                <input type="password" name="password_confirmation" class="form-control" v-model="profile.password_confirmation">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    @if (auth()->user()->isApplicant() && $user->canUploadRequirements())
                        @include('components.requirements')
                    @endif
                    <!-- End Account -->

                    <button class="btn text-right btn-primary" type="submit">Update Profile</button>
                </div>
            </div>
            @include('components.footer')
        </div>
        </form>
    </div>


    <script>
        (function() {
            gender = document.getElementById("gender")
            gender.value = '{{ $user->gender }}'
            role = document.getElementById("role")
            role.value = '{{ $user->role }}'
            @if (auth()->user()->role !== 'ADMINISTRATOR')
                role.disabled = true
                role.readonly = true
            @endif


            const frm = document.getElementById('frmSubmit')
            const requirements = document.getElementsByClassName('requirement-file')
            frm.addEventListener('submit', event => {
                cv = document.getElementById('cv')
                if (cv.value === '') {
                    cv.remove()
                }
                Array.from(requirements).forEach((el) => {
                    if (el.value === '') {
                        el.remove()
                    }
                })
            })
        })();

    </script>
@endsection


@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lodash.js/4.17.21/lodash.min.js"
        integrity="sha512-WFN04846sdKMIP5LKNphMaWzU7YpMyCU245etK3g/2ARYbPK9Ub18eG+ljU96qKRCWh+quCY7yefSmlkQw1ANQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        
    <script type="module">
        import {
            createApp,
            ref,
            watch,
            computed,
            onMounted
        } from 'https://unpkg.com/vue@3/dist/vue.esm-browser.js'

        createApp({
            setup() {
                const profile = ref(@json($user))
                const works = ref(@json($user->workHistory))
                const requirements = ref(@json($requirements))
                const role = ref(@json(auth()->user()->role))
              
                const addWork = () => {
                    works.value.push({})
                }
                function removeWork(index){
                    works.value.splice(index,1)
                }

                function uploadFile(ref){
                    console.log(this.$refs[ref].files[0])
                    console.log(this.$refs)
                }

                // function formCheck(){
                //     if(role.value == 'SUB_HR'){
                //         document.querySelectorAll('.form-control').forEach( el => {
                //             el.disabled = true
                //         })
                //     }
                // }
                return {
                    profile,
                    works,
                    addWork,
                    removeWork,
                    uploadFile,
                    requirements
                }
            }
        }).mount('#app')
    </script>   

@endsection