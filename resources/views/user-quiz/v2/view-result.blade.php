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
                                        <h6>Applicant: {{$application->user->fullname}} </h6>
                                        <h6>Email:  {{$application->user->email}} </h6>
                                        <h6>Score: {{$application->userQuiz->score}} / {{$application->job->quiz->questions()->count()}}</h6>
                                        <h6> Result: 
                                            @if($application->userQuiz->is_passed)
                                                <span class="text-success"> Passed</span>
                                            @else
                                                <span class="text-danger"> Failed</span>
                                            @endif
                                        </h6>

                                        <h6>Required: {{$application->job->quiz->passing_rate}} %</h6>
                                        <h6>Time Elapsed: {{$application->userQuiz->time_elapsed}}</h6>
                                        <div class="row">
                                            <div class="col-4">
                                                <h6> My Result:</h6>
                                            </div>
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

                                        </div>


                                    </div>
                                    <div class="col-8">
                                        <div class=" mb-3" v-for="(question, index) in questions" :key="index">
                                            <div class="input-group input-group-static">

                                                <label > @{{index + 1}} - <span class="font-weight-bold">@{{questions[index].question}} </span></label>
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
                                                    <span class="font-weight-bold text-info">Answer</span> : <em>@{{questions[index].question_data.user_answer}}</em>
                                                    <span class="font-weight-bold text-success " v-if="questions[index].question_data.answer == questions[index].question_data.user_answer" > <i class="material-icons" style="vertical-align: bottom;">check_box</i> Correct</span>
                                                    <span class="font-weight-bold text-danger " v-if="questions[index].question_data.answer != questions[index].question_data.user_answer" > <i class="material-icons" style="vertical-align: bottom;">close</i> Wrong <br></span>
                                                    <template v-if="questions[index].question_data.answer != questions[index].question_data.user_answer">
                                                    <br>
                                                    <span class="font-weight-bold text-success">Correct Answer </span> : <strong>@{{questions[index].question_data.answer}}</strong>

                                                    </template>
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
    </div>
</div>
@endsection

@section('scripts')
<script type="module">
    import { createApp, ref, watch, computed  } from 'https://unpkg.com/vue@3/dist/vue.esm-browser.js'
  
    createApp({
      setup() {
        const questions = ref(@json($questions))
        console.log(questions.value)
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
    

        return {
          questions,
          unAnswered
        }
      }
    }).mount('#app')


</script>
@endsection