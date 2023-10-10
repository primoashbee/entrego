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
                                                    
                                <h6 class="mt-3 mb-2 ms-3 ">Job: {{$application->job->job_title}} | Exam: {{$quiz->name}}</h6>
                            
                        </div>

                        <div class="card-body">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-4">

                                    </div>
                                    <div class="col-8">
                                        

                                        <div class=" mb-3" v-for="(question, index) in questions" :key="index">
                                            <div class="input-group input-group-static">

                                                <label > @{{index + 1}} - <span class="font-weight-bold">@{{questions[index].question}} </span></label>
                                                <hr>
                                            </div>
                                            {{-- <pre> @{{question.choices}}</pre> --}}
                                            <p> -------------</p>
                                            {{-- <pre> @{{shuffledChoices(question.choices)}}</pre> --}}
                                            <div class="mt-2"v-for="(choices, choice_index) in question.choices" :key="choice_index">
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
                                                    </label>

                                                    {{-- <input type="text"  class="form-control px-2"  v-model="questions[index].choices[choice_index].answer"> --}}
                                                    
                                                </div>
                                                
                                            </div>
                                            
                                        </div>
                                        <div class="div" style="float: right;">
                                            <button @click="submit" :disabled="submitDisabled" class="btn btn-success"> Submit</button>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/lodash.js/4.17.21/lodash.min.js" integrity="sha512-WFN04846sdKMIP5LKNphMaWzU7YpMyCU245etK3g/2ARYbPK9Ub18eG+ljU96qKRCWh+quCY7yefSmlkQw1ANQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script type="module">
    
    import { createApp, ref, watch, computed  } from 'https://unpkg.com/vue@3/dist/vue.esm-browser.js'
  
    createApp({
      setup() {
        const schema = {
            'question': '',
            'choices' : [
                {
                    'choice':'choice_a',
                    'answer':'',
                    'is_answer':false
                },
                {
                    'choice':'choice_b',
                    'answer':'',
                    'is_answer':false
                },
                {
                    'choice':'choice_c',
                    'answer':'',
                    'is_answer':false
                },
                {
                    'choice':'choice_d',
                    'answer':'',
                    'is_answer':false
                },
            ]
        }
        const aplication_id = ref(@json($application->id))
        const questions = ref(@json($quiz->questions))
        const name = ref(@json($quiz->name))
        const job_group = ref(@json($quiz->job_group))
        const description = ref(@json($quiz->description))
        const has_passing = ref(@json($quiz->has_passing_rate === 1 ? 'true' :'false'))
        const passing_rate = ref(@json($quiz->passing_rate))

        function formatRecievedQuestions(q)
        {
            questions.value = q.map((item)=>{
                const formatted = {
                    id: item.id,
                    question: item.question,
                    choices: _.shuffle([
                        {
                            answer: item.choice_a,
                            choice: 'choice_a',
                            is_answer: item.answer == 'choice_a' ? 'on' : 'off',
                            user_answer: 'off,'
                        },
                        {
                            answer: item.choice_b,
                            choice: 'choice_b',
                            is_answer: item.answer == 'choice_b' ? 'on' : 'off',
                            user_answer: 'off,'
                        },
                        {
                            answer: item.choice_c,
                            choice: 'choice_c',
                            is_answer: item.answer == 'choice_c' ? 'on' : 'off',
                            user_answer: 'off,'
                        },
                        {
                            answer: item.choice_d,
                            choice: 'choice_d',
                            is_answer: item.answer == 'choice_d' ? 'on' : 'off',
                            user_answer: 'off,'
                        }
                    ])
                }

                return formatted
            })
        }

        formatRecievedQuestions(@json($quiz->questions))

        const answerPayload =()=>{
            const answers = questions.value.map((question, index)=>{

                const answer = question.choices.filter((choice, c_index)=> {
                        return choice.user_answer =='on'
                    })[0]?.choice

                const correct_answer = question.choices.filter((choice, c_index)=> {
                        return choice.is_answer =='on'
                    })[0]?.choice

                return {
                    id: question.id,
                    answer: answer,
                    correct: answer === correct_answer,
                    correct_answer: correct_answer
                }
            })
            return {
                application_id: aplication_id.value,
                answers: answers
            }
        }
        function checked(index, choice_index){
            questions.value[index].choices.forEach((choice, c_index)=>{
                choice.user_answer = "off"
                
                if(c_index == choice_index){
                    choice.user_answer = "on"
                }
            })
        }
        
        async function submit(){

            const accept = await Swal.fire({
                title: 'Submit examination?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes'
            })
            if(!accept.isConfirmed){
                return;
            }


            let alert = Swal.fire({
                title: 'Processing',
                timerProgressBar: true,
                didOpen: () => {
                    Swal.showLoading()
                },
            });
            const id = @json($quiz->id);
            const url = `/user-quiz/take`
            const res = await fetch(url, {
                'method': 'POST',
                'body': JSON.stringify(answerPayload()),
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
                'Quiz Saved',
                'success'
            )

            location.href = `/user-quiz/result/${id}`
            // location.href = '/quiz'
        }



        const submitDisabled = computed(()=>{
            let total = questions.value.length;
            const answered = questions.value.filter((question, index)=>{
                const eto = question.choices.filter((choice, c_index)=>{
                    return choice.user_answer == 'on'
                }).length
                return eto;
            }).length

           return total !== answered
        })

        return {
          questions,
          submit,
          checked,
          name,
          job_group,
          description,
          submitDisabled,
          has_passing,
          passing_rate,
          answerPayload,
        }
      }
    }).mount('#app')


</script>
@endsection