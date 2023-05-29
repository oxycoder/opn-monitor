<script>
    $(document).ready(function () {
        var data_get_map = { 'frm_GeneralSettings': "/api/loki/settings/get" };
        mapDataToFormUI(data_get_map).done(function (data) {
            formatTokenizersUI();
            // place actions to run after load, for example update form styles.
            $('.selectpicker').selectpicker({ title: 'All (recommended)' }).selectpicker('render');
            $('.selectpicker').selectpicker('refresh');
        });

        // link save button to API set action
        $("#saveAct").click(function () {
            saveFormToEndpoint(url = "/api/loki/settings/set", formid = 'frm_GeneralSettings', callback_ok = function () {
                $('#loki-response').removeClass('hidden');
                ajaxCall(url = "/api/loki/service/reconfigure", sendData = {}, callback = function (data, status) {
                
                });
            });
        });

        updateServiceControlUI('loki');
    });
</script>

<div class="alert alert-info hidden" role="alert" id="loki-response">
    <div id="loki-alert-messages" class="loki-alert-messages">
        <label>Apply config success.</label>
    </div>
</div>

<div class="col-md-12">
    {{ partial("layout_partials/base_form",['fields':generalForm,'id':'frm_GeneralSettings'])}}
</div>

<div class="col-md-12">
    <button class="btn btn-primary" id="saveAct" type="button"><b>{{ lang._('Save') }}</b></button>
</div>