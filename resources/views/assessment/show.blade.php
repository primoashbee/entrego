@extends('layouts.user')
@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-2"></div>
        <div class="col-10 position-relative z-index-2">
            <div class="row mt-4">
                <div class="col-10">
                    <div class="card mb-4 ">
                        <div class="d-flex">
                            <div
                                class="icon icon-shape icon-lg bg-gradient-success shadow text-center border-radius-xl mt-n3 ms-4">
                                <i class="material-icons opacity-10" aria-hidden="true">group</i>
                            </div>
                                                    
                            <h6 class="mt-3 mb-2 ms-3 ">Personal Assessments</h6>

                        </div>

                        <div class="card-body">
                            <div class="col-12 ">
                                @foreach($data as $item)

                                <div class="text-center mt-3">
                                    {{-- <figure>
                                        <blockquote class="blockquote">
                                          <p class="ps-2"> {{$item}}</p>
                                        </blockquote>
                                        <figcaption class="blockquote-footer ps-3">
                                          <cite title="Source Title">Source Title</cite> Someone famous in 
                                        </figcaption>
                                      </figure> --}}
                                      <h5 class="lead"> Question #{{$item->question->position}}</h5>
                                      <h6 style="margin-left: 30px">{{$item->question->question}}</h6>

                                      <div class="px-5">
                                        @if($item->reversed)
                                            <span> Accurate</span>
                                            <input type="radio"  value="5" style="margin-left:25px;transform:scale(2)" {{$item->answer == "5" ? 'checked' : ''}}>
                                            <input type="radio"  value="4" style="margin-left:25px;transform:scale(2)" {{$item->answer == "4" ? 'checked' : ''}}>
                                            <input type="radio"  value="3" style="margin-left:25px;transform:scale(2)" {{$item->answer == "3" ? 'checked' : ''}}>
                                            <input type="radio"  value="2" style="margin-left:25px;transform:scale(2)" {{$item->answer == "2" ? 'checked' : ''}}>
                                            <input type="radio"  value="1" style="margin-left:25px;transform:scale(2);margin-right:25px" {{$item->answer == "1" ? 'checked' : ''}}>
                                            <span> Inaccurate</span>    
                                        @else
                                            <span> Accurate</span>
                                            <input type="radio"  value="1" style="margin-left:25px;transform:scale(2)" {{$item->answer == "1" ? 'checked' : ''}}>
                                            <input type="radio"  value="2" style="margin-left:25px;transform:scale(2)" {{$item->answer == "2" ? "checked" : ''}}>
                                            <input type="radio"  value="3" style="margin-left:25px;transform:scale(2)" {{$item->answer == "3" ? "checked" : ''}}>
                                            <input type="radio"  value="4" style="margin-left:25px;transform:scale(2)" {{$item->answer == "4" ? "checked" : ''}}>
                                            <input type="radio"  value="5" style="margin-left:25px;transform:scale(2);margin-right:25px" {{$item->answer == "5" ? 'checked' : ''}}>
                                            <span> Inaccurate</span>
                                        @endif
                                    </div>
                                </div>
                                @endforeach

                            </div>
                        </div>

                     
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection