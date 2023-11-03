function get(route, callback) 
{
    $.ajax(
    {
        type: 'get',
        url: route,
        success: function(response)
        {
            callback(response);
        },
    });
}

function post(route, data_source, before, callback) {
    $(data_source).click(function(e)
    {
        e.preventDefault();

        const data = $(data_source).serialize();
        
        $.ajax(
        {
            type: 'post',
            url: route,
            data: data,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) 
            {
                if(before) {
                    const el = document.getElementById(before);
                    el.innerHTML = '';
                }

                callback(response);
            },
        });
    });
}

function test() {
    console.log(1);
}