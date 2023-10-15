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
                                                        <option value=""></option>
                                                        <option value="true"> Yes</option>
                                                        <option value="false">No</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-6 mb-3">
                                                <div class="input-group input-group-static">
                                                    <label class="">Percentage (%) eg: 70</label>
                                                    <input type="number"  class="form-control" v-model="passing_rate" :disabled="!has_passing">
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

                                                <label class="">Question # @{{index + 1}}</label>
                                                <input type="text" class="form-control" v-model="questions[index].question">
                                            </div>
                                            <div class="answers px-2 mt-2" v-for="(choices, choice_index) in question.choices" :key="choice_index">
                                                <div class="input-group input-group-dynamic mb-4 is-filled">
                                                    <input type="radio" :checked="questions[index].choices[choice_index].is_answer =='on'" :name="`questions.${index}`" @change="checked(index,choice_index)" >
                                                    <input type="text"  class="form-control px-2"  v-model="questions[index].choices[choice_index].answer">
                                                </div>
                                                
                                            </div>
                                            
                                        </div>
                                        <div class="div" style="float: right;">
                                            <button @click="addRow" :disabled="addRowDisabled" class="btn btn-primary"> Add Item</button>
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
        
        const questions = ref(@json($quiz->questions))
        const name = ref(@json($quiz->name))
        const job_group = ref(@json($quiz->job_group))
        const description = ref(@json($quiz->description))
        const has_passing = ref(@json($quiz->has_passing_rate === 1 ? 'true' :'false'))
        const passing_rate = ref(@json($quiz->passing_rate))
        const has_timer = ref(@json($quiz->has_timer === 1 ? 'true' :'false'))
        const time_in_seconds = ref(@json($quiz->time_in_seconds))


        function formatRecievedQuestions(q)
        {
            questions.value = q.map((item)=>{
                const formatted = {
                    id: item.id,
                    question: item.question,
                    choices: [
                        {
                            answer: item.choice_a,
                            choice: 'choice_a',
                            is_answer: item.answer == 'choice_a' ? 'on' : 'off'
                        },
                        {
                            answer: item.choice_b,
                            choice: 'choice_b',
                            is_answer: item.answer == 'choice_b' ? 'on' : 'off'
                        },
                        {
                            answer: item.choice_c,
                            choice: 'choice_c',
                            is_answer: item.answer == 'choice_c' ? 'on' : 'off'
                        },
                        {
                            answer: item.choice_d,
                            choice: 'choice_d',
                            is_answer: item.answer == 'choice_d' ? 'on' : 'off'
                        }
                    ]
                }

                return formatted
            })
        }

        formatRecievedQuestions(@json($quiz->questions))
        function addRow(){
            const data = {
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
            questions.value.push(data)
        }

        function removeRow(index){
          
            // questions.value = delete questions.value[index]
            questions.value.splice(index,1)
        }

        function checked(index, choice_index){
            questions.value[index].choices.forEach((choice, c_index)=>{
                choice.is_answer = "off"
                
                if(c_index == choice_index){
                    choice.is_answer = "on"
                }
            })
        }
        
        async function submit(){
            const payload =  {
                name: name.value,
                // job_type: job_type.value,
                job_group: job_group.value,
                description: description.value,
                questions: questions.value,
                has_passing: has_passing.value,
                passing_rate: passing_rate.value,
                has_timer : has_timer.value,
                time_in_seconds: time_in_seconds.value
            }

            let alert = Swal.fire({
                title: 'Processing',
                timerProgressBar: true,
                didOpen: () => {
                    Swal.showLoading()
                },
            });
            const id = @json($quiz->id);
            const url = `/quiz/update/${id}`
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
            'Quiz Updated',
            'success'
            )
            // location.href = '/quiz'
        }

        const addRowDisabled = computed(()=>{
            const last_question = questions.value.length-1
            let disabled = true
            questions.value[last_question].choices.forEach((choice, index)=>{
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
          job_group,
          description,
          addRowDisabled,
          submitDisabled,
          has_passing,
          passing_rate,
          removeRow,
          has_timer,
          time_in_seconds
        }
      }
    }).mount('#app')


</script>
@endsection