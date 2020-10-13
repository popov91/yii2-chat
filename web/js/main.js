$(".incorrect").on('click', function () {
    let button_value = $( this ).val();
    let button = $('#button-' + button_value)
    let message = $('#message-' + button_value)

    $.ajax({
        url: 'incorrect-message',
        data: {id : button_value},
        type: 'POST',
        success: function () {
            button.hide();
            message.show();
        },
        error: function () {
            console.log('error');
        }
    });
});

$(".correct").on('click', function () {
    let button_value = $( this ).val();
    let post = $('#post-' + button_value)

    $.ajax({
        url:  'post/correct-message',
        data: {id : button_value},
        type: 'POST',
        success: function () {
            post.hide();
        },
        error: function () {
            console.log('error');
        }
    });
});