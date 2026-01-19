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

    #pfgendetailsrecordTable {
        border-collapse: collapse;
        width: 100%;
    }

    #pfgendetailsrecordTable th,
    #pfgendetailsrecordTable td {
        border: 1px solid #ddd;
    /*    padding: 8px; */
    }

    #pfgendetailsrecordTable th {
        background-color: #f2f2f2;
    }

    #pfgendetailsrecordTable tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    #pfgendetailsrecordTable tr:hover {
        background-color: #ddd;
    }
 

    .selected {
        background-color: yellow;
    }
    #pfgendetailsrecordTable td.column-align-center {
        text-align: center;
    }

    #pfgendetailsrecordTable td.column-align-right {
        text-align: right;
    }
    
    #pfgenhdrrecordTable  {
        border-collapse: collapse;
        width: 100%;
    }




#pfgenhdrrecordTable {
        border-collapse: collapse;
        width: 100%;
    }

    #pfgenhdrrecordTable th,
    #pfgenhdrrecordTable td {
        border: 1px solid #ddd;
    /*    padding: 8px; */
    }

    #pfgenhdrrecordTable th {
        background-color: #f2f2f2;
    }

    #pfgenhdrrecordTable tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    #pfgenhdrrecordTable tr:hover {
        background-color: #ddd;
    }
 

    .selected {
        background-color: yellow;
    }
    #pfgenhdrrecordTable td.column-align-center {
        text-align: center;
    }

    #pfgenhdrrecordTable td.column-align-right {
        text-align: right;
    }
    
    #pfgenhdrrecordTable  {
        border-collapse: collapse;
        width: 100%;
    }

 
    #pfupddetailsreecordTable {
        border-collapse: collapse;
        width: 100%;
    }

    #pfupddetailsreecordTable th,
    #pfupddetailsreecordTable td {
        border: 1px solid #ddd;
    /*    padding: 8px; */
    }

    #pfupddetailsreecordTable th {
        background-color: #f2f2f2;
    }

    #pfupddetailsreecordTable tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    #pfupddetailsreecordTable tr:hover {
        background-color: #ddd;
    }
 

    .selected {
        background-color: yellow;
    }
    #pfupddetailsreecordTable td.column-align-center {
        text-align: center;
    }

    #pfupddetailsreecordTable td.column-align-right {
        text-align: right;
    }
    






#spgdailyrecordTable {
        border-collapse: collapse;
        width: 100%;
    }

    #spgdailyrecordTable th,
    #spgdailyrecordTable td {
        border: 1px solid #ddd;
    /*    padding: 8px; */
    }

    #spgdailyrecordTable th {
        background-color: #f2f2f2;
    }

    #spgdailyrecordTable tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    #spgdailyrecordTable tr:hover {
        background-color: #ddd;
    }
 

    .selected {
        background-color: yellow;
    }
    #spgdailyrecordTable td.column-align-center {
        text-align: center;
    }

    #spgdailyrecordTable td.column-align-right {
        text-align: right;
    }
 
    #spgdailyrecordTable {
        border-collapse: collapse;
        width: 100%;
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
          <h3 class="m-1 text-dark text-center" style="background-color: #1589FF;"><strong>PF Upload file TAB SHOW DATA</strong></h3>

          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
      <div class="card-body">
      <form name="categoryForm" id="categoryForm" method="" 
            action=""  >

      <div class="form-row">
						<div class="form-group col-md-2" >
						  <label for="purchaseDetailsPurchaseDate">Date From<span class="text-center">*</span></label>
						  <input type="text" style="height: 50px; color:blue; font-style: bold; font-size: 28px;"
                            class="form-control datepicker text-center" id="upfromdate" 
                            name="upfromdate"    >
						</div>
						<div class="form-group col-md-2" >
						  <label for="purchaseDetailsPurchaseDate">Date To<span class="text-center">*</span></label>
						  <input type="text" style="height: 50px; color:blue; font-style: bold; font-size: 28px;"
                            class="form-control datepicker text-center" id="uptodate" 
                            name="uptodate"    >
						</div>
                        <div class="form-group col-md-2" style="margin-left: 30px;">
						    <label for="purchaseDetailsPurchaseDate">Show Upload File<span class="text-center"></span></label>
                            <button name="submit" id="showpfupdata" style="height: 50px;" type="submit" class="form-control btn btn-primary">Show</button>
                        </div>
                        <div class="form-group col-md-2" style="margin-left: 30px;">
						    <label for="purchaseDetailsPurchaseDate">Excel Upload File<span class="text-center"></span></label>
                            <button name="submit" id="exlpfupdata" style="height: 50px;" type="submit" class="form-control btn btn-primary">Excel</button>
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
              <input type="hidden" class="input" id="mc1_id" />
              <input type="hidden" class="input" id="record_id" />
              <input type="hidden" class="input" id="mc3_id" />
              <input type="hidden" class="input" id="trollyid" />
              <input type="hidden" id="current_record_id" />
              <input type="hidden" id="current_gen_record_id" />
 
              

            

 

            </form>

            
