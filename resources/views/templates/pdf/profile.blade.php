<!DOCTYPE HTML>

<html>

<head>
    <meta charset="UTF-8">
    <title>{{ $user->fullname }}</title>
    <style>
        body {
            margin: 40px;
            font-family: "Adobe Caslon Pro", "Minion Pro", serif;
            font-size: 12pt;
        }

        header {
            font-family: "Trajan Pro", serif;
            padding-bottom: 10px;
        }

        header h1 {
            font-size: 20pt;
            letter-spacing: 2pt;
            border-bottom: 1px solid black;
            margin-bottom: 4px;
        }

        header span {
            font-size: 10pt;
            float: right;
        }

        section h2 {
            font-family: "Trajan Pro", serif;
            font-size: 14pt;
        }

        section p {
            margin-left: 40px;
        }

        section.coverletter {
            margin-top: 40px;
        }

        section.coverletter p {
            margin-left: 0px;
        }

        section ul {
            list-style-type: circle;
        }

        .jobtable {
            display: table;
            width: 100%;
            border-bottom: 1px solid black;
            margin-left: 20px;
        }

        .edtable {
            display: table;
            width: 100%;
            margin-left: 20px;
            padding-bottom: 15px;
        }

        .skillstable {
            display: table;
            width: 100%;
        }

        .table {
            display: table;
            margin-left: 20px;
        }

        .tablerow {
            display: table-row;
        }

        .jobtitle {
            display: table-cell;
            font-style: italic;
        }

        .right {
            display: table-cell;
            text-align: right;
        }

        .cell {
            display: table-cell;
        }

        .onlinecell {
            font-style: italic;
            padding-right: 10px;
        }

        .urlcell {
            display: table-cell;
            letter-spacing: 1px;
        }

        .pagebreak {
            page-break-before: always;
        }
    </style>

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

        .flexbox-container>div {
            flex: 50%;
            /* or - flex: 0 50% - or - flex-basis: 50% - */
            /*demo*/
            box-shadow: 0 0 0 1px black;
            margin-bottom: 10px;
        }
    </style>




