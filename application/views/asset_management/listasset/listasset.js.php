<script>
    var dataTable;
    var iZoneName="";
    var iDivisionName="";
    var iBisUnitName="";
    var iFAID="";
    var iFAID_lama="";
    var iItemName="";
    var iStatus = '%';
    var iSearch = 'BranchName';

    jQuery(document).ready(function () {
        loadGridMutation();

    });
    // jQuery(document).ready(function () {
    //     TableManaged.init();
    // });
    btnStart();

function sch(e){
    console.log(e.value);
    if(e.name=="ZoneName"){
        iZoneName=e.value;
    }
    if(e.name=="DivisionName"){
        iDivisionName=e.value;
    }
    if(e.name=="BisUnitName"){
        iBisUnitName=e.value;
    }
    if(e.name=="FAID"){
        iFAID=e.value;
    }
    if(e.name=="FAID_lama"){
        iFAID_lama=e.value;
    }
    if(e.name=="ItemName"){
        iItemName=e.value;
    }
     $('#table_gridMutation').DataTable().ajax.reload();
}
    function loadGridMutation() {
        dataTable = $('#table_gridMutation').DataTable({
          
            "lengthMenu": [
                [5, 10, 15, 20, -1],
                [5, 10, 15, 20, "All"] // change per page values here
            ],
//                // set the initial value
            "pageLength": 5,
            "processing": true,
            "serverSide": true,
            "ajax": {
                url: "<?php echo base_url("/asset_management/listasset/ajax_GridMutation"); ?>", // json datasource
                type: "post", // method  , by default get
                data: function (z) {
                    z.sZoneName = iZoneName;
                    z.sDivisionName = iDivisionName;
                    z.sBisUnitName = iBisUnitName;
                    z.sFAID = iFAID;
                    z.sFAID_lama = iFAID_lama;
                    z.sItemName = iItemName;
                },
                error: function () {  // error handling
                    $(".table_gridMutation-error").html("");
                    // $("#lookup").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
                    $('#table_gridMutation tbody').html('<tbody class="employee-grid-error"><tr><th colspan="4">No data found in the server</th></tr></tbody>');
                    $("#table_gridMutation_processing").css("display", "none");

                }
            },
            "columnDefs": [
                {"targets": [-1], "orderable": false, "searchable": false},
//                {"targets": [0], "orderable": false},
//                {"targets": [1], "orderable": false},
//                {"targets": [2], "orderable": false},
//                {"targets": [3], "orderable": false},
//                {"targets": [4], "orderable": false},
//                {"targets": [5], "orderable": false},
//                {"targets": [6], "orderable": false},
//                {"targets": [7], "orderable": false},
//                {"targets": [8], "orderable": false},
//                {"targets": [9], "visible": false, "searchable": false},
//                {"targets": [10], "visible": false, "searchable": false},
//                {"targets": [11], "visible": false, "searchable": false},
            ],
        });
    }

    function detilasset(e) {
        var id = e.id;
        var encripturl = '<?php echo base_url(); ?>asset_management/listasset/detilasset/' + id;
        $.ajax({
            url: encripturl,
            type: 'POST',
            dataType: 'html',
            success: function (e) {
                $('#bodyDetail').html(e);
            },
        });
    }

    function setID(val) {
        document.getElementById("data_id").value = val;
        console.log(val);
    }
   function mutationasset(e) {
//       document.getElementById("myModal2").style.zIndex = "1";
        $("#mdl_Update").css("z-index", "10000");
        console.log(e.id,'-',e.name);
//        var encripturl = '<?php echo base_url(); ?>asset_management/listasset/mutationasset/' + e.id + '/' + e.name;
//        $.ajax({
//            url: encripturl,
//            type: 'POST',
//            dataType: 'html',
//            success: function (a) {
//                console.log(a);
////                $('#modal-mutation').html(a);
//            },
//        });
    }

</script>