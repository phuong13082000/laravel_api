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

    //price-range
    $('#sl2').slider().on('slideStop', function (ev) {
        const min = ev.value[0];
        const max = ev.value[1];

        const url = new URL(window.location.origin + '/shop');

        const params = new URLSearchParams(window.location.search);
        params.forEach((value, key) => {
            if (key !== 'min' && key !== 'max' && key !== 'page') {
                url.searchParams.set(key, value);
            }
        });

        url.searchParams.set('min', min);
        url.searchParams.set('max', max);

        window.location.href = url.toString();
    });
});
