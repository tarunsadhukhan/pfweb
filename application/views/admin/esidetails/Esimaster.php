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



#qcrecordTable {
        border-collapse: collapse;
        width: 100%;
    }

    #qcrecordTable th,
    #qcrecordTable td {
        border: 1px solid #ddd;
        padding: 8px;
    }

    #qcrecordTable th {
        background-color: #f2f2f2;
    }

    #qcrecordTable tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    #qcrecordTable tr:hover {
        background-color: #ddd;
    }

    .selected {
        background-color: yellow;
    }
    #qcrecordTable td.column-align-center {
        text-align: center;
    }

    #qcrecordTable td.column-align-right {
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
.selected-row {
    background-color: blanchedalmond; /* Change to the desired color */
}

    </style>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12">
          <h3 class="m-1 text-dark text-center" style="background-color: #1589FF;"><strong>ESI Master Module</strong></h3>

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
  <div class="form-group col-md-2">
    <label for="purchaseDetailsPurchaseDate">EB No / ESI No <span class="text-center">*</span></label>
    <input type="text" name="ebno" id="ebno" value=""
      style="height: 50px; color:blue; font-style: bold; font-size: 28px;"
      class="form-control">
    <input type="text" name="esino" id="esino" value=""
      style="height: 50px; color:blue; font-style: bold; font-size: 28px;"
      class="form-control">

    </div>
      <div class="form-group col-md-2">
    <label for="purchaseDetailsPurchaseDate">Name <span class="text-center">*</span></label>
    <input type="text" name="ebname" id="ebname" value=""
      style="height: 50px; color:blue; font-style: bold; font-size: 28px;"
      class="form-control" maxlength="12">
  </div>
  <div class="form-group col-md-1" style="margin-left: 1px;">
    <label for="purchaseDetailsVendorName">Date of Join<span class="requiredIcon text-center">*</span></label>
    <input type="text" style="height: 50px; color:blue; font-style: bold; font-size: 20px;"
      class="form-control datepicker text-center" id="dojdate"
      name="dojdate" >
  </div>
  <div class="form-group col-md-1" style="margin-left: 1px;">
    <label for="purchaseDetailsVendorName">Adhar Seeded<span class="requiredIcon text-center">*</span></label>
    <select id="adharseeded" style="height: 50px; color:blue; font-style: bold; font-size: 28px;"
      name="adharseeded" class="form-control chosenSelect text-center">
      <option value="1">Yes</option>
      <option value="0">No</option>
    </select>
  </div>
  <div class="form-group col-md-1" style="margin-left: 1px;">
    <label for="purchaseDetailsVendorName">Active<span class="requiredIcon text-center">*</span></label>
    <select id="uanactive" style="height: 50px; color:blue; font-style: bold; font-size: 28px;"
      name="uanactive" class="form-control chosenSelect text-center">
      <option value="1">Yes</option>
      <option value="0">No</option>
    </select>
  </div>
  <div class="form-group col-md-1" style="margin-left: 1px;">
    <label for="purchaseDetailsVendorName">Date of Inactive<span class="requiredIcon text-center">*</span></label>
    <input type="text" style="height: 50px; color:blue; font-style: bold; font-size: 20px;"
      class="form-control datepicker text-center" id="inactdate"
      name="inactdate" readonly>
  </div>
 
  <div class="form-group col-md-1" style="margin-left: 1px;">
    <label for="purchaseDetailsVendorName">Reason Code <span class="requiredIcon text-center">*</span></label>
    <select id="reasoncode" style="height: 50px; color:blue; font-style: bold; font-size: 28px;"
      name="reasoncode" class="form-control chosenSelect text-center">

      <option value="99">Select</option>
      <option value="3">Retired</option>
      <option value="2">Left Service</option>
      <option value="5">Expired</option>
      <option value="10">Retrenchment</option>
      
      
    </select>
  </div>
  <div class="form-group col-md-1">
    <label for="purchaseDetailsPurchaseDate">Save Data<span class="text-center"></span></label>
    <button name="submit" id="saveuan" style="height: 50px;" type="submit"
      class="form-control btn btn-primary">Save</button>
    <button name="submit" id="edituan" style="height: 50px;" type="submit"
      class="form-control btn btn-primary">Update</button>
  </div>
  <div class="form-group col-md-1">
    <label for="purchaseDetailsPurchaseDate">Reset Data<span class="text-center"></span></label>
    <button name="submit" id="resetuan" style="height: 50px;" type="submit"
      class="form-control btn btn-primary">Reset</button>
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
       
            <h1>UAN Members List</h1>
    <table id="qcrecordTable">
        <thead>
            <tr>
                <th>Record ID</th>
                <th>EB No</th>
                <th>ESI No</th>
                <th>Emp Name</th>
                <th>Date of Join </th>
                <th>Adhar Seeded</th>
                <th>Active</th>
                <th>Date of Inactive</th>
                <th>Exit Reason</th>
                <th>extcode </th>
                <th>adh seed</th>
                <th>inact</th>



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

