@extends('layouts.app')

@section('content')
<div class="sites_create">
        <form class="mt-3" id="add-data">
                <div class="btn-container">
                    <button type="button" class="btn btn-success add-data"  id="create_new">Add site</button>
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
<div class="sites-container">
    <form class="mt-3" id="remove-data">
                    <div class="btn-container">
                        <button type="button" class="btn btn-success remove-data"  id="create_new">Remove selected</button>
                    </div>
    <div id="sites" class="sites"></div>
    </form>
</div>

<script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src={{ asset('js/web.js') }}></script>
<script src={{ asset('js/elements.js') }}></script>
<script src={{ asset('js/faculty.js') }}></script>
<script>
    
    get("{{ route('links') }}", (response) => 
    {
        response.forEach(elem => 
        {
            const checkbox = create('sites__check', '', '', 'input');
            checkbox.type = 'checkbox';
            checkbox.name = 'removes[]';
            checkbox.value = elem.id;
            const div = create('site',);
            const a = create('sites__link', '', '', 'a');
            a.href = '/links/'+elem.id;
            const link = create('sites__link', elem.sites_link);
            const faculty_name = create('sites__faculty', elem.faculty.name);
            a.appendChild(link);
            a.appendChild(faculty_name);

            div.appendChild(a);
            const site = create('site');
            site.appendChild(checkbox);
            site.appendChild(div);

            const sites = document.getElementById('sites');
            sites.appendChild(site);
        });
    });


    faculties.forEach(elem => 
    {
        const option = create('option', elem.name, '', 'option');
        option.value = elem.id;
        
        const options = document.getElementById('options');
        options.appendChild(option);

    });


    request('add-data', "{{ route('links.store') }}", 'post', (response) => 
    {
        const sites = document.getElementById('sites');
        sites.innerHTML = '';
        document.getElementById("add-data").reset();
        get("{{ route('links') }}", (response) => 
        {
            response.forEach(elem => 
            {
                const checkbox = create('sites__check', '', '', 'input');
                checkbox.type = 'checkbox';
                checkbox.name = 'removes[]';
                checkbox.value = elem.id;
                const div = create('site',);
                const a = create('sites__link', '', '', 'a');
                a.href = '/links/'+elem.id;
                const link = create('sites__link', elem.sites_link);
                const faculty_name = create('sites__faculty', elem.faculty.name);
                a.appendChild(link);
                a.appendChild(faculty_name);

                div.appendChild(a);
                const site = create('site');
                site.appendChild(checkbox);
                site.appendChild(div);

                const sites = document.getElementById('sites');
                sites.appendChild(site);
            });
        });
        
    });

    request('remove-data', "{{ route('links.delete_multiple') }}", 'delete', (response) => 
    {
        const sites = document.getElementById('sites');
        sites.innerHTML = '';
        get("{{ route('links') }}", (response) => 
        {
            response.forEach(elem => 
            {
                const checkbox = create('sites__check', '', '', 'input');
                checkbox.type = 'checkbox';
                checkbox.name = 'removes[]';
                checkbox.value = elem.id;
                const div = create('site',);
                const a = create('sites__link', '', '', 'a');
                a.href = '/links/'+elem.id;
                const link = create('sites__link', elem.sites_link);
                const faculty_name = create('sites__faculty', elem.faculty.name);
                a.appendChild(link);
                a.appendChild(faculty_name);

                div.appendChild(a);
                const site = create('site');
                site.appendChild(checkbox);
                site.appendChild(div);

                const sites = document.getElementById('sites');
                sites.appendChild(site);
            });
        });
    });

</script>
@endsection