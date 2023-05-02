export function generateAjax(url)
{
    let finalData;
    $.ajax({
        url: url,
        async: false,
        success: function(data) {
            finalData = data;
            console.log(data);
        }
    });
    return finalData;
}