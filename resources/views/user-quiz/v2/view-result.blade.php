@extends('layouts.user')

@section('content')
<div class="container-fluid py-4" id="app">
    <div class="row">
        
            <div class="col-lg-8 ">
                <div class="">
                    <div class="col-12">
                        <div class="card">
                            <div class="d-flex">
                                <div
                                    class="icon icon-shape icon-lg bg-gradient-success shadow text-center border-radius-xl mt-n3 ms-4">
                                    <i class="material-icons opacity-10" aria-hidden="true">group</i>
                                </div>
                                                        
                                <h6 class="mt-3 mb-2 ms-3 ">Job: {{$application->job->job_title}} | Exam: {{$application->job->quiz->name}}</h6>
    
                                
                            </div>
    
                            <div class="card-body">
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-4">
                                            <h6>Applicant: {{$application->user->fullname}} </h6>
                                            <h6>Email:  {{$application->user->email}} </h6>
                                            
                                            @if(is_null($application->userQuiz->is_passed))
                                            <h6>Score: - </h6>
                                            @else
                                            <h6>Score: {{$application->userQuiz->score}} / {{$application->job->quiz->questionsv2()->count()}}</h6>
                                            @endif
                                            <h6> Result: 
                                                @if($application->userQuiz->is_passed)
                                                    <span class="text-success"> Passed</span>
                                                @elseif(is_null($application->userQuiz->is_passed))
                                                    <span class="text-warnning"> Pending</span>
    
                                                @else
                                                    <span class="text-danger"> Failed</span>
                                                @endif
                                            </h6>
    
                                            <h6>Required: {{$application->job->quiz->passing_rate}} %</h6>
                                            @if($application->job->quiz->has)_timer
                                            <h6>Time Elapsed: {{$application->userQuiz->time_elapsed}}</h6>
                                            @endif
                                            <div class="row">
                                                <div class="col-4">
                                                    <h6> My Result:</h6>
                                                </div>
                                                @if(is_null($application->userQuiz->is_passed))
                                                 Pending
                                                @else
                                                <div class="col-8" style="margin-left:-30px">
                                                    <div class="progress">
                                                        @if($application->userQuiz->percentage < 50)
                                                            <div class="progress-bar bg-gradient-danger" style="width: {{$application->userQuiz->percentage}}%; height:20px">{{$application->userQuiz->percentage}}%</div>
                                                        @elseif($application->userQuiz->percentage >= 50 &&  $application->userQuiz->percentage <= 75)
                                                            <div class="progress-bar bg-gradient-secondary" style="width: {{$application->userQuiz->percentage}}%; height:20px">{{$application->userQuiz->percentage}}%</div>
                                                        @else
                                                            <div class="progress-bar bg-gradient-success" style="width: {{$application->userQuiz->percentage}}%; height:20px">{{$application->userQuiz->percentage}}%</div>    
                                                        @endif
                                                    </div>
                                                </div>
                                                @endif
    
    
                                            </div>
    
    
                                        </div>
                                        <div class="col-8">
                                            <div class=" mb-3" v-for="(question, index) in questions" :key="index">
                                                @if(auth()->user()->role != "APPLICANT")
                                                <span class="font-weight-bold" v-if="question.quiz_question.question_type==='essay' || question.quiz_question.question_type==='identification'" > 
                                                    <a href="" @click.prevent="markAnswer(index, false)" :class="{'text-danger': question.is_correct != null && !question.is_correct}"><i class="material-icons">thumb_down</i></a>
    
                                                    <a href="" @click.prevent="markAnswer(index, true)" :class="{'text-success': question.is_correct}" class="mx-2"><i class="material-icons">thumb_up</i></a>
                                                </span> 
                                                @else
                                                <span class="font-weight-bold" v-if="question.quiz_question.question_type==='essay' || question.quiz_question.question_type==='identification'" > 
                                                    <a href="" @click.prevent="" :class="{'text-danger': question.is_correct != null && !question.is_correct}"><i class="material-icons">thumb_down</i></a>
    
                                                    <a href="" @click.prevent="" :class="{'text-success': question.is_correct}" class="mx-2"><i class="material-icons">thumb_up</i></a>
                                                </span> 
                                                @endif
                                                <div class="input-group input-group-static">
                                                    <label >        
                                                            @{{index + 1}} - 
                                                        <span class="font-weight-bold">@{{questions[index].question}} </span>
                                                    </label>
                                                    <hr>
                                                </div>
                                                <template v-if="questions[index].quiz_question.question_type ==='choice'">
                                                    <div class="answers px-2 mt-2">
                                                        <div class="input-group input-group-dynamic mb-4 is-filled" v-for="(choice, choice_index) in questions[index].question_data.choices">
                                                            <input type="radio" :name="`question-${index}`" :id="`question-${index}-${choice_index}`" :checked="questions[index].question_data.choices[choice_index].user_answer =='on'" 
                                                            >
                                                            <label :for="`question-${index}-${choice_index}`" class="mx-2 pt-2"> 
                                                                @{{questions[index].question_data.choices[choice_index].answer}}  
                                                                <span class="font-weight-bold text-success " v-if="questions[index].question_data.choices[choice_index].is_answer=='on' && questions[index].question_data.choices[choice_index].user_answer =='on'" > <i class="material-icons" style="vertical-align: bottom;">check_box</i> Correct</span>
                                                                <span class="font-weight-bold text-success " v-if="questions[index].question_data.choices[choice_index].is_answer=='on' && questions[index].question_data.choices[choice_index].user_answer =='off'" > <i class="material-icons" style="vertical-align: bottom;">check_box</i> Correct Answer</span>
                                                                <span class="font-weight-bold text-danger " v-if="questions[index].question_data.choices[choice_index].is_answer=='off' && questions[index].question_data.choices[choice_index].user_answer =='on'" > <i class="material-icons" style="vertical-align: bottom;">close</i> Wrong</span>
                                                                {{-- <span class="font-weight-bold text-success" v-if="questions[index].choices[choice_index].is_answer && questions[index].choices[choice_index].user_answer =='off'" > <i class="material-icons" style="vertical-align: bottom;">check_box</i> Correct Answer</span> --}}
                                                                {{-- <span class="font-weight-bold text-danger" v-if="!questions[index].choices[choice_index].is_answer && questions[index].choices[choice_index].user_answer =='on'"> <i class="material-icons" style="vertical-align: bottom;">close</i> Wrong</span> --}}
                                                            </label>
                                                        </div>
                                                    </div>
                                                </template>
                                                <template v-if="questions[index].quiz_question.question_type ==='boolean'">
                                                    <div class="answers px-2 mt-2">
                                                        <div class="input-group input-group-dynamic mb-4 is-filled" v-for="(choice, choice_index) in questions[index].question_data.choices">
                                                            <input type="radio" :name="`question-${index}`" :id="`question-${index}-${choice_index}`" :checked="questions[index].question_data.choices[choice_index].user_answer =='on'" 
                                                            >
                                                            <label :for="`question-${index}-${choice_index}`" class="mx-2 pt-2"> 
                                                                @{{questions[index].question_data.choices[choice_index].answer}}  
                                                                <span class="font-weight-bold text-success " v-if="questions[index].question_data.choices[choice_index].is_answer=='on' && questions[index].question_data.choices[choice_index].user_answer =='on'" > <i class="material-icons" style="vertical-align: bottom;">check_box</i> Correct</span>
                                                                <span class="font-weight-bold text-success " v-if="questions[index].question_data.choices[choice_index].is_answer=='on' && questions[index].question_data.choices[choice_index].user_answer =='off'" > <i class="material-icons" style="vertical-align: bottom;">check_box</i> Correct Answer</span>
                                                                <span class="font-weight-bold text-danger " v-if="questions[index].question_data.choices[choice_index].is_answer=='off' && questions[index].question_data.choices[choice_index].user_answer =='on'" > <i class="material-icons" style="vertical-align: bottom;">close</i> Wrong</span>
                                                                {{-- <span class="font-weight-bold text-success" v-if="questions[index].choices[choice_index].is_answer && questions[index].choices[choice_index].user_answer =='off'" > <i class="material-icons" style="vertical-align: bottom;">check_box</i> Correct Answer</span> --}}
                                                                {{-- <span class="font-weight-bold text-danger" v-if="!questions[index].choices[choice_index].is_answer && questions[index].choices[choice_index].user_answer =='on'"> <i class="material-icons" style="vertical-align: bottom;">close</i> Wrong</span> --}}
                                                            </label>                                                    </div>
                                                    </div>
                                                </template>
                                                <template v-if="questions[index].quiz_question.question_type ==='identification'">
                                                    <div class="input-group input-group-static">
                                                        <label class=>
                                                        <span class="font-weight-bold text-warning">Answered</span> : <em>@{{questions[index].question_data.user_answer}}</em>
    
                                                        </label>
                                                        {{-- <input type="text" class="form-control px-2" v-model="questions[index].question_data.user_answer" readonly > --}}
                                                    </div>
                                                </template>
                                                <template v-if="questions[index].quiz_question.question_type ==='essay'">
                                                    <div class="input-group input-group-static">
                                                        <label class=>
                                                        <span class="font-weight-bold text-warning">Answered</span> : <em>@{{questions[index].question_data.user_answer}}</em>
    
                                                        </label>
                                                        {{-- <input type="text" class="form-control px-2" v-model="questions[index].question_data.user_answer" readonly > --}}
                                                    </div>
                                                </template>
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @if(auth()->user()->role != 'APPLICANT')
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        Check List:
                        <ul class="list-group list-group-flush">
                                <li class="list-group-item" v-for="(question, index) in questions"> 
                                    <p> 
                                        <span  :class="{'font-weight-bold text-success': question.is_correct != null }"> <i class="material-icons">check_circle</i></span>                                        
                                        <small>@{{index+1}}. @{{question.question}} </small><p>
                                </li>
                        </ul>
                        
                        <button class="btn btn-success" v-if="canSubmit" @click="submit">Submit</button>
                    </div>
                </div>
            </div>
            @endif
    </div>
