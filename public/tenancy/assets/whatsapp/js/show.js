$(document).ready(function (){
    let div = $('#whatsapp_status');
    const socket = io('http://localhost:6001', {
        query: { 'tenant': $('#tenant').val(), 'user_id': $('#userId').val() },
    });
    socket.on('connect', () => {
        console.log(`Connected to server with ID ${socket.id}`);
        div.html(`<h1>Loading</h1>`);
    });
    socket.on('whatsapp_status', (data) => {
        div.html(`<h1>` + data['message'] + `</h1>`);
        if (data['qr']){
            div.qrcode({
                text: data['qr'],
                width: 420,
                height: 420
            });
        }
    });
});
