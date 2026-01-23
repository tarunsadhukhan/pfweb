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
          <h3 class="m-1 text-dark text-center" style="background-color: #1589FF;"><strong>ESI DATA SUBMISSION REPORT</strong></h3>

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

                <div class="form-group col-md-1">
                  <label for="purchaseDetailsPurchaseDate">Tkt No<span class="text-center">*</span></label>
                  <input type="text" name="ebno" id="ebno" value=""
                  style="height: 40px; color:blue; font-style: bold; font-size: 20px;"
                  class="form-control" maxlength="12" autocomplete="off">
              </div>
               <div class="form-group col-md-2">
                  <label for="purchaseDetailsPurchaseDate">IP No<span class="text-center">*</span></label>
                  <input type="text" name="ipno" id="ipno" value=""
                  style="height: 40px; color:blue; font-style: bold; font-size: 20px;"
                  class="form-control" maxlength="12">
              </div>
               <div class="form-group col-md-2">
                  <label for="purchaseDetailsPurchaseDate">Name<span class="text-center">*</span></label>
                  <input type="text" name="name" id="name" value=""
                  style="height: 40px; color:blue; font-style: bold; font-size: 20px;"
                  class="form-control" maxlength="12">
              </div>

              
              <div class="form-group col-md-2" >
						  <label for="purchaseDetailsPurchaseDate">Date From<span class="text-center">*</span></label>
						  <input type="text" style="height: 40px; color:blue; font-style: bold; font-size: 20px;"
                            class="form-control datepicker text-center" id="upfromdate" 
                            name="upfromdate"    >
						</div>
						<div class="form-group col-md-2" >
						  <label for="purchaseDetailsPurchaseDate">Date To<span class="text-center">*</span></label>
						  <input type="text" style="height: 40px; color:blue; font-style: bold; font-size: 20px;"
                            class="form-control datepicker text-center" id="uptodate" 
                            name="uptodate"    >
						</div>
              <div class="form-group col-md-1" >
                        <label for="purchaseDetailsPurchaseDate">Print<span class="text-center"></span></label>
                       <button name="printesidata" id="printesidata" style="height: 40px;" type="button" class="form-control btn btn-primary">Print</button>
              </div>
                       <div class="form-group col-md-1" style="margin-left: 30px;">
						    <label for="purchaseDetailsPurchaseDate">Reset Date<span class="text-center"></span></label>
                            <button name="submit" id="resetesidata" style="height: 40px;" type="submit" class="form-control btn btn-primary">Reset</button>
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
              <input type="hidden" class="input" id="maintype" value="0" />
 
              

            

 

            </form>

            
            <h1>PF UPload Data Details</h1>
    <table id="spgdailyrecordTable" class="display">
        <thead>
          <tr>
            <th>Record Id</th>
            <th>EB No</th>
            <th>IP No</th>
            <th>Name</th>
            <th>From Date</th>
            <th>To Date</th>
            <th>No of Days</th>
            <th>Date of Verification</th>
            <th>Edit</th>
            <th>Delete</th>
            <th>Print</th>
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
          
                $('#upfromdate').datepicker('setDate', 'today');
                          $('#uptodate').datepicker('setDate', 'today');

 
 
 
</script>
<script>
// On EB No blur, fetch IP No and Name from server
$(document).ready(function() {
  $('#ebno').on('blur', function() {
    var ebno = $('#ebno').val().trim();
    var ipno = $('#ipno').val().trim();
    if (ebno !== '') {
      $.ajax({
        url: '<?php echo base_url('admin/esidetails/InsuranceController/get_ipno_name_by_ebno'); ?>',
        type: 'POST',
        data: { ipno: ipno, ebno: ebno },
        dataType: 'json',
        success: function(response) {
          if (response.success) {
            $('#ipno').val(response.ipno);
            $('#name').val(response.name);
          } else {
            $('#ipno').val('');
            $('#name').val('');
          }
        },
        error: function() {
//          $('#ipno').val('');
//          $('#name').val('');
        }
      });
    } else {
 //     $('#ipno').val('');
 //     $('#name').val('');
    }
  });
});

  $('#ipno').on('blur', function() {
    var ebno = $('#ebno').val().trim();
    var ipno = $('#ipno').val().trim();
//alert(ipno);

    if (ipno !== '') {
//alert(ipno);

    $.ajax({
        url: '<?php echo base_url('admin/esidetails/InsuranceController/get_ipno_name_by_ebno'); ?>',
        type: 'POST',
        data: { ipno: ipno, ebno: ebno },
        dataType: 'json',
        success: function(response) {
          if (response.success) {
            $('#ebno').val(response.ebno);
            $('#name').val(response.name);
          } else {
            $('#ebno').val('');
            $('#name').val('');
          }
        },
        error: function() {
   //       $('#ebno').val('');
   //       $('#name').val('');
        }
      });
    } else {
  //    $('#ebno').val('');
  //    $('#name').val('');
    }
  });
 


</script>

<script>
        $(document).ready(function() {
            $('input[type="text"]').on('focus', function() {
                $(this).select();
            });
        });

   

 
  

   


 
 

 
$("#resetesidata").click(function(event){
  event.preventDefault(); 
//  alert('reset');
  $('#ebno').val('');
  $('#ipno').val('');
  $('#name').val('');
});



       $("#printesidata").click(function(event) {
         //   alert('aabb');
          event.preventDefault();
          var upfromdate = $('#upfromdate').val();
          var uptodate = $('#uptodate').val();
          var companyId = $('#companyId').val();
          var ebno = $('#ebno').val();
          var ipno = $('#ipno').val();
          var name = $('#name').val();
        // alert(payrollstartdate);
          var url = '<?php echo site_url("admin/esidetails/InsuranceController/exportpdfdata"); ?>' +
              '?upfromdate=' + upfromdate +
              '&uptodate=' + uptodate+
              '&companyId=' + companyId+
              '&ebno=' + ebno+              
             '&ipno=' + ipno
             +'&name=' + name
              ;      


          //                     alert(url);
          //$(location).attr('href',url);
          window.open(url, '_blank');


          return false;
      });
 



       


</script>



</body>
</html>
