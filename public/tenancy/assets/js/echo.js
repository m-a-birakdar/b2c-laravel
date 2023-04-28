// const socket = io('http://localhost:6001');
// socket.on('connect', () => {
//     console.log(`Connected to server with ID ${socket.id}`);
// });
// socket.on('news', (data) => {
//     console.log(data);
// });
// import Echo from 'laravel-echo';
window.Echo = new Echo({
    broadcaster: 'socket.io',
    host: "127.0.0.1:6001"
});
window.Echo.channel('user-channel').listen('.UserEvent', (data) => {
    console.log(data);
});
