@extends('layouts.user')
@section('content')
<div class="container-fluid py-4" id="div-view">
    <div class="row">
        
        <div class="col-lg-10 position-relative z-index-2">
            @if(session()->has('success'))
            <div class="alert alert-success text-white mx-3" role="alert">
                <strong>Success!</strong> {{session()->get('success')}}
            </div>
            @endif
            <div class="row mt-4">

                <div class="col-12">
                    <div class="card mb-4 ">
                        <div class="d-flex">
                            <div
                                class="icon icon-shape icon-lg bg-gradient-success shadow text-center border-radius-xl mt-n3 ms-4">
                                <i class="material-icons opacity-10" aria-hidden="true">group</i>
                            </div>
                            <h6 class="mt-3 mb-2 ms-3 ">Manpower Requests</h6>
                        </div>

                        <div class="card-body">
                            <a href="{{route('manpower.create')}}" class="btn btn-success" style="float: right; margin-bottom: 0%">Add New Request</a>
                            <div class="float-right">&nbsp;</div><br>
                            <div class="card">
                                <div class="table-responsive">
                                  <table class="table align-items-center mb-0">
                                    <thead>
                                      <tr>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Job Tile</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Job Group</th>
                                        {{-- <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">E-mail</th> --}}
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Job Nature</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"> Vacancies </th>

                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Department</th>
                                        <th class=" text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Requested At</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Action</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($list as $item)
                                      <tr>
                                        <td>
                                            <a href="{{route('job.create', $item->id)}}" target="_blank"><p class="text-center text-xs font-weight-bold mb-0">{{ $item->job_title }}</p></a>
                                        </td>
                                        <td>
                                          <p class=" text-center text-xs font-weight-bold mb-0">{{ $item->job_group_name }}</p>
                                        </td>
                                        <td>
                                          <p class=" text-center text-xs font-weight-bold mb-0">{{ $item->job_nature_name }}</p>
                                        </td>
                                        <td>
                                          <p class=" text-center text-xs font-weight-bold mb-0">
                                            <a href="#" manpower-title="{{$item->job_title}}" class="modalOpen" manpower-id="{{$item->id}}">{{$item->applications_count}} </a>/ {{ $item->vacancies }}
                                          </p>
                                        </td>
                                        <td>
                                          <p class=" text-center text-xs font-weight-bold mb-0">{{ $item->department_name }}</p>
                                        </td>
                                        <td class="">
                                          @if(auth()->user()->role == 'ADMINISTRATOR')
                                            <div class="form-check form-switch text-center">
                                              <input class="form-check-input" type="checkbox" manpower-id="{{$item->id}}" id="flexSwitchCheckDefault" {{$item->active ? 'checked=""': ''}}>
                                            </div>
                                          @else
                                            @if($item->active)
                                                <span class="badge bg-gradient-success"> Active </span>
                                            @else
                                                <span class="badge bg-gradient-secondary"> Pending </span>
                                            @endif
                                          @endif
                                            {{-- @if($item->active)
                                                <p class="text-center"><span class="badge bg-gradient-success"> Active </span></p>
                                            @else
                                                <p class="text-center"><span class="badge bg-gradient-secondary"> Pending </span></p>
                                            @endif --}}
                                        </td>
                                        <td>
                                            <p class=" text-center text-xs font-weight-bold mb-0">{{ $item->created_at->diffForHumans() }}</p>
                                          </td>
                                        <td class="align-middle">
                                          <a href="{{route('manpower.edit', $item->id)}}" class="text-secondary font-weight-normal text-xs text-success" data-toggle="tooltip" data-original-title="Edit item">
                                            <i class="material-icons">edit</i>
                                          </a>
                                          @if(auth()->user()->role == 'ADMINISTRATOR')

                                          <a href="javascript:void(0)" manpower-id="{{$item->id}}" data-value="" onclick="deleteRecord({{json_encode($item)}})" class="px-2 text-secondary font-weight-normal text-xs text-danger" data-toggle="tooltip" data-original-title="Edit item">
                                            <i class="material-icons">delete</i>
                                          </a>
                                          @endif
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


<!-- Modal -->
<div class="modal fade modal-lg" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title font-weight-normal" id="exampleModalLabel">Manpower : <span id="lblManPowerTitle"></span></h5>
        <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div id="content">
          asdasds
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
        {{-- <button type="button" class="btn bg-gradient-primary">Save changes</button> --}}
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script>
  (function(){
    const switches = document.querySelectorAll(".form-check-input");
    switches.forEach(function(toggle) {
      toggle.addEventListener("change", async function() {
        const new_state = toggle.checked
        const text = new_state ? 'ACTIVATED' : 'DISABLED'
        const payload = {
          active: new_state,
          _method: "PATCH"
        }
        const id = this.getAttribute('manpower-id')
        const res = await fetch(`/manpower/${id}`, {
          'method': 'PATCH',
          
          'body': JSON.stringify(payload),
          'headers': {
            "Content-Type": "application/json",
            "Accept": "application/json",
            "X-Requested-With": "XMLHttpRequest",
            "X-CSRF-Token": '{{csrf_token()}}',
          },
          'content-type': 'application/json'
        })
        if(res.status === 200){
          const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
          });

          Toast.fire({
            icon: 'success',
            title: `Manpower request status ${text}`
          })
        }
      });
    });
  })()

  const myModal = new bootstrap.Modal(document.getElementById('exampleModal'));

  document.querySelectorAll('.modalOpen').forEach((el)=>{
    el.addEventListener('click' , async (e)=>{
      e.preventDefault()
      const id = el.getAttribute('manpower-id')
      const title = el.getAttribute('manpower-title')

      document.getElementById('lblManPowerTitle').innerHTML = title
      document.getElementById("content").innerHTML = ''

      const data = await getDeployedList(id)
      const application_list = data.data.applications
      let trows = '';
      application_list.forEach((application)=>{
        const row = `
          <tr>
              <td>
                  <a href="/users/update/${application.user.id}" target="_blank"><p  class="text-center text-xs font-weight-bold mb-0"> ${application.user.email} </p></a>
              </td>
              <td>
                  <p class="text-center text-xs font-weight-bold mb-0">${application.user.first_name} ${application.user.last_name}</p>
              </td>
              <td>
                  <p class="text-center text-xs font-weight-bold mb-0">${application.status} </p>
              </td>
          </tr>
        `
        trows = trows + row
      })
      const html = `
      <div class="table-responsive">
        <table class="table align-items-center mb-0">
          <thead>
            <tr>
              <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Email</th>
              <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Name</th>
              <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
            </tr>
          </thead>
          <tbody>
            ${trows}
          </tbody>
          </table>
        </div>
      `
      document.getElementById("content").innerHTML = html

      myModal.show()

    })
  })

  async function getDeployedList(manpower_id){
    const result  =  await fetch(`/manpower/${manpower_id}/deployed`, {
          'headers': {
              "X-CSRF-Token": '{{csrf_token()}}' 
          },
          'method': 'GET',
          'content-type': 'application/json'
      })
    const  data  = await result.json()
    return data
  }
  async function deleteRecord(item){
    console.log(item)
    // const data = JSON.parse(item);
    const data = item;
    const {result} = await Swal.fire({
      title: 'Are you sure you want to delete this?',
      showCancelButton: true,
      confirmButtonText: 'Yes',
      denyButtonText: `Cancel`,
    })
    // .then((result) => {
    //   /* Read more about isConfirmed, isDenied below */
    //   if (result.isConfirmed) {
    //     Swal.fire('Saved!', '', 'success')
    //   } else if (result.isDenied) {
    //     Swal.fire('Changes are not saved', '', 'info')
    //   }
    // })
    if(result.isConfirmed){
      const res = await fetch(`/manpower/${data.id}`, {
          'headers': {
              "X-CSRF-Token": '{{csrf_token()}}' 
          },
          'method': 'DELETE',
          'content-type': 'application/json'
      })
      if(res.status === 200){
          const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
          });

          Toast.fire({
            icon: 'success',
            title: 'Manpower request successfully DELETED'
          })
        }
        return;
    }
    const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
          });

    Toast.fire({
      icon: 'info',
      title: 'Delete cancelled'
    })


  }

</script>
@endsection