<!--             <h1>PF UPload Data Details</h1>
    <table id="spgdailyrecordTable" class="display">
        <thead>
            <tr>
                <th>Record Id</th>
                <th>TRRN No </th>
                <th>Tran Type</th>
                <th>Challan Date</th>
                <th>Ac 1 Amount</th>
                <th>Ac 2 Amount</th>
                <th>Ac 10 Amount</th>
                <th>Ac 21 Amount</th>
                <th>Ac 22 Amount</th>
                <th>Total Amount</th>
                <th>Status</th>
                <th>Payment Date</th>
                <th>statusid</th>
                <th>stattypid</th>
                
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
           
 -->       

 <div class="container-fluid">
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="table1-tab" data-toggle="tab" href="#table1" role="tab" aria-controls="table1" aria-selected="true">PF Upload Header</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="table2-tab" data-toggle="tab" href="#table2" role="tab" aria-controls="table2" aria-selected="false">PF Upload Details</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="table3-tab" data-toggle="tab" href="#table3" role="tab" aria-controls="table3" aria-selected="false">PF Genation HDR Data</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="table4-tab" data-toggle="tab" href="#table4" role="tab" aria-controls="table4" aria-selected="false">PF Genation Details Data</a>
        </li>
    </ul>
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="table1" role="tabpanel" aria-labelledby="table1-tab">
            <h2 class="mt-3">PF Upload Header</h2>
            <table id="spgdailyrecordTable" class="display">
        <thead>
            <tr>
                <th>Record Id</th>
                <th>Month End Date</th>
                <th>TRRN No </th>
                <th>Tran Type</th>
                <th>Challan Date</th>
                <th>Ac 1 Amount</th>
                <th>Ac 2 Amount</th>
                <th>Ac 10 Amount</th>
                <th>Ac 21 Amount</th>
                <th>Ac 22 Amount</th>
                <th>Total Amount</th>
                <th>Status</th>
                <th>Payment Date</th>
                <th>statusid</th>
                <th>stattypid</th>
                <th>Batch No</th>
                <th>No of Person</th>
                
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
        </div>
        <div class="tab-pane fade" id="table2" role="tabpanel" aria-labelledby="table2-tab">
            <h2 class="mt-3">PF Upload Details</h2>
            <table id="pfupddetailsreecordTable" class="display">
        <thead>
            <tr>
            <th>Record Id</th>
                <th>Month End Date</th>
                <th>TRRN No</th>
                <th>UAN No</th>
                <th>Name</th>
                <th>Gross Wages</th>
                <th>EPF Wages</th>
                <th>EPS Wages</th>
                <th>EDLI Wages</th>
                <th>EPF Cont</th>
                <th>EPS Cont</th>
                <th>EPF EPS Diff</th>>
                <th>NCP Days</th>>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
        </div>
        <div class="tab-pane fade" id="table3" role="tabpanel" aria-labelledby="table3-tab">
            <h2 class="mt-3">PF Upload Details</h2>
            <table id="pfgenhdrrecordTable" class="display">
        <thead>
            <tr>
            <th>Record Id</th>
                <th>Month End Date</th>
                <th>Gross Wages</th>
                <th>EPF Wages</th>
                <th>EPS Wages</th>
                <th>EDLI Wages</th>
                <th>EPF Cont</th>
                <th>EPS Cont</th>
                <th>EPF EPS Diff</th>
                <th>No of Persons</th>
                
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
        </div>
        <div class="tab-pane fade" id="table4" role="tabpanel" aria-labelledby="table4-tab">
            <h2 class="mt-3">PF Genation Data</h2>
            <table id="pfgendetailsrecordTable" class="display">
        <thead>
            <tr>
            <th>Record Id</th>
                <th>Month End Date</th>
                <th>UAN No</th>
                <th>Name</th>
                <th>Gross Wages</th>
                <th>EPF Wages</th>
                <th>EPS Wages</th>
                <th>EDLI Wages</th>
                <th>EPF Cont</th>
                <th>EPS Cont</th>
                <th>EPF EPS Diff</th>
                <th>NCP Days</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
        </div>

    </div>
