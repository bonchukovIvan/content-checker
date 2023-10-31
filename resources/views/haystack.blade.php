@extends('layouts.app')
@section('content')
    <div class="panel panel-default">
        <div class="panel-body">
            <p style="font-size:20px; font-weight:bold;">Title</p>
            <div>
                <form class="mt-3" id="form-remove">
                <button type="button" class="btn btn-success form-remove" style="background:red" id="create_new">Delete select needles</button>
                </form>
                 <form class="mt-3" id="form-data">
                        <div>
                        <label for="name">Name:</label>
                        <input type="text" name="name" value="{{ $haystack->name  }}">
                        <label for="name">Link:</label>
                        <input type="text" name="link" value="{{ $haystack->link  }}">
                            <label for="name">Needles:</label>
                            <div id="values">
                                @if ($haystack->needles)
                                    @foreach ($haystack->needles as $needle)
                                        <p>Value:</p> 
                                        <input type="text" name="needles[{{ $needle->id }}][value]" value="{{ $needle->value  }}">
                                        <input type="checkbox" name="remove_needles[]" value="{{ $needle->id }}">
                                    @endforeach
                                @endif
                            </div>
                            <button type="button" onclick="addInput()">+</button>
                        </div>
                        <button type="button" class="btn btn-success submit-form" style="background:green" id="create_new">Create haystack</button>
                </form>
            </div>
        </div>
    </div>
    <script>
        function addInput() {
            var inputFields = document.getElementById('values');
            var newDiv = document.createElement('div');
            newDiv.innerHTML = '<label for="inputField">Value:</label><input type="text" class="inputField" name="needles_new[]"> <button type="button" onclick="removeInput(this)">-</button>';
            inputFields.appendChild(newDiv);
        }
        function removeInput(element) {
            var inputFields = document.getElementById('values');
            inputFields.removeChild(element.parentNode);
        }
    </script>
    <script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script type="text/javascript">
    
        $(".form-remove").click(function(e){
            e.preventDefault();
            
            var data = $('#form-data').serialize();
            $.ajax({
                type: 'post',
                url: "{{ route('needle.remove', $haystack->id) }}",
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
             location.reload();
        });

    </script>
    <script>
            $(".submit-form").click(function(e){
            e.preventDefault();
            var data = $('#form-data').serialize();
            $.ajax({
                type: 'post',
                url: "{{ route('update', $haystack->id) }}",
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
            location.reload();
        });
    </script>
@endsection