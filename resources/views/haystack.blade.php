@extends('layouts.app')
@section('content')
    <div class="panel panel-default">
        <div class="panel-body">
            <p style="font-size:20px; font-weight:bold;">Title</p>
            <a href='/'>
                <button type="button" class="btn" style="background:blue" id="back">Back</button>
            </a>
            <div>
                <form class="mt-3" id="form-remove">
                <button type="button" class="btn btn-success form-remove" style="background:red" id="delete">Delete select</button>
                </form>
                 <form class="mt-3" id="form-data">
                        <div class="haystack">
                            <div class="haystack-container">
                                <label for="name">Name:</label>
                                <input id="name" type="text" name="name" value="">
                                <label for="link">Link:</label>
                                <input id="link" type="text" name="link" value="">
                                    <label for="values">Needles:</label>
                                    <div id="values" class="values">
                                        {{-- @if ($haystack->needles)
                                            @foreach ($haystack->needles as $needle)
                                                <p>Value:</p> 
                                                <input type="text" name="needles[{{ $needle->id }}][value]" value="{{ $needle->value  }}">
                                                <input type="checkbox" name="remove_needles[]" value="{{ $needle->id }}">
                                            @endforeach
                                        @endif --}}
                                    </div>
                                    <button type="button" onclick="addInput()">+</button>
                            </div>
                        </div>
                        <button type="button" class="btn btn-success submit-form" style="background:green" id="create_new">Update</button>
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

        function create(class_name, inner_text = '', add_text = '', type = 'div') 
        {
            const element = document.createElement(type);
            element.classList.add(class_name);
            if(inner_text) 
            {
                element.innerText = add_text+inner_text;
            }
            return element;
        }
        function get_one() 
        {
            $.ajax(
            {
                type: 'get',
                url: "{{ route('haystack.get_one', $id) }}",
                success: function(response)
                {
                    console.log(response);
                    const name = document.getElementById('name');
                    name.value = response.name;

                    const link = document.getElementById('link');
                    link.value = response.link;
                    needles_arr = [];
                    response.needles.forEach((elem) => 
                    {
                        const needle_container = create('needle');
                        const needle_checkbox = create('value_input','','', type = 'input');
                        needle_checkbox.type = 'checkbox';
                        needle_checkbox.name = 'remove_needles[]';
                        needle_checkbox.value = elem.id;

                        const needle = create('value_input','','', type = 'input');
                        needle.name = 'needles['+elem.id+'][value]';
                        needle.value = elem.value;
                        needle.type = 'text';
                        
                        needle_container.appendChild(needle_checkbox);
                        needle_container.appendChild(needle);
                        needles_arr.push(needle_container);
                    });

                    const values = document.getElementById('values');
                    needles_arr.forEach((elem) => 
                    {
                        values.appendChild(elem);
                    });
                },
            });
        }
        get_one();
    
        $(".form-remove").click(function(e)
        {
            e.preventDefault();
            
            var data = $('#form-data').serialize();
            $.ajax(
            {
                type: 'post',
                url: "{{ route('needle.remove') }}",
                data: data,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function(){
                    $('#delete').html('....Please wait');
                },
                success: function(response){
                    const values = document.getElementById('values');
                    values.innerHTML = '';
                    get_one();
                },
                complete: function(response){
                    $('#delete').html('Delete selected');
                }
            });
        });
    </script>

    <script>
            $(".submit-form").click(function(e)
            {
            e.preventDefault();
            var data = $('#form-data').serialize();
            $.ajax({
                type: 'post',
                url: "{{ route('update', $id) }}",
                data: data,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function(){
                    $('#create_new').html('....Please wait');
                },
                success: function(response){
                   const values = document.getElementById('values');
                   values.innerHTML = '';
                   get_one();
                },
                complete: function(response){
                    $('#create_new').html('Update');
                }
            });
        });
    </script>
@endsection