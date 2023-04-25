let usersOnline = [];
export function startEndConnection(io, socket) {
    socket.on('start_end_connection', (data) => {
        if (data['status'] === 'start' && ! usersOnline.includes(data['user_id'])){
            usersOnline.push(data['user_id']);
        } else if(data['status'] === 'end'){
            usersOnline = usersOnline.filter((value) => value !== data['user_id']);
        }
        io.emit('connected_users', usersOnline.length);
        console.log(usersOnline);
    });
}
