@extends('layouts.app')

@section('content')
<div class="sites_create">
        <form class="mt-3" id="add-data">
                <div class="btn-container">
                    <button type="button" class="btn btn-success add-data"  id="create_new">Add site</button>
                </div>
                <div class="form-group">
                    <label for="email">Link</label>
                    <input type="text" name="link" id="link" class="form-control">
                </div>
                <div class="form-group">
                    <select id="options" name="faculty_id" ></select>
                </div>
        </form>

</div>
<div class="sites-container">
    <form class="mt-3" id="remove-data">
                    <div class="btn-container">
                        <button type="button" class="btn btn-success remove-data"  id="create_new">Remove selected</button>
                    </div>
    <div id="sites" class="sites">        
    </div>
    </form>
</div>

<script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src={{ asset('js/web.js') }}></script>
<script src={{ asset('js/elements.js') }}></script>
<script>

    get("{{ route('sites') }}", (response) => 
    {
        display_sites(response);
    });

    get("{{ route('faculties') }}", (response) => 
    {
        response.forEach(elem => 
        {
            const option = create('option', elem.name, '', 'option');
            option.value = elem.id;
            
            const options = document.getElementById('options');
            options.appendChild(option);

        });
    });

    request('add-data', "{{ route('sites.store') }}", 'post', (response) => 
    {
        const sites = document.getElementById('sites');
        sites.innerHTML = '';
        get("{{ route('sites') }}", (response) => 
        {
            display_sites(response);
        });
    });

    request('remove-data', "{{ route('sites.delete_multiple') }}", 'delete', (response) => 
    {

        const sites = document.getElementById('sites');
        sites.innerHTML = '';
        get("{{ route('sites') }}", (response) => 
        {
            display_sites(response);
        });
    });

</script>
@endsection