@extends('layouts.app')

@section('content')
<div class="sites_create">
    <form class="mt-3" id="add-data">
            <div class="btn-container">
                <button type="button" class="btn btn-success add-data"  id="create_new">Add group</button>
            </div>
            <div class="form-group">
                <label for="name">Group name</label>
                <input type="text" name="name" id="name" class="form-control">
            </div>
            <div class="form-group">
                    <select id="options" name="faculty_id" ></select>
            </div>
            <button type="button" onclick="addInput()">+</button>
            <div class="form-group">
                <div id="values" class="values">
                    <div class="value">
                        <label for="value">Value</label>
                        <input type="text" name="values[]" id="value" class="form-control">
                    </div>
                </div>
            </div>
    </form>
</div>
<div class="sites-container">
    <form class="mt-3" id="remove-data">
        <div class="btn-container">
            <button type="button" class="btn btn-success remove-data"  id="create_new">Remove selected</button>
        </div>
        <div id="values__groups-values" class="values__groups-values"></div>
    </form>
</div>

<script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src={{ asset('js/web.js') }}></script>
<script src={{ asset('js/elements.js') }}></script>
<script src={{ asset('js/btn.js') }}></script>
<script src={{ asset('js/faculty.js') }}></script>

<script>
    faculties.forEach(elem => 
    {
        const option = create('option', elem.name, '', 'option');
        option.value = elem.id;
        
        const options = document.getElementById('options');
        options.appendChild(option);

    });

    get("{{ route('values-group') }}", (response) => 
    {
        
        response.forEach((elem) => 
        {

            const checkbox = create('values__check', '', '', 'input');
            checkbox.type = 'checkbox';
            checkbox.name = 'removes[]';
            checkbox.value = elem.id;

            const name = create('name', elem.name);
            // const faculty_name = create('sites__faculty', '');
            
            const a = create('values__groups_a', '', '', 'a');
            
            a.appendChild(name);
            a.href = '/values/'+elem.id;
            const group_head = create('group__head');
            group_head.appendChild(a);
            group_head.appendChild(checkbox);
            const div = create('values__group');
            div.appendChild(group_head);
            if(elem.faculty_id)
            {
                const faculty_name = create('values__faculty', elem.faculty.name);
                div.appendChild(faculty_name);
            }

            const group_values = create('values__group-values');

            if(elem.values)
            {
                elem.values.forEach((element) =>
                {
                    const value = create('values__group-value');
                    const value_name = create('values__group-value__name', element.search_value);
                    value.appendChild(value_name);
                    group_values.appendChild(value);
                });
            }

            const groups = document.getElementById('values__groups-values');
            div.appendChild(group_values);
            groups.appendChild(div);
            
        });
    });

    request('add-data', "{{ route('values-group.store') }}", 'post', (response) => 
    {
        const sites = document.getElementById('values__groups-values');
        sites.innerHTML = '';
        document.getElementById("add-data").reset();
        console.log(response)
        get("{{ route('values-group') }}", (response) => 
        {
            response.forEach((elem) => 
        {

            const checkbox = create('values__check', '', '', 'input');
            checkbox.type = 'checkbox';
            checkbox.name = 'removes[]';
            checkbox.value = elem.id;

            const name = create('name', elem.name);
            // const faculty_name = create('sites__faculty', '');
            
            const a = create('values__groups_a', '', '', 'a');
            
            a.appendChild(name);
            a.href = '/values/'+elem.id;
            const group_head = create('group__head');
            group_head.appendChild(a);
            group_head.appendChild(checkbox);
            const div = create('values__group');
            div.appendChild(group_head);
            if(elem.faculty_id)
            {
                const faculty_name = create('values__faculty', elem.faculty.name);
                div.appendChild(faculty_name);
            }

            const group_values = create('values__group-values');

            if(elem.values)
            {
                elem.values.forEach((element) =>
                {
                    const value = create('values__group-value');
                    const value_name = create('values__group-value__name', element.search_value);
                    value.appendChild(value_name);
                    group_values.appendChild(value);
                });
            }

            const groups = document.getElementById('values__groups-values');
            div.appendChild(group_values);
            groups.appendChild(div);
            
        });
        });
    });

    request('remove-data', "{{ route('values-group.delete_multiple') }}", 'delete', (response) => 
    {
        const sites = document.getElementById('values__groups-values');
        sites.innerHTML = '';
        get("{{ route('values-group') }}", (response) => 
        {
            response.forEach((elem) => 
        {

            const checkbox = create('values__check', '', '', 'input');
            checkbox.type = 'checkbox';
            checkbox.name = 'removes[]';
            checkbox.value = elem.id;

            const name = create('name', elem.name);
            // const faculty_name = create('sites__faculty', '');
            
            const a = create('values__groups_a', '', '', 'a');
            
            a.appendChild(name);
            a.href = '/values/'+elem.id;
            const group_head = create('group__head');
            group_head.appendChild(a);
            group_head.appendChild(checkbox);
            const div = create('values__group');
            div.appendChild(group_head);
            if(elem.faculty_id)
            {
                const faculty_name = create('values__faculty', elem.faculty.name);
                div.appendChild(faculty_name);
            }

            const group_values = create('values__group-values');

            if(elem.values)
            {
                elem.values.forEach((element) =>
                {
                    const value = create('values__group-value');
                    const value_name = create('values__group-value__name', element.search_value);
                    value.appendChild(value_name);
                    group_values.appendChild(value);
                });
            }

            const groups = document.getElementById('values__groups-values');
            div.appendChild(group_values);
            groups.appendChild(div);
            
        });
        });
    });

</script>
@endsection