</div>

          
            </div><!-- /.card -->
          <!-- /.col-md-6 -->
          <div class="col-lg-6">
            <div class="card">
            </div>

          </div>
          <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->



  
  <?php $this->load->view('admin/footer'); ?>



<script>
$(function () {
  
     //Initialize Select2 Elements
    
    $('.select2').select2();

//Initialize Select2 Elements
$('.select2bs4').select2({
  theme: 'bootstrap4'
})



  $( ".selector" ).datepicker( "setDate", new Date());

  
 
})
//$(".datepicker").datepicker({maxDate: '0'});

$("#genpfdata").attr('disabled',true);
$("#cancelpfdata").attr('disabled',true);
$("#genpfdata").show();
$("#cancelpfdata").hide();

var date = new Date();
            date.setDate(date.getDate() - 90);
            
            // Format the date to YYYY-MM-DD
            var date = new Date();
            date.setDate(date.getDate() - 90);
            
            // Format the date to dd-mm-yy
            var day = ("0" + date.getDate()).slice(-2);
            var month = ("0" + (date.getMonth() + 1)).slice(-2);
            var formattedDate = day + "-" + month + "-" + date.getFullYear();

$("#upfromdate").datepicker({ 
  dateFormat: 'dd-mm-yy',
					todayHighlight:'TRUE',
					autoclose: true,
                    maxDate: '0',
                });
                $("#uptodate").datepicker({ 
                  dateFormat: 'dd-mm-yy',
					todayHighlight:'TRUE',
					autoclose: true,
                });
                $("#chaldate").datepicker({ 
  dateFormat: 'dd-mm-yy',
					todayHighlight:'TRUE',
					autoclose: true,
                    maxDate: '0',
                });
                $("#paydate").datepicker({ 
                  dateFormat: 'dd-mm-yy',
					todayHighlight:'TRUE',
					autoclose: true,
                });

                $('#upfromdate').datepicker('setDate', formattedDate);
                $('#uptodate').datepicker('setDate', 'today');

 
 
 
</script>

<script>
        $(document).ready(function() {
            $('input[type="text"]').on('focus', function() {
                $(this).select();
            });
        });

  
  

  //    initDataTable();
      function initDataTable() {
             var spgdailyDate= $('#spgdailyDate').val();
             var companyId=$('#companyId').val();
//             alert(spgdailyDate);
//jQuery('.dataTable').wrap('<div class="dataTables_scroll" />');
            table = $('#spgdailyrecordTable').DataTable({
                ajax: {
                    url: '<?php echo base_url('admin/uandetails/Pfdatageneration/get_pfgendata'); ?>',
                    type: 'POST',
                    data: function(d) {
                        d.pfgendate = $('#spgdailyDate').val();
                        d.companyId=$('#companyId').val();
                    }
                  },
                  columnDefs: [
                    { targets: [0], visible: false }, // Hide the first column (auto_id)
                    { targets: [0], visible: false }, { targets: [0], visible: false },{
                    targets: [5, 6],
                    render: function(data, type, row, meta) {
                        return '<div class="column-align-right">' + data + '</div>';
                    }
                  }
                ],
                drawCallback: function() {
                // Apply alignment styles to the table cells
                $('#recordTable td.column-align-center').css('text-align', 'center');
                $('#recordTable td.column-align-right').css('text-align', 'right');
            },
            order: [[7, 'asc']],                 // Sort by the first column (auto_id) in descending order
                pageLength: 10 // Set the default number of rows per page to 25
              });
        }
 


        function refreshDataTable() {
              table.ajax.reload(null, false); // Reload the data without resetting the current page
        }


        $('#spgdailyrecordTable1 tbody').on('click', 'tr', function() {
                var rowData = table.row(this).data();
                $('#record_id').val(rowData[0]);
                $('#trrnno').val(rowData[1]);
                $("#trantype").val(rowData[13]).trigger("change");

                $('#spgspeed').val(rowData[3]);
                $('#spgtpi').val(rowData[4]);
                $('#spgfrmtype').val(rowData[25]);
                $('#spgspindle').val(rowData[26]);                
                $('#spgjborbo').val(rowData[24]);                
                $('#spgactcount').val(rowData[5]);                
                $('#spgdailyahrs').val(rowData[11]);                
                $('#spgdailybhrs').val(rowData[12]);                
                $('#spgdailychrs').val(rowData[13]);                
                $('#spgnowinder').val(rowData[6]);                
                $('#spgnofrma').val(rowData[7]);                
                $('#spgnofrmb').val(rowData[8]);                
                $('#spgnofrmc').val(rowData[9]);                
                $('#spgnofrmtot').val(rowData[10]);                
                $('#spgproda').val(rowData[15]);                
                $('#spgprodb').val(rowData[16]);                
                $('#spgprodc').val(rowData[17]);                
                $('#spgprodtot').val(rowData[18]);                
                $('#spgstdcount').val(rowData[27]);                
                       });
        
            $('#recordTable tbody').on('click', 'tr', function() {
                if ($(this).hasClass('selected')) {
                    $(this).removeClass('selected');
                } else {
                    table.$('tr.selected').removeClass('selected');
                    $(this).addClass('selected');
                }
            });



            $('#spgdailyDate1').on('change', function() {
               


                refreshDataTable();
            });


            $('#spgdailyDate').on('change', function() {
             var spgdailyDate= $('#spgdailyDate').val();
             var companyId=$('#companyId').val();
          $.ajax({
            url: "<?php echo base_url('admin/uandetails/Pfdatageneration/get_pfdataexists'); ?>",
            type: "POST",
            data: {companyId: companyId,pfgendate: spgdailyDate },
            dataType: "json",
            success: function(response) {
              if (response.success) {
           //     alert(response.savedata);
             //   alert(response.noofrows>0);
                if (response.noofrows>0) {
             //       alert('1');
                    $("#genpfdata").attr('disabled',true);
                    $("#cancelpfdata").attr('disabled',false);
                    $("#genpfdata").hide();
                    $("#cancelpfdata").show();
                } else 
                {        
               //     alert('2');
                    $("#genpfdata").attr('disabled',false);
                    $("#cancelpfdata").attr('disabled',true);
                    $("#genpfdata").show();
                    $("#cancelpfdata").hide();
                    
                }
        
              }
              refreshDataTable();
        
            }  
            });
 
              });


   


