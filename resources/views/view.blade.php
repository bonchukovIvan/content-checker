@extends('layouts.app')
@section('content')
    <div class="panel panel-default">
        <div class="panel-body">
            <p style="font-size:20px; font-weight:bold;">Title</p>         
            <div> 
                <form class="mt-3" id="form-remove">
                    <button type="button" class="btn btn-success form-remove" style="background:red" id="create_new">Delete select haystacks</button>
                
                @foreach ($haystacks as $haystack)
                    <div>
                    <input type="checkbox" name="remove_heystacks[]" value="{{ $haystack->id }}">
                    <a href="/view/{{$haystack->id}}">
                    
                    <p>Name {{ $haystack->name }}</p>
                    <p>Link {{ $haystack->link }}</p> 
                    </a>    
                        <div>
                        @if ($haystack->needles)
                            @foreach ($haystack->needles as $needle)
                                <p>Needle {{ $needle->value }}</p> 
                            @endforeach
                        @endif
 
                        </div>
                    </div>
                @endforeach
                </form>
            </div>
        </div>
    </div>
    <script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script type="text/javascript">
    
        $(".form-remove").click(function(e){
            e.preventDefault();
            
            var data = $('#form-remove').serialize();
            $.ajax({
                type: 'post',
                url: "{{ route('haystack.remove') }}",
                data: data,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function(){
                    $('#create_new').html('....Please wait');
                },
                success: function(response){
                    alert(response.success);
                },
                complete: function(response){
                    $('#create_new').html('Create New');
                }
            });
         
        });

    </script>
@endsection