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
                    <select id="options" name="faculty_id" ></select>
                </div>
        </form>
</div>

<script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src={{ asset('js/web.js') }}></script>
<script src={{ asset('js/elements.js') }}></script>
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
    const faculties = [
        { id: "1", name: "teset" },
        { id: "2", name: "elit" },
        { id: "3", name: "biem" },
        { id: "4", name: "ifsk" },
        { id: "5", name: "nnip" },
        { id: "6", name: "nnmi" },
        { id: "7", name: "all" },
        { id: "8", name: "general" }
    ];
    
    faculties.forEach(elem => 
    {
        const option = create('option', elem.name, '', 'option');
        option.value = elem.id;
        
        const options = document.getElementById('options');
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