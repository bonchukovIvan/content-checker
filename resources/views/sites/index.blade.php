@extends('layouts.app')@extends('layouts.app')

@section('content')
    <div class="create-form">

    </div>
    <div class="haystacks-list">
 
    </div>

    <script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src={{ asset('js/web.js') }}></script>
    <script src={{ asset('js/elements.js') }}></script>
    <script type="text/javascript">
        get("{{ route('sites.view_all') }}", (response) => {
            console.log(response);
        })
        

    </script>
    
@endsection