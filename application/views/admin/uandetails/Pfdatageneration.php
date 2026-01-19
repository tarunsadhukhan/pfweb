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
          <h3 class="m-1 text-dark text-center" style="background-color: #1589FF;"><strong>MOnthly PF Data Generation</strong></h3>

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
                            class="form-control datepicker text-center" id="spgdailyDate" 
                            name="spgdailyDate"   readonly >
						</div>
                        <div class="form-group col-md-2" style="margin-left: 30px;">
						    <label for="purchaseDetailsPurchaseDate">Generate PF Data<span class="text-center"></span></label>
                            <button name="submit" id="genpfdata" style="height: 50px;" type="submit" class="form-control btn btn-primary">Generate Data</button>
                            <button name="submit" id="cancelpfdata" style="height: 50px;" type="submit" class="form-control btn btn-primary">Cancel Data</button>
                        </div>
                        <div class="form-group col-md-2" style="margin-left: 30px;">
						    <label for="purchaseDetailsPurchaseDate">Export To Excel<span class="text-center"></span></label>
                            <button name="submit" id="genpfexldata" style="height: 50px;" type="submit" class="form-control btn btn-primary">Export to Xl</button>
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
                <th>Gross Wages</th>
                <th>EPF Wages</th>
                <th>EPS Wages</th>
                <th>EDLI Wages</th>
                <th>EPF Cont</th>
                <th>EPS Cont</th>
                <th>EPF EPS Diff</th>
                <th>NCP Days</th>
                <th>Refund</th>
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


$("#spgdailyDate").datepicker({ 
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

                $('#spgdailyDate').datepicker('setDate', 'today');

 
 
 
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

      $("#cancelpfdata").click(function(event){
          event.preventDefault(); 
          alert('cancel');
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

                  alert(response.savedata);
                  refreshDataTable();
             //     alert(response.msgno);
               if (response.msgno==2) {
                    $("#genpfdata").attr('disabled',false);
                    $("#cancelpfdata").attr('disabled',true);
                    $("#genpfdata").show();
                    $("#cancelpfdata").hide();
               }  else {
                $("#cancelpfdata").attr('disabled',false);
                
               }   
                  }
            }
        });
 
      });




      initDataTable();
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


        $('#spgdailyrecordTable tbody').on('click', 'tr', function() {
                var rowData = table.row(this).data();
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

 

     
   
       


</script>



</body>
</html>
