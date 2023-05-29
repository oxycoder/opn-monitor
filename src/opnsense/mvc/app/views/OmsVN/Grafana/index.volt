<script>
    $(document).ready(function () {
        var data_get_map = { 'frm_GeneralSettings': "/api/grafana/settings/get" };
        mapDataToFormUI(data_get_map).done(function (data) {
            formatTokenizersUI();
            // place actions to run after load, for example update form styles.
            $('.selectpicker').selectpicker({ title: 'All (recommended)' }).selectpicker('render');
            $('.selectpicker').selectpicker('refresh');
        });

        // link save button to API set action
        $("#saveAct").click(function () {
            saveFormToEndpoint(url = "/api/grafana/settings/set", formid = 'frm_GeneralSettings', callback_ok = function () {
                $('#grafana-response').removeClass('hidden');
                ajaxCall(url = "/api/grafana/service/reconfigure", sendData = {}, callback = function (data, status) {
                    updateServiceControlUI('grafana');
                });
            });
        });

        updateServiceControlUI('grafana');
    });
</script>

<div class="alert alert-info hidden" role="alert" id="grafana-response">
    <div id="grafana-alert-messages" class="grafana-alert-messages">
        <label>Update config success. Restart service to take effect.</label>
    </div>
</div>

<div class="col-md-12">
    {{ partial("layout_partials/base_form",['fields':generalForm,'id':'frm_GeneralSettings'])}}
</div>

<div class="col-md-12">
    <button class="btn btn-primary" id="saveAct" type="button"><b>{{ lang._('Save') }}</b></button>
</div>