$(function () {
    const form = $('#paymentForm');
    const invoice = $('#invoice');
    let request;
    let generation = 0;
    $('.select-search').select2({width: '100%'});
    $('#payment_date').datepicker({dateFormat: 'yy-mm-dd', changeMonth: true, changeYear: true}).datepicker('setDate', new Date());
    function resetDetails() {
        $('#property, #unit').empty().append(new Option('Select an invoice first', ''));
        $('#amount, #payment_for').val('');
    }
    $('#tenant').on('change', function () {
        const current = ++generation;
        if (request) request.abort();
        resetDetails();
        invoice.empty().append(new Option('Select Invoice', '')).trigger('change.select2');
        if (!this.value) return;
        invoice.prop('disabled', true);
        request = $.post('src/harvest/get_invoices.php', {tenant_id: this.value})
            .done(function (html) { if (current === generation) invoice.html(html).trigger('change.select2'); })
            .fail(function (_, status) { if (status !== 'abort') $.notify('Unable to load invoices. Please try again.', 'error'); })
            .always(function () { if (current === generation) invoice.prop('disabled', false); });
    });
    invoice.on('change', function () {
        resetDetails();
        if (!this.value) return;
        const selected = $(this).find(':selected');
        $('#property').empty().append(new Option(selected.attr('data-property'), selected.attr('data-property-id'))).trigger('change.select2');
        $('#unit').empty().append(new Option(selected.attr('data-unit'), selected.attr('data-unit-id'))).trigger('change.select2');
        $('#amount').val(selected.attr('data-amount'));
        $('#payment_for').val(selected.attr('data-period'));
    });
    form.on('submit', function (event) {
        event.preventDefault();
        const button = form.find('[type=submit]');
        if (button.prop('disabled')) return;
        button.prop('disabled', true).text('Saving payment…');
        $.ajax({url: 'src/process/save_payment.php', method: 'POST', data: form.serialize(), dataType: 'json'})
            .done(function (res) {
                $.notify(res.message, res.status === 'success' ? 'success' : 'error');
                if (res.status === 'success') { form[0].reset(); $('#tenant').val('').trigger('change'); $('#payment_date').datepicker('setDate', new Date()); }
            })
            .fail(function (xhr) { $.notify(xhr.responseJSON?.message || 'Unable to save payment. Please try again.', 'error'); })
            .always(function () { button.prop('disabled', false).text('Submit Payment'); });
    });
});
