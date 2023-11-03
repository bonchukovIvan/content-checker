@extends('layouts.app')

@section('content')

<div class="check">
    <form class="mt-3" id="form-data">
            <button type="button" class="btn btn-success submit-form" id="create_new">Check</button>
        </form>
        <div id="result" class="results-container">
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
                    const results = document.getElementById('result');
                    results.innerHTML = '';
                    createResult(response.result);
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
                const link = document.createElement('div');
                link.classList.add("result__link");
                link.innerText = element.link;

                const name = document.createElement('div');
                name.classList.add("haystack__title");
                name.innerText = element.name;
                name.appendChild(link);

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
                            needle_text.classList.add("resneed");
                            needle_text.classList.add("result__needles-text");
                            needle_text.innerText = prop;

                            const needle_value = document.createElement('div');
                            needle_value.classList.add("resneed");
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
                result.classList.add("haystack");

                result.appendChild(name);
     
                result.appendChild(needles);

                res_arr.push(result);
            });
            
            const results = document.createElement('div');
            results.classList.add("results");
            res_arr.forEach((result) => {
                results.appendChild(result);
            });

            const panelBody = document.getElementById('result');
            panelBody.appendChild(results);
        }
    </script>
@endsection