$("#exlpfupdata").click(function(event){
    event.preventDefault();

    var activeTab = $('.tab-pane.show.active').attr('id');
    var upfromdate = $('#upfromdate').val();
    var uptodate = $('#uptodate').val();
    var companyId = $('#companyId').val();
    var url;

    if (activeTab === 'table1') {
        url = '<?php echo base_url('admin/uandetails/Pfuploadfileshow/export_excel_hdr'); ?>' +
              '?upfromdate=' + upfromdate +
              '&uptodate=' + uptodate +
              '&companyId=' + companyId;
    } else if (activeTab === 'table2') {
        var recordId = $('#current_record_id').val();
        url = '<?php echo base_url('admin/uandetails/Pfuploadfileshow/export_excel_details'); ?>' +
              '?upfromdate=' + upfromdate +
              '&uptodate=' + uptodate +
              '&companyId=' + companyId +
              '&recordId=' + recordId;
    } else if (activeTab === 'table3') {
        url = '<?php echo base_url('admin/uandetails/Pfuploadfileshow/export_excel_genhdr'); ?>' +
              '?upfromdate=' + upfromdate +
              '&uptodate=' + uptodate +
              '&companyId=' + companyId;
    } else if (activeTab === 'table4') {
        var recordId = $('#current_gen_record_id').val();
        url = '<?php echo base_url('admin/uandetails/Pfuploadfileshow/export_excel_gendetails'); ?>' +
              '?upfromdate=' + upfromdate +
              '&uptodate=' + uptodate +
              '&companyId=' + companyId +
              '&recordId=' + recordId;
    }

    window.open(url, '_blank');

    return false;
});

