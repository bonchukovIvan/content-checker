@extends('layouts.app')

@section('content')
<div class="sites_create">
        <form class="mt-3" id="add-data">
                <div class="btn-container">
                    <button type="button" class="btn btn-success add-data"  id="create_new">Update site</button>
                </div>
                <div class="form-group">
                    <label for="link">Link</label>
                    <input type="text" name="link" id="link" class="form-control">
                </div>
                <div class="form-group">
                    <select id="options_faculty" name="faculty_id" ></select>
                    <select id="options_departament" name="departament_id" ></select>
                </div>
        </form>
</div>

<script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src={{ asset('js/web.js') }}></script>
<script src={{ asset('js/elements.js') }}></script>
<script src={{ asset('js/faculty.js') }}></script>
<script src={{ asset('js/departament.js') }}></script>
<script>
    function fetchFirstResource() 
    {
        get("{{ route('sites.get_one', $id) }}", (response) => 
        {
            const link = document.getElementById('link');
            link.value = response.link;
            const options = document.getElementById('options');
            options.value = response.faculty.id;
        });
    }
    departaments.forEach(elem => 
    {
        const option = create('option', elem.name, '', 'option');
        option.value = elem.id;
        
        const options = document.getElementById('options_departament');
        options.appendChild(option);

    });

    faculties.forEach(elem => 
    {
        const option = create('option', elem.name, '', 'option');
        option.value = elem.id;
        const options = document.getElementById('options_faculty');
        options.appendChild(option);

    });

    fetchFirstResource();
    
    request('add-data', "{{ route('sites.update', $id) }}", 'patch', (response) => 
    {
        const link = document.getElementById('link');
        link.value = response.link;
        const options = document.getElementById('options');
        options.value =  response.faculty_id;
    });

</script>
@endsection