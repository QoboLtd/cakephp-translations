var translation = translation || {};

(function ($) {

    $('#translations_translate_id_modal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var record_id = button.data('record');
        var model_name = button.data('model');
        var field_name = button.data('field');
        var field_value = button.data('value');

        $('#orig_for_translate').val(field_value);

        $.get('/language-translations/translations?object_foreign_key=' + record_id + '&object_model=' + model_name + '&object_field=' + field_name + '&json=1', function (data) {
            if (data.length != 0) {
                $.each(data, function (key, val) {
                    $('#translation_' + val['language']['code']).val(val['translation']);
                    $('#translation_id_' + val['language']['code']).val(val['id']);
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
        lang = $(this).data('lang');
        formData = $('#form_translation_' + lang).serialize();
        $.post('/language-translations/translations/addOrUpdate', formData, function (data) {
            $('#result_' + lang).attr('class', data ? 'alert alert-success' : 'alert alert-danger');
            $('#result_' + lang).html(data ? 'Translation is created or updated successfully.' : 'Translation cannot be saved. Please try later.').show().delay(5000).fadeOut();
        });
    });
})(jQuery);