$("#showpfupdata").click(function(event){
    event.preventDefault(); 
//    alert('ananan');
    initDatedata();     
    initDatedata2();     
              
});

     
 
              initDatedata();     
              initDatedata2();     
               
        function initDatedata() {
            $('#spgdailyrecordTable').DataTable().destroy();
            $('#pfgenhdrrecordTable').DataTable().destroy();
             var companyId=$('#companyId').val();
             var upfromdate= $('#upfromdate').val();
             var uptodate= $('#uptodate').val();
//            alert('iiii');
             table1 = $('#spgdailyrecordTable').DataTable({
                ajax: {
                    url: "<?php echo base_url('admin/uandetails/Pfuploadfileshow/Pfupddatalast'); ?>",
                    type: 'POST',
                    data: function(d) {
                        d.companyId=$('#companyId').val();
                        d.upfromdate=upfromdate;
                        d.uptodate=uptodate;
                    }
                  },
                  columnDefs: [
                    { targets: [0], visible: false }, // Hide the first column (auto_id)
                    { targets: [13], visible: false }, { targets: [14], visible: false },{
                    targets: [5, 6],
                    render: function(data, type, row, meta) {
                        return '<div class="column-align-right">' + data + '</div>';
                    }
                  }
                ],
                drawCallback: function() {
                // Apply alignment styles to the table cells
                $('#spgdailyrecordTable td.column-align-center').css('text-align', 'center');
                $('#spgdailyrecordTable td.column-align-right').css('text-align', 'right');
            },
            order: [[2, 'desc']],                 // Sort by the first column (auto_id) in descending order
                pageLength: 10 // Set the default number of rows per page to 25
              });

            }
            function initDatedata2() {
                $('#pfgenhdrrecordTable').DataTable().destroy();
             var companyId=$('#companyId').val();
             var upfromdate= $('#upfromdate').val();
             var uptodate= $('#uptodate').val();
   
              table3 = $('#pfgenhdrrecordTable').DataTable({
                ajax: {
                    url: "<?php echo base_url('admin/uandetails/Pfuploadfileshow/Pfgendatalast'); ?>",
                    type: 'POST',
                    data: function(d) {
                        d.companyId=$('#companyId').val();
                        d.upfromdate=upfromdate;
                        d.uptodate=uptodate;
                    }
                  },
                  columnDefs: [
                    { targets: [0], visible: false }, // Hide the first column (auto_id)
                    { targets: [0], visible: false }, { targets: [0], visible: false },{
                    targets: [5, 6],
                    render: function(data, type, row, meta) {
                        return '<div class="column-align-right">' + data + '</div>';
                    }
                  }
                ],
                drawCallback: function() {
                // Apply alignment styles to the table cells
                $('#pfgenhdrrecordTable td.column-align-center').css('text-align', 'center');
                $('#pfgenhdrrecordTable td.column-align-right').css('text-align', 'right');
            },
            order: [[2, 'desc']],                 // Sort by the first column (auto_id) in descending order
                pageLength: 10 // Set the default number of rows per page to 25
              });

       



            }

            function initDatedata1a(recordId) {
                $('#pfupddetailsrecordTable').DataTable().destroy();
             var companyId=$('#companyId').val();
             var upfromdate= $('#upfromdate').val();
             var uptodate= $('#uptodate').val();
             var recordId=recordId;
   alert(recordId);
              table2 = $('#pfupddetailsrecordTable').DataTable({
                ajax: {
                    url: "<?php echo base_url('admin/uandetails/Pfuploadfileshow/Pfupddetailsdata'); ?>",
                    type: 'POST',
                    data: function(d) {
                        d.companyId=$('#companyId').val();
                        d.upfromdate=upfromdate;
                        d.uptodate=uptodate;
                        d.recordId = recordId;
                    }
                    
                  },
                  columnDefs: [
                    { targets: [0], visible: false }, // Hide the first column (auto_id)
                    { targets: [0], visible: false }, { targets: [0], visible: false },{
                    targets: [5, 6],
                    render: function(data, type, row, meta) {
                        return '<div class="column-align-right">' + data + '</div>';
                    }
                  }
                ],
                drawCallback: function() {
                // Apply alignment styles to the table cells
                $('#pfupddetailsrecordTable td.column-align-center').css('text-align', 'center');
                $('#pfupddetailsrecordTable td.column-align-right').css('text-align', 'right');
            },
            order: [[2, 'desc']],                 // Sort by the first column (auto_id) in descending order
                pageLength: 10 // Set the default number of rows per page to 25
              });

       



            }





            function initDatedata11a(recordId ) {
             //   $('#pfgenhdrrecordTable').DataTable().destroy();
                $('#pfupddetailsrecordTable').DataTable().destroy();
             var companyId=$('#companyId').val();
             var upfromdate= $('#upfromdate').val();
             var uptodate= $('#uptodate').val();
             var recordId=recordId;
alert('table2'); 
alert(recordId);               
            var table2 = $('#pfupddetailsrecordTable').DataTable({
                      ajax: {
                    url: "<?php echo base_url('admin/andetails/Pfuploadfileshow/Pfupddetailsdata'); ?>",
                    type: 'POST',
                    data: function(d) {
                        d.companyId=$('#companyId').val();
                        d.upfromdate=upfromdate;
                        d.uptodate=uptodate;
                        d.recordId = recordId;
                    }
                  },
                  columnDefs: [
                    { targets: [0], visible: false }, // Hide the first column (auto_id)
                    { targets: [0], visible: false }, { targets: [0], visible: false },{
                    targets: [5, 6],
                    render: function(data, type, row, meta) {
                        return '<div class="column-align-right">' + data + '</div>';
                    }
                  }
                ],
                drawCallback: function() {
                // Apply alignment styles to the table cells
                $('#pfgenhdrrecordTable td.column-align-center').css('text-align', 'center');
                $('#pfgenhdrrecordTable td.column-align-right').css('text-align', 'right');
            },
            order: [[2, 'desc']],                 // Sort by the first column (auto_id) in descending order
                pageLength: 10 // Set the default number of rows per page to 25
              });

       



            }
 




            $('#spgdailyrecordTable tbody').on('dblclick', 'tr', function() {
          //  var data = table1.row(this).data();
            var rowData = table1.row(this).data();
          //    alert('clicked');
                  // Assuming you want to pass the Record Id to the second table's AJAX request
            var recordId = rowData[0];

//        alert(recordId);
            $('#current_record_id').val(recordId);
            reloadSecondTable(recordId );
            // Switch to the second tab
            $('#table2-tab').tab('show');
        });
    
        $('#pfgenhdrrecordTable tbody').on('dblclick', 'tr', function() {
          //  var data = table1.row(this).data();
            var rowData = table3.row(this).data();
           //   alert('clicked');
                  // Assuming you want to pass the Record Id to the second table's AJAX request
            var recordId = rowData[1];

//        alert(recordId);
            $('#current_gen_record_id').val(recordId);
            reloadSecondTableg(recordId );
            // Switch to the second tab
            $('#table4-tab').tab('show');
        });

        

        function reloadSecondTable(recordId) {
            $('#pfupddetailsreecordTable').DataTable().destroy();
            console.log('Reloading second table with record ID:', recordId);

//            $('#pfgenhdrrecordTable').DataTable({
                var table2 = $('#pfupddetailsreecordTable').DataTable({
                ajax: {
                    url: "<?php echo base_url('admin/uandetails/Pfuploadfileshow/Pfupddetailsdata'); ?>",
                    type: 'POST',
                    data: function(d) {
                  
                        d.recordId = recordId;
                    },
                    complete: function(xhr, status) {
                        console.log('AJAX request status:', status);
                        console.log('AJAX response:', xhr.responseText);
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX error:', status, error);
                    }
                },
                columnDefs: [
                    { targets: [0], visible: false },
                    {
                        targets: [5, 6],
                        render: function(data, type, row, meta) {
                            return '<div class="column-align-right">' + data + '</div>';
                        }
                    }
                ],
                drawCallback: function() {
                    $('#pfupddetailsrecordTable td.column-align-center').css('text-align', 'center');
                    $('#pfupddetailsrecordTable td.column-align-right').css('text-align', 'right');
                },
                order: [[2, 'desc']],
                pageLength: 10
            });
        }

        // Adjust DataTable columns when the tab becomes visible
        $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
            $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
        });

        function reloadSecondTableg(recordId) {
            $('#pfgendetailsrecordTable').DataTable().destroy();
            console.log('Reloading second table with record ID:', recordId);

//            $('#pfgenhdrrecordTable').DataTable({
                var table4 = $('#pfgendetailsrecordTable').DataTable({
                ajax: {
                    url: "<?php echo base_url('admin/uandetails/Pfuploadfileshow/Pfgendetailsdata'); ?>",
                    type: 'POST',
                    data: function(d) {
                  
                        d.recordId = recordId;
                    },
                    complete: function(xhr, status) {
                        console.log('AJAX request status:', status);
                        console.log('AJAX response:', xhr.responseText);
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX error:', status, error);
                    }
                },
                columnDefs: [
                    { targets: [0], visible: false },
                    {
                        targets: [5, 6],
                        render: function(data, type, row, meta) {
                            return '<div class="column-align-right">' + data + '</div>';
                        }
                    }
                ],
                drawCallback: function() {
                    $('#pfgendetailsrecordTable td.column-align-center').css('text-align', 'center');
                    $('#pfgendetailsrecordTable td.column-align-right').css('text-align', 'right');
                },
                order: [[2, 'desc']],
                pageLength: 10
            });
        }

 
       


</script>



</body>
</html>
