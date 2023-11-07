function get(route, callback) 
{
    $.ajax(
    {
        type: 'get',
        url: route,
        success: function(response)
        {
            callback(response, id = '');
        },
    });
}


function request(source, route, type, callback) 
{
    $("."+source).click(function(e)
    {
        e.preventDefault();
            
        var data = $('#'+source).serialize();
        $.ajax(
        {
            type: type,
            url: route,
            data: data,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function(){
                $('#delete').html('....Please wait');
            },
            success: function(response){
                callback(response);
            },
            complete: function(response){
                $('#delete').html('Add site');
            }
        });
    });
}

