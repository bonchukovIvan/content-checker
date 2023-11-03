@extends('layouts.app')

@section('content')
    <div class="create-form">
        <form class="mt-3" id="form-data">
            <div class="btn-container">
                <button type="button" class="btn btn-success submit-form"  id="create_new">Create haystack</button>
            </div>
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" class="form-control">
            </div>
            <div class="form-group">
                <label for="email">Link</label>
                <input type="text" name="link" id="link" class="form-control">
            </div>
            <div id="values" class="form-group">
                <label for="inputField">Value:</label>
                <input type="text" class="inputField" name="values[]"> 
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                
                <button type="button" onclick="addInput()">+</button>
            </div>
        </form>
    </div>
    <div class="haystacks-list">
        <form class="mt-3" id="form-remove">
        <div class="haystacks">
            <div class="btn-container">
                <button type="button" class="btn btn-success form-remove"  id="create_new">Delete select needles</button>
            </div>
            <div id="haystacks" class="haystacks-container">

            </div>
        </div>
        </form>
    </div>


    <script>
        function addInput() {
            var inputFields = document.getElementById('values');
            var newDiv = document.createElement('div');
            newDiv.classList.add('form-group');
            newDiv.innerHTML = '<label for="inputField">Value:</label><input type="text" class="inputField" name="values[]"> <button type="button" onclick="removeInput(this)">-</button>';
            inputFields.appendChild(newDiv);
        }
        function removeInput(element) 
        {
            var inputFields = document.getElementById('values');
            inputFields.removeChild(element.parentNode);
        }
    </script>

    <script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src={{ asset('js/web.js') }}></script>
    <script src={{ asset('js/elements.js') }}></script>
    <script type="text/javascript">
        get("{{ route('all') }}", create_haystacks)
        
        $(".form-remove").click(function(e){
            e.preventDefault();
            
            var data = $('#form-remove').serialize();
            
            $.ajax({
                type: 'post',
                url: "{{ route('haystack.remove') }}",
                data: data,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response){
                    const haystacks = document.getElementById('haystacks');
                    haystacks.innerHTML = '';
                    create_haystacks(response);
                },
            });
         
        });

    </script>
    <script type="text/javascript">
    
        $(".submit-form").click(function(e){
            e.preventDefault();
            var data = $('#form-data').serialize();
            $.ajax({
                type: 'post',
                url: "{{ route('store') }}",
                data: data,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function(){
                    $('#create_new').html('....Please wait');
                },
                success: function(response){
                    const haystacks = document.getElementById('haystacks');
                    haystacks.innerHTML = '';
                    document.getElementById("form-data").reset();
                    create_haystacks(response);
                    
                },
                complete: function(response){
                    $('#create_new').html('Create New');
                }
            });
        });
    </script>
    
@endsection