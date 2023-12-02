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

                            <div class="card-body">
                                <div class="table-responsive">
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
                                                {{$item->avg_tth}} days
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
                        </div>

                </div>
            </div>
        </div>
    </div>
@endsection


@section('scripts')
    <script>

@endsection
