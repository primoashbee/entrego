<html>
<style>
    /* @property --p {
        syntax: '<number>';
        inherits: true;
        initial-value: 0;
    } */

    .pie {
        --p: 20;
        --b: 22px;
        --c: darkred;
        --w: 150px;

        width: var(--w);
        aspect-ratio: 1;
        position: relative;
        display: inline-grid;
        margin: 5px;
        place-content: center;
        font-size: 25px;
        font-weight: bold;
        font-family: sans-serif;
    }

    .pie:before,
    .pie:after {
        content: "";
        position: absolute;
        border-radius: 50%;
    }

    .pie:before {
        inset: 0;
        background:
            radial-gradient(farthest-side, var(--c) 98%, #0000) top/var(--b) var(--b) no-repeat,
            conic-gradient(var(--c) calc(var(--p)*1%), #0000 0);
        -webkit-mask: radial-gradient(farthest-side, #0000 calc(99% - var(--b)), #000 calc(100% - var(--b)));
        mask: radial-gradient(farthest-side, #0000 calc(99% - var(--b)), #000 calc(100% - var(--b)));
    }

    .pie:after {
        inset: calc(50% - var(--b)/2);
        background: var(--c);
        transform: rotate(calc(var(--p)*3.6deg)) translateY(calc(50% - var(--w)/2));
    }

    /* .animate {
        animation: p 1s .5s both;
    } */

    .no-round:before {
        background-size: 0 0, auto;
    }

    .no-round:after {
        content: none;
    }

    @keyframes p {
        from {
            --p: 0
        }
    }

    body {
        background: #f2f2f2;
    }

    h1 h2 h3 h4 h5 p {
        color: white;
        
    }
    .item {
        width: 100%
    }

    .item {
  width: 100%
}

.container {
    background-color: black;
    padding: 25px 25px 25px 25px;
}
.flexbox-container {
  display: flex;
  flex-wrap: wrap;
  /* background-color: black; */
}

.flexbox-container > div {
  flex: 50%; /* or - flex: 0 50% - or - flex-basis: 50% - */
  /*demo*/
  box-shadow: 0 0 0 1px black;
  margin-bottom: 10px;
  padding-bottom: 25px;
}

.criteria-item {
    display: inline-block;   
    position: relative;

}
.criteria-item {
    display: inline-block;   
    position: relative;

}
.criteria-item-first {
    width : 150px;
}
.criteria {
    padding-bottom: 10px;
}

.charts > .chart-item {
    display: inline-block;
    position: relative;
}

.extraversion {
    background-image: linear-gradient(195deg, #747b8a 0%, #495361 100%);
    --c: #495361
}

.agreeableness {
    background-image: linear-gradient(195deg, #66BB6A 0%, #43A047 100%);
    --c: #43A047

}

.conscientiousness {
    background-image: linear-gradient(195deg, #FFA726 0%, #FB8C00 100%);
    --c: #FFA726

}

.neuroticism {
    background-image: linear-gradient(195deg, #EC407A 0%, #D81B60 100%);
    --c: #EC407A

}

.openness {
    background-image: linear-gradient(195deg, #49a3f1 0%, #1A73E8 100%);
    --c: #1A73E8

}



</style>
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">

<body>
    <div class="container">
        <h1 style="text-align: center; color: white;"> Personality Assessment</h1>

        <div class="flexbox-container">
            <div class="item" style="color:white;text-align:center">
                <h1> Highs and Lows</h1>   
                <h5> High {{$data->stats()['max']['label']}}</h5>
                <p> {{$data->stats()['max']['statement']}}</p>
                <br>
                <h5> Low {{$data->stats()['min']['label']}}</h5>
                <p> {{$data->stats()['min']['statement']}}</p>
                <br>

            </div>
            <div class="item" style="color:white">
                <div class="graphs">
                    <div class="criteria">
                        <div class="criteria-item criteria-item-first"> Extraversion </div>
                        <div class="criteria-item w3-light-grey w3-round" style="min-width:250px;">
                            <div class="w3-container w3-round w3-blue extraversion" style="width:{{$data->extraversion_percentage}}%;">{{$data->extraversion_percentage}}%</div>
                          </div>
                    </div>
                    <div class="criteria">
                        <div class="criteria-item criteria-item-first"> Agreeableness </div>
                        <div class="criteria-item w3-light-grey w3-round" style="min-width:250px; ">
                            <div class="w3-container w3-round w3-blue agreeableness" style="width:{{$data->agreeableness_percentage}}%;">{{$data->agreeableness_percentage}}%</div>
                          </div>
                    </div>
                    <div class="criteria">
                        <div class="criteria-item criteria-item-first"> Conscientiousness </div>
                        <div class="criteria-item w3-light-grey w3-round" style="min-width:250px;;">
                            <div class="w3-container w3-round w3-blue conscientiousness" style="width:{{$data->conscientiousness_percentage}}%;">{{$data->conscientiousness_percentage}}%</div>
                          </div>
                    </div>
                    <div class="criteria">
                        <div class="criteria-item criteria-item-first"> Neuroticism </div>
                        <div class="criteria-item w3-light-grey w3-round" style="min-width:250px; ">
                            <div class="w3-container w3-round w3-blue neuroticism" style="width:{{$data->neuroticism_percentage}}%;">{{$data->neuroticism_percentage}}%</div>
                          </div>
                    </div>
                    <div class="criteria">
                        <div class="criteria-item criteria-item-first"> Openness </div>
                        <div class="criteria-item w3-light-grey w3-round" style="min-width:250px; ;">
                            <div class="w3-container w3-round w3-blue openness" style="width:{{$data->openness_percentage}}%;">{{$data->openness_percentage}}%</div>
                          </div>
                    </div>
                </div>
                <br>
                <div class="charts" style="align-content: center">
                    
                    <div class="chart-item">
                        <div class="pie animate" style="--p: {{$data->stats()['min']['score']}};--c:{{$data->stats()['min']['color']}};color:white">  {{$data->stats()['min']['score']}}%</div>
                        <h5 style="text-align: center"> {{ $data->stats()['min']['label'] }}</h5>

                    </div>
                    <div class="chart-item">
                        <div class="pie animate" style="--p: {{$data->stats()['max']['score']}};--c:{{$data->stats()['max']['color']}};color:white">  {{$data->stats()['max']['score']}}%</div>
                        <h5 style="text-align: center"> {{ $data->stats()['max']['label'] }}</h5>

                    </div>
                </div>
                <br>
            </div>
        </div>
    </div>

</body>

</html>
