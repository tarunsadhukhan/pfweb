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

</style>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12">
          <h3 class="m-1 text-dark text-center" style="background-color: #1589FF;"><strong>ESI Payement Updation</strong></h3>

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
						          <label for="purchaseDetailsPurchaseDate">Update Upload File<span class="text-center"></span></label>
                      <button name="submit" id="updatepfupdata" style="height: 50px;" type="submit" class="form-control btn btn-primary">Update</button>
                </div>
      



            </div>
                   
                        <div class="form-row">
                        <div class="form-group col-md-1" >
						  <label for="purchaseDetailsPurchaseDate">Month End Date<span class="text-center">*</span></label>
						  <input type="text" style="height: 50px; color:blue; font-style: bold; font-size: 16px;"
                            class="form-control datepicker text-center" id="chaldate" 
                            name="chaldate"  disabled  >
						</div>
                        <div class="form-group col-md-2">
                        <label for="purchaseDetailsPurchaseDate">Upload Gross<span class="text-center">*</span></label>
                        <input type="text" name="uploadgross" id="uploadgross" value=""
                        style="height: 50px; color:blue; font-style: bold; font-size: 16px;"
                        class="form-control" maxlength="14">
                      
                    </div>
                    <div class="form-group col-md-2">
                        <label for="purchaseDetailsPurchaseDate">Upload ESI<span class="text-center">*</span></label>
                        <input type="text" name="uploadesi" id="uploadesi" value=""
                        style="height: 50px; color:blue; font-style: bold; font-size: 16px;"
                        class="form-control" maxlength="14">
                      
                    </div>
                    <div class="form-group col-md-2">
                        <label for="purchaseDetailsPurchaseDate">Online ESI<span class="text-center">*</span></label>
                        <input type="text" name="onlineesi" id="onlineesi" value=""
                        style="height: 50px; color:blue; font-style: bold; font-size: 16px;"
                        class="form-control" maxlength="14">
                      
                    </div>
                    <div class="form-group col-md-2">
                        <label for="purchaseDetailsPurchaseDate">ESI Payment<span class="text-center">*</span></label>
                        <input type="text" name="paymentesi" id="paymentesi" value=""
                        style="height: 50px; color:blue; font-style: bold; font-size: 16px;"
                        class="form-control" maxlength="14">
                      
                    </div>
                    <div class="form-group col-md-2">
                        <label for="purchaseDetailsPurchaseDate">Challan No<span class="text-center">*</span></label>
                        <input type="text" name="challanno" id="challanno" value=""
                        style="height: 50px; color:blue; font-style: bold; font-size: 16px;"
                        class="form-control" maxlength="14">
                      
                    </div>
                     
                    <div class="form-group col-md-1" >
						  <label for="purchaseDetailsPurchaseDate">Payment Date<span class="text-center">*</span></label>
						  <input type="text" style="height: 50px; color:blue; font-style: bold; font-size: 16px;"
                            class="form-control datepicker text-center" id="paymentdate" 
                            name="paymentdate"    >
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

            
            <h1>PF UPload Data Details</h1>
    <table id="spgdailyrecordTable" class="display">
        <thead>
            <tr>
               <th>Record Id</th>
                <th>Month End Date</th>
                <th>Upload Gross </th>
                <th>Upload ESI</th>
                <th>No of Persons</th>
                <th>Online ESI</th>
                <th>Paid Amount</th>
                <th>Challan No</th>
                <th>Payment Date</th>
                
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
                $("#paymentdate").datepicker({ 
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
          var uploadgross = $('#uploadgross').val();
          var uploadesi = $('#uploadesi').val();
          var onlineesi = $('#onlineesi').val();
          var paymentesi = $('#paymentesi').val();
          var challanno = $('#challanno').val();
          var paymentdate = $('#paymentdate').val();
   
          $("#updatepfupdata").attr('disabled',true);
          $.ajax({
           url: "<?php echo base_url('admin/esidetails/Esi_payment_updation/update_monthesidata'); ?>",
            type: "POST",
                data: {companyId: companyId,record_id: record_id,uploadgross:uploadgross,uploadesi:uploadesi,
                  onlineesi:onlineesi,paymentesi:paymentesi,challanno:challanno,paymentdate:paymentdate
                  
        
            },
            dataType: "json",
            success: function(response) {
              var savedata=(response.savedata);
                if (response.success) {
                    alert('Record updated Successfully');
                    $("#updatepfupdata").attr('disabled',false);
                  refreshDataTable();
                  $('#uploadgross').val();
                $("#uploadesi").val(rowData[14]).trigger("change");
                $('#paymentesi').val();
                $('#challano').val();
                 $('#paymentdate').val();                
                $("#updatepfupdata").attr('disabled',false);
                    
                  }
            }
        });
 
      });

  

      initDataTable();
      function initDataTable() {
             var upfromdate= $('#upfromdate').val();
             var uptodate= $('#uptodate').val();
             var companyId=$('#companyId').val();
           //  alert('data');
             table = $('#spgdailyrecordTable').DataTable({
                ajax: {
                    url: '<?php echo base_url('admin/esidetails/Esi_payment_updation/get_esidataupload'); ?>',
                    type: 'POST',
                    data: function(d) {
                        d.upfromdate = $('#upfromdate').val();
                        d.uptodate = $('#uptodate').val();
                        d.companyId=$('#companyId').val();
                    }
                  },
                  columnDefs: [
                    { targets: [0], visible: true }, // Hide the first column (auto_id)
                    { targets: [0], visible: true }, { targets: [0], visible: true },{
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


    //    $('#spgdailyrecordTable tbody').on('mouseenter click', 'tr', function() {
        $('#spgdailyrecordTable tbody').on('click', 'tr', function() {
                var rowData = table.row(this).data();
                $('#record_id').val(rowData[0]);
                $('#chaldate').val(rowData[1]);
                $('#uploadgross').val(rowData[2]);
                $('#uploadesi').val(rowData[3]);
                $('#onlineesi').val(rowData[5]);
                $('#paymentesi').val(rowData[6]);
                $('#challanno').val(rowData[7]);
                $('#paymentdate').val(rowData[8]);                
             
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
            var url = '<?php echo site_url("admin/uandetails/Pfuploadfileupd/create_pfuplodfile"); ?>' +
                      '?batchno=' + batchno +
                       '&companyId=' + companyId  
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

          //    initDatedata();      
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
                    { targets: [13], visible: false }, { targets: [14], visible: false },{
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
            order: [],                 // Sort by the first column (auto_id) in descending order
                pageLength: 5 // Set the default number of rows per page to 25
              });
        }
 

        $("#showpfupdata").click(function(event){
    event.preventDefault(); 
//    alert('ananan');
    initDatadata();     
   
              
});
   
       


</script>



</body>
</html>
