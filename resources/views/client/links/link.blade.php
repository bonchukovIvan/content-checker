@extends('layouts.app')

@section('content')
<div class="sites_create">
        <form class="mt-3" id="add-data">
                <div class="btn-container">
                    <button type="button" class="btn btn-success add-data"  id="create_new">Update link</button>
                </div>
                <div class="form-group">
                    <label for="link">Link</label>
                    <input type="text" name="sites_link" id="sites_link" class="form-control">
                </div>
                <div class="form-group">
                    <select id="options" name="faculty_id" ></select>
                </div>
        </form>
</div>

<script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src={{ asset('js/web.js') }}></script>
<script src={{ asset('js/elements.js') }}></script>
<script src={{ asset('js/faculty.js') }}></script>
<script>
    function fetchFirstResource() 
    {
        get("{{ route('links.get_one', $id) }}", (response) => 
        {
            console.log(response)
            const link = document.getElementById('sites_link');
            link.value = response.sites_link;
            const options = document.getElementById('options');
            options.value = response.faculty.id;
        });
    }
    
    faculties.forEach(elem => 
    {
        const option = create('option', elem.name, '', 'option');
        option.value = elem.id;
        
        const options = document.getElementById('options');
        options.appendChild(option);
    });
    fetchFirstResource();
    
    request('add-data', "{{ route('links.update', $id) }}", 'patch', (response) => 
    {
        const link = document.getElementById('link');
        link.value = response.sites_link;
        const options = document.getElementById('options');
        options.value =  response.faculty_id;
    });

</script>
@endsection