<body>

    <header id="info">
        <h1>{{ $user->fullname }}</h1>
        <span>{{ $user->full_address }} <br>
            {{ $user->contact_number }}<br>
            {{ $user->email }}</span>
    </header>
    <section id="statement">
        <h2>Skills </h2>
        <p> {{ $user->skills }}</p>
    </section>
    <section id="statement">
        <h2>Languages </h2>
        <p> {{ $user->languages }}</p>
    </section>
    <section id="employment">
        <h2>Employment History</h2>
        @foreach ($user->workHistory as $work)
            <section>
                <div class="jobtable">
                    <div class="tablerow">
                        <span class="jobtitle">{{ $work->job_title }}</span>
                        <span class="right">{{ $work->start_date_formatted }} to {{ $work->end_date_formatted }}</span>
                    </div>
                    <div class="tablerow">
                        <span>{{ $work->company_name }}</span>
                        <span class="right"></span>
                    </div>
                </div>
                <ul>
                    <li>
                        {{ $work->accomplishments }}
                    </li>
                </ul>
            </section>
        @endforeach
    </section>

    <div class="pagebreak">
        <section id="statement">
            <img src="{{$image_src}}" style="  width: 100%;            ">
        </section>
        {{-- <img src="https://quickchart.io/chart?w=500&h=300&c=%7B%0A++%22type%22%3A+%22bar%22%2C%0A++%22data%22%3A+%7B%0A++++%22labels%22%3A+%5B2012%2C+2013%2C+2014%2C+2015%2C+2016%5D%2C%0A++++%22datasets%22%3A+%5B%7B%0A++++++%22label%22%3A+%22Users%22%2C%0A++++++%22data%22%3A+%5B120%2C+60%2C+50%2C+180%2C+120%5D%0A++++%7D%5D%0A++%7D%0A%7D" style="width: 500px; height:500px"/> --}}
    </div>
    {{-- <section id="skills">
        <h2>Experience</h2>
        <div class="skillstable">
            <div class="tablerow">
                <ul class="cell">
                    <li>Pants inspection</li>
                    <li>Squirrel chasing</li>
                    <li>Basket weaving</li>
                </ul>
                <ul class="cell">
                    <li>Synergetic synthesis</li>
                    <li>Flagrant goofing</li>
                    <li>Perennial loafing</li>
                </ul>
            </div>
        </div>
    </section>
    <div class="pagebreak"></div>
    <section id="education">
        <h2>Education</h2>
        <div class="edtable">
            <div class="tablerow">
                <span class="jobtitle">Quantum Dance, MS</span>
                <span class="right">September 2008</span>
            </div>
            <div class="tablerow">
                <span>Crazy Go Nuts University</span>
                <span class="right">Population, Tire</span>
            </div>
        </div>
        <div class="edtable">
            <div class="tablerow">
                <span class="jobtitle">Fruit Counting, BA</span>
                <span class="right">February 2006</span>
            </div>
            <div class="tablerow">
                <span>Corrugated College of Crepes</span>
                <span class="right">Calamansi, CA</span>
            </div>
        </div>
    </section>
    <section id="online">
        <h2>Online</h2>
        <div class="table">
            <div class="tablerow">
                <span class="onlinecell">Blog:</span>
                <span class="urlcell">www.myblogorrificblogosite.net</span>
            </div>
            <div class="tablerow">
                <span class="onlinecell">GitHub:</span>
                <span class="urlcell">www.github.com/octocat</span>
            </div>
        </div>
    </section>
    <div class="pagebreak"></div>
    <section class="coverletter" id="coverletter">
        <p>Dear Company,</p>
        <p>Look again at that dot. That's here. That's home. That's us. On it
           everyone you love, everyone you know, everyone you ever heard of,
           every human being who ever was, lived out their lives.
           The aggregate of our joy and suffering, thousands of confident
           religions, ideologies, and economic doctrines, every hunter and
           forager, every hero and coward, every creator and destroyer of
           civilization, every king and peasant, every young couple in love,
           every mother and father, hopeful child, inventor and explorer,
           every teacher of morals, every corrupt politician,
           every "superstar," every "supreme leader," every saint and
           sinner in the history of our species lived there--on a mote
           of dust suspended in a sunbeam.</p>

        <p>First, I believe that this nation should commit itself to
           achieving the goal, before this decade is out, of landing
           a man on the moon and returning him safely to the earth.
           No single space project in this period will be more
           impressive to mankind, or more important for the long-range
           exploration of space; and none will be so difficult or
           expensive to accomplish.</p>

        <p>The Earth is a very small stage in a vast cosmic arena. Think of
           the rivers of blood spilled by all those generals and emperors so
           that, in glory and triumph, they could become the momentary masters
           of a fraction of a dot. Think of the endless cruelties visited by
           the inhabitants of one corner of this pixel on the scarcely
           distinguishable inhabitants of some other corner, how frequent
           their misunderstandings, how eager they are to kill one another,
           how fervent their hatreds.</p>

        <p>We choose to go to the moon. We choose to go to the moon in this
           decade and do the other things, not because they are easy, but
           because they are hard, because that goal will serve to organize and
           measure the best of our energies and skills, because that challenge
           is one that we are willing to accept, one we are unwilling to
           postpone, and one which we intend to win, and the others, too.</p>

        <p>The surface is fine and powdery. I can kick it up loosely with my
           toe. It does adhere in fine layers, like powdered charcoal, to the
           sole and sides of my boots. I only go in a small fraction of an
           inch, maybe an eighth of an inch, but I can see the footprints of
           my boots and the treads in the fine, sandy particles. There seems
           to be no difficult in moving around, as we suspected.</p>

        <p>The view of the Earth from the Moon fascinated me-a small disk,
           240,000 miles away. It was hard to think that that little thing
           held so many problems, so many frustrations.
           Raging nationalistic interests, famines, wars,
           pestilence don't show from that distance.</p>
        <p>Sincerely,</p>
        <p>First M. Last</p>
    </section> --}}
</body>

</html>
