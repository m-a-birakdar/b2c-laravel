import { generateAjax } from "./generate-ajax.js";

$(document).ready(function (){
    generateAjax($('#load-users').val());
    // const socket = io('http://localhost:6001', {
    //     query: { 'user_id': $('#userId').val(), 'tenant': $('#tenant').val() },
    // });
    // socket.on('connect', () => {
    //     console.log(`Connected to server with ID ${socket.id}`);
    // });
});