</div>
@endsection

@section('scripts')
<script type="module">
    import { createApp, ref, watch, computed  } from 'https://unpkg.com/vue@3/dist/vue.esm-browser.js'
  
    createApp({
      setup() {
        const questions = ref(@json($questions))
        function checked(index, choice_index){
            return false;
            questions.value[index].choices.forEach((choice, c_index)=>{
                choice.is_answer = "off"
                
                if(c_index == choice_index){
                    choice.is_answer = "on"
                }
            })
        }

        function unAnswered(choices){
            return
            return choices.filter((choice, index)=>{
                return choice.user_answer == 'on'
            })?.length == 0
        }

        function markAnswer(question_index, is_correct){
            questions.value[question_index].is_correct = is_correct
        }

        const canSubmit = computed(()=>{
            return !questions.value.filter((q)=>q.is_correct == null).length > 0 
        })


        async function submit(){
            const { isConfirmed } = await Swal.fire({
                title: "Checking",
                text: "Submit checked quiz?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes"
                })

            console.log(isConfirmed)
            if(!isConfirmed){
                return;
            }
            const application_id = @json(request()->application_id);
            const url = `/v2/user-quiz/result/${application_id}`;
            const payload = {
                questions : questions.value
            }
            const res = await fetch(url, {

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

            await Swal.fire({
                title: "Success!",
                text: "SJT/CSA reviewed",
                icon: "success"
            });

            location.reload();
        }

        return {
          questions,
          unAnswered,
          markAnswer,
          canSubmit,
          submit
        }
      }
    }).mount('#app')


</script>
@endsection