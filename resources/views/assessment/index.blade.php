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
                                                    
                                <h6 class="mt-3 mb-2 ms-3 ">Personal Assessment</h6>
                            
                        </div>

                        <div class="card-body">
                            <div class="col-8 ">
                                <div class="text-center">
                                    <h4>Question #@{{question+1}}</h4>
                                    <h5 class="px-5 mb-3">@{{ current_question.question }}</h5>
                                    <div class="px-5">
                                        <span> Accurate</span>
                                        <input type="radio" name="radio" id="radio" value="1" style="margin-left:25px;transform:scale(2)" v-model="current_question.answer">
                                        <input type="radio" name="radio" id="radio" value="2" style="margin-left:25px;transform:scale(2)" v-model="current_question.answer">
                                        <input type="radio" name="radio" id="radio" value="3" style="margin-left:25px;transform:scale(2)" v-model="current_question.answer">
                                        <input type="radio" name="radio" id="radio" value="4" style="margin-left:25px;transform:scale(2)" v-model="current_question.answer">
                                        <input type="radio" name="radio" id="radio" value="5" style="margin-left:25px;transform:scale(2);margin-right:25px" v-model="current_question.answer">
                                        <span> Inaccurate</span>

                                    </div>
                                </div>
                                <button class="btn btn-default btn-warning" style="float: left;" @click="question--" :disabled="canPrevious">Previous</button>
                                <button class="btn btn-default btn-warning" style="float: right;" @click="question++" :disabled="canNext"  v-if="!showSubmitButton">Next</button>
                                <button class="btn btn-default btn-success" style="float: right;" @click="submit" :disabled="canSubmit" v-if="showSubmitButton">Submit</button>
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
        const initial_questions = ref(@json($questions)) 
        const questions = ref(initial_questions.value.map((item)=>{
            return { ...item, answer: null}
        }))
        const question = ref(0)
        const answer_selected = ref('')
        const current_question = computed(()=>{
            return questions.value[question.value]
        })

        const canPrevious = computed(()=>{
            if(question.value == 0){
                return true
            }
            return false
        })
        const canNext = computed(()=>{
            if(question.value == questions.value.length -1){
                return false
            }

            if(current_question.value.answer){
                return false
            }

            return true
        })

        const showSubmitButton = computed(()=>{
            console.log(question.value == questions.value.length-1)
            if(question.value == questions.value.length-1){
                return true;
            }
            return false;
        })
        const canSubmit = computed(()=>{
           if(questions.value[question.value].answer){
            return false
           }
           return true
        })

        const submit = () => {
            console.log(questions)
        }

        
        watch(answer_selected, (newVal, oldVal) => {
            questions.value = {...questions.value, answer: newVal} 
        })

        return {
            questions,
            question,
            current_question,
            answer_selected,
            canPrevious,
            canNext,
            canSubmit,
            showSubmitButton,
            submit
        }
      }
    }).mount('#app')


</script>
@endsection