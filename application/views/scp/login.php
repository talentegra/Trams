<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>TRMS! | </title>

    <!-- Bootstrap -->
    <link href="<?php echo base_url() ?>vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="<?php echo base_url() ?>vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- Animate.css -->
    <link href="https://colorlib.com/polygon/gentelella/css/animate.min.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="<?php echo base_url() ?>build/css/custom.min.css" rel="stylesheet">
  </head>

  <body class="login">
    <div id="infoMessage"><?php echo $message;?></div>
  
    <div>
      <a class="hiddenanchor" id="signup"></a>
      <a class="hiddenanchor" id="signin"></a>

      <div class="login_wrapper">
        <div class="animate form login_form">
          <section class="login_content">
            <?php echo form_open("scp/login");?>
              <h1>Login Form</h1>
              <div>
                <input type="text" class="form-control" placeholder="Email" required="required" id="email" name ="email" />
              </div>
              <div>
                <input type="password" class="form-control" placeholder="Password" required="required" id="password" name ="password"/>
              </div>
              <div>
                <input class="btn btn-default submit" type="submit" id="btn_login" name="btn_login" value ="Log in">
                <a class="reset_pass" href="#">Lost your password?</a>
              </div>

              <div class="clearfix"></div>

              <div class="separator">
                <div>
                  <h1>Training Management Software</h1>
                  <p>©2016 All Rights Reserved.</p>
                </div>
              </div>
            <?php echo form_close();?>
          </section>
        </div>

        
      </div>
    </div>
  </body>
</html>
