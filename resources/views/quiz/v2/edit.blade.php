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
                                                    
                                <h6 class="mt-3 mb-2 ms-3 ">Quizzes</h6>
                            
                        </div>

                        <div class="card-body">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-4">
                                        <div class=" mb-3">
                                            <div class="input-group input-group-static">
                                                <label class="">Quiz Name</label>
                                                <input type="text" name="name" id="name" class="form-control" v-model="name">
                                            </div>
                                        </div>
                                        <div class=" mb-3">
                                            <div class="input-group input-group-static">
                                                <label class="">Job Group</label>
                                                <select id="job_group" name="job_group" class="form-control" v-model="job_group">
                                                @foreach($job_group as $job)
                                                    <option class="{{$job['value']}}">{{$job['label']}}</option>
                                                @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-6 mb-3">
                                                <div class="input-group input-group-static">
                                                    <label class="">Has passing</label>
                                                    <select id="has_passing" name="has_passing" class="form-control" v-model="has_passing">
                                                        <option :value="true"> Yes</option>
                                                        <option :value="false">No</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-6 mb-3">
                                                <div class="input-group input-group-static">
                                                    <label class="">Percentage (%) eg: 70</label>
                                                    <input type="number"  class="form-control" v-model="passing_rate" :disabled="has_passing =='false'">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-6 mb-3">
                                                <div class="input-group input-group-static">
                                                    <label class="">Is Timed</label>
                                                    <select id="has_timer" name="has_timer" class="form-control" v-model="has_timer">
                                                        <option value=""></option>
                                                        <option value="true"> Yes</option>
                                                        <option value="false">No</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-6 mb-3">
                                                <div class="input-group input-group-static">
                                                    <label class="">Timer (in seconds)</label>
                                                    <input type="number"  step="1" class="form-control" v-model="time_in_seconds" :disabled="has_timer=='false'">
                                                </div>
                                            </div>
                                        </div>

                                        <div class=" mb-3">
                                            <div class="input-group input-group-static">
                                                <label class="">Description</label>
                                                <textarea name="description" id="description" class="form-control" v-model="description"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-8">
                                        <div class=" mb-3" v-for="(question, index) in questions" :key="index">
                                            <button class="btn btn-warning" style="float:right" @click="removeRow(index)" v-if="index > 0">X</button>
                                            <div class="input-group input-group-static">
                                                <div class="col-lg-12">
                                                    <div class="row">
                                                        <div class="col-lg-3">
                                                            <label class="">Question Type</label>

                                                            <select class="form-control"  v-model="questions[index].question_type" @change="questionTypeChanged(index)">
                                                                <option :value="type.value" v-for="(type, index) in question_type"> @{{type.label}}</option>    
                                                            </select>
                                                        </div>
                                                        <div class="col-lg-9">
                                                            <label class="">Question # @{{index + 1}}</label>
                                                            <input type="text" class="form-control" v-model="questions[index].question">
                                                        </div>
                                                    </div>


                                                </div>

                                            </div>
                                            
                                            <template v-if="questions[index].question_type ==='choice'">
                                                <div class="answers px-2 mt-2">
                                                    <div class="input-group input-group-dynamic mb-4 is-filled" v-for="(choice, choice_index) in questions[index].question_data.choices">
                                                        <input type="radio" :name="`question-${index}`" :checked="questions[index].question_data.choices[choice_index].is_answer =='on'" @change="choiceAnswerSelected(index, choice_index)">
                                                        <input type="text" class="form-control px-2"  v-model="questions[index].question_data.choices[choice_index].answer">
                                                    </div>
                                                </div>
                                            </template>
                                            <template v-if="questions[index].question_type ==='boolean'">
                                                <div class="answers px-2 mt-2">
                                                    <div class="input-group input-group-dynamic mb-4 is-filled" v-for="(choice, choice_index) in questions[index].question_data.choices">
                                                        <input type="radio" :name="`question-${index}`" :checked="questions[index].question_data.choices[choice_index].is_answer =='on'"   @change="choiceAnswerSelected(index, choice_index)">
                                                        <input type="text" class="form-control px-2"  v-model="questions[index].question_data.choices[choice_index].answer" readonly>
                                                    </div>
                                                </div>
                                            </template>
                                            <template v-if="questions[index].question_type ==='identification'">
                                                <div class="input-group input-group-static">
                                                    <label class=>Answer</label>
                                                    <input type="text" class="form-control px-2" v-model="questions[index].question_data.answer" >
                                                </div>
                                            </template>
                                            {{-- <div class="answers px-2 mt-2" v-for="(choices, choice_index) in question.choices" :key="choice_index">
                                                <div class="input-group input-group-dynamic mb-4 is-filled">
                                                    <input type="radio" :name="`questions.${index}`" @change="checked(index,choice_index)">
                                                    <input type="text" class="form-control px-2"     v-model="questions[index].choices[choice_index].answer">
                                                </div>
                                                
                                            </div> --}}
                                            
                                        </div>
                                        <div class="div" style="float: right;">
                                            <button @click="addRow" class="btn btn-primary" :disabled="!canAddRow"> Add Item</button>
                                            <button @click="submit" :disabled="!quizFormValid || !canAddRow" class="btn btn-success"> Submit</button>
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
        const question_type = ref([
            {
                "value":"choice",
                "label":"Multiple Choice"
            },
            {
                "value":"boolean",
                "label":"True or False"
            },
            {
                "value":"identification",
                "label":"Identification"
            },
        ])
        
        const schema = {
            'question': '',
            'question_type': null
        }
        
        const questions = ref(@json($quiz->questionsv2))
        const job_type = ref(@json($quiz->job_type))
        const name = ref(@json($quiz->name))
        const job_group = ref(@json($quiz->job_group))
        const description = ref(@json($quiz->description))
        const has_passing = ref(@json($quiz->has_passing_rate === 1 ? 'true' :'false'))
        const passing_rate = ref(@json($quiz->passing_rate))
        const has_timer = ref(@json($quiz->has_timer === 1 ? 'true' :'false'))
        const time_in_seconds = ref(@json($quiz->time_in_seconds))


        // watch(
        //     ()=>questions,
        //     (value)=> {
        //         console.log(value)
        //     }
        // )
 
        function questionTypeChanged(index)
        {
            const type = questions.value[index].question_type
            let question_data = {}
            switch(type){
                case 'choice':
                    question_data =  {
                                        "choices" : [
                                            {
                                                "choice": "a",
                                                "answer": "",
                                                "is_answer": false
                                            },
                                            {
                                                "choice": "b",
                                                "answer": "",
                                                "is_answer": false
                                            },
                                            {
                                                "choice": "c",
                                                "answer": "",
                                                "is_answer": false
                                            },
                                            {
                                                "choice": "d",
                                                "answer": "",
                                                "is_answer": false
                                            },
                                        ],
                                        "answer"  : null
                                    }
                    break;
                case 'boolean':
                    question_data = {
                                        "answer"  : null,
                                        "choices" : [
                                            {
                                                "choice": "true",
                                                "answer": "true",
                                                "is_answer": false
                                            },
                                            {
                                                "choice": "false",
                                                "answer": "false",
                                                "is_answer": false
                                            },
                                        ],
                                        "answer"  : null
                                    }
                    break;
                case 'identification':
                    question_data = {
                                        "answer"  : null
                                    }
                    break;
            }

            questions.value[index].question_data = question_data
        }

        function addRow(){
            const data = {
                "question_type": null,
                "question_data" : {

                }
            }
            questions.value.push(data)
        }

        function removeRow(index){
          
            // questions.value = delete questions.value[index]
            questions.value.splice(index,1)
        }


        function choiceAnswerSelected(index, choice_index)
        {
            let answer;
            questions.value[index].question_data.choices.forEach((choice,c_index)=>{
                choice.is_answer = "off"
                if(c_index == choice_index){
                    choice.is_answer = "on"
                    answer = choice.choice

                }
            })
            questions.value[index].question_data.answer = answer

        }

        function checked(index, choice_index){
            let answer  = null;
            questions.value[index].question_data.choices.forEach((choice, c_index)=>{
                choice.is_answer = "off"
                if(c_index == choice_index){
                    choice.is_answer = "on"
                }
            })
        }
        

        const canAddRow = computed(()=>{
            const last_question_index= questions.value.length-1
            const question = questions.value[last_question_index]
            if(question.question_type === 'choice'){
                const has_answer = question.question_data.answer != null
                const choices_filled_up = question.question_data.choices.filter((choice)=>{return choice.answer !=""}).length == 4
                const question_filled_up = question.question != ""
                console.log(has_answer, choices_filled_up, question_filled_up)
                if(has_answer && choices_filled_up && question_filled_up){
                    return true
                }
                return false
            }
            if(question.question_type === 'boolean'){
                const has_answer = question.question_data.answer != null
                const question_filled_up = question.question != ""
                if(has_answer && question_filled_up){
                    return true
                }
                return false
            }
            if(question.question_type === 'identification'){
                const has_answer = question.question_data.answer != null &&  question.question_data.answer != ""
                const question_filled_up = question.question != ""
                if(has_answer && question_filled_up){
                    return true
                }
                return false
            }
            // const   
            return false;
        })

        const quizFormValid = computed(()=>{
            if(name.value == '' || job_group.value == '' || description.value == '' || has_passing.value =='' ){
                return false
            }
            if(has_passing.value =='true'){
                if(passing_rate.value==0){
                    return false
                }
            }
            if(has_timer.value =='true'){
                if(time_in_seconds.value==0){
                    return false
                }
            }
            return true
        })

        const canSubmit = computed(()=>{
            return quizFormValid
            return true
        })

        
        async function submit(){
            const { isConfirmed} = await Swal.fire({
                                        title: "Confirmation",
                                        text: "Update Quiz?",
                                        icon: "info",
                                        showCancelButton: true,
                                        confirmButtonColor: "#3085d6",
                                        cancelButtonColor: "#d33",
                                        confirmButtonText: "Yes"
                                    })
            if( !isConfirmed ){
                return;
            }
            const payload =  {
                name: name.value,
                job_type: job_type.value,
                job_group: job_group.value,
                description: description.value,
                questions: questions.value,
                has_passing: has_passing.value,
                passing_rate: passing_rate.value,
                time_in_seconds: time_in_seconds.value,
                has_timer: has_timer.value
            }

            let alert = Swal.fire({
                title: 'Processing',
                timerProgressBar: true,
                didOpen: () => {
                    Swal.showLoading()
                },
            });
            const id = @json($quiz->id);
            const url = `/v2/quiz/update/${id}`
            const res = await fetch(url, {
                'method': 'PUT',
                'body': JSON.stringify(payload),
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
            'Quiz created',
            'success'
            )
            location.href = '/quiz'
        }

        const addRowDisabled = computed(()=>{
            const last_question = questions.value.length-1
            let disabled = true
            questions.value[last_question].choices.forEach((choice, index)=>{
                console.log(choice.is_answer)
                if(choice.is_answer == 'on'){
                    disabled = false;
                }
            })
            return disabled
        })

        const submitDisabled = computed(()=>{
            if(name.value == '' || job_group.value == '' || description.value == '' || addRowDisabled.value || has_passing.value =='' ){
                return true
            }
            if(has_passing.value =='true'){
x
                console.log(passing_rate.value)
                if(passing_rate.value==0){
                    return true
                }
            }
            return false
        })
        

        return {
          questions,
          addRow,
          submit,
          checked,
          name,
          job_type,
          job_group,
          description,
          addRowDisabled,
          submitDisabled,
          has_passing,
          passing_rate,
          removeRow,
          has_timer,
          time_in_seconds,


          question_type,
          questionTypeChanged,
          choiceAnswerSelected,
          canAddRow,
          canSubmit,
          quizFormValid
        }
      }
    }).mount('#app')


</script>
@endsection