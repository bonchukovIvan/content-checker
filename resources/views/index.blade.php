@extends('layouts.app')


@section('content')
    <div class="panel panel-default">
        <div class="panel-body">
            <p style="font-size:20px; font-weight:bold;">Title</p>
            <form class="mt-3" id="form-data">
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
                </div>
                    <button type="button" onclick="addInput()">+</button>
                <button type="button" class="btn btn-success submit-form" style="background:green" id="create_new">Create haystack</button>
            </form>
        </div>
    </div>

    <script>
        function addInput() {
            var inputFields = document.getElementById('values');
            var newDiv = document.createElement('div');
            newDiv.innerHTML = '<label for="inputField">Value:</label><input type="text" class="inputField" name="values[]"> <button type="button" onclick="removeInput(this)">-</button>';
            inputFields.appendChild(newDiv);
        }
        function removeInput(element) {
            var inputFields = document.getElementById('values');
            inputFields.removeChild(element.parentNode);
        }
    </script>

    <script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
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
                    alert(response.success);
                },
                complete: function(response){
                    $('#create_new').html('Create New');
                }
            });
        });
    </script>
@endsection