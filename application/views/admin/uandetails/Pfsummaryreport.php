<!-- /.navbar -->

  <?php



use PHPUnit\TextUI\XmlConfiguration\CodeCoverage\Report\Php;

 $this->load->view('admin/header'); ?>

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="<?php echo base_url()?>public/admin/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?php echo base_url()?>public/admin/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url()?>public/admin/dist/js/adminlte.min.js"></script>


<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">

<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>


<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
<!--
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
-->
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
   <!-- Select2 -->
   <link rel="stylesheet" href="<?php echo base_url()?>public/admin/plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="<?php echo base_url()?>public/admin/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
  <script src="<?php echo base_url()?>public/admin/plugins/select2/js/select2.full.min.js"></script>



<style>
/* Prevent pointer events on the search input row to avoid sorting trigger */
table.display thead tr.search-row th {
    pointer-events: none;
}
table.display thead tr.search-row th input {
    pointer-events: auto;
}

.nav-tabs .nav-link {
            font-size: 24px; /* Increase font size */
            padding: 10px 15px; /* Adjust padding */
        }

        .nav-tabs .nav-link.active {
            font-weight: bold; /* Make active tab bold */
            background-color: #f8f9fa; /* Change background color of active tab */
            border-color: #dee2e6 #dee2e6 #f8f9fa; /* Adjust border color */
        }

        .nav-tabs .nav-link:hover {
            background-color: #e9ecef; /* Change background color on hover */
        }

        .tab-content {
            font-size: 16px; /* Increase font size for tab content */
        }

    #pfsummaryTable {
        border-collapse: collapse;
        width: 100%;
    }

    #pfsummaryTable th,
    #pfsummaryTable td {
        border: 1px solid #ddd;
/*    padding: 8px; */
        white-space: nowrap;
    }

    #pfsummaryTable th {
        background-color: #f2f2f2;
    }

    #pfsummaryTable tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    #pfsummaryTable tr:hover {
        background-color: #ddd;
    }


    .selected {
        background-color: yellow;
    }
    #pfsummaryTable td.column-align-center {
        text-align: center;
    }

    #pfsummaryTable td.column-align-right {
        text-align: right;
    }

    .select2-selection__rendered {
    line-height: 50px !important;

}
.select2-container .select2-selection--single {
    height: 50px !important;
    font-size: 20px;
    font-style: bold;
    color: #FFFFFF;
}
.select2-selection__arrow {
    height: 50px !important;
}

.no-wrap {
    white-space: nowrap;
}


.dataTables_scroll
{
    overflow:auto;
}

table.dataTable {
            width: 100% !important;
        }

</style>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12">
          <h3 class="m-1 text-dark text-center" style="background-color: #1589FF;"><strong>PF Summary Report</strong></h3>

          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
      <div class="card-body">
      <form name="summaryForm" id="summaryForm" method=""
            action=""  >

      <div class="form-row">
						<div class="form-group col-md-2" >
						  <label for="fromdate">Date From<span class="text-center">*</span></label>
						  <input type="text" style="height: 50px; color:blue; font-style: bold; font-size: 28px;"
                            class="form-control datepicker text-center" id="fromdate"
                            name="fromdate"    >
						</div>
						<div class="form-group col-md-2" >
						  <label for="todate">Date To<span class="text-center">*</span></label>
						  <input type="text" style="height: 50px; color:blue; font-style: bold; font-size: 28px;"
                            class="form-control datepicker text-center" id="todate"
                            name="todate"    >
						</div>
                        <div class="form-group col-md-2" style="margin-left: 30px;">
						    <label for="showdata">Show Data<span class="text-center"></span></label>
                            <button name="submit" id="showdata" style="height: 50px;" type="submit" class="form-control btn btn-primary">Show</button>
                        </div>
                        <div class="form-group col-md-2" style="margin-left: 30px;">
						    <label for="exceldata">Excel Data<span class="text-center"></span></label>
                            <button name="submit" id="exceldata" style="height: 50px;" type="submit" class="form-control btn btn-primary">Excel</button>
                        </div>

                    </div>

                    <div class="form-row">



              <br></br>



                </div>




 <?php
                  $company_id = $this->session->userdata('company_id');
                //  echo $company_id;
              ?>

