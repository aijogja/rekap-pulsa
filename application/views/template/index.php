<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Ai Celluler</title>
<base href="<?php echo base_url('') ?>" />
<link href="assets/css/bootstrap.css" rel="stylesheet" />
<link href="assets/css/bootstrap-responsive.css" rel="stylesheet" />
<link href="assets/css/jquery-ui-1.8.16.custom.css" rel="stylesheet" />
<style type="text/css">
      body {padding-top: 20px; padding-bottom: 40px;}
	  a.brand {text-decoration:none}
      /* Custom container */
      .container {margin: 0 auto; max-width: 1000px;}      
      /* Customize the navbar links to be fill the entire space of the .navbar */
      .navbar .navbar-inner {padding: 0;}
      .navbar .nav {margin: 0;}
      .navbar .nav li {display: table-cell; width: 1%; float: none;}
	  .navbar .nav li a {font-weight: bold; text-align: center; border-left: 1px solid rgba(255,255,255,.75); border-right: 1px solid rgba(0,0,0,.1);}
      .navbar .nav li:first-child a {border-left: 0; border-radius: 3px 0 0 3px;}
      .navbar .nav li:last-child a {border-right: 0; border-radius: 0 3px 3px 0;}
	  
	  #footer {height: 30px; padding-top:15px;}
      #footer {background-color: #333; color:#FFF}	  
	  
</style>
</head>

<body>
<div class="container">
    <div class="masthead">
        <h3 class="muted"><a href="<?php echo base_url() ?>" class="brand">Ai Celluler</a></h3>
        <div class="navbar">
            <div class="navbar-inner">
                <div class="container">
                    <div class="nav-collapse collapse">
                        <ul class="nav">
                            <li <?php if(!$this->uri->segment(1)) echo "class='active'"; ?>><a href="<?php echo base_url() ?>">Home</a></li>                
                            <li><a href="#">About</a></li>
                            <li><a href="#">Produk</a></li>
                            <li><a href="#">Contact</a></li>
                            <li <?php if($this->uri->segment(2) == 'services') echo "class='active'"; ?>><a href="home/services">Services</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div><!-- /.navbar -->
    </div>
    <div>
        <p class="lead">
        <?php $this->load->view('content/'.$main_content); ?>
        </p>
    </div>
</div> <!-- /container -->  
<div id="footer" class="navbar-fixed-bottom">
    <div class="container">&copy; 2013 Ai Celluler</div>
</div>    
</body>
<!--Load JS-->
<script src="assets/js/jquery-1.7.2.min.js"></script>
<script src="assets/bootstrap/js/bootstrap.min.js"></script>
<script src="assets/js/jquery-ui-1.8.16.custom.min.js"></script>

<script type="text/JavaScript"> 
$(function(){
	$( "#dialog:ui-dialog" ).dialog( "destroy" );
	$( "#dialog" ).dialog({
		autoOpen: false,      
		modal:true,
		closeOnEscape:false
    });
	
	$( "#cek_hape" ).click(function() {
		var nope = $('input[name="nope"]').val();
		if(nope){
			$( "#dialog" ).dialog( "open" );
		}
    });
})

</script>
</html>
