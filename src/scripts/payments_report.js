$(function () {
    let request;
    function loadPayments() {
        const from = $('#from_date').val();
        const to = $('#to_date').val();
        if (from && to && from > to) { $.notify('Start date must be before end date.', 'error'); return; }
        if (request) request.abort();
        request = $.post('src/harvest/fetch_payments.php', {from, to})
            .done(function (html) { $('#paymentsBody').html(html); })
            .fail(function (_, status) { if (status !== 'abort') $.notify('Unable to load payments.', 'error'); });
    }
    $('#filterBtn').on('click', loadPayments);
    $('#resetBtn').on('click', function () { $('#from_date, #to_date').val(''); loadPayments(); });
    loadPayments();
});