<input type="hidden" class="input" value="<?php echo $company_id; ?>" id="companyId" />






            </form>


 <div class="container-fluid">
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="table1" role="tabpanel" aria-labelledby="table1-tab">
            <h2 class="mt-3">PF Summary Data</h2>
            <table id="pfsummaryTable" class="display">
        <thead>
            <tr>
                <th colspan="1" style="text-align: center; border: 1px solid #C0C0C0;">Month</th>
<th colspan="5"
    style="text-align:center;
           border:1px solid #C9C4C3;
           background-color:#E8F0FE;">
    PF Deducted
</th>
                <th colspan="5" style="text-align: center; border: 1px solid #C0C0C0;">PF Uploaded</th>
                <th colspan="5" style="text-align: center; border: 1px solid #C0C0C0;">PF Payment</th>
                <th colspan="5" style="text-align: center; border: 1px solid #C0C0C0;">PF Outstanding As per Deduction</th>
                <th colspan="5" style="text-align: center; border: 1px solid #C0C0C0;">PF Outstanding As per Upload</th>
                <th colspan="5" style="text-align: center; border: 1px solid #C0C0C0;">Upload Pending </th>
            </tr>
            <tr class="search-row">
                <th>Month End Date</th>
                <th>EPF Cont G</th>
                <th>EPS Cont G</th>
                <th>EPF EPS Diff G</th>
                <th>Adm Chgs G</th>
                <th>Total G</th>
                <th>EPF Cont D</th>
                <th>EPS Cont D</th>
                <th>EPF EPS Diff D</th>
                <th>Adm Chgs D</th>
                <th>Total D</th>
                <th>EPF Cont P</th>
                <th>EPS Cont P</th>
                <th>EPF EPS Diff P</th>
                <th>Adm Chgs P</th>
                <th>Total P</th>
                <th>EPF Cont OD</th>
                <th>EPS Cont OD</th>
                <th>EPF EPS Diff OD</th>
                <th>Adm Chgs OD</th>
                <th>Total OD</th>
                <th>EPF Cont OU</th>
                <th>EPS Cont OU</th>
                <th>EPF EPS Diff OU</th>
                <th>Adm Chgs OU</th>
                <th>Total OU</th>
                <th>EPF Cont PU</th>
                <th>EPS Cont PU</th>
                <th>EPF EPS Diff PU</th>
                <th>Adm Chgs PU</th>
                <th>Total PU</th>
            </tr>
            <tr>
                <th><input type="text" placeholder="Search Month End Date" style="width:100%" /></th>
                <th><input type="text" placeholder="Search EPF Cont G" style="width:100%" /></th>
                <th><input type="text" placeholder="Search EPS Cont G" style="width:100%" /></th>
                <th><input type="text" placeholder="Search EPF EPS Diff G" style="width:100%" /></th>
                <th><input type="text" placeholder="Search Adm Chgs G" style="width:100%" /></th>
                <th><input type="text" placeholder="Search Total G" style="width:100%" /></th>
                <th><input type="text" placeholder="Search EPF Cont D" style="width:100%" /></th>
                <th><input type="text" placeholder="Search EPS Cont D" style="width:100%" /></th>
                <th><input type="text" placeholder="Search EPF EPS Diff D" style="width:100%" /></th>
                <th><input type="text" placeholder="Search Adm Chgs D" style="width:100%" /></th>
                <th><input type="text" placeholder="Search Total D" style="width:100%" /></th>
                <th><input type="text" placeholder="Search EPF Cont P" style="width:100%" /></th>
                <th><input type="text" placeholder="Search EPS Cont P" style="width:100%" /></th>
                <th><input type="text" placeholder="Search EPF EPS Diff P" style="width:100%" /></th>
                <th><input type="text" placeholder="Search Adm Chgs P" style="width:100%" /></th>
                <th><input type="text" placeholder="Search Total P" style="width:100%" /></th>
                <th><input type="text" placeholder="Search EPF Cont OD" style="width:100%" /></th>
                <th><input type="text" placeholder="Search EPS Cont OD" style="width:100%" /></th>
                <th><input type="text" placeholder="Search EPF EPS Diff OD" style="width:100%" /></th>
                <th><input type="text" placeholder="Search Adm Chgs OD" style="width:100%" /></th>
                <th><input type="text" placeholder="Search Total OD" style="width:100%" /></th>
                <th><input type="text" placeholder="Search EPF Cont OU" style="width:100%" /></th>
                <th><input type="text" placeholder="Search EPS Cont OU" style="width:100%" /></th>
                <th><input type="text" placeholder="Search EPF EPS Diff OU" style="width:100%" /></th>
                <th><input type="text" placeholder="Search Adm Chgs OU" style="width:100%" /></th>
                <th><input type="text" placeholder="Search Total OU" style="width:100%" /></th>
                <th><input type="text" placeholder="Search EPF Cont PU" style="width:100%" /></th>
                <th><input type="text" placeholder="Search EPS Cont PU" style="width:100%" /></th>
                <th><input type="text" placeholder="Search EPF EPS Diff PU" style="width:100%" /></th>
                <th><input type="text" placeholder="Search Adm Chgs PU" style="width:100%" /></th>
                <th><input type="text" placeholder="Search Total PU" style="width:100%" /></th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
        </div>
    </div>
 </div>





      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <?php $this->load->view('admin/footer'); ?>

