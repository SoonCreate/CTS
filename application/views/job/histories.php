<div class="container-fluid">
    <div id="jobHistoryList"></div>
</div>

<script type="text/javascript">

    require(["sckj/DataGrid"],function(Grid){
        var grid ;

        $ajax.get(url("job/history_structure"),{handleAs:"json"}).then(function(structure){
            grid = new Grid({
                asyncCache : true,
                id : "jobHistoryList",
                pageSize : 10,
                url : url("job/history_data",{job_id : <?= v('job_id')?>}),
                structure:structure,
                autoWidth : false,
                autoHeight : true,
                operationColumn : {
                    data : [
                        {url : "job/history_log",label: "<?= label('log')?>"},
                        {url : "job/history_output",label: "<?= label('data')?>",realLink: true}
                    ]
                }
            },"jobHistoryList");

            grid.startup();
        });
    });

</script>