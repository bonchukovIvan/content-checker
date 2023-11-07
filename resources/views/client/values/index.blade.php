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
        <div id="groups-values" class="groups-values"></div>
    </form>
</div>

<script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src={{ asset('js/web.js') }}></script>
<script src={{ asset('js/elements.js') }}></script>
<script src={{ asset('js/btn.js') }}></script>

<script>

    get("{{ route('values-group') }}", (response) => 
    {
        
        response.forEach((elem) => 
        {
            const checkbox = create('haystack__check', '', '', 'input');
            checkbox.type = 'checkbox';
            checkbox.name = 'removes[]';
            checkbox.value = elem.id;
            console.log(response);
            const name = create('name', elem.name);

            const a = create('groups_a', '', '', 'a');
            a.appendChild(name);
            a.href = '/values/'+elem.id;

            const div = create('group');
            div.appendChild(checkbox);
            div.appendChild(a);
    
            const group_values = create('group-values');
   

            if(elem.values)
            {
                elem.values.forEach((element) =>
                {
                    const value = create('group-value');
                    const value_name = create('group-value__name', element.search_value);
                    value.appendChild(value_name);
                    group_values.appendChild(value);
                });
            }

            const groups = document.getElementById('groups-values');
            groups.appendChild(div);
            groups.appendChild(group_values);
        });
    });

    request('add-data', "{{ route('values-group.store') }}", 'post', (response) => 
    {
        const sites = document.getElementById('groups-values');
        sites.innerHTML = '';
        document.getElementById("add-data").reset();
        console.log(response)
        get("{{ route('values-group') }}", (response) => 
        {
            response.forEach((elem) => 
        {
            const checkbox = create('haystack__check', '', '', 'input');
            checkbox.type = 'checkbox';
            checkbox.name = 'removes[]';
            checkbox.value = elem.id;
            console.log(response);
            const name = create('name', elem.name);

            const a = create('groups_a', '', '', 'a');
            a.appendChild(name);
            a.href = '/values/'+elem.id;

            const div = create('group');
            div.appendChild(checkbox);
            div.appendChild(a);
    
            const group_values = create('group-values');
   

            if(elem.values)
            {
                elem.values.forEach((element) =>
                {
                    const value = create('group-value');
                    const value_name = create('group-value__name', element.search_value);
                    value.appendChild(value_name);
                    group_values.appendChild(value);
                });
            }

            const groups = document.getElementById('groups-values');
            groups.appendChild(div);
            groups.appendChild(group_values);
        });
        });
    });

    request('remove-data', "{{ route('values-group.delete_multiple') }}", 'delete', (response) => 
    {
        const sites = document.getElementById('groups-values');
        sites.innerHTML = '';
        get("{{ route('values-group') }}", (response) => 
        {
            response.forEach((elem) => 
        {
            const checkbox = create('haystack__check', '', '', 'input');
            checkbox.type = 'checkbox';
            checkbox.name = 'removes[]';
            checkbox.value = elem.id;
            console.log(response);
            const name = create('name', elem.name);

            const a = create('groups_a', '', '', 'a');
            a.appendChild(name);
            a.href = '/values/'+elem.id;

            const div = create('group');
            div.appendChild(checkbox);
            div.appendChild(a);
    
            const group_values = create('group-values');
   

            if(elem.values)
            {
                elem.values.forEach((element) =>
                {
                    const value = create('group-value');
                    const value_name = create('group-value__name', element.search_value);
                    value.appendChild(value_name);
                    group_values.appendChild(value);
                });
            }

            const groups = document.getElementById('groups-values');
            groups.appendChild(div);
            groups.appendChild(group_values);
        });
        });
    });

</script>
@endsection