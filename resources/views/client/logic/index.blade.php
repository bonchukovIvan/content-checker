@extends('layouts.app')
@section('content')
<div class="check">
    <div class="check-container">
        <div class="check-body">
        <div class="btn-container check">
                <button type="button" class="btn btn-success add-data"  id="check-btn">Check</button>
        </div>
        <div id="results" class="results"></div>
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src={{ asset('js/web.js') }}></script>
<script src={{ asset('js/elements.js') }}></script>
<script>
    let btn = document.getElementById('check-btn');
    btn.addEventListener('click', () => 
    {
        const res = document.getElementById('results'); 
        res.innerHTML = '';   
        $.ajax(
        {
            type: 'get',
            url: "{{ route('logic') }}",
            beforeSend: function(){
                $('#check-btn').html('....Please wait');
            },
            success: function(response){
                console.log(response)
                response.forEach((elem) => 
            {
                const div = create('result');
                const link = create('link', elem.link);
                const success = create('group__success', elem.success+'%');
                const index_count = create('index_count', 'К масштабу: '+elem.index_count);
                const head = create('head');
                const btn = create('collapsible', '+', '', 'button')
                btn.addEventListener('click', () => 
                {
                    btn.classList.toggle('active');
                    
                    let content = btn.nextElementSibling;
                    content.classList.toggle('active-values');
                    if (content.style.maxHeight)
                    {
                        content.style.maxHeight = null;
                        btn.innerText = '+';
                    }
                    else
                    {
                        
                        // content.style.maxHeight = content.scrollHeight +'px';
                        content.style.maxHeight = 100+'%';
                        btn.innerText = '-';
                    }
                });
                head.appendChild(link);
                head.appendChild(success);
                div.appendChild(index_count);
                div.appendChild(head);
                div.appendChild(btn);
                const values = create('result__values');
                elem.values.forEach((value) => 
                {
                    const group = create('group');
                
                    const group_name = create('group__name', value.name);
                    const group_result = create('group__result', value.result);

                    if (!value.result) 
                    {
                        group.classList.add('result-false');
                        group_result.innerText = 'false';
                    }
                    else
                    {
                        group.classList.add('result-true');
                    }
                    const div = create('value');
                    group.appendChild(group_name);
                    group.appendChild(group_result);
                    values.appendChild(group);
                }); 
                div.appendChild(values);
                const results = document.getElementById('results'); 
                results.appendChild(div);
                
            }); 
            },
            complete: function(response){
                $('#check-btn').html('Check again');
            }
        });
    
    }
    );
    

</script>
@endsection