<script>
$(document).ready(function() {
    $('.datepicker').datepicker({
        dateFormat: 'dd-mm-yyyy',
        changeMonth: true,
        changeYear: true
    });

    // Set default dates: from date = current date - 3 months, to date = current date
    var today = new Date();
    var fromDate = new Date(today.getFullYear(), today.getMonth() - 3, today.getDate());
    
    var fromStr = ('0' + fromDate.getDate()).slice(-2) + '-' + ('0' + (fromDate.getMonth() + 1)).slice(-2) + '-' + fromDate.getFullYear();
    var toStr = ('0' + today.getDate()).slice(-2) + '-' + ('0' + (today.getMonth() + 1)).slice(-2) + '-' + today.getFullYear();
    
    $('#fromdate').val(fromStr);
    $('#todate').val(toStr);
        // Add a placeholder for details table
        if ($('#pfsummaryDetailsTable').length === 0) {
            $('#pfsummaryTable').after('<div id="pfsummaryDetailsContainer" style="margin-top:30px;"></div>');
        }

    var table = $('#pfsummaryTable').DataTable({
        "scrollX": true,
        "scrollY": "400px",
        "scrollCollapse": true,
        "paging": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": false,
        "columnDefs": [
            { "width": "100px", "targets": 0 }, // Month End Date
            { "width": "100px", "targets": [1,6,11] }, // EPF Cont G, D, P
            { "width": "100px", "targets": [2,7,12] }, // EPS Cont G, D, P
            { "width": "120px", "targets": [3,8,13] }, // EPF EPS Diff G, D, P
            { "width": "100px", "targets": [4,9,14] }, // Adm Chgs G, D, P
            { "width": "120px", "targets": [5,10,15] }, // Total G, D, P
            { "width": "100px", "targets": [16,21,26] }, // EPF Cont OD, OU, PU
            { "width": "100px", "targets": [17,22,27] }, // EPS Cont OD, OU, PU
            { "width": "120px", "targets": [18,23,28] }, // EPF EPS Diff OD, OU, PU
            { "width": "100px", "targets": [19,24,29] }, // Adm Chgs OD, OU, PU
            { "width": "120px", "targets": [20,25,30] }, // Total OD, OU, PU
            { "className": "column-align-right", "targets": [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30] },
            { "className": "column-align-center", "targets": [0] }
        ],
        "initComplete": function() {
            this.api().columns().every(function() {
                var column = this;
                $('input', this.header()).on('keyup change', function() {
                    if (column.search() !== this.value) {
                        column.search(this.value).draw();
                    }
                });
                $('input', this.header()).on('click', function(e) {
                    e.stopPropagation();
                });
            });
        }
    });

        // Helper: get column index by header text
        function getColIndicesBySuffix(suffix) {
            var indices = [];
            $('#pfsummaryTable thead tr:eq(1) th').each(function(i) {
                if ($(this).text().trim().endsWith(suffix)) indices.push(i);
            });
            return indices;
        }

        var dCols = getColIndicesBySuffix('D');
        var pCols = getColIndicesBySuffix('P');

        // Delegate click for _D and _P columns
        $('#pfsummaryTable tbody').on('click', 'td', function() {
            var colIdx = table.cell(this).index().column;
            var rowIdx = table.cell(this).index().row;
            var rowData = table.row(rowIdx).data();
            var monthEndDate = rowData[0];
            var colType = null;
            if (dCols.includes(colIdx)) colType = 'D';
            if (pCols.includes(colIdx)) colType = 'P';
            if (!colType) return;

            // Show loading
            $('#pfsummaryDetailsContainer').html('<div class="text-center">Loading details...</div>');

            // AJAX to fetch details
            $.ajax({
                url: '<?php echo base_url(); ?>admin/uandetails/Pfuploadfileshow/getPfSummaryDetails',
                type: 'POST',
                data: {
                    month_end_date: monthEndDate,
                    type: colType
                },
                dataType: 'json',
                success: function(response) {
                    if (response.success && response.data && response.data.length > 0) {
                        var html = '<h4>Details for ' + monthEndDate + ' (' + (colType === 'D' ? 'Deducted' : 'Paid') + ')</h4>';
                        html += '<table id="pfsummaryDetailsTable" class="display" style="width:100%;border:1px solid #888;margin-bottom:30px;"><thead><tr>';
                        // Table headers
                        for (var key in response.data[0]) {
                            html += '<th>' + key + '</th>';
                        }
                        html += '</tr></thead><tbody>';
                        // Table rows
                        response.data.forEach(function(row) {
                            html += '<tr>';
                            for (var key in row) {
                                html += '<td>' + row[key] + '</td>';
                            }
                            html += '</tr>';
                        });
                        html += '</tbody></table>';
                        $('#pfsummaryDetailsContainer').html(html);
                    } else {
                        $('#pfsummaryDetailsContainer').html('<div class="text-center">No details found for this period.</div>');
                    }
                },
                error: function(xhr, status, error) {
                    $('#pfsummaryDetailsContainer').html('<div class="text-danger">Error loading details.</div>');
                }
            });
        });

    // Add spinner HTML if not present
    if ($('#pfsummarySpinner').length === 0) {
        $('body').append('<div id="pfsummarySpinner" style="display:none;position:fixed;top:0;left:0;width:100vw;height:100vh;z-index:9999;background:rgba(255,255,255,0.5);text-align:center;"><div style="position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);"><div class="spinner-border text-primary" style="width:4rem;height:4rem;" role="status"><span class="sr-only">Loading...</span></div></div></div>');
    }

    $('#showdata').on('click', function(e) {
        e.preventDefault();
        var fromdate = $('#fromdate').val();
        var todate = $('#todate').val();
        var companyId = $('#companyId').val();

        if (!fromdate || !todate) {
            alert('Please select both From Date and To Date');
            return;
        }

        $('#pfsummarySpinner').show();
        $.ajax({
            url: '<?php echo base_url(); ?>admin/uandetails/Pfuploadfileshow/getSummaryData',
            type: 'POST',
            data: {
                fromdate: fromdate,
                todate: todate,
                companyId: companyId
            },
            dataType: 'json',
            success: function(response) {
                table.clear().draw();
                if (response.data && response.data.length > 0) {
                    table.rows.add(response.data).draw();
                }
                $('#pfsummarySpinner').hide();
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
                alert('Error loading data');
                $('#pfsummarySpinner').hide();
            }
        });
    });

    $('#exceldata').on('click', function(e) {
        e.preventDefault();
        var fromdate = $('#fromdate').val();
        var todate = $('#todate').val();
        var companyId = $('#companyId').val();

        if (!fromdate || !todate) {
            alert('Please select both From Date and To Date');
            return;
        }

        window.location.href = '<?php echo base_url(); ?>admin/uandetails/Pfuploadfileshow/exportSummaryExcel?fromdate=' + fromdate + '&todate=' + todate + '&companyId=' + companyId;
    });
});
</script>

</body>
</html>