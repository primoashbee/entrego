<div class="row mt-4">
    <div class="col-12">
        <div class="card mb-4 ">
            <div class="d-flex">
                <div
                    class="icon icon-shape icon-lg bg-gradient-success shadow text-center border-radius-xl mt-n3 ms-4">
                    <i class="material-icons opacity-10" aria-hidden="true">assignment_late
                    </i>
                </div>
                <h6 class="mt-3 mb-2 ms-3 ">Requirements</h6>

            </div>
            <div class="card-body">
                    <div class="row">
                        <p class="text-center"> Accepts  (.pdf, .doc, docx) </p>
                        @foreach($requirements as $item)
                        <div class="col-md-4 mx-3">

                            <div class="form-group">

                                <label class="font-weight-bold" for="requirement[{{$item->id}}">
                                    {{$item->requirement->name}}
                                </label> 
                                <br>
                                <input type="file" @if($item->status=='APPROVED') disabled @endif name="requirement[{{$item->id}}]" id="requirement[{{$item->id}}" class="requirement-file" accept=".pdf, .doc, .docx">  
                            </div>
                            
                            @if($item->status == "MISSING")
                                <span class="badge badge-pill bg-gradient-secondary"> Missing </span>
                            @elseif($item->status == "PENDING_FOR_APPROVAL")
                                <span class="badge badge-pill bg-gradient-info"> Pending for Approval </span>
                            @elseif($item->status == "REJECTED")
                                <span class="badge badge-pill bg-gradient-danger"> Rejected </span>
                            @elseif($item->status == "APPROVED")
                                <span class="badge badge-pill bg-gradient-success"> Approved </span>
                            @endif
                            @if($item->isUploaded())
                                <a href="{{route('requirement.download', $item->id)}}" target="_blank"  style="margin-bottom:-100px">
                                    {{-- View --}}
                                    <i class="material-icons">file_download</i>
                                </a>
                            @endif
                        </div>
                        @endforeach
                    </div>
            </div>
        </div>
    </div>
</div>