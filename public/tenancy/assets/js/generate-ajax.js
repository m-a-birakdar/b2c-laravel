export function generateAjax(url, data = {}, method = 'GET')
{
    let finalData;
    $.ajax({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url: url,
        method: method,
        data: data,
        async: false,
        success: function(data) {
            finalData = data;
            console.log(data);
        },
        error: function(xhr, status, error) {
            console.log(xhr.responseText);
        }
    });
    return finalData;
}
