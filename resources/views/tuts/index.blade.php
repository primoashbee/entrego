<html>
    <body>
    {{-- <form action="/tuts" method="POST"> --}}
    <form action="{{route('tuts.store')}}" method="POST">
        @csrf()
        <p> Ano gusto mo?</p>
        <input type="text" name="gusto">
        <input type="submit" value="submit" name="submit">

        <ul>
            @foreach($tutorials as $tutorial)
            <li> {{$tutorial->gusto}} <a href="#" onClick="deleteTuts({{$tutorial->id}})">Delete</a>  <a href="#" onClick="archiveTuts({{$tutorial->id}})">Archive</a></li>
            @endforeach
        </ul>
    </form> 

    <form action="" method="POST" id="frmDelete">
        @csrf()
        @method('DELETE') 
        <input type="text" name="tutorial_id" id="tutorial_id">
    </form>

    <form action="" method="POST" id="frmArchive">
        @csrf()
        @method('PATCH') 
        <input type="text" name="archived" id="archived" value="1">
        <input type="text" name="gusto" id="archived" value="new gusto">
    </form>


    </body>
    <script>

        function deleteTuts(tutorial_id){

            document.getElementById('tutorial_id').value = tutorial_id;
            const form = document.getElementById('frmDelete')
            form.setAttribute('action', `/tut/${tutorial_id}`)
            if(confirm('Delete?')){
                form.submit()
            }
            
        }
        function archiveTuts(tutorial_id){

            document.getElementById('tutorial_id').value = tutorial_id;
            const form = document.getElementById('frmArchive')
            form.setAttribute('action', `/tut/${tutorial_id}`)
            if(confirm('Archive?')){
                form.submit()
            }
            
        }
    </script>
</html>
