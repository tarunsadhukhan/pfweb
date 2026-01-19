
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 3 | Log in</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url()?>public/admin/plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="<?php echo base_url()?>public/admin/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url()?>public/admin/dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">

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


</head>

<style>
body.login-page {
  background: linear-gradient(135deg, #e3eafc 0%, #f8f9fa 100%);
  min-height: 100vh;
}
.login-box {
  max-width: 400px;
  margin: auto;
  padding-top: 40px;
}
.login-logo {
  margin-bottom: 20px;
}
.login-logo a, .login-logo span {
  font-size: 2.2rem;
  font-weight: 700;
  color: #2c3e50;
  letter-spacing: 2px;
}
.login-logo span span {
  color: #007bff;
}
.card {
  border-radius: 18px;
  box-shadow: 0 8px 32px 0 rgba(60,72,88,0.18);
  border: 1.5px solid #e3eafc;
  background: #1976d2;
}
.login-card-body {
  background: #1976d2;
  color: #fff;
}
.login-box-msg, .form-group label, .input-group-text span, .requiredIcon, .mb-1 a, .mb-0 a {
  color: #fff !important;
}
.login-card-body {
  padding: 2rem;
}
.login-box-msg {
  font-size: 1.2rem;
  color: #555;
}
.form-group label {
  font-weight: 500;
}
.form-control, .input-group-text {
  height: 48px;
  font-size: 1rem;
}
.input-group-text {
  background: #f4f6f9;
}
.btn-primary {
  border-radius: 8px;
  font-size: 1.1rem;
  font-weight: 600;
}
.mt-3 a, .mb-0 a {
  font-size: 0.98rem;
}
.requiredIcon {
  color: #dc3545;
}
.select2-selection__rendered {
  line-height: 48px !important;
}
.select2-container .select2-selection--single {
  height: 48px !important;
  font-size: 1rem;
  color: #333;
}
.select2-selection__arrow {
  height: 48px !important;
}
</style>

<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="../../index2.html" style="
      color: #1976d2;
      text-decoration: underline;
      font-weight: bold;
      font-size: 2.4rem;
      letter-spacing: 2px;
      border-bottom: 2px solid #1976d2;
      padding-bottom: 4px;
      transition: color 0.2s, border-bottom-color 0.2s;
    "
    onmouseover="this.style.color='#0056b3';this.style.borderBottomColor='#0056b3'"
    onmouseout="this.style.color='#1976d2';this.style.borderBottomColor='#1976d2'"
    ><b>NEW PF-ESI </b><span style="color:#007bff;">WEB</span></a>
  </div>


  <!-- /.login-logo -->
  <?php 
        if (!empty($this->session->flashdata('msg'))) {
            echo "<div class='alert alert-danger mb-3'>".$this->session->flashdata('msg')."</div>"; 
        }
    ?>
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Sign in to start your session</p>


      <form action="<?php echo base_url().'admin/login/authenticate'?>" name="loginForm" id="loginForm" method="post">

<div class="form-group mb-4" style="margin-bottom: 1.5rem;">
  <label for="compsel" style="margin-bottom: 0.5rem; font-weight: 500;">Select Company <span class="requiredIcon text-center">*</span></label>
  <select class="form-control select2" name="compsel" id="compsel" style="border-radius: 12px; padding-left: 16px; font-size: 1rem; height: 48px;">
    <option value="0">Select....</option>
    <?php foreach ($data['wndmcdata'] as $each){ ?>
      <option value="<?php echo $each['mechine_id']; ?>"><?php echo $each['mechine_name']; ?></option>
    <?php } ?>
  </select>
</div>
<div class="input-group mb-4" style="margin-bottom: 1.5rem;">
  <input type="text" name="username" id="username" class="form-control" placeholder="Username" style="border-radius: 12px 0 0 12px; padding-left: 16px;">
  <div class="input-group-append">
    <div class="input-group-text" style="border-radius: 0 12px 12px 0;">
      <span class="fas fa-envelope"></span>
    </div>
  </div>
</div>
<?php echo form_error('username'); ?>
<div class="input-group mb-4" style="margin-bottom: 1.5rem;">
  <input type="password" name="password" id="password" class="form-control" placeholder="Password" style="border-radius: 12px 0 0 12px; padding-left: 16px;">
  <div class="input-group-append">
    <div class="input-group-text" style="border-radius: 0 12px 12px 0;">
      <span class="fas fa-lock"></span>
    </div>
  </div>
</div>
<?php echo form_error('password'); ?>        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="remember">
              <label for="remember">
                Remember Me
              </label>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block" id="signInBtn" disabled>Sign In</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

       <!-- /.social-auth-links -->

      <p class="mb-1">
        <a href="forgot-password.html">I forgot my password</a>
      </p>
      <p class="mb-0">
        <a href="register.html" class="text-center">Register a new membership</a>
      </p>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
</body>
</html>


<script>
  $(document).ready(function() {
    $('.select2').select2();
    $('.select2bs4').select2({ theme: 'bootstrap4' });
    function toggleSignInBtn() {
      var val = $('#compsel').val();
      if (val === '0' || val === null || val === '') {
        $('#signInBtn').prop('disabled', true);
      } else {
        $('#signInBtn').prop('disabled', false);
      }
    }
    toggleSignInBtn();
    $('#compsel').on('change', function() {
      toggleSignInBtn();
    });
  });
</script>