$("#inactdate").datepicker({ 
  dateFormat: 'dd-mm-yy',
					todayHighlight:'TRUE',
					autoclose: true,
                    maxDate: '0',
                });
                $("#dojdate").datepicker({ 
  dateFormat: 'dd-mm-yy',
					todayHighlight:'TRUE',
					autoclose: true,
                    maxDate: '0',
                });
                $("#payrollenddate").datepicker({ 
                  dateFormat: 'dd-mm-yy',
					todayHighlight:'TRUE',
					autoclose: true,
                });

                $('#incactdate').datepicker('setDate', 'today');
                $('#dojdate').datepicker('setDate', 'today');


$("#saveuan").attr('disabled',true);
$("#edituan").attr('disabled',true);
$("#deleuan").attr('disabled',true);
$("#edituan").hide();
$("#saveuan").show();


 
</script>

<script>
        $(document).ready(function() {
            $('input[type="text"]').on('focus', function() {
                $(this).select();
            });
       
 
        });

//start save
        $("#saveuan").click(function(event){
          event.preventDefault(); 
          var companyId=$('#companyId').val();
          var dojdate= $('#dojdate').val();
          var reasoncode= $('#reasoncode').val();
          var incactdate= $('#inactdate').val();
          var esino= $('#esino').val();
          var ebname= $('#ebname').val();
          var adharseeded= $('#adharseeded').val();
          var uanactive= $('#uanactive').val();
          var record_id= $('#record_id').val();
  
          var record_id=0;
          $.ajax({
            url: "<?php echo base_url('admin/esidetails/Esimaster/saveesi_data'); ?>",
            type: "POST",
            data: {companyId: companyId,dojdate: dojdate,reasoncode: reasoncode,incactdate: incactdate,esino: esino,
                ebname: ebname,adharseeded:adharseeded,uanactive: uanactive, record_id:record_id              

            },
            dataType: "json",
            success: function(response) {
              var savedata=(response.savedata);
                
                if (response.success) {
                  alert('Record Added Successfully');
                  $("#uan_no").val();
                $("#uanname").val();
                $("#ebname").val();
                $("#ebno").val();
                $("#pfno").val();
                
                  $("#edituan").hide();
                  $("#saveuan").show();
                  $("#saveuan").attr('disabled',true);
                      $("#edituan").attr('disabled',true);
                      $("#resetuan").click();
                      refreshDataTable();
                } else {
                  alert('Record Already Exists');
               
                  }
            }
        });
 
      });

      initDataTable();
      function initDataTable() {
        var companyId=$('#companyId').val();
   //     alert(companyId);
            table = $('#qcrecordTable').DataTable({
                ajax: {
                    url: '<?php echo base_url('admin/esidetails/Esimaster/get_esidetails'); ?>',
                    type: 'POST',
                    data: function(d) {
                        d.companyId=companyId;
                    }
                  },columnDefs: [
                    { targets: [0], visible: false }, // Hide the first column (auto_id)
                    { targets: [9,11], visible: false }, { targets: [10], visible: false },{
                    targets: [5, 6],
                    render: function(data, type, row, meta) {
                        return '<div class="column-align-right">' + data + '</div>';
                    }
                  }
                ],
                scrollX: true,  // Enable horizontal scrolling
            autoWidth: false,  // Disable automatic column width calculation           
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


        $('#qcrecordTable tbody').on('click', 'tr', function() {
                var rowData = table.row(this).data();
                $('#record_id').val(rowData[0]);
                $("#adharseeded").val(rowData[10]).trigger("change");
                $("#uanactive").val(rowData[11]).trigger("change");
                $('#ebno').val(rowData[1]);
                $('#ebname').val(rowData[3]);
                $('#esino').val(rowData[2]);
                $('#dojdate').val(rowData[4]);
                $('#pfno').val(rowData[5]);
                $('#inactdate').val(rowData[7]);
                var rc=rowData[0];
                if (rc>0) {
                    $("#saveuan").attr('disabled',true);
                      $("#edituan").attr('disabled',false);
                      $("#edituan").show();
                      $("#saveuan").hide();
                    }  
//                    $(this).toggleClass('selected');
 //       var colIndex = /* specify the column index to toggle */;
  //      var cell = table.cell(this, colIndex);
   //     var cellData = cell.data();
    //    cell.data(cellData === 'yes' ? 'no' : 'yes').draw(false);       
                
            });
        
            $('#recordTable tbody').on('click', 'tr', function() {
                if ($(this).hasClass('selected')) {
                    $(this).removeClass('selected');
                } else {
                    table.$('tr.selected').removeClass('selected');
                    $(this).addClass('selected');
                }
            });


            $('#windingqcDate, #qcshiftName').on('change', function() {
                $('#record_id').val(0);
                $("#mc_no1").val(0).trigger("change");
                $("#quality_id").val(0).trigger("change");
                $('#nospool').val(0);
              
                refreshDataTable();
            });

            $("#resetuan").click(function(event){
              event.preventDefault(); 
              $('#uanno').val('');
              $('#ebno').val('');
              $('#uanname').val('');
              $('#ebname').val('');
              $('#pfno').val('');
        });


            $("#getwndqc").click(function(event){
          event.preventDefault(); 
          var windingqcDate = $('#windingqcDate').val();
             var companyId=$('#companyId').val();
             var qcshiftName= $('#qcshiftName').val(); 
             alert (windingqcDate);
          $.ajax({
            url: "<?php echo base_url('admin/Winding_quality_entry/getwndqcode_data'); ?>",
            type: "POST",
            data: {windingqcDate: windingqcDate,qcshiftName: qcshiftName,companyId: companyId
            },
            dataType: "json",
            success: function(response) {
              var savedata=(response.savedata);
                $('#tnetWt').val('');
                $('#netWt').val('');
                $('#frameNo').val('');
                $('#trollyNo').val('');
                $('#doffNo').val('');
                $('#tareWt').val('');
                $('#grossWt').val('');
                
               
                if (response.success) {
                    alert(savedata);    
              }
            }
        });
        refreshDataTable();
      });



      $('#uanno').on('blur', function() {
          var uanno =  $('#uanno').val();
          var companyId=$('#companyId').val();
          var ebno =  $('#ebno').val();
        $.ajax({
            url: "<?php echo base_url('admin/uandetails/Uanmaster/getuanname'); ?>",
            type: "POST",
            data: {uanno: uanno,companyId: companyId,ebno: ebno },
            dataType: "json",
            success: function(response) {
              if (response.success) {
                    $('#uanname').val(response.name);
                    $('#record_id').val(response.uanid);
                    $('#uanname').css({'border-color': 'green','background-color': 'white'
                    });
                    var dben=response.debno;
                    $ln=debn.length; 
                    if ($ln>0) {
                      alert ('UAN No mapped with another EB No'+debn);
                      $("#saveuan").attr('disabled',true);
                      $("#edituan").attr('disabled',true);
                      
                    }

                  } else {
                    var dben=response.debno;
                    $ln=debn.length; 
                    if ($ln>0) {
                      alert ('UAN No mapped with another EB No'+debn);
                      $("#saveuan").attr('disabled',true);
                      $("#edituan").attr('disabled',true);
                      
                    }
           
                }
            }
        });
 
      });

      $('#ebno').on('blur', function() {
          var ebno =  $('#ebno').val();
          var companyId=$('#companyId').val();
          $.ajax({
            url: "<?php echo base_url('admin/uandetails/Uanmaster/getebname'); ?>",
            type: "POST",
            data: {ebno: ebno,companyId: companyId },
            dataType: "json",
            success: function(response) {
              if (response.success) {
                  $('#uanno').val(response.uanno);
                    $('#uanname').val(response.name);
                    $('#ebname').val(response.name);
                    $('#esino').val(response.esino);
             //       $('#record_id').val(response.uanid);
                    $('#uanname').css({'border-color': 'green','background-color': 'white'
                    });
                    ebn=ebno;
                    $lnn=ebn.length;
                    if (response.esino==0) { 
                      if ($lnn>0) {
                      $("#saveuan").attr('disabled',false);
                      $("#edituan").attr('disabled',true);
                      $("#edituan").hide();
                      $("#saveuan").show();
                      }
                    } else {
                      alert ('Record Already Exists');
                      $("#saveuan").attr('disabled',false);
                      $("#edituan").attr('disabled',true);
                      $("#edituan").hide();
                      $("#saveuan").show();

                    }   
                } else {
                  alert('No Employee Master Data found') ;
                }
            }
        });
 
      });


      $("#edituan").click(function(event){
        event.preventDefault(); 
          var companyId=$('#companyId').val();
          var dojdate= $('#dojdate').val();
          var reasoncode= $('#reasoncode').val();
          var incactdate= $('#inactdate').val();
          var esino= $('#esino').val();
          var ebname= $('#ebname').val();
          var adharseeded= $('#adharseeded').val();
          var uanactive= $('#uanactive').val();
          var record_id= $('#record_id').val();

            $.ajax({
            url: "<?php echo base_url('admin/esidetails/Esimaster/updateesi_data'); ?>",
            type: "POST",
            data: {companyId: companyId,dojdate: dojdate,reasoncode: reasoncode,incactdate: incactdate,esino: esino,
                ebname: ebname,adharseeded:adharseeded,uanactive: uanactive, record_id:record_id              
            },
            dataType: "json",
            success: function(response) {
              var savedata=(response.savedata);
              if (response.success) {
                  alert('Record Added Successfully');
                  $("#esino").val();
                $("#ebname").val();
                $("#ebname").val();
                $("#ebno").val();
                $("#pfno").val();
                
                  $("#edituan").hide();
                  $("#saveuan").show();
                  $("#saveuan").attr('disabled',true);
                      $("#edituan").attr('disabled',true);
                      $("#resetuan").click();
                      refreshDataTable();


                  }
            }
        });
        refreshDataTable();
      });






</script>



</body>
</html>
