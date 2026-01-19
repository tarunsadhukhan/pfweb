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

.duplicate-row {
    background-color: #ffcccc; /* Change to the desired color */
}

/* Spinner Overlay Styles */
#spinnerOverlay {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    z-index: 9999;
    justify-content: center;
    align-items: center;
}

.spinner-container {
    text-align: center;
    background-color: #fff;
    padding: 30px 50px;
    border-radius: 10px;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.3);
}

.spinner {
    border: 5px solid #f3f3f3;
    border-top: 5px solid #3498db;
    border-radius: 50%;
    width: 50px;
    height: 50px;
    animation: spin 1s linear infinite;
    margin: 0 auto 15px auto;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

.spinner-text {
    font-size: 16px;
    color: #333;
    font-weight: bold;
}

.spinner-time {
    font-size: 20px;
    color: #3498db;
    font-weight: bold;
    margin-top: 10px;
}

</style>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">

    <!-- Spinner Overlay -->
    <div id="spinnerOverlay">
        <div class="spinner-container">
            <div class="spinner"></div>
            <div class="spinner-text">Processing... Please wait</div>
            <div class="spinner-time" id="elapsedTime">00:00</div>
        </div>
    </div>

    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12">
          <h3 class="m-1 text-dark text-center" style="background-color: #1589FF;"><strong>PF Upload file Generation</strong></h3>

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
						  <label for="purchaseDetailsPurchaseDate">Date<span class="text-center">*</span></label>
						  <input type="text" style="height: 50px; color:blue; font-style: bold; font-size: 28px;"
                            class="form-control datepicker text-center" id="upfromdate" 
                            name="upfromdate"    >
						</div>
						<div class="form-group col-md-2" >
						  <label for="purchaseDetailsPurchaseDate">Date<span class="text-center">*</span></label>
						  <input type="text" style="height: 50px; color:blue; font-style: bold; font-size: 28px;"
                            class="form-control datepicker text-center" id="uptodate" 
                            name="uptodate"    >
						</div>
                        <div class="form-group col-md-2" style="margin-left: 1px;">
                        <label for="purchaseDetailsVendorName">All/Selective Uan<span class="requiredIcon text-center">*</span></label>
                        <select id="upallsel" style="height: 50px; color:blue; font-style: bold; font-size: 28px;"
                        name="upallsel" class="form-control chosenSelect text-center">
                        <option value="1">All</option>
                        <option value="0">Selective</option>
                        </select>
                    </div>
                    <div class="form-group col-md-2" style="margin-left: 1px;">
                        <label for="purchaseDetailsVendorName">Upload Type<span class="requiredIcon text-center">*</span></label>
                        <select id="upshare" style="height: 50px; color:blue; font-style: bold; font-size: 28px;"
                        name="upshare" class="form-control chosenSelect text-center">
                        <option value="1">EE & ER Both Share</option>
                        <option value="2">EE Share</option>
                        <option value="3">ER Share</option>
                        </select>
                    </div>

                        <div class="form-group col-md-1" style="margin-left: 30px;">
						    <label for="purchaseDetailsPurchaseDate">Gen Upd File<span class="text-center"></span></label>
                            <button name="submit" id="genpfupdata" style="height: 50px;" type="submit" class="form-control btn btn-primary">Gen File</button>
                        </div>
                        <div class="form-group col-md-1" style="margin-left: 30px;">
						    <label for="purchaseDetailsPurchaseDate">All Data File<span class="text-center"></span></label>
                            <button name="submit" id="createpfupdata" style="height: 50px;" type="submit" class="form-control btn btn-primary">Gen File</button>
                        </div>
                </div>
  
                <div id="uanentry" class="form-row" data-show="false" style="display: none;">

        <div class="form-group col-md-2">
            <label for="uanno">Uan No <span class="text-center">*</span></label>
            <input type="text" name="uanno" id="uanno" value=""
                   style="height: 50px; color:blue; font-style: bold; font-size: 28px;"
                   class="form-control" maxlength="12">
        </div>
        <div class="form-group col-md-2">
            <label for="uanname">Name <span class="text-center">*</span></label>
            <input type="text" name="uanname" id="uanname" value=""
                   style="height: 50px; color:blue; font-style: bold; font-size: 20px;"
                   class="form-control">
        </div>
        <div class="form-group col-md-1" style="margin-left: 30px;">
						    <label for="purchaseDetailsPurchaseDate">Add UAN<span class="text-center"></span></label>
                            <button name="submit" id="addunano" style="height: 50px;" type="submit" class="form-control btn btn-primary">Add UAN </button>
                        </div>
        
      </div>

     
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

            </form>
       
            <h1>Month PF Generated Data</h1>
    <table id="spgdailyrecordTable" class="display">
        <thead>
            <tr>
                <th>Record Id</th>
                <th>Uan No </th>
                <th>Name As per PF</th>
             </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
           
       


          
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

                $('#upfromdate').datepicker('setDate', 'today');
                $('#uptodate').datepicker('setDate', 'today');

// Spinner Timer Variables and Functions
var spinnerTimerInterval = null;
var spinnerStartTime = null;

function startSpinnerTimer() {
    spinnerStartTime = new Date();
    $('#elapsedTime').text('00:00');
    spinnerTimerInterval = setInterval(function() {
        var now = new Date();
        var elapsed = Math.floor((now - spinnerStartTime) / 1000);
        var minutes = Math.floor(elapsed / 60);
        var seconds = elapsed % 60;
        var display = (minutes < 10 ? '0' : '') + minutes + ':' + (seconds < 10 ? '0' : '') + seconds;
        $('#elapsedTime').text(display);
    }, 1000);
}

function stopSpinnerTimer() {
    if (spinnerTimerInterval) {
        clearInterval(spinnerTimerInterval);
        spinnerTimerInterval = null;
    }
}

 
 
 
</script>

<script>
        $(document).ready(function() {
            $('input[type="text"]').on('focus', function() {
                $(this).select();
            });
        });

//start save

        $("#genpfupdata").click(function(event){
          var table = $('#spgdailyrecordTable').DataTable();
          event.preventDefault(); 
          var companyId=$('#companyId').val();
          var upfromdate= $('#upfromdate').val();
          var uptodate= $('#uptodate').val();
          var upshare= $('#upshare').val();
          var upallsel= $('#upallsel').val();
          var tableData = table.rows().data().toArray();
        // Format data as JSON
        alert(upshare);
        var jsonData = JSON.stringify(tableData);

          $("#genpfupdata").attr('disabled',true);
          $("#spinnerOverlay").css('display', 'flex');
          startSpinnerTimer();
          $.ajax({
           url: "<?php echo base_url('admin/uandetails/Pfuploadfilegen/gen_monthpfupdata'); ?>",
            type: "POST",
                data: {upfromdate: upfromdate,uptodate: uptodate,companyId: companyId,
                 upshare:upshare ,upallsel: upallsel,
                  tableData: jsonData // Add the gathered table data here
            },
            dataType: "json",
            success: function(response) {
              var savedata=(response.savedata);
                if (response.success) {
                    alert(response.savedata);
                    var bno="Upload Batch No= "+response.batchno+" Require to Create PF Upload Files";
                    alert(bno);
                   // refreshDataTable();
                    $("#genpfdata").attr('disabled',true);
                    $("#cancelpfdata").attr('disabled',false);
                    $("#genpfdata").hide();
                    $("#cancelpfdata").show();
                  }
                  $("#genpfupdata").attr('disabled',false);
                  $("#spinnerOverlay").hide();
                  stopSpinnerTimer();
                  if (!response.success) {
                      alert(response.savedata); 
                  }
                },
                error: function() {
                    $("#genpfupdata").attr('disabled',false);
                    $("#spinnerOverlay").hide();
                    stopSpinnerTimer();
                    alert('An error occurred. Please try again.');
                }
        });
 
      });


        $("#createpfupdata").click(function(event){
          var table = $('#spgdailyrecordTable').DataTable();
                    event.preventDefault(); 
          var companyId=$('#companyId').val();
          var upfromdate= $('#upfromdate').val();
          var uptodate= $('#uptodate').val();
          var upshare= $('#upshare').val();
          var upallsel= $('#upallsel').val();
          var tableData = table.rows().data().toArray();
          if (upfromdate<='2025-08-31')
          {
              alert('All file Cannot Create for Old version');
              $('#upfromdate').focus();
              return false;
          }
//        alert(upshare);
        var jsonData = JSON.stringify(tableData);
          $("#createpfupdata").attr('disabled',true);
          $("#spinnerOverlay").css('display', 'flex');
          startSpinnerTimer();
          $.ajax({
           url: "<?php echo base_url('admin/uandetails/Pfuploadfilegen/gen_createpfupdata'); ?>",
            type: "POST",
                data: {upfromdate: upfromdate,uptodate: uptodate,companyId: companyId,
                 upshare:upshare ,upallsel: upallsel,
                  tableData: jsonData // Add the gathered table data here
            },
            dataType: "json",
            success: function(response) {
              var savedata=(response.savedata);
                if (response.success) {
                    alert(response.savedata);
                    var bno="Upload Batch No= "+response.batchno+" Require to Create PF Upload Files";
                    alert(bno);
                 //   refreshDataTable();
                    $("#genpfdata").attr('disabled',true);
                    $("#cancelpfdata").attr('disabled',false);
                    $("#genpfdata").hide();
                    $("#cancelpfdata").show();
                }
                $("#createpfupdata").attr('disabled',false);
                $("#spinnerOverlay").hide();
                stopSpinnerTimer();
                if (!response.success) {
                    alert(response.savedata);     
                }
            },
            error: function() {
                $("#createpfupdata").attr('disabled',false);
                $("#spinnerOverlay").hide();
                stopSpinnerTimer();
                alert('An error occurred. Please try again.');
            }
        });
 
      });





      $("#cancelpfdata").click(function(event){
          event.preventDefault(); 
          var companyId=$('#companyId').val();
          var spgdailyDate= $('#spgdailyDate').val();
          $("#cancelpfdata").attr('disabled',true);
          $.ajax({
           url: "<?php echo base_url('admin/uandetails/Pfdatageneration/cancel_monthpfdata'); ?>",
            type: "POST",
                data: {pfgendate: spgdailyDate,companyId: companyId
            },
            dataType: "json",
            success: function(response) {
              var savedata=(response.savedata);
                if (response.success) {
                    alert('Record Canceled Successfully');
             //     refreshDataTable();
                    $("#genpfdata").attr('disabled',false);
                    $("#cancelpfdata").attr('disabled',true);
                    $("#genpfdata").show();
                    $("#cancelpfdata").hide();
                    
                  }
            }
        });
 
      });


      var table = $('#spgdailyrecordTable').DataTable();
      $('#addunano').on('click', function(event) {
    event.preventDefault(); 
    var uanno = $('#uanno').val();
    var companyId = $('#companyId').val();
    var uanname = $('#uanname').val();
    var record_id = $('#record_id').val();

    // Check for duplicates
    var columnIdx = 1; // Assuming the uanno is in the second column (index 1)
    var data = table.column(columnIdx).data().toArray();
    if (data.includes(uanno)) {
        alert('Duplicate entry found for UAN No: ' + uanno);
    } else {
        table.row.add([
            record_id,
            uanno,
            uanname
        ]).draw(false);
        console.log(uanno);
        $('#uanno').val('');
        $('#uanname').val('');
        $('#record_id').val(0);
    }
    $('#uanno').val('');
        $('#uanname').val('');
        $('#record_id').val(0);

  });

function highlightDuplicates() {

    var columnIdx =0 /* specify the column index to check for duplicates */;
    var data = table.column(columnIdx, { search: 'applied' }).data().toArray();
    var duplicates = data.reduce(function(acc, value, index) {
        if (data.indexOf(value) !== index) {
            if (!acc[value]) {
                acc[value] = [];
            }
            acc[value].push(index);
        }
        return acc;
    }, {});

    Object.keys(duplicates).forEach(function(key) {
        duplicates[key].forEach(function(idx) {
            $(table.row(idx).node()).addClass('duplicate-row');
        });
    });
}






//      initDataTable();
      function initDataTable() {
             var spgdailyDate= $('#spgdailyDate').val();
             var companyId=$('#companyId').val();
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
                scrollX: true,  // Enable horizontal scrolling
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


        $('#spgdailyrecordTable tbody').on('click', 'tr', function() {
                var rowData = table.row(this).data();
alert('ppp');
                $('#spgquality_id').val(rowData[1]);
                $('#spgquality').val(rowData[2]);
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

         //   $('#upallsel').trigger('change');


            $('#upallsel').on('change', function() {
              upallsel= $('#upallsel').val();
                  var selectedValue = upallsel;
alert(upallsel);
                  var $formRow = $('#uanentry');
                if (selectedValue == 0) {
//                    alert('show');
                    $formRow.attr('data-show', 'true').show();
                } else if (selectedValue == 1) {
  //                alert('hide');
                    $formRow.attr('data-show', 'false').hide();
                }
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


   


$("#genpfexldata").click(function(event){
  event.preventDefault(); 

//	alert ("aaaa");
	var opt=3;
            var doffrepdate= $('#spgdailyDate').val();
            var companyId=$('#companyId').val();
            var url = '<?php echo site_url("admin/uandetails/Pfdatageneration/gen_excelpfdata"); ?>' +
                      '?doffrepdate=' + doffrepdate +
                       '&companyId=' + companyId  
                         ;
                      alert(url);
			//$(location).attr('href',url);
			window.open( url, '_blank');
			
			
return false;
});

$('#uanno').on('blur', function() {
          var uanno =  $('#uanno').val();
          var companyId=$('#companyId').val();
        $.ajax({
            url: "<?php echo base_url('admin/uandetails/pfuploadfilegen/getuanname'); ?>",
            type: "POST",
            data: {uanno: uanno,companyId: companyId },
            dataType: "json",
            success: function(response) {
              if (response.success) {
                    $('#uanname').val(response.name);
                    $('#record_id').val(response.uanid);
                    $('#uanname').css({'border-color': 'green','background-color': 'white'
              });
           
                  }  
            }
        });
 
      });

 

     
   
       


</script>



</body>
</html>
