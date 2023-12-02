@extends('layouts.user')
@section('content')
    <div class="container-fluid py-4" id="div-view">
        <div class="row">
            @include('components.errors')
            <div class="col-lg-10 position-relative z-index-2">

                    <div class="col-12">
                        <div class="card mb-4 ">
                            <div class="d-flex">
                                <div
                                    class="icon icon-shape icon-lg bg-gradient-success shadow text-center border-radius-xl mt-n3 ms-4">
                                    <i class="material-icons opacity-10" aria-hidden="true">format_list_bulleted</i>
                                </div>
                                <h6 class="mt-3 mb-2 ms-3 ">{{ ucwords(str_replace("-"," ",request()->type))}} </h6>
                            </div>
                            <form action="{{url()->current()}}" method="GET" id="frmFilter">
                            <input type="hidden" name="export" value="export" id="hidden_export" disabled>

                            <div class="card-body">
                                <div class="table-responsive">
                                    <div class="row" id="div-filters"> 
                                        <div class="col-2">
                                            <div class="input-group input-group-static mb-4">
                                                <label>From Date</label>
                                                <input type="date" class="form-control form-filter" name="start_date" id="start_date"  >
                                              </div>                                    
                                        </div>
                                        <div class="col-2">
                                            <div class="input-group input-group-static mb-4">
                                                <label>End Date</label>
                                                <input type="date" class="form-control form-filter" name="end_date" id="end_date"  >
                                              </div>                                    
                                        </div>
                                        <div class="col-7"></div>
                                        <div class="col-1">
                                            <button class="btn btn-lg btn-success mt-3" type="button" value="export" name="export" id="btnExport"><i class="material-icons">print</i></button>
                                        </div>
    
                                    </div>
                                    <div class="row"> 
                                        <div class="col-2">
                                 
                                        </div>
                                        <div class="col-3">
                                   
                                        </div>
                                        <div class="col-3">
                                   
                                        </div>
                                        <div class="col-1"></div>
                                        <div class="col-3">
                                            <div class="input-group input-group-outline mb-3">
                                                <input type="text" class="form-control form-filter" style="height:42px" placeholder="Search"  name="q" id="q" value="{{request()->q}}">
                                                <div class="input-group-append">
                                                    <button class="btn btn-primary" type="submit">Search</button>
                                                </div>
                                            </div>
                                        </div>
                                        
                                    </div>
                                    <table class="table align-items-center mb-0">
                                      <thead>
                                        <tr>
                                          <th class="text-uppercase text-secondary text-xxs font-weight-bolder">Job</th>
                                          <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder">Requested</th>
  
                                          <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder">Deployed</th>
                                          <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder">Fulfillment Rate</th>
                                          <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder">AVG Time to Hire</th>
                                        </tr>
                                      </thead>
                                      <tbody>
                                        @foreach($list as $item)
                                        <tr>
                                            <td class="">
                                                {{$item->job_title}}
                                            </td>
                                            <td class="align-middle text-center">
                                                {{$item->requested}}
                                            </td>
                                            <td class="align-middle text-center">
                                                {{$item->deployed}}
                                            </td>
                                            <td class="align-middle text-center">
                                                {{$item->fulfillment_rate}}
                                            </td>
                                            <td class="align-middle text-center">
                                                @if($item->avg_tth)
                                                {{$item->avg_tth}} days
                                            @else
                                             - 
                                            @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                      </tbody>
                                      <tfoot>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                      </tfoot>
                                    </table>
                                  </div>
                            </div>
                            </form>
                        </div>

                </div>
            </div>
        </div>
    </div>
@endsection


@section('scripts')
    <script>
        (function () {

        document.getElementById('start_date').value = "{{request()->start_date == '' ? old('start_date') : request()->start_date }}"
        document.getElementById('end_date').value = "{{request()->end_date == '' ? old('end_date') : request()->end_date}}"
        document.getElementById('q').value = "{{request()->q == '' ? old('q') : request()->q}}"


    })();
    document.getElementById('frmFilter').addEventListener("submit", function(event){
        Array.from(document.getElementsByClassName('form-filter')).forEach(element => {
            if(element.value == "" ){
                element.disabled=true
            }
        });

    })
    document.getElementById('btnExport').addEventListener('click', function(event){
        Array.from(document.getElementsByClassName('form-filter')).forEach(element => {
            if(element.value == "" ){
                element.disabled=true
            }
        });
        
        // document.getElementById('div-filters').innerHTML = document.getElementById('div-filters').innerHTML + input
        document.getElementById('hidden_export').disabled = false
        document.getElementById('frmFilter').submit()
        document.getElementById('hidden_export').disabled = true

    })
    </script>

@endsection
