@extends('layouts.app')

@section('content')
<div class="sites_create">
        <form class="mt-3" id="add-data">
                <div class="btn-container">
                    <button type="button" class="btn btn-success add-data"  id="create_new">Update value</button>
                </div>
                <div class="form-group">
                    <label for="name">Group Name</label>
                    <input type="text" name="name" id="name" class="form-control">
                </div>
                <div class="form-group">
                    <select id="options" name="faculty_id" ></select>
                    <div id="form-departament" class="form-departament"></div>
                </div>
                <div class="form-group">
                    <button type="button" onclick="addNewInput()">+</button>
                </div>
                <div class="form-group">
                <div id="values" class="result-values">
                </div>
            </div>
        </form>
</div>

<script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src={{ asset('js/web.js') }}></script>
<script src={{ asset('js/elements.js') }}></script>
<script src={{ asset('js/btn.js') }}></script>
<script src={{ asset('js/faculty.js') }}></script>
<script src={{ asset('js/departament.js') }}></script>
<script>

    faculties.forEach(elem => 
    {
        const option = create('option', elem.name, '', 'option');
        option.value = elem.id;
        
        const options = document.getElementById('options');
        options.appendChild(option);
    });

    get("{{ route('values-group.get_one', $id) }}", (response) => 
    {
        const options = document.getElementById('options');
        options.value = response.faculty_id;
        const link = document.getElementById('name');
        link.value = response.name;
        console.log(response)
        dep_id = [];
        response.departaments.forEach((elem) => {
            dep_id.push(elem.id);
        })
        console.log(dep_id)
        departaments.forEach(elem => 
            {
                const checkbox = create('departament__check', '', '', 'input');
                checkbox.type = 'checkbox';
                checkbox.name = 'departaments_id[]';
                checkbox.value = elem.id;
                if (dep_id.includes(parseInt(checkbox.value))) {
                    checkbox.checked = true;
                }
                const div = create('option');
                const label = create('departament__label', elem.name);
                div.appendChild(label);
                div.appendChild(checkbox);
                
                const options = document.getElementById('form-departament');
                options.appendChild(div);
            });
        response.values.forEach((elem) => 
        {
            const input = create('value_input', '', '', 'input');
            input.id = 'value';
            input.name = 'values['+elem.id+']';
            input.value = elem.search_value;
            const label = create('value_label', 'Value', '', 'label');



            const div = create('value');
            div.appendChild(label);
            div.appendChild(input);
            const link = document.getElementById('values');
            link.appendChild(div);
        });

    });
    request('add-data', "{{ route('values-group.update', $id) }}", 'patch', (response) => 
    {
        console.log(response);
        const name = document.getElementById('name');
        name.value = response.name;
        const values = document.getElementById('values');
        values.innerHTML = '';
        response.values.forEach((elem) => 
        {
            const input = create('value_input', '', '', 'input');
            input.id = 'value';
            input.name = 'values['+elem.id+']';
            input.value = elem.search_value;
            const label = create('value_label', 'Value', '', 'label');

            const div = create('value');
            div.appendChild(label);
            div.appendChild(input);
            const link = document.getElementById('values');
            link.appendChild(div);
        });
    });

    function activateCheckboxes(values) {

    }
</script>
@endsection