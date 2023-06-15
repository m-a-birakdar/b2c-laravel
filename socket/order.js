export async function Order(io, socket, userId, tenant)
{
    socket.on('new_order', (data) => {
        console.log('new_order');
        io.emit('new_order', {
            order_id: data['order_id'],
            user_id: userId,
            tenant: tenant,
        });
        console.log(data);
    });
}
