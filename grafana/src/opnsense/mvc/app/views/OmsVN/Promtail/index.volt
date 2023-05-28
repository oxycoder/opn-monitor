<link rel="stylesheet" href="{{ cache_safe('/ui/css/ace/ace.css') }}" type="text/css" />
<script src="{{ cache_safe('/ui/js/ace/ace.min.js') }}"></script>

<script>
    function decodeEntities(encodedString) {
        var div = document.createElement('div');
        div.innerHTML = encodedString;
        return div.textContent;
    }
    $(document).ready(function () {
        var editor = ace.edit('promtail.general.scrape_configs');
        editor.renderer.on('afterRender', function () {
            $('.ace_editor').closest('td').css('width', '100%');
        });
        var data_get_map = { 'frm_GeneralSettings': "/api/promtail/settings/get" };
        mapDataToFormUI(data_get_map).done(function (data) {
            formatTokenizersUI();
            // place actions to run after load, for example update form styles.
            $('.selectpicker').selectpicker({ title: 'All (recommended)' }).selectpicker('render');
            $('.selectpicker').selectpicker('refresh');

            // format yaml field
            editor.setValue(decodeEntities(data.frm_GeneralSettings.promtail.general.scrape_configs));
        });

        // link save button to API set action
        $("#saveAct").click(function () {
            saveFormData(url = "/api/promtail/settings/set", formid = 'frm_GeneralSettings', callback_ok = function () {
                $('#promtail-response').removeClass('hidden');
                ajaxCall(url = "/api/promtail/service/reload", sendData = {}, callback = function (data, status) {

                });
            });
        });

        updateServiceControlUI('promtail');

        function saveFormData(url, formid, callback_ok, disable_dialog, callback_fail) {
            disable_dialog = disable_dialog || false;
            const data = getFormData(formid);
            data.promtail.general.scrape_configs = editor.getValue();
            ajaxCall(url, data, function (data, status) {
                if (status === "success") {
                    // update field validation
                    handleFormValidation(formid, data['validations']);

                    // if there are validation issues, update our screen and show a dialog.
                    if (data['validations'] !== undefined) {
                        if (!disable_dialog) {
                            const detailsid = "errorfrm" + Math.floor((Math.random() * 10000000) + 1);
                            const errorMessage = $('<div></div>');
                            errorMessage.append('Please correct validation errors in form <br />');
                            errorMessage.append('<i class="fa fa-bug pull-right" aria-hidden="true" data-toggle="collapse" ' +
                                'data-target="#' + detailsid + '" aria-expanded="false" aria-controls="' + detailsid + '"></i>');
                            errorMessage.append('<div class="collapse" id="' + detailsid + '"><hr/><pre></pre></div>');

                            // validation message box is optional, form is already updated using handleFormValidation
                            BootstrapDialog.show({
                                type: BootstrapDialog.TYPE_WARNING,
                                title: 'Input validation',
                                message: errorMessage,
                                buttons: [{
                                    label: 'Dismiss',
                                    action: function (dialogRef) {
                                        dialogRef.close();
                                    }
                                }],
                                onshown: function () {
                                    // set debug information
                                    $("#" + detailsid + " > pre").html(JSON.stringify(data, null, 2));
                                }
                            });
                        }

                        if (callback_fail !== undefined) {
                            // execute callback function
                            callback_fail(data);
                        }
                    } else if (callback_ok !== undefined) {
                        // execute callback function
                        callback_ok(data);
                    }
                }
            });
        }
    });

</script>

<div class="alert alert-info hidden" role="alert" id="promtail-response">
    <div id="promtail-alert-messages" class="promtail-alert-messages">
        <label>Apply config success.</label>
    </div>
</div>

<div class="col-md-12">
    {{ partial("layout_partials/base_form",['fields':generalForm,'id':'frm_GeneralSettings'])}}
</div>

<div class="col-md-12">
    <button class="btn btn-primary" id="saveAct" type="button"><b>{{ lang._('Save') }}</b></button>
</div>