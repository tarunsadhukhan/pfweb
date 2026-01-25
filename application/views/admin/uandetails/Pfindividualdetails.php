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

.column-align-right {
    text-align: right;
}

.column-align-left {
    text-align: left;
}

.column-align-center {
    text-align: center;
}

table.dataTable thead th,
        table.dataTable thead td {
            padding: 10px 18px;
            border-bottom: 1px solid #111;
            text-align: center; /* Center align all headers */
            font-size: 18px;
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
          <h3 class="m-1 text-dark text-center" style="background-color: #1589FF;"><strong>Individual PF Ledger Details</strong></h3>

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
                        <div class="form-group col-md-2">
                            <label for="purchaseDetailsPurchaseDate">Uan No  <span class="text-center">*</span></label>
                            <input type="text" name="uanno" id="uanno" value=""
                            style="height: 50px; color:blue; font-style: bold; font-size: 28px;"
                            class="form-control" maxlength="12">
                        </div>
                        <div class="form-group col-md-2">
                            <label for="purchaseDetailsPurchaseDate">Name <span class="text-center">*</span></label>
                            <input type="text" name="uanname" id="uanname" value=""
                            style="height: 50px; color:blue; font-style: bold; font-size: 20px;"
                            class="form-control">
                        </div>
                        <div class="form-group col-md-1" style="margin-left: 30px;">
						    <label for="purchaseDetailsPurchaseDate"> Details<span class="text-center"></span></label>
                            <button name="submit" id="showpfupinddata" style="height: 50px;" type="submit" class="form-control btn btn-primary">Show</button>
                        </div>

                        <div class="form-group col-md-1" style="margin-left: 30px;">
						    <label for="purchaseDetailsPurchaseDate">Excel<span class="text-center"></span></label>
                            <button name="submit" id="genpfexldata" style="height: 50px;" type="submit" class="form-control btn btn-primary">Excel</button>
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
            <table id="spgdailyrecordTable">
        <thead>
            <tr>
                <th>Month End Date</th>
                <th>EE Contribution</th>
                <th>ER Contribution</th>
                <th>Total Amount</th>
                <th>EE Contribution</th>
                <th>ER Contribution</th>
                 <th>Total Amount</th>
                 <th>Outstanding </th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
<!-- 
    <table id="spgdailyrecordTable" class="display">
        <thead>
            <tr>
                <th>Month End Date</th>
                <th>EE Contribution</th>
                <th>ER Contribution</th>
                <th>Total Amount</th>
                <th>EE Contribution</th>
                <th>ER Contribution</th>
                 <th>Total Amount</th>
                 <th>Outstanding </th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table> -->
           
       


          
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
                  $("#updatepfupdata").attr('disabled',false);
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
            var url = '<?php echo site_url("admin/uandetails/Pfuploadfileupd/create_pfuplodfile"); ?>' +
                      '?batchno=' + batchno +
                       '&companyId=' + companyId  
                         ;
                      alert(url);
			//$(location).attr('href',url);
			window.open( url, '_blank');
			
			
return false;
});

$("#showpfupinddata").click(function(event){
  event.preventDefault(); 
 // alert('abbb');
//  initDataTable(); 
initDatedata();
//refreshDataTable
            });

     
  
//              initDatedata();      
        function initDatedata() {
            $('#spgdailyrecordTable').DataTable().destroy();
             var companyId=$('#companyId').val();
             var companyId=$('#companyId').val();
             var upfromdate= $('#upfromdate').val();
             var uptodate= $('#uptodate').val();
             var uanid=$('#record_id').val();
//             alert(uanid);
            table = $('#spgdailyrecordTable').DataTable({
                autoWidth: true,
                    ajax: {
                    url: "<?php echo base_url('admin/uandetails/Pfindividualdetails/Pfindividualata'); ?>",
                    type: 'POST',
                    data: function(d) {
                        d.companyId=$('#companyId').val();
                        d.upfromdate=upfromdate;
                        d.uptodate=uptodate;
                        d.uanid=uanid;
                    }
                  },
                  columnDefs: [
                    { targets: [0], visible: true }, // Hide the first column (auto_id)
                    { targets: [0], visible: true }, { targets: [0], visible: true },{
                    targets: [1,2,3,4,5,6,7],
                    render: function(data, type, row, meta) {
                        return '<div class="column-align-right">' + data + '</div>';
                    }
                  }
                ],
                createdRow: function(row, data, dataIndex) {
            // Apply styles to the row if a condition is met
            if (data[0] == 'Grand Total') { // Change 'Specific Value' to your condition
                $(row).css({
                    'font-weight': 'bold',
                    'font-size': '22px' // Adjust the font size as needed
                });
            }
        },
                drawCallback: function() {
                // Apply alignment styles to the table cells
                $('#spgdailyrecordTable td.column-align-center').css('text-align', 'center');
                $('#spgdailyrecordTable td.column-align-right').css('text-align', 'right');
                $('#spgdailyrecordTable td.column-align-left').css('text-align', 'left');
            },
            order: [],                 // Sort by the first column (auto_id) in descending order
                pageLength: 10 // Set the default number of rows per page to 25
              });
        }
 

        $("#showpfupinddata").click(function(event){
    event.preventDefault(); 
//    alert('ananan');
    initDatedata();     
   
              
});
   

$('#uanno').on('blur', function() {
          var uanno =  $('#uanno').val();
          var companyId=$('#companyId').val();
      
        $.ajax({
            url: "<?php echo base_url('admin/uandetails/Pfindividualdetails/getuanname'); ?>",
            type: "POST",
            data: {uanno: uanno,companyId: companyId  },
            dataType: "json",
            success: function(response) {
              if (response.success) {
                    $('#uanname').val(response.name);
                    $('#record_id').val(response.uanid);
                    $('#uanname').css({'border-color': 'green','background-color': 'white'
                    });
 
                  } else {
              
                }
            }
        });
 
      });

$("#genpfexldata").click(function(event){
  event.preventDefault(); 

//	alert ("aaaa");
	var opt=3;
//            var doffrepdate= $('#spgdailyDate').val();
//            var companyId=$('#companyId').val();
             var companyId=$('#companyId').val();
             var companyId=$('#companyId').val();
             var upfromdate= $('#upfromdate').val();
             var uptodate= $('#uptodate').val();
             var uanid=$('#record_id').val();
             var uanno=$('#uanno').val();
            var url = '<?php echo site_url("admin/uandetails/Pfindividualdetails/gen_excelpfdata"); ?>' +
                      '?upfromdate=' + upfromdate +
                       '&uptodate=' + uptodate+  
                       '&uanid=' + uanid+
                       '&uanno=' + uanno+  
                       '&companyId=' + companyId  
                         ;
                      alert(url);
			//$(location).attr('href',url);
			window.open( url, '_blank');
			
			
return false;
});
       



</script>



</body>
</html>
