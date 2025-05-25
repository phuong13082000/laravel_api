$(document).ready(function () {

    //logout
    $('#btnLogout').click(function () {
        $.ajax({
            url: '/user/logout',
            method: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                if (response.status === 'success') {
                    window.location.href = '/';
                }
            },
            error: function (xhr) {
                console.error('Logout error: ', xhr.responseText);
            }
        });
    });
});
