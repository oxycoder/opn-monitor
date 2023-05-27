
<script>
    $( document ).ready(function() {
        // get entries from system log for 'Grafana'
        let grid_systemlog = $("#grid-systemlog").UIBootgrid({
            options:{
                // Hide nonfunctional search field
                navigation:2,
                sorting:false,
                rowSelect: false,
                selection: false,
                rowCount:[20,50,100,200,500,1000,-1],
                requestHandler: function(request){
                    // Show only log entries that match 'Grafana'
                    request['searchPhrase'] = 'Grafana';
                    return request;
                },
            },
            search:'/api/diagnostics/log/core/system'
        });

        // get entries from grafana.log
        let grid_grafanalog = $("#grid-grafanalog").UIBootgrid({
            options:{
                sorting:false,
                rowSelect: false,
                selection: false,
                rowCount:[20,50,100,200,500,1000,-1],
            },
            search:'/api/diagnostics/log/omsvn/grafana'
        });

        grid_systemlog.on("loaded.rs.jquery.bootgrid", function(){
            $(".action-page").click(function(event){
                event.preventDefault();
                $("#grid-systemlog").bootgrid("search",  "");
                let new_page = parseInt((parseInt($(this).data('row-id')) / $("#grid-log").bootgrid("getRowCount")))+1;
                $("input.search-field").val("");
                // XXX: a bit ugly, but clearing the filter triggers a load event.
                setTimeout(function(){
                    $("ul.pagination > li:last > a").data('page', new_page).click();
                }, 100);
            });
        });

        grid_grafanalog.on("loaded.rs.jquery.bootgrid", function(){
            $(".action-page").click(function(event){
                event.preventDefault();
                $("#grid-grafanalog").bootgrid("search",  "");
                let new_page = parseInt((parseInt($(this).data('row-id')) / $("#grid-log").bootgrid("getRowCount")))+1;
                $("input.search-field").val("");
                // XXX: a bit ugly, but clearing the filter triggers a load event.
                setTimeout(function(){
                    $("ul.pagination > li:last > a").data('page', new_page).click();
                }, 100);
            });
        });
    });
</script>


<ul class="nav nav-tabs" role="tablist" id="maintabs">
    <li class="active"><a data-toggle="tab" href="#systemlog"><b>{{ lang._('System Log') }}</b></a></li>
    <li><a data-toggle="tab" href="#grafanalog">{{ lang._('Grafana Log') }}</a></li>
</ul>

<div class="content-box tab-content">

    <div id="systemlog" class="tab-pane fade in active">
        <div class="content-box" style="padding-bottom: 1.5em;">
            <div  class="col-sm-12">
                <table id="grid-systemlog" class="table table-condensed table-hover table-striped table-responsive" data-store-selection="true">
                    <thead>
                    <tr>
                        <th data-column-id="timestamp" data-width="11em" data-type="string">{{ lang._('Date') }}</th>
                        <th data-column-id="process_name" data-width="11em" data-type="string">{{ lang._('Process') }}</th>
                        <th data-column-id="line" data-type="string">{{ lang._('Line') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div id="acmelog" class="tab-pane fade">
        <div class="content-box" style="padding-bottom: 1.5em;">
            <div  class="col-sm-12">
                <table id="grid-grafanalog" class="table table-condensed table-hover table-striped table-responsive" data-store-selection="true">
                    <thead>
                    <tr>
                        <th data-column-id="timestamp" data-width="11em" data-type="string">{{ lang._('Date') }}</th>
                        <th data-column-id="process_name" data-width="11em" data-type="string">{{ lang._('Process') }}</th>
                        <th data-column-id="line" data-type="string">{{ lang._('Line') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
