import { generateAjax } from "./../../js/generate-ajax.js";

let user = $('#userId');
let receipt = $('#receipt_id');
let container = $('.direct-chat-messages');
let loading = `<div class="w-100 text-center"><div class="lds-roller"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div></div>`;

const socket = io('http://localhost:2000', {
    query: { 'user_id': user.val(), 'tenant': $('#tenant').val() },
});
socket.on('connect', () => {
    console.log(`Connected to server with ID ${socket.id}`);
});

socket.on('new_message', (data) => {
    if (data.receipt_id === parseInt(receipt.val()) || data.sender_id === parseInt(receipt.val()) || data.sender_id === parseInt(user.val())){
        writeMessage(data);
    } else {
        $(`#load-users li[data-id="` + data.sender_id + `"]`).children('a').children('span').addClass('bg-danger').html(1);
    }
});

$(document).ready(function (){
    loadUsers();

    sendMessage();

    selectReceipt();
});

function writeMessage(data)
{
    container.append(messageContent(data));
    let scrollHeight = container[0].scrollHeight;
    container.scrollTop(scrollHeight);
}

function messageContent(data)
{
    let isOwner = data.sender_id === parseInt( user.val());
    return `<div class="direct-chat-msg ` + (isOwner ? 'right' : '') + `">
        <div class="direct-chat-infos clearfix">
            <span class="direct-chat-name ` + (isOwner ? 'float-left' : 'float-right') + `"></span>
            <span class="direct-chat-timestamp ` + (isOwner ? 'float-right' : 'float-left') + `">` + data.created_at + `</span>
        </div>
        <div class="direct-chat-text">` + data.text + `</div>
    </div>`;
}

function selectReceipt() {
    $(document).on('click', '.user-chat', function (){
        let th = $(this);
        let id = th.data('id');
        let name = th.data('name');
        receipt.val(id);
        $('.direct-chat').show();
        $('.chat-title').html(name);
        container.html(loading);
        th.children('a').children('span').removeClass('bg-danger').html(``);
        let messages = generateAjax($('#load-messages').val() + '?first_id=' + id + '&second_id=' + user.val());
        container.html(``);
        if (messages['data'].length > 0){
            let newMessages = messages['data'].reverse()
            newMessages.forEach((message) => {
                writeMessage(message);
            });
        } else {
            container.html(`<div class="alert alert-danger">No messages</div>`)
        }
    })
}
function sendMessage() {
    $(document).on('click', '#sendMessage', function (){
        let input = $(this).parent().siblings('input');
        socket.emit('new_message', {
            sender_id: parseInt( user.val()),
            receipt_id: parseInt(receipt.val()),
            text: input.val(),
            created_at: 'Now'
        });
        console.log(input.val());
        input.val('');
    })
}

function loadUsers()
{
    let users = generateAjax($('#load-users-url').val());
    socket.on('get_users_online', (data) => {
        let html = ``;
        users['data'].forEach((user) => {
            html += `<li class="nav-item user-chat" data-id="` + user.id + `" data-name="` + user.name +`"> <a href="#" class="nav-link"> `+ ( data['online_users'].includes(user.id) ? `<i class="fas fa-circle text-success mr-2"></i>` : `<i class="fas fa-circle text-danger mr-2"></i>`) + user.name + ` <span class="badge float-right"></span></a></li>`;
        });
        $('#load-users').html(html);
    });
}
