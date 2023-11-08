@extends('layouts.app')
@section('content')
<div class="check">
    <div class="check-container">
        <div class="check-body">
        <div class="btn-container">
                <button type="button" class="btn btn-success add-data"  id="check-btn">Add group</button>
        </div>
        <div id="results" class="results"></div>
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src={{ asset('js/web.js') }}></script>
<script src={{ asset('js/elements.js') }}></script>
<script>
    get("{{ route('logic') }}", (response) => 
    {
        console.log(response);
        // for (const [key, value] of Object.entries(response)) 
        // {
        //     const div = create('result');
        //     const link = create('link', key);
        //     div.appendChild(link);
        //     for (const [name, res] of Object.entries(value)) 
        //     {
        //         console.log(`${name}: ${res}`);
                
        //     }

        //     const results = document.getElementById('results'); 
        //     results.appendChild(div);
        // }
    });
</script>
@endsection