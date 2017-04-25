var translation = translation || {};

(function ($) {

    $('#translations_translate_id_modal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var record_id = button.data('record');
        var model_name = button.data('model');
        var field_name = button.data('field');

        $.get('/translations/translations?object_foreign_key=' + record_id + '&object_model=' + model_name + '&object_field=' + field_name + '&json=1', function (data) {
            if (data.length != 0) {
                $.each(data, function (key, val) {
                    $('#translation_' + val['language']['code']).val(val['translation']);
                });
            } else {
                $('textarea[name=translation]').each(function () {
                    this.value = '';
                });
            }
        });

        $('input[name=object_foreign_key]').val(record_id);
        $('input[name=object_model]').val(model_name);
        $('input[name=object_field]').val(field_name);
    });
    $('#translations_translate_id_modal').on('hidden.bs.modal', '.modal', function () {
        $(this).removeData('bs.modal');
    });
    $('button[name=btn_translation]').click(function () {
        form = $(this).closest("form");
        $.post('/translations/translations/addOrUpdate', form.serialize(), function (data) {
            $('#translate_result').attr('class', data ? 'alert-success' : 'alert-danger');
            $('#translate_result').html(data ? 'Translation is created or updated successfully.' : 'Translation cannot be saved.').show().delay(5000).fadeOut();
        });
    });
})(jQuery);
