@extends('layouts.user')
@section('content')

<div class="container-fluid py-4" id="app">
    <div class="row">
        <div class="col-12 position-relative z-index-2">
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card mb-4 ">
                        <div class="d-flex">
                            <div
                                class="icon icon-shape icon-lg bg-gradient-success shadow text-center border-radius-xl mt-n3 ms-4">
                                <i class="material-icons opacity-10" aria-hidden="true">group</i>
                            </div>
                                                    
                                <h6 class="mt-3 mb-2 ms-3 ">Personal Assessment - Result</h6>

                            
                        </div>

                        <div class="card-body">
                            <!-- definitions-->
                            <div class="row">
                                <div class="col-4">
                                    <figure>
                                      <blockquote class="blockquote text-right">
                                          <h5 style="margin-left:15px">Extraversion</h5>
                                          <p class="ps-2">
                                            Extraversion describes a person’s inclination to seek stimulation from the outside world, especially in the form of attention from other people. Extraverts engage actively with others to earn friendship, admiration, power, status, excitement, and romance. Introverts, on the other hand, conserve their energy, and do not work as hard to earn these social rewards.   
                                          </p>
                                          <p class="ps-2">In the brain, Extraversion seems to be related to dopamine activity. Dopamine can be thought of as the "reward" neurotransmitter, and is the main chemical associated with our instinct to pursue a goal. The classic example is a rat in a maze, whose brain pumps out dopamine as he frantically seeks the cheese. Extraverts tend to have more dopamine activity, indicating that they are more responsive to the potential for a reward. Introverts have less dopamine activity, and so are less likely to put themselves out to chase down rewards.</p>
                                      </blockquote>
                                    </figure>
                                </div>

                                <div class="col-4">
                                    <figure>
                                      <blockquote class="blockquote text-right">
                                          <h5 style="margin-left:15px">Agreeableness</h5>
                                          <p class="ps-2">
                                            Agreeableness describes the extent to which a person prioritizes the needs of others over their own needs. People who are high in Agreeableness experience a great deal of empathy and tend to get pleasure out of serving and taking care of others. People who are low in Agreeableness tend to experience less empathy and put their own concerns ahead of others. 
                                          </p>
                                          <p class="ps-2">
                                            In the brain, high Agreeableness has been associated with increased activity in the superior temporal gyrus, a region responsible for language processing and the recognition of emotions in others.
                                          </p>
                                      </blockquote>
                                    </figure>
                                </div>
                                
                                <div class="col-4">
                                    <figure>
                                        <blockquote class="blockquote text-right">
                                            <h5 style="margin-left:15px">Conscientiousness</h5>
                                            <p class="ps-2">
                                                Conscientiousness describes a person's level of goal orientation and persistence. Those who are high in Conscientiousness are organized and determined, and are able to forego immediate gratification for the sake of long-term achievement. Those who are low in this trait are impulsive and easily sidetracked.
                                            </p>    
                                            <p>
                                                In the brain, Conscientiousness is associated with frontal lobe activity. The frontal lobe can be thought of as the "executive brain," moderating and regulating the more animal and instinctual impulses from other areas of the brain. For example, while we might instinctually want to eat a piece of cake that's in front of us, the frontal lobe steps in and says "no, that's not healthy, and it doesn't fit in with our diet goals." People who are high in Conscientiousness are more likely to use this brain region to control their impulses and keep themselves on track.
                                            </p>
                                            
                                        </blockquote>
                                    </figure>
                                </div>

                            </div>

                            <div class="row">
                                <div class="col-2"></div>
                                <div class="col-4">
                                    <figure>
                                        <blockquote class="blockquote text-right">
                                            <h5 style="margin-left:15px">Neuroticism</h5>
                                            <p class="ps-2">
                                                Neuroticism describes a person's tendency to respond to stressors with negative emotions, including fear, sadness, anxiety, guilt, and shame. 
                                            </p>    
                                            <p>This trait can be thought of as an alarm system. People experience negative emotions as a sign that something is wrong in the world. Fear is a response to danger, guilt a response to having done something wrong. However, not everyone has the same reaction to a given situation. High Neuroticism scorers are more likely to react to a situation with strong negative emotions. Low Neuroticism scorers are more likely to brush off their misfortune and move on. </p>
                                            <p>In the brain, Neuroticism appears to relate to the interconnection of several regions, including regions involved in processing negative stimuli (such as angry faces or aggressive dogs) and dealing with negative emotions. One study found an association between high Neuroticism and altered serotonin processing in the brain. </p>
                                            
                                        </blockquote>
                                    </figure>
                                </div>
                                <div class="col-4">
                                    <figure>
                                        <blockquote class="blockquote text-right">
                                            <h5 style="margin-left:15px">Openness</h5>
                                            <p class="ps-2">
                                                Not to be confused with one's tendency to be open and disclose their thoughts and feelings, Openness in the context of the Big Five refers more specifically to Openness to Experience, or openness to considering new ideas. This trait has also been called "Intellect" by some researchers, but this terminology has been largely abandoned because it implies that people high in Openness are more intelligent, which is not necessarily true.
                                                Openness describes a person's tendency to think abstractly. Those who are high in Openness tend to be creative, adventurous, and intellectual. They enjoy playing with ideas and discovering novel experiences. Those who are low in Openness tend to be practical, traditional, and focused on the concrete. They tend to avoid the unknown and follow traditional ways.
                                            </p>    
                                            <p>In the brain, Openness seems to be related to the degree to which certain brain regions are interconnected. Those high in Openness seem to have more connection between disparate brain regions, which may explain why they are more likely to see connections where others do not. </p>
                                            
                                        </blockquote>
                                    </figure>
                                </div>
                            </div>


                            <!-- graph -->
                            <div class="row">
                                <div class="col-2"></div>
                                <div class="col-6">
                                    <h6> Extraversion</h6>
                                    <div class="progress mb-4">
                                        <div class="progress-bar bg-gradient-secondary" style="width: {{$data->extraversion_percentage}}%; height:20px">{{$data->extraversion_percentage}}%</div>
                                    </div>
    
                                    <h6> Agreeableness</h6>
                                    <div class="progress progress mb-4">
                                        <div class="progress-bar bg-gradient-success" style="width: {{$data->agreeableness_percentage}}%; height:20px">{{$data->agreeableness_percentage}}%</div>
                                    </div>
    
                                    <h6> Conscientiousness</h6>
                                    <div class="progress progress mb-4">
                                        <div class="progress-bar bg-gradient-warning" style="width: {{$data->conscientiousness_percentage}}%; height:20px">{{$data->conscientiousness_percentage}}%</div>
                                    </div>
    
                                    <h6> Neuroticism</h6>
                                    <div class="progress progress mb-4">
                                        <div class="progress-bar bg-gradient-primary" style="width: {{$data->neuroticism_percentage}}%; height:20px">{{$data->neuroticism_percentage}}%</div>
                                    </div>
    
                                    <h6> Openness</h6>
                                    <div class="progress progress mb-4">
                                        <div class="progress-bar bg-gradient-info" style="width: {{$data->openness_percentage}}%; height:20px">{{$data->openness_percentage}}%</div>
                                    </div>
                                </div>
                            </div>

                            <!-- high and lows !-->
                            <div class="row">
                                <div class="col-6">
                                    <div class="card card-frame">
                                        <div class="card-body">
                                            <h6 class="text-center"><em>Extraversion</em></h6>
                                            <div class="row">
                                                <div class="col-6" >
                                                    <ul class="list-group">
                                                        <li class="list-group-item text-center font-weight-bold">High</li>
                                                        <li class="list-group-item">Enjoys being the center of attention</li>
                                                        <li class="list-group-item">Likes to start conversations</li>
                                                        <li class="list-group-item">Enjoys meeting new people</li>
                                                        <li class="list-group-item">Has a wide social circle of friends and acquaintances</li>
                                                        <li class="list-group-item">Finds it easy to make new friends</li>
                                                        <li class="list-group-item">Feels energized when around other people</li>
                                                        <li class="list-group-item">Say things before thinking about them</li>
                                                        </ul>
                                                </div>
                                                <div class="col-6">
                                                    <ul class="list-group">
                                                        <li class="list-group-item text-center font-weight-bold">Low</li>
                                                        <li class="list-group-item">Prefers solitude</li>
                                                        <li class="list-group-item">Feels exhausted when having to socialize a lot</li>
                                                        <li class="list-group-item">Finds it difficult to start conversations</li>
                                                        <li class="list-group-item">Dislikes making small talk</li>
                                                        <li class="list-group-item">Carefully thinks things through before speaking</li>
                                                        <li class="list-group-item">Dislikes being the center of attention</li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="card card-frame">
                                        <div class="card-body">
                                            <h6 class="text-center"><em>Agreeableness</em></h6>
                                            <div class="row">
                                                <div class="col-6" >
                                                    <ul class="list-group">
                                                    <li class="list-group-item text-center font-weight-bold">High</li>
                                                        <li class="list-group-item">Has a great deal of interest in other people</li>
                                                        <li class="list-group-item">Cares about others</li>
                                                        <li class="list-group-item">Feels empathy and concern for other people</li>
                                                        <li class="list-group-item">Enjoys helping and contributing to the happiness of other people</li>
                                                        <li class="list-group-item">Assists others who are in need of help</li>
                                                        </ul>
                                                </div>
                                                <div class="col-6">
                                                    <ul class="list-group">
                                                    <li class="list-group-item text-center font-weight-bold">Low</li>
                                                        <li class="list-group-item">Takes little interest in others</li>
                                                        <li class="list-group-item">Doesn't care about how other people feel</li>
                                                        <li class="list-group-item">Has little interest in other people's problems</li>
                                                        <li class="list-group-item">Insults and belittles others</li>
                                                        <li class="list-group-item">Manipulates others to get what they want</li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-6">
                                    <div class="card card-frame">
                                        <div class="card-body">
                                            <h6 class="text-center"><em>Conscientiousness</em></h6>
                                            <div class="row">
                                                <div class="col-6" >
                                                    <ul class="list-group">
                                                        <li class="list-group-item text-center font-weight-bold">High</li>
                                                        <li class="list-group-item">Spends time preparing</li>
                                                        <li class="list-group-item">Finishes important tasks right away</li>
                                                        <li class="list-group-item">Pays attention to detail</li>
                                                        <li class="list-group-item">Enjoys having a set schedule</li>
                                             
                                                    </ul>
                                                </div>
                                                <div class="col-6">
                                                    <ul class="list-group">
                                                    <li class="list-group-item text-center font-weight-bold">Low</li>
                                                        <li class="list-group-item">Dislikes structure and schedules</li>
                                                        <li class="list-group-item">Makes messes and doesn't take care of things</li>
                                                        <li class="list-group-item">Fails to return things or put them back where they belong</li>
                                                        <li class="list-group-item">Procrastinates important tasks</li>
                                                        <li class="list-group-item">Fails to complete necessary or assigned tasks</li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="card card-frame">
                                        <div class="card-body">
                                            <h6 class="text-center"><em>Neuroticism</em></h6>
                                            <div class="row">
                                                <div class="col-6" >
                                                    <ul class="list-group">
                                                        <li class="list-group-item text-center font-weight-bold">High</li>
                                                        <li class="list-group-item">Experiences a lot of stress</li>
                                                        <li class="list-group-item">Worries about many different things</li>
                                                        <li class="list-group-item">Gets upset easily</li>
                                                        <li class="list-group-item">Experiences dramatic shifts in mood</li>
                                                        <li class="list-group-item">Feels anxious</li>
                                                        <li class="list-group-item">Struggles to bounce back after stressful events</li>
                                                        </ul>
                                                </div>
                                                <div class="col-6">
                                                    <ul class="list-group">
                                                    <li class="list-group-item text-center font-weight-bold">Low</li>
                                                        <li class="list-group-item">Emotionally stable</li>
                                                        <li class="list-group-item">Deals well with stress</li>
                                                        <li class="list-group-item">Rarely feels sad or depressed</li>
                                                        <li class="list-group-item">Doesn't worry much</li>
                                                        <li class="list-group-item">Is very relaxed</li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-3"></div>
                                <div class="col-6">
                                    <div class="card card-frame">
                                        <div class="card-body">
                                            <h6 class="text-center"><em>Openness</em></h6>
                                            <div class="row">
                                                <div class="col-6" >
                                                    <ul class="list-group">
                                                    <li class="list-group-item text-center font-weight-bold">High</li>
                                                        <li class="list-group-item">Very Creative</li>
                                                        <li class="list-group-item">Open to trying new things</li>
                                                        <li class="list-group-item">Focused on tackling new challenges</li>
                                                        <li class="list-group-item">Happy to think about abstract concepts</li>
                                                        </ul>
                                                </div>
                                                <div class="col-6">
                                                    <ul class="list-group">
                                                    <li class="list-group-item text-center font-weight-bold">Low</li>
                                                        <li class="list-group-item">Dislikes change</li>
                                                        <li class="list-group-item">Does not enjoy new things</li>
                                                        <li class="list-group-item">Resists new ideas</li>
                                                        <li class="list-group-item">Not very imaginative</li>
                                                        <li class="list-group-item">Dislikes abstract or theoretical concepts</li>
                                                    </ul>
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