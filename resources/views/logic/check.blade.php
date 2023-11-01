@extends('layouts.app')

@section('content')
    <div class="panel panel-default">
        <div class="panel-body">
            <p style="font-size:20px; font-weight:bold;">Title</p>
            <form class="mt-3" id="form-data">
                <button type="button" class="btn btn-success submit-form" style="background:green" id="create_new">Check</button>
                <div id="result" class="test">
                </div>
            </form>
        </div>
    </div>

    <script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script type="text/javascript">
    
        $(".submit-form").click(function(e){
            e.preventDefault();
            var data = $('#form-data').serialize();
            $.ajax({
                type: 'post',
                url: "{{ route('logic.main') }}",
                data: data,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function(){
                    $('#create_new').html('....Please wait');
                },
                success: function(response){
                    createResult(response.result);
                    console.log(response.result[0])
                },
                complete: function(response){
                    $('#create_new').html('Create New');
                }
            });
        });

        function createResult(result) 
        {
            result.forEach((element) =>
            {
                const elem = document.createElement('div');
                elem.innerText = element.name;
                
                const results = document.createElement('div');
                elem.innerText = element.name;
                
                const result = document.createElement('div');
                result.classList.add("result");
                result.appendChild(elem);
                
                const panelBody = document.querySelector('.panel-body');
                panelBody.appendChild(result);
            })
        }
    </script>
@endsection