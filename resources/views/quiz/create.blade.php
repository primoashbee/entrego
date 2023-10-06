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
                                                    
                            @if(request()->route()->getName() === "quiz.index")
                                <h6 class="mt-3 mb-2 ms-3 ">Quizzes</h6>
                            @else
                                <h6 class="mt-3 mb-2 ms-3 ">Applicants</h6>
                            @endif
                            
                        </div>

                        <div class="card-body">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-4">
                                        <div class=" mb-3">
                                            <div class="input-group input-group-static">
                                                <label class="">Quiz Name</label>
                                                <input type="text" name="name" id="name" class="form-control">
                                            </div>
                                        </div>
                                        <div class=" mb-3">
                                            <div class="input-group input-group-static">
                                                <label class="">Type</label>
                                                <input type="text" name="name" id="name" class="form-control">
                                            </div>
                                        </div>
                                        <div class=" mb-3">
                                            <div class="input-group input-group-static">
                                                <label class="">Job Group</label>
                                                <select id="job_group" name="job_group" class="form-control">
                                                @foreach($job_group as $job)
                                                    <option class="{{$job['value']}}">{{$job['label']}}</option>
                                                @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class=" mb-3">
                                            <div class="input-group input-group-static">
                                                <label class="">Description</label>
                                                <textarea name="description" id="description" class="form-control"> {{ old('description') }} </textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-8">
                                        <div class=" mb-3" v-for="(item, index) in questions" :key="index">
                                            <div class="input-group input-group-static">
                                                <label class="">Question # @{{index + 1}}</label>
                                                {{-- <pre> @{{questions[index]}} </pre> --}}
                                                <input type="text" name="name" id="name" class="form-control" v-model="questions[index].question">
                                            </div>
                                            <div class="answers px-2" v-for="(choices, choice_index) in item.choices" :key="choice_index">
                                                <div class="input-group input-group-dynamic mb-4 is-filled">
                                                    @{{ `questions[${index}].choices[${choice_index}].answer`}}
                                                    <input type="radio" name="answer[]" id="answer[]">
                                                    <input type="text" class="form-control px-2" answer=[] v-model="questions[index].choices[choice_index].answer">
                                                </div>
                                                
                                            </div>
                                            
                                        </div>
                                        <button @click="addRow"> Click</button>
                                        <button @click="submit"> submit</button>

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
    import { createApp, ref, watch  } from 'https://unpkg.com/vue@3/dist/vue.esm-browser.js'
  
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
        const questions = ref([])
        questions.value.push(schema)

        console.log(questions.value)

        watch(
            ()=>questions,
            (value)=> {
                console.log(value)
            }
        )

        function addRow(){
            questions.value.push({...schema})
            console.log(questions.value)
        }
        
        function submit(){
            console.log(questions.value)
        }
        return {
          questions,
          addRow,
          submit
        }
      }
    }).mount('#app')


  </script>
@endsection