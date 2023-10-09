@extends('layouts.user')

@section('content')
<div class="container-fluid py-4" id="app">
    <div class="row">
        <div class="col-lg-2 col-lg-10 position-relative z-index-2">
            <div class="row mt-4">
                <div class="col-10">
                    <div class="card mb-4 ">
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
                                        <h6>Score: {{$application->userQuiz->score}} / {{$application->job->quiz->questions()->count()}}</h6>
                                        <h6> Result: 
                                            @if($application->userQuiz->is_passed)
                                                <span class="text-success"> Passed</span>
                                            @else
                                                <span class="text-danger"> Failed</span>
                                            @endif
                                        </h6>

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
                                    <div class="col-8">
                                        <div class=" mb-3" v-for="(question, index) in questions" :key="index">
                                            <div class="input-group input-group-static">
                                                <label > @{{index + 1}} - <span class="font-weight-bold">@{{questions[index].question}} </span></label>
                                            </div>
                                            <div class="answers px-2 mt-2" v-for="(choices, choice_index) in question.choices" :key="choice_index">
                                                <div class="form-check px-0">
                                                    <input type="radio" 
                                                        class="form-check-input"
                                                        :id="`questions-${index}-choices-${choice_index}-user_answer`" 
                                                        :checked="questions[index].choices[choice_index].user_answer =='on'" 
                                                        :name="`questions.${index}`" 
                                                        @change="checked(index,choice_index)" 
                                                    />                                                   
                                                    <label class="custom-control-label" :for="`questions-${index}-choices-${choice_index}-user_answer`">
                                                        @{{questions[index].choices[choice_index].answer}} 
                                                        <span class="font-weight-bold text-success " v-if="questions[index].choices[choice_index].is_answer && questions[index].choices[choice_index].user_answer =='on'" > <i class="material-icons" style="vertical-align: bottom;">check_box</i> Correct</span>
                                                        <span class="font-weight-bold text-success" v-if="questions[index].choices[choice_index].is_answer && questions[index].choices[choice_index].user_answer =='off'" > <i class="material-icons" style="vertical-align: bottom;">check_box</i> Correct Answer</span>
                                                        <span class="font-weight-bold text-danger" v-if="!questions[index].choices[choice_index].is_answer && questions[index].choices[choice_index].user_answer =='on'"> <i class="material-icons" style="vertical-align: bottom;">close</i> Wrong</span>
                                                    </label>                                                
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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
<script type="module">
    import { createApp, ref, watch, computed  } from 'https://unpkg.com/vue@3/dist/vue.esm-browser.js'
  
    createApp({
      setup() {
        const questions = ref(@json($questions))

        function checked(index, choice_index){
            questions.value[index].choices.forEach((choice, c_index)=>{
                choice.is_answer = "off"
                
                if(c_index == choice_index){
                    choice.is_answer = "on"
                }
            })
        }
    

        return {
          questions,
        }
      }
    }).mount('#app')


</script>
@endsection