<!DOCTYPE html>
<html lang="en" class="login_page">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>SISPENSI PDRD LOGIN</title>
    
        <!-- Bootstrap framework -->
            <link rel="stylesheet" href="<?php echo $this->config->item("theme"); ?>bootstrap/css/bootstrap.min.css" />
        <!-- theme color-->
            <link rel="stylesheet" href="<?php echo $this->config->item("theme"); ?>css/blue.css" />
        <!-- tooltip -->    
			<link rel="stylesheet" href="<?php echo $this->config->item("theme"); ?>lib/qtip2/jquery.qtip.min.css" />
        <!-- main styles -->
            <link rel="stylesheet" href="<?php echo $this->config->item("theme"); ?>css/style.css" />
    
        <!-- favicon -->
            <link rel="shortcut icon" href="<?php echo $this->config->item("theme"); ?>img/icon.png" />
    
			<link href='http://fonts.googleapis.com/css?family=PT+Sans' rel='stylesheet' type='text/css'>
			<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
			<script type="text/javascript" class="init">
				$(document).ready(function() {

					var baseurl = '<?php echo base_url(); ?>';
					
					$('#submitLogin').on('click', function() {
						processLogin();
					});

					function processLogin(){
						var data = new FormData();
							data.append('username', $('#username').val());
							data.append('password', $('#password').val());
						$.ajax({
							url: baseurl+"login/process",
							type: 'POST', 
							data: data, 
							processData: false,
							contentType: false,
							dataType: "json",
							success: function(data){
								//alertMessage(data.status,data.message);
								if(data.status==0){
									window.setTimeout(function(){
									window.location.href = baseurl+"dashboard";
									}, 3000);
								}
								if(data.status==2){
									window.location.href = baseurl+"login/reg";
								}
								document.getElementById('ztxtAppsMsg').innerHTML = data.notif;				
							},
							error: function(xhr, ajaxOptions, thrownError){
								alert(xhr.responseText);
								$('body').css('cursor','default');			
							}
						});
					}
				});
        	</script>
    </head>
    <body>
		<div id="ztxtAppsMsg"></div>
		<div class="login_box">
			<img src="<?php echo $this->config->item("theme"); ?>img/login-logo.png" width="100%"> 	
			<div class="cnt_b">
				<div class="form-group">
					<div class="input-group">
						<span class="input-group-addon input-sm"><i class="glyphicon glyphicon-user"></i></span>
						<input class="form-control input-sm" type="text" id="username" name="username" placeholder="Username" />
					</div>
				</div>
				<div class="form-group">
					<div class="input-group">
						<span class="input-group-addon input-sm"><i class="glyphicon glyphicon-lock"></i></span>
						<input class="form-control input-sm" type="password" id="password" name="password" placeholder="Password" />
					</div>
				</div>

			</div>
			<div class="btm_b clearfix">
				<button class="btn btn-default btn-sm pull-right" id="submitLogin" type="submit"><i class="splashy-lock_large_unlocked"></i> Sign In</button>
			</div>  	
		</div>
	</body>	 
        <script src="<?php echo $this->config->item("theme"); ?>js/jquery.min.js"></script>
        <script src="<?php echo $this->config->item("theme"); ?>js/jquery.actual.min.js"></script>
		<script src="<?php echo $this->config->item("theme"); ?>lib/validation/jquery.validate.js"></script>
		<script src="<?php echo $this->config->item("theme"); ?>bootstrap/js/bootstrap.min.js"></script>
	
</html>
