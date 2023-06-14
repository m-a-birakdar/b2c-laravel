export function Order(io, socket)
{
    socket.on('new_order', (data) => {
        console.log(data);
    });
}
