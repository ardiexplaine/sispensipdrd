<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>SISPENSI</title>

        <!-- Bootstrap framework -->
            <link rel="stylesheet" href="<?php echo $this->config->item("theme"); ?>bootstrap/css/bootstrap.min.css" />
        <!-- jQuery UI theme -->
            <link rel="stylesheet" href="<?php echo $this->config->item("theme"); ?>lib/jquery-ui/css/Aristo/Aristo.css" />
			<!-- <link rel="stylesheet" href="<?php echo $this->config->item("theme"); ?>lib/uniform/Aristo/uniform.aristo.css" /> -->
        <!-- breadcrumbs -->
            <link rel="stylesheet" href="<?php echo $this->config->item("theme"); ?>lib/jBreadcrumbs/css/BreadCrumb.css" />
        <!-- tooltips-->
            <link rel="stylesheet" href="<?php echo $this->config->item("theme"); ?>lib/qtip2/jquery.qtip.min.css" />
		<!-- colorbox -->
            <link rel="stylesheet" href="<?php echo $this->config->item("theme"); ?>lib/colorbox/colorbox.css" />
        <!-- code prettify -->
            <link rel="stylesheet" href="<?php echo $this->config->item("theme"); ?>lib/google-code-prettify/prettify.css" />
		<!-- datepicker -->
			<link rel="stylesheet" href="<?php echo $this->config->item("theme"); ?>lib/datepicker/datepicker.css" />
        <!-- sticky notifications -->
            <link rel="stylesheet" href="<?php echo $this->config->item("theme"); ?>lib/sticky/sticky.css" />
        <!-- aditional icons -->
            <link rel="stylesheet" href="<?php echo $this->config->item("theme"); ?>img/splashy/splashy.css" />
		<!-- flags -->
            <link rel="stylesheet" href="<?php echo $this->config->item("theme"); ?>img/flags/flags.css" />
        <!-- datatables -->
            <!-- <link rel="stylesheet" href="<?php echo $this->config->item("theme"); ?>lib/datatables/extras/TableTools/media/css/TableTools.css"> -->
            <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">

        <!-- main styles -->
            <link rel="stylesheet" href="<?php echo $this->config->item("theme"); ?>css/style.css" />
		<!-- theme color-->
            <link rel="stylesheet" href="<?php echo $this->config->item("theme"); ?>css/blue.css" id="link_theme" />

            <link href='http://fonts.googleapis.com/css?family=PT+Sans' rel='stylesheet' type='text/css'>

        <!-- favicon -->
            <link rel="shortcut icon" href="<?php echo $this->config->item("theme"); ?>img/icon.png" />

		 <!-- datatable libs -->
			<script src="<?php echo $this->config->item("theme"); ?>js/jquery-3.3.1.js"></script>
			<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script> 

			<style type="text/css">
				.no-js #loader { display: none;  }
				.js #loader { display: block; position: absolute; left: 100px; top: 0; }
				.page-loader {
					position: fixed;
					left: 0px;
					top: 0px;
					width: 100%;
					height: 100%;
					z-index: 9999;
					background: url(http://keuda.kemendagri.go.id/asset/themes/pemda/img/Preloader_3.gif) center no-repeat #fff;
				}
				.AppsMsg {
					position: fixed;
					z-index: 9999;
				}
			</style>

			<script>
				$(document).ready(function(){
					$(".page-loader").fadeOut("slow");
				});

				var baseurl = '<?php echo base_url(); ?>';

				function setDetailData(wfcat,wfnum){
					if(wfcat == 'WF01'){
						location.href = baseurl+'ranperda/kabkot/'+wfnum;
					}
					if(wfcat == 'WF02'){
						location.href = baseurl+'ranperda/provin/'+wfnum;
					}
				}
			</script>
    </head>
    <body class="full_width sidebar_hidden">	
        <div id="maincontainer" class="clearfix">

            <header>

				<?php $this->load->view('navigation'); ?>

				<div class="modal fade" id="zmdlReason">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
								<h3 class="modal-title">Reject Document</h3>
							</div>
							<div class="modal-body">
								<div class="form-group">
									<input type="hidden" id="txtReasonCurrst" >
									<input type="hidden" id="txtReasonNextst" >
									<label for="email">Alasan tentang mengapa documen ditolak!</label>
									<textarea id="txtReason" class="input-sm form-control"></textarea>
								</div>
							</div>
							<div class="modal-footer">
								<button type="button" id="btnReason" class="btn btn-default">Submit</button>
							</div>
						</div>
					</div>
				</div>

			</header>
            <div id="contentwrapper">
                <div class="main_content">
					<div class="page-loader"></div>
					<?php $this->load->view($content);?>            
                </div>
            </div>
        </div>

	<div class="modal fade" id="myNotification">
		<div class="modal-dialog">
			<div class="modal-content">
				<div id="dataModal"></div>
			</div>
		</div>
	</div>

    <!-- touch events for jquery ui-->
	<script src="<?php echo $this->config->item("theme"); ?>js/forms/jquery.ui.touch-punch.min.js"></script>
    <!-- easing plugin -->
	<script src="<?php echo $this->config->item("theme"); ?>js/jquery.easing.1.3.min.js"></script>
    <!-- smart resize event -->
	<script src="<?php echo $this->config->item("theme"); ?>js/jquery.debouncedresize.min.js"></script>
    <!-- js cookie plugin -->
	<script src="<?php echo $this->config->item("theme"); ?>js/jquery_cookie_min.js"></script>
    <!-- main bootstrap js -->
	<script src="<?php echo $this->config->item("theme"); ?>bootstrap/js/bootstrap.min.js"></script>
    <!-- bootstrap plugins -->
	<script src="<?php echo $this->config->item("theme"); ?>js/bootstrap.plugins.min.js"></script>
	<!-- typeahead -->
	<script src="<?php echo $this->config->item("theme"); ?>lib/typeahead/typeahead.min.js"></script>
	<!-- datepicker -->
	<script src="<?php echo $this->config->item("theme"); ?>lib/datepicker/bootstrap-datepicker.min.js"></script>
	<!-- <script src="<?php echo $this->config->item("theme"); ?>lib/uniform/jquery.uniform.min.js"></script> -->
	<script src="<?php echo $this->config->item("theme"); ?>js/sispensi.js"></script>

    </body>
</html>


