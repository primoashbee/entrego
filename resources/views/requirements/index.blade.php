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
                            <div class="card">
                                <div class="table-responsive">
                                  <table class="table align-items-center mb-0">
                                    <thead>
                                      <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder">Name</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder">Required</th>

                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder">Requirement</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder">Status</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder">Action</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($list as $item)
                                        <tr>
                                            <td class="">
                                                <span class="text-xs font-weight-bold mb-0 mt-2"> {{ $item->user->fullname }}</span>
                                            </td>
                                            <td class="align-middle text-center">
                                                @if($item->requirement->required)
                                                    <span class="badge badge-pill bg-gradient-success"> Yes </span>

                                                @else
                                                <span class="badge badge-pill bg-gradient-info"> No </span>

                                                @endif
                                            </td>
                                            <td class="align-middle text-center">
                                                <span class="text-xs font-weight-bold mb-0 mt-2"> {{ $item->requirement->name }}</span>
                                            </td>                                            
                                            <td class="align-middle text-center">
                                                @if($item->status == "MISSING")
                                                    <span class="badge badge-pill bg-gradient-secondary"> Missing </span>
                                                @elseif($item->status == "PENDING_FOR_APPROVAL")
                                                    <span class="badge badge-pill bg-gradient-info"> Pending for Approval </span>
                                                @elseif($item->status == "REJECTED")
                                                    <span class="badge badge-pill bg-gradient-danger"> Rejected </span>
                                                @elseif($item->status == "APPROVED")
                                                    <span class="badge badge-pill bg-gradient-success"> Approved </span>
                                                @endif
                                            </td>
                                            <td class="align-middle text-center">
                                                <a href="{{route('requirement.download', $item->id)}}" class="text-secondary text-center font-weight-normal text-xs text-primary" data-toggle="tooltip" data-original-title="Edit item">
                                                    <i class="material-icons">remove_red_eye</i>
                                                </a>                                           
                                                <a href="javascript:void(0)" onclick="promptStatus({{$item->id}}, 'REJECTED')" class="text-secondary text-center font-weight-normal text-xs text-danger" data-toggle="tooltip" data-original-title="Edit item">
                                                    <i class="material-icons">cancel</i>
                                                </a>
                                                <a href="javascript:void(0)" onclick="promptStatus({{$item->id}}, 'APPROVED')" class="text-secondary text-center font-weight-normal text-xs text-success" data-toggle="tooltip" data-original-title="Edit item">
                                                    <i class="material-icons">check_circle</i>
                                                </a>
                                              </td>
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
    async function promptEmail(id){
        const { value: url } = await Swal.fire({
                                    input: 'url',
                                    inputLabel: 'Enter zoom URL',
                                    inputPlaceholder: 'Enter the URL'
                                })

        if (url) {
            const response = await Swal.fire({
                title: 'Confirmation',
                text: "Are you sure the zoom link is correct?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes'
            })

            if(response.isConfirmed){
                let alert = Swal.fire({
                    title: 'Processing',
                    timerProgressBar: true,
                    didOpen: () => {
                        Swal.showLoading()
                    },
                });

                await sendInterview(id, url)

                alert.close()

                await Swal.fire(
                    'Success!',
                    'Interview details sent!',
                    'success'
                )
                
            }
        }

    }
    async function sendInterview(id, link){
        const payload = {
            link: link
        }
        const res = await fetch(`/job/send-interview/${id}`, {
            'method': 'POST',
            'body': JSON.stringify(payload),
            'headers': {
                "Content-Type": "application/json",
                "Accept": "application/json",
                "X-Requested-With": "XMLHttpRequest",
                "X-CSRF-Token": '{{csrf_token()}}',
            },
            'content-type': 'application/json'
            })

    }

    async function promptStatus(id, status){
        const response = await Swal.fire({
                title: 'Confirmation',
                text: `Are you sure you want this requirement ${status}?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes'
            })

        if(!response.isConfirmed){
            return false;

        }
        let alert = Swal.fire({
                    title: 'Processing',
                    timerProgressBar: true,
                    didOpen: () => {
                        Swal.showLoading()
                    },
                });

        const res = await fetch(`/requirement/${id}`, {
          'method': 'PATCH',
          'body': JSON.stringify({status:status}),
          'headers': {
            "Content-Type": "application/json",
            "Accept": "application/json",
            "X-Requested-With": "XMLHttpRequest",
            "X-CSRF-Token": '{{csrf_token()}}',
          },
          'content-type': 'application/json'
        })

        alert.close()
        await Swal.fire(
            'Success!',
            'Requirement updated',
            'success'
        )
    }

   
</script>
@endsection