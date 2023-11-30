@extends('layouts.user')

@section('content')
<div class="container-fluid py-4" id="app">
    <div class="sticky-top">...</div>
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
                                            <template v-if="questions[index].question_type ==='choice'">
                                                <div class="answers px-2 mt-2">
                                                    <div class="input-group input-group-dynamic mb-4 is-filled" v-for="(choice, choice_index) in questions[index].question_data.choices">
                                                        <input type="radio" :name="`question-${index}`" :id="`question-${index}-${choice_index}`" @change="choiceAnswerSelected(index, choice_index)">
                                                        <label :for="`question-${index}-${choice_index}`" class="mx-2 pt-2"> @{{questions[index].question_data.choices[choice_index].answer}} </label>
                                                    </div>
                                                </div>
                                            </template>
                                            <template v-if="questions[index].question_type ==='boolean'">
                                                <div class="answers px-2 mt-2">
                                                    <div class="input-group input-group-dynamic mb-4 is-filled" v-for="(choice, choice_index) in questions[index].question_data.choices">
                                                        <input type="radio" :name="`question-${index}`" :id="`question-${index}-${choice_index}`"   @change="choiceAnswerSelected(index, choice_index)">
                                                        <label :for="`question-${index}-${choice_index}`" class="mx-2 pt-2"> @{{questions[index].question_data.choices[choice_index].answer}} </label>
                                                    </div>
                                                </div>
                                            </template>
                                            <template v-if="questions[index].question_type ==='identification'">
                                                <div class="input-group input-group-static">
                                                    <label class=>Answer</label>
                                                    <input type="text" class="form-control px-2" v-model="questions[index].question_data.user_answer" >
                                                </div>
                                            </template>
                                            
                                        </div>
                                        <div class="div" style="float: right;">
                                            {{-- <button @click="submit" :disabled="submitDisabled" class="btn btn-success"> Submit</button> --}}
                                            <button @click="submit()"  class="btn btn-success"> Submit</button>
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
    
    import { createApp, ref, watch, computed, onMounted  } from 'https://unpkg.com/vue@3/dist/vue.esm-browser.js'
  
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
        // const questions = ref(@json($quiz->questionsv2)).map((q)=>{ return q})
        const questions_unformatted = ref(@json($quiz->questionsv2))
        const questions = ref(questions_unformatted.value.map((x)=>{ 
            x['question_data']['user_answer'] = null; 
            return x;
        }))
        const name = ref(@json($quiz->name))
        const job_group = ref(@json($quiz->job_group))
        const description = ref(@json($quiz->description))

        const has_passing = ref(@json($quiz->has_passing_rate === 1 ? 'true' :'false'))
        const passing_rate = ref(@json($quiz->passing_rate))

        const has_timer = ref(@json($quiz->has_timer))
        const time_in_seconds = ref(@json($quiz->time_in_seconds));
        // const time_in_seconds = ref(5);
        const time_left =  ref(@json($quiz->time_in_seconds));
        // const time_left =  ref(5);
        const time_elapsed =  ref(0);
        let timer;
        onMounted(async()=>{
            if(@json($taken)){
                const accept = await Swal.fire({
                    title: 'Information',
                    text: "You've already finished this examination. Redirecting you to the result",
                    icon: 'info',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes'
                })

                location.href = `/user-quiz/result/${@json($application->id)}`
                return;

            }
            // const accept = await Swal.fire({
            //     title: 'Information?',
            //     text: "This is a timed quiz. Start quiz now?",
            //     icon: 'info',
            //     showCancelButton: true,
            //     confirmButtonColor: '#3085d6',
            //     cancelButtonColor: '#d33',
            //     confirmButtonText: 'Yes'
            // })

            // if(!accept.isConfirmed){
            //     location.reload();
            //     return;
            // };
            

            // timer = startTimer()

            // window.onbeforeunload = function(evt) {
            // var message = 'Leaving this site will make you quiz fail';
            // if (typeof evt == 'undefined') {
                // evt = window.event;
            // }
            // if (evt) {
                // evt.returnValue = message;
            // }

            // return message;
        // }
        })

        
        function choiceAnswerSelected(index, choice_index)
        {
            
            let answer = 'tae'
            questions.value[index].question_data.choices.forEach((choice,c_index)=>{
                choice.user_answer = "off"
                if(c_index == choice_index){
                    choice.user_answer = "on"
                    answer = choice.choice

                }
            })
            // questions.value[index].question_data.answer = answer
            questions.value[index].question_data.user_answer = answer

        }
        function startTimer(){
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: time_left.value * 1000,
                timerProgressBar: true,
                // didOpen: (toast) => {
                //     toast.addEventListener('mouseenter', Swal.stopTimer)
                //     toast.addEventListener('mouseleave', Swal.resumeTimer)
                // }
            })

            Toast.fire({
                icon: 'success',
                title: 'Time Left',
                html: `<span id="time-left-span">${timerFormatted.value}</span>`
            })
            const el = document.getElementById('time-left-span')
            return setInterval(() => {
                el.innerHTML = timerFormatted.value
                time_left.value = time_left.value - 1
            }, 1000);
        }
        
        const timerFormatted = computed(()=>{

            const total = time_left.value

            const minutes = String(Math.floor(total / 60))
            const seconds = String(total % 60);
            return `${minutes.padStart(2, '0')}:${seconds.padStart(2, '0')}`            
        })

        watch(time_left, async (newVal, oldVal)=>{
            console.log(time_elapsed.value)
            time_elapsed.value = time_in_seconds.value - time_left.value
            if(time_left.value == 0){
                await submit(true)
            }
        })
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

        // formatRecievedQuestions(@json($quiz->questionsv2))

        const answerPayload =()=>{
            // const answers = questions.value.map((question, index)=>{

            //     const answer = question.choices.filter((choice, c_index)=> {
            //             return choice.user_answer =='on'
            //         })[0]?.choice

            //     const correct_answer = question.choices.filter((choice, c_index)=> {
            //             return choice.is_answer =='on'
            //         })[0]?.choice

            //     return {
            //         id: question.id,
            //         answer: answer,
            //         correct: answer === correct_answer,
            //         correct_answer: correct_answer
            //     }
            // })
            const answers = questions.value
            return {
                application_id: aplication_id.value,
                answers: answers,
                time_elapsed: time_elapsed.value
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
        
        async function submit(forced=false){
    
            if(forced){
                let timerInterval
                clearInterval(timer)

                await Swal.fire({
                    title: `Time's up`,
                    html: 'I will close in <b></b> seconds. Your answer will be submitted automatically',
                    timer: 5000,
                    timerProgressBar: true,
                    didOpen: () => {
                        Swal.showLoading()
                        const b = Swal.getHtmlContainer().querySelector('b')
                        timerInterval = setInterval(() => {
                        b.textContent = Math.floor(Swal.getTimerLeft() / 1000)
                        }, 100)
                    },
                    willClose: () => {
                        clearInterval(timerInterval)
                    }
                })
            }else{
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
                    startTimer()
                    return;
                }
                clearInterval(timer)

            }
            

            

            let alert = Swal.fire({
                title: 'Processing',
                timerProgressBar: true,
                didOpen: () => {
                    Swal.showLoading()
                },
            });
            const id = @json($application->id);
            const url = `/v2/user-quiz/take`
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
          has_timer,
          time_in_seconds,
          time_left,
          choiceAnswerSelected
        }
      }
    }).mount('#app')


</script>
@endsection