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
            const res_arr = [];
            result.forEach((element) =>
            {
                console.log(element);
                const name = document.createElement('div');
                name.classList.add("result__name");
                name.innerText = element.name;

                const link = document.createElement('div');
                link.classList.add("result__link");
                link.innerText = element.link;

                const needles = document.createElement('div');
                needles.classList.add("result__needles");
                if(element.needles) 
                {    
                    const needle_arr = [];
                    console.log(element.needles);
                    for(prop in element.needles)
                    {
                        
                        const needle = document.createElement('div');
                        if (!element.needles[prop]) 
                        {
                            needle.classList.add("result__needles-false");

                            const needle_text = document.createElement('div');
                            needle_text.classList.add("result__needles-text");
                            needle_text.innerText = prop;

                            const needle_value = document.createElement('div');
                            needle_value.classList.add("result__needles-value");
                            needle_value.innerText = element.needles[prop];

                            needle.appendChild(needle_text);
                            needle.appendChild(needle_value);

                            needle_arr.push(needle);
                        }
                        else 
                        {
                            needle.classList.add("result__needles-true");

                            const needle_text = document.createElement('div');
                            needle_text.classList.add("result__needles-text");
                            needle_text.innerText = prop;

                            const needle_value = document.createElement('div');
                            needle_value.classList.add("result__needles-value");
                            needle_value.innerText = element.needles[prop];

                            needle.appendChild(needle_text);
                            needle.appendChild(needle_value);

                            needle_arr.push(needle);
                        }
                    };
                    needle_arr.forEach((needle) => {
                        needles.appendChild(needle);
                    });
                }
                
                const result = document.createElement('div');
                result.classList.add("result");

                result.appendChild(name);
                result.appendChild(link);
                result.appendChild(needles);

                res_arr.push(result);
            });
            
            const results = document.createElement('div');
            results.classList.add("results");
            res_arr.forEach((result) => {
                results.appendChild(result);
            });

            const panelBody = document.querySelector('.panel-body');
                panelBody.appendChild(results);
        }
    </script>
@endsection