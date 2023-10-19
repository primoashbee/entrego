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
                        <div class="col-md-4 mx-3" v-for="(item, index) in requirements">

                            <div class="form-group">

                                <label class="font-weight-bold" :for="`requirement-${index}`">
                                    @{{item.requirement.name}}
                                </label> 
                                <br>
                                <input type="file" :disabled ="item.status =='APPROVED'"id="`requirement-${index}`" class="requirement-file" accept=".pdf, .doc, .docx">  
                            </div>
                            <span class="badge badge-pill bg-gradient-secondary" v-if="item.status=='MISSING'"> Missing </span>
                            <span class="badge badge-pill bg-gradient-info"   v-if="item.status=='MISSING'"> Pending for Approval </span>
                            <span class="badge badge-pill bg-gradient-danger" v-if="item.status=='REJECTED'"> Rejected </span>
                            <span class="badge badge-pill bg-gradient-success" v-if="item.status=='APPROVED'"> Approved </span>
                            <a :href="`/download/requirement/${item.id}`" target="_blank"  style="margin-bottom:-100px" v-if="item.status !='MISSING'">
                                {{-- View --}}
                                <i class="material-icons">file_download</i>
                            </a>
                    </div>
                    </div>
            </div>
        </div>
    </div>
</div>