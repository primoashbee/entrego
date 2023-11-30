@extends('layouts.user')
@section('content')
    <div class="container-fluid py-4" id="div-view">
        <div class="row">
            @include('components.errors')
            <div class="col-lg-10 position-relative z-index-2">
                <div class="row mt-4">

                    <div class="col-4">
                        <div class="card mb-4 ">
                            <div class="d-flex">
                                <div
                                    class="icon icon-shape icon-lg bg-gradient-success shadow text-center border-radius-xl mt-n3 ms-4">
                                    <i class="material-icons opacity-10" aria-hidden="true">add</i>
                                </div>
                                <h6 class="mt-3 mb-2 ms-3 "> {{ $type_label }} </h6>
                            </div>

                            <div class="card-body">
                                <form action="{{ route('settings.store', $type) }}" method="POST">
                                    @csrf
                                    <div class="input-group input-group-static my-3">
                                        <label class="">{{substr($type_label, 0, -1)}} Name</label>
                                        <input type="text" name="value" class="form-control"
                                            onfocus="focused(this)" onfocusout="defocused(this)" required>
                                    </div>
                                    <input type="submit" class="btn btn-info">
                                </form>
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
        function show(div) {
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
