<script>
    var dataTable, iid;
    var i1 = "";
    var i2 = "";
    var i3 = "";
    var i4 = "";
    var i5 = "";
    var i6 = "";
    var i7 = "";
    var i8 = "";
    var i9 = "";
    var i10 = "";
    var i11 = "";
    jQuery(document).ready(function () {
        ComponentsDateTimePickers.init();
        loadGridVendor();

    });
    // jQuery(document).ready(function () {
    //     TableManaged.init();
    // });
    btnStart();

    $("#fm_param").submit(function (e) {
        e.preventDefault();
        $('#divGrid').show();
        $('#table_gridMutation').DataTable().ajax.reload();
        $('#id_downlod').fadeIn('slow');
        $('#id_downlod').attr('href', "<?php echo base_url() . 'reports/vendorreport/downloadReport?' ?>" + $('form#fm_param').serialize());
    });

    function sch(e) {
        console.log(e.value);
        if (e.name == "ias") {
            i1 = e.value;
        }
        if (e.name == "deskripsi") {
            i2 = e.value;
        }
        if (e.name == "vendor") {
            i3 = e.value;
        }
        if (e.name == "kwi") {
            i4 = e.value;
        }
        if (e.name == "Fpur") {
            i5 = e.value;
        }
        if (e.name == "Nomor") {
            i6 = e.value;
        }
        if (e.name == "nominal") {
            i7 = e.value;
        }
        if (e.name == "tgl_upload_doc") {
            i8 = e.value;
        }
        if (e.name == "tgl_dibayar") {
            i9 = e.value;
        }
        if (e.name == "status_doc") {
            i10 = e.value;
        }
        if (e.name == "status_pembayaran") {
            i11 = e.value;
        }
        $('#table_gridMutation').DataTable().ajax.reload();
    }

    function loadGridVendor() {
        var table2 = $('#table_gridMutation');
        table2.dataTable({
            "ajax": {
                "url": "<?php echo base_url("/reports/vendorreport/ajax_GridMutation_"); ?>",
                "type": "POST",
                "data": function (z) {
                    z.from = $('#from').val();
                    z.to = $('#to').val();
                    z.branch = $('#id_branch').val();
                    z.vendor = $('#id_vendor').val();
                    z.status = $('#status').val();
                    z.s1 = i1;
                    z.s2 = i2;
                    z.s3 = i3;
                    z.s4 = i4;
                    z.s5 = i5;
                    z.s6 = i6;
                    z.s7 = i7;
                    z.s8 = i8;
                    z.s9 = i9;
                    z.s10 = i10;
                    z.s11 = i11;
                }
            },
            "columns": [
                {"data": "no"},
                {"data": "ias"},
                {"data": "deskripsi"},
                {"data": "vendor"},
                {"data": "kwi"},
                {"data": "Fpur"},
                {"data": "Nomor"},
                {"data": "nominal"},
                {"data": "tgl_upload_doc"},
                {"data": "tgl_dibayar"},
                {"data": "status_doc"},
                {"data": "status_pembayaran"},
            ],
            // Internationalisation. For more info refer to http://datatables.net/manual/i18n
            "language": {
                "aria": {
                    "sortAscending": ": activate to sort column ascending",
                    "sortDescending": ": activate to sort column descending"
                },
                "emptyTable": "No data available in table",
                "info": "Showing _START_ to _END_ of _TOTAL_ entries",
                "infoEmpty": "No entries found",
                "infoFiltered": "(filtered1 from _MAX_ total entries)",
                "lengthMenu": "Show _MENU_ entries",
                "search": "Search:",
                "zeroRecords": "No matching records found"
            },
            "bStateSave": true, // save datatable state(pagination, sort, etc) in cookie.
            "lengthMenu": [
                [5, 10, 15, 20, -1],
                [5, 10, 15, 20, "All"] // change per page values here
            ],
            // set the initial value
            "pageLength": 5,
            "pagingType": "bootstrap_full_number",
            "language": {
                "search": "Cari: ",
                "lengthMenu": "  _MENU_ records",
                "paginate": {
                    "previous": "Prev",
                    "next": "Next",
                    "last": "Last",
                    "first": "First"
                }
            },
            "aaSorting": [[0, 'asc']/*, [5,'desc']*/],
            "columnDefs": [{// set default column settings
                    'orderable': true,
                    "searchable": true,
                    'targets': [0]
                }],
            "order": [
                [0, "asc"]
            ] // set first column as a default sort by asc
        });
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
                url: "<?php echo base_url("/reports/vendorreport/ajax_GridMutation"); ?>", // json datasource
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
                {"targets": [12], "checkboxes": {"selectRow": true}},
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
            "select": {"style": "multi"},
        });
    }

    var iCb = 1;
    $('#table_gridMutation').on('click', 'input[type="checkbox"]', function (e) {
        if (iCb == 1) {
            iddisposal_ = dataTable.columns(12).data().eq(0).sort().unique().join(',');
            iCb = 0;
        } else {
            iCb = 1;
        }
        $("#idPDF").attr("href", "<?php echo base_url(); ?>reports/vendorreport/downloadPDF?iddisposal=" + iddisposal_);
        $("#idWord").attr("href", "<?php echo base_url(); ?>reports/vendorreport/formdisposal?iddisposal=" + iddisposal_);
    });

    document.querySelector("tbody").addEventListener("change", function (e) {
        if (e.target.tagName === 'INPUT')
            var rows_selected = dataTable.column(12).checkboxes.selected();
        if (iddisposal_ == "") {
            iddisposal_ = iddisposal_ + rows_selected.join(",");
        } else {
            iddisposal_ = rows_selected.join(",");
        }
        $("#idPDF").attr("href", "<?php echo base_url(); ?>reports/vendorreport/downloadPDF?iddisposal=" + iddisposal_);
        $("#idWord").attr("href", "<?php echo base_url(); ?>reports/vendorreport/formdisposal?iddisposal=" + iddisposal_);
    });
    function detilasset(e) {
        $(".modal-title").html('Depreciation');
        $("#submitmutasi").hide();
        var id = e.id;
        var encripturl = '<?php echo base_url(); ?>reports/vendorreport/detilasset/' + id;
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
        var encripturl = '<?php echo base_url(); ?>reports/vendorreport/mutationasset/' + e.id + '/' + e.name;
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
        var encripturl = '<?php echo base_url(); ?>reports/vendorreport/disposal/' + id + '/' + faid;
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

    $("form#mutations").submit(function (e) {
        e.preventDefault();
        if ($("#cabang").val() != "" && $("#unit").val() != 0 && $("#unit").val() != "" || $("#divisi").val() != "") {
            $.ajax({
                url: '<?php echo base_url(); ?>reports/vendorreport/mutasi/' + iid,
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
        var encripturl = '<?php echo base_url(); ?>reports/vendorreport/getBranch/' + zona;
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
                url: '<?php echo base_url(); ?>reports/vendorreport/getdivisi/' + cabang,
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
                url: '<?php echo base_url(); ?>reports/vendorreport/getunit/' + cabang,
                type: 'POST',
                dataType: 'html',
                success: function (jawaban) {
                    $('#unit').html(jawaban);

                },
            });
        }
    });

    function uploaddisposal() {
        $("#submitmutasi").hide();
        $("#updis").show();
        $(".modal-title").html('Upload Disposal');
        var ihtml = '';
        ihtml += '<div id="modal-add" class="modal-add">';
        ihtml += '<div class="panel panel-inverse">';
//        ihtml += '<hr class="dotted">';
        ihtml += '<div class="validator-form form-horizontal">';
        ihtml += '<div class="form-group">';
        ihtml += '<label class="control-label col-sm-3">Upload File (.docx/.doc)</label>';
        ihtml += '<div class="col-sm-7">';
        ihtml += '<input type="file" class="form-control" name="namafile" id="namafile" required>       ';
        ihtml += '</div>';
        ihtml += '</div>';
        ihtml += '</div>';
        ihtml += '</div>';
        ihtml += '</div>';
        $('#bodyDetail').html(ihtml);
    }
//
//    $("#updis").click(function () {
//        alert("ya");
//    });

    $("form#mutations").on('click', '#updis', function (e) {


        var file_data = $('#namafile').prop('files')[0];
        var form_data = new FormData();
        form_data.append('namafile', file_data);
        $.ajax({
            url: '<?php echo base_url(); ?>reports/vendorreport/add_disposal',
            type: 'POST',
            data: form_data,
            cache: false,
            contentType: false,
            processData: false,
            success: function (a) {
                $('#table_gridMutation').DataTable().ajax.reload();
            },
            beforeSend: function (data) {
                $("#updis").attr('disabled', 'disabled').html('Loading...');
            },
            complete: function () {
                $("#updis").removeAttr('disabled').html('Save');
            }
        });
    });
</script>