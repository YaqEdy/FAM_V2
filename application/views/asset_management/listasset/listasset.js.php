<script>
    var dataTable, iid;
    var iZoneName = "";
    var iDivisionName = "";
    var iBisUnitName = "";
    var iFAID = "";
    var iFAID_lama = "";
    var iItemName = "";
    var iStatus = '%';
    var iSearch = 'BranchName';

    jQuery(document).ready(function () {
        loadGridMutation();

    });
    // jQuery(document).ready(function () {
    //     TableManaged.init();
    // });
    btnStart();

    function sch(e) {
        console.log(e.value);
        if (e.name == "ZoneName") {
            iZoneName = e.value;
        }
        if (e.name == "DivisionName") {
            iDivisionName = e.value;
        }
        if (e.name == "BisUnitName") {
            iBisUnitName = e.value;
        }
        if (e.name == "FAID") {
            iFAID = e.value;
        }
        if (e.name == "FAID_lama") {
            iFAID_lama = e.value;
        }
        if (e.name == "ItemName") {
            iItemName = e.value;
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
        $(".modal-title").html('Depreciation');
        $("#submitmutasi").hide();
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

    function mutationasset(e) {
        $(".modal-title").html('Mutation Asset');
        iid = e.id;
        $("#submitmutasi").show();
        var encripturl = '<?php echo base_url(); ?>asset_management/listasset/mutationasset/' + e.id + '/' + e.name;
        $.ajax({
            url: encripturl,
            type: 'POST',
            dataType: 'html',
            success: function (a) {
                $('#bodyDetail').html(a);
            },
        });
    }

    function disposal(e) {
        var id = e.id;
        var faid = e.name;
        var encripturl = '<?php echo base_url(); ?>asset_management/listasset/disposal/' + id + '/' + faid;
        $.ajax({
            url: encripturl,
            type: 'POST',
            dataType: 'JSON',
            success: function (a) {
                if (a) {
                    $('#table_gridMutation').DataTable().ajax.reload();
                }
            },
            beforeSend: function () {
                $(".disposal").attr('disabled', 'disabled').html('Loading...');
            },
            compelete: function () {
                $(".disposal").removeAttr('disabled', 'disabled').html('disposal');
            }
        });
    }

    $("form#mutations").click(function (e) {
        e.preventDefault();
        if ($("#cabang").val() != "" && $("#unit").val() != 0 && $("#unit").val() != "" || $("#divisi").val() != "") {
            $.ajax({
                url: '<?php echo base_url(); ?>asset_management/listasset/mutasi/' + iid,
                type: 'POST',
                data: new FormData(this),
                cache: false,
                contentType: false,
                processData: false,
                success: function (a) {
                    $('#table_gridMutation').DataTable().ajax.reload();
                }
//            beforeSend: function () {
//                $("#submitmutasi").attr('disabled', 'disabled').html('Loading...');
//            },
//            compelete: function () {
//                $("#submitmutasi").removeAttr('disabled', 'disabled').html('Mutation');
//            }
            });
        }
    });

    $(document).on('change', '#zona', function (e) {
        zona = $(this).find("option:selected").attr('value');
        var encripturl = '<?php echo base_url(); ?>asset_management/listasset/getBranch/' + zona;
        $.ajax({
            url: encripturl,
            type: 'POST',
            dataType: 'html',
            success: function (jawaban) {
                $('#cabang').html(jawaban);
                $('#unit').html("<option value='0'>--Select--</option>");

            },
        });
    });

    $(document).on('change', '#cabang', function (e) {
        cabang = $(this).find("option:selected").attr('value');
        var kode = $(this).find("option:selected").attr('kode');
        if (kode.trim() == '00000') {
            $('#displaydivisi').show();
            $('#displayUnit').hide();
            $.ajax({
                url: '<?php echo base_url(); ?>asset_management/listasset/getdivisi/' + cabang,
                type: 'POST',
                dataType: 'html',
                success: function (jawaban) {
                    $('#divisi').html(jawaban);

                },
            });

        } else {
            $('#displaydivisi').hide();
            $('#displayUnit').show();
            $.ajax({
                url: '<?php echo base_url(); ?>asset_management/listasset/getunit/' + cabang,
                type: 'POST',
                dataType: 'html',
                success: function (jawaban) {
                    $('#unit').html(jawaban);

                },
            });
        }
    });
</script>