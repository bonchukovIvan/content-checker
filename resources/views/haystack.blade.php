@extends('layouts.app')
@section('content')

        <div class="panel-body">
            <div>
                <form class="mt-3" id="form-remove">
                <button type="button" class="btn btn-success form-remove"  id="delete">Delete select</button>
                </form>
                 <form class="mt-3" id="form-data">
                        <div class="haystack">
                            <div class="haystack-container">
                            <div class="haystack__title">
                            <label for="name">Name:</label>
                            <input id="name" type="text" name="name" value="">
                            <label for="link">Link:</label>
                            <input id="link" type="text" name="link" value="">
                        </div>
                            <div class="needle-update">
                                <button type="button" onclick="addInput()">+</button>
                                <label for="values">Needles:</label>
                            </div>
                                
                                <div id="values" class="values">
                                </div>
                                    
                            </div>
                        </div>
                        <button type="button" class="btn btn-success submit-form"  id="create_new">Update</button>
                </form>
            </div>
        </div>

    <script>
        function addInput() {
            var inputFields = document.getElementById('values');
            var newDiv = document.createElement('div');
            newDiv.classList.add('values-update');
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