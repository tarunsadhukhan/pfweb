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

/* Highlight rows where main type = 1 */
.main-type-row {
    background-color: #90EE90 !important; /* Light green */
}

.main-type-row:hover {
    background-color: #7CCD7C !important; /* Darker green on hover */
}

</style>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12">
          <h3 class="m-1 text-dark text-center" style="background-color: #1589FF;"><strong>PF Upload file Updation</strong></h3>

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
            <div class="form-group col-md-1" style="margin-left: 30px;">
						    <label for="purchaseDetailsPurchaseDate">Show<span class="text-center"></span></label>
                            <button name="submit" id="showpfupdata" style="height: 50px;" type="submit" class="form-control btn btn-primary">Show</button>
            </div>
                <div class="form-group col-md-1" style="margin-left: 30px;">
						          <label for="purchaseDetailsPurchaseDate">Update<span class="text-center"></span></label>
                      <button name="submit" id="updatepfupdata" style="height: 50px;" type="submit" class="form-control btn btn-primary">Update</button>
                </div>
                <div class="form-group col-md-1">
                  <label for="purchaseDetailsPurchaseDate">Batch No<span class="text-center">*</span></label>
                  <input type="text" name="batchno" id="batchno" value=""
                  style="height: 50px; color:blue; font-style: bold; font-size: 28px;"
                  class="form-control" maxlength="1200">
              </div>
              <div class="form-group col-md-1" style="margin-left: 30px;">
						          <label for="purchaseDetailsPurchaseDate">Old File<span class="text-center"></span></label>
                      <button name="submit" id="batchcreate" style="height: 50px;" type="submit" class="form-control btn btn-primary">Create</button>
              </div>
              <div class="form-group col-md-1" style="margin-left: 30px;">
						          <label for="purchaseDetailsPurchaseDate">New File<span class="text-center"></span></label>
                      <button name="submit" id="batchncreate" style="height: 50px;" type="submit" class="form-control btn btn-primary">Create</button>
              </div>




            </div>
                   
                        <div class="form-row">
                        <div class="form-group col-md-1">
                        <label for="purchaseDetailsPurchaseDate">TRRN No <span class="text-center">*</span></label>
                        <input type="text" name="trrnnno" id="trrnno" value=""
                        style="height: 50px; color:blue; font-style: bold; font-size: 16px;"
                        class="form-control" maxlength="14">
                      
                    </div>
                    <div class="form-group col-md-1" ">
                        <label for="purchaseDetailsVendorName">Tran Type<span class="requiredIcon text-center">*</span></label>
                        <select id="trantype" style="height: 50px; color:blue; font-style: bold; font-size: 16px;"
                        name="trantype" class="form-control chosenSelect text-center">
                        <option value="1">Both Share</option>
                        <option value="2">EE Share</option>
                        <option value="3">ER Share</option>
                        <option value="4">No Share</option>
                        </select>
                    </div>
                    <div class="form-group col-md-1" >
						  <label for="purchaseDetailsPurchaseDate">Chal Date<span class="text-center">*</span></label>
						  <input type="text" style="height: 50px; color:blue; font-style: bold; font-size: 16px;"
                            class="form-control datepicker text-center" id="chaldate" 
                            name="chaldate"   readonly >
						</div>
                    <div class="form-group col-md-1"  >
                        <label for="purchaseDetailsPurchaseDate">AC 1 <span class="text-center">*</span></label>
                        <input type="text" name="ac1amt" id="ac1amt" value=""
                        style="height: 50px; color:blue; font-style: bold; font-size: 16px;"
                        class="form-control" maxlength="14" readonly>
                      
                    </div>
                    <div class="form-group col-lg-1"  >
                        <label for="purchaseDetailsPurchaseDate">AC 2 <span class="text-center">*</span></label>
                        <input type="text" name="ac2amt" id="ac2amt" value=""
                        style="height: 50px; color:blue; font-style: bold; font-size: 16px;"
                        class="form-control" maxlength="14" >
                      
                    </div>
                    <div class="form-group col-md-1">
                        <label for="purchaseDetailsPurchaseDate">AC 10 <span class="text-center">*</span></label>
                        <input type="text" name="ac10amt" id="ac10amt" value=""
                        style="height: 50px; color:blue; font-style: bold; font-size: 16px;"
                        class="form-control" maxlength="14" readonly>
                      
                    </div>
                    <div class="form-group col-md-1">
                        <label for="purchaseDetailsPurchaseDate">AC 21 <span class="text-center">*</span></label>
                        <input type="text" name="ac21amt" id="ac21amt" value=""
                        style="height: 50px; color:blue; font-style: bold; font-size: 16px;"
                        class="form-control" maxlength="14">
                      
                    </div>
                    <div class="form-group col-md-1">
                        <label for="purchaseDetailsPurchaseDate">AC 22<span class="text-center">*</span></label>
                        <input type="text" name="ac22amt" id="ac22amt" value=""
                        style="height: 50px; color:blue; font-style: bold; font-size: 16px;"
                        class="form-control" maxlength="14">
                      
                    </div>
                    <div class="form-group col-md-1">
                        <label for="purchaseDetailsPurchaseDate">Total<span class="text-center">*</span></label>
                        <input type="text" name="totamt" id="totamt" value=""
                        style="height: 50px; color:blue; font-style: bold; font-size: 16px;"
                        class="form-control" maxlength="14" readonly>
                      
                    </div>
                    <div class="form-group col-md-1" style="margin-left: 1px;">
                        <label for="purchaseDetailsVendorName">Status<span class="requiredIcon text-center">*</span></label>
                        <select id="upshare" style="height: 50px; color:blue; font-style: bold; font-size: 16px;"
                        name="upshare" class="form-control chosenSelect text-center">
                        <option value="1">Reject</option>
                        <option value="2">Due for Payment</option>
                        <option value="4">Cancel</option>
                        <option value="3">Payment Confirm</option>
                        </select>
                    </div>
                    <div class="form-group col-md-1" >
						  <label for="purchaseDetailsPurchaseDate">Payment Date<span class="text-center">*</span></label>
						  <input type="text" style="height: 50px; color:blue; font-style: bold; font-size: 16px;"
                            class="form-control datepicker text-center" id="paydate" 
                            name="paydate"   readonly >
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
              <input type="hidden" class="input" id="maintype" value="0" />
 
              

            

 

            </form>

            
            <h1>PF UPload Data Details</h1>
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
                <th>No of Employee</th>
                
                <th>Main Type</th>
               
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

//start save
        $("#genpfdata").click(function(event){
          event.preventDefault(); 
          var companyId=$('#companyId').val();
          var spgdailyDate= $('#spgdailyDate').val();
          $("#genpfdata").attr('disabled',true);
          $.ajax({
           url: "<?php echo base_url('admin/uandetails/Pfdatageneration/gen_monthpfdata'); ?>",
            type: "POST",
                data: {pfgendate: spgdailyDate,companyId: companyId
            },
            dataType: "json",
            success: function(response) {
              var savedata=(response.savedata);
                if (response.success) {
                    alert('Record Added Successfully');
                  refreshDataTable();
                    $("#genpfdata").attr('disabled',true);
                    $("#cancelpfdata").attr('disabled',false);
                    $("#genpfdata").hide();
                    $("#cancelpfdata").show();
                    
                  }
            }
        });
 
      });

      $("#updatepfupdata").click(function(event){
          event.preventDefault(); 
          var companyId=$('#companyId').val();
          var record_id=$('#record_id').val();
          var trrnno = $('#trrnno').val();
          var chaldate = $('#chaldate').val();
          var ac1amt = $('#ac1amt').val();
          var ac2amt = $('#ac2amt').val();
          var ac10amt = $('#ac10amt').val();
          var ac21amt = $('#ac21amt').val();
          var ac22amt = $('#ac22amt').val();
          var totamt = $('#totamt').val();
          var upshare = $('#upshare').val();
          var paydate = $('#paydate').val();
          var mainType = $('#maintype').val();
          
          // Prevent status change to Payment Confirm or payment date change when main type = 1
          if (mainType == 1) {
              if (upshare == 3) {
                  alert('Cannot change status to Payment Confirm for Main Type records. Please update individual records separately.');
                  return false;
              }
              if (paydate && paydate.trim() !== '') {
                  alert('Cannot set Payment Date for Main Type records. Please update individual records separately.');
                  return false;
              }
          }
          
          var ac2amt = parseFloat($('#ac2amt').val()) || 0;
            var ac21amt = parseFloat($('#ac21amt').val()) || 0;
            var ac22amt = parseFloat($('#ac22amt').val()) || 0;

  
          $("#updatepfupdata").attr('disabled',true);
          $.ajax({
           url: "<?php echo base_url('admin/uandetails/Pfuploadfileupd/update_monthpfdata'); ?>",
            type: "POST",
                data: {record_id: record_id,companyId: companyId, ac1amt: ac1amt,ac2amt: ac2amt,ac10amt: ac10amt,
                    ac21amt: ac21amt,ac22amt : ac22amt,totamt : totamt,upshare : upshare,trrnno: trrnno,
                    chaldate: chaldate,paydate: paydate

            },
            dataType: "json",
            success: function(response) {
              var savedata=(response.savedata);
                if (response.success) {
                    alert('Record updated Successfully');
                    $("#updatepfupdata").attr('disabled',false);
                  refreshDataTable();
                  $('#trrnno').val();
                $("#trantype").val(rowData[14]).trigger("change");
                $('#chaldate').val();
                $('#ac1amt').val();
                $('#ac2amt').val();
                $('#ac10amt').val();
                $('#ac21amt').val();                
                $('#ac22amt').val();                
                $('#totamt').val();                
                $("#upshare").val(rowData[13]).trigger("change");
                $('#paydate').val();                
                $("#updatepfupdata").attr('disabled',false);
                    
                  }
            }
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
                    url: '<?php echo base_url('admin/uandetails/Pfuploadfileshow/Pfupddatalast'); ?>',
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
            createdRow: function(row, data, dataIndex) {
                // Highlight row if main type = 1 (column index 17)
                if (data[17] == 1) {
                    $(row).addClass('main-type-row');
                }
            },
            order: [[7, 'asc']],                 // Sort by the first column (auto_id) in descending order
                pageLength: 10 // Set the default number of rows per page to 25
              });
        }
 


        function refreshDataTable() {
              table.ajax.reload(null, false); // Reload the data without resetting the current page
        }


    //    $('#spgdailyrecordTable tbody').on('mouseenter click', 'tr', function() {
        $('#spgdailyrecordTable tbody').on('click', 'tr', function() {
                var rowData = table.row(this).data();
                $('#record_id').val(rowData[0]);
                $('#trrnno').val(rowData[2]);
                $("#trantype").val(rowData[14]).trigger("change");
                $('#chaldate').val(rowData[4]);
                $('#ac1amt').val(rowData[5]);
                $('#ac2amt').val(rowData[6]);
                $('#ac10amt').val(rowData[7]);
                $('#ac21amt').val(rowData[8]);                
                $('#ac22amt').val(rowData[9]);                
                $('#totamt').val(rowData[10]);                
                $("#upshare").val(rowData[13]).trigger("change");
                $('#paydate').val(rowData[12]);                
                var ups=rowData[13];
                var mainType = rowData[17];
                $('#maintype').val(mainType);
                  $("#updatepfupdata").attr('disabled',false);
                
                // If main type = 1, disable Payment Confirm option and payment date changes
                if (mainType == 1) {
                    // Disable only Payment Confirm option (value 3), allow Reject/Cancel
                    $('#upshare option[value="3"]').prop('disabled', true);
                    $('#paydate').prop('readonly', true).css('background-color', '#e9ecef');
                } else {
                    // Enable all options
                    $('#upshare option[value="3"]').prop('disabled', false);
                    $('#paydate').prop('readonly', true).css('background-color', '');
                }
                
                if (ups==3 || ups==4) {
  //                $("#updatepfupdata").attr('disabled',true);
                }  

              });
        
            $('#recordTable tbody').on('click', 'tr', function() {
                if ($(this).hasClass('selected')) {
                    $(this).removeClass('selected');
                } else {
                    table.$('tr.selected').removeClass('selected');
                    $(this).addClass('selected');
                }
            });



            $('#ac2amt, #ac21amt, #ac22amt ').on('input', function() {
            //    alert('ac2');
            var ac1 = parseFloat($('#ac1amt').val()) || 0;
            var ac10 = parseFloat($('#ac10amt').val()) || 0;
            var ac2 = parseFloat($('#ac2amt').val()) || 0;
            var ac21 = parseFloat($('#ac21amt').val()) || 0;
            var ac22 = parseFloat($('#ac22amt').val()) || 0;
            $('#ac2amt').val(ac2);
       //         $('#ac10amt').val(rowData[7]);
                $('#ac21amt').val(ac21);                
               $('#ac22amt').val(ac22);                
  

                $tamt=ac1+ac10+ac2+ac21+ac22; 
                $('#totamt').val($tamt);                
     
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


   



$("#batchcreate").click(function(event){
  event.preventDefault(); 

//	alert ("aaaa");
	var opt=3;
            var batchno= $('#batchno').val();
            var companyId=$('#companyId').val();
            var oldnew=1;            
            var url = '<?php echo site_url("admin/uandetails/Pfuploadfileupd/create_pfuplodfile"); ?>' +
                      '?batchno=' + batchno +
                       '&companyId=' + companyId +
                       '&oldnew=' + oldnew
                         ;
                      alert(url);
			//$(location).attr('href',url);
			window.open( url, '_blank');
			
			
return false;
});

$("#batchncreate").click(function(event){
  event.preventDefault(); 

//	alert ("aaaa");
	var opt=3;
            var batchno= $('#batchno').val();
            var companyId=$('#companyId').val();
            var oldnew=2;
            var url = '<?php echo site_url("admin/uandetails/Pfuploadfileupd/create_pfuplodfile"); ?>' +
                      '?batchno=' + batchno +
                       '&companyId=' + companyId +
                       '&oldnew=' + oldnew
                       ;
                      alert(url);
			//$(location).attr('href',url);
			window.open( url, '_blank');
			
			
return false;
});




$("#showpfupdata").click(function(event){
  event.preventDefault(); 
//  initDataTable(); 
  refreshDataTable();
            });

     
            function initDatedata2() {
                 var companyId=$('#companyId').val();
          $.ajax({
            url: "<?php echo base_url('admin/uandetails/Pfdatageneration/Pfupddatalast'); ?>",
            type: "POST",
            data: {companyId: companyId },
            dataType: "json",
            success: function(response) {
              if (response.success) {
                $('#upfromdate').val(response.upfromdate);
                $('#uptodate').val(response.upfromdate);
               } else {
                $('#cmeter').val(0);
                $('#opmeter').val(0);
          
                

              }
            }  
            });
 
              };

              initDatedata();      
        function initDatedata() {
            $('#spgdailyrecordTable').DataTable().destroy();
             var companyId=$('#companyId').val();
             var companyId=$('#companyId').val();
             var upfromdate= $('#upfromdate').val();
             var uptodate= $('#uptodate').val();
            table = $('#spgdailyrecordTable').DataTable({
                autoWidth: true,
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
                    { targets: [13], visible: true }, { targets: [14], visible: false },{
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
            createdRow: function(row, data, dataIndex) {
                // Highlight row if main type = 1 (column index 17)
                if (data[17] == 1) {
                    $(row).addClass('main-type-row');
                }
            },
            order: [],                 // Sort by the first column (auto_id) in descending order
                pageLength: 5 // Set the default number of rows per page to 25
              });
        }
 

        $("#showpfupdata").click(function(event){
    event.preventDefault(); 
//    alert('ananan');
    initDatedata();     
   
              
});
   
       


</script>



</body>
</html>
