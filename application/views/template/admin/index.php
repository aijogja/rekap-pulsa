<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo get_setting('nama_celluler'); ?></title>
<base href="<?php echo base_url('') ?>" />
<link href="assets/css/bootstrap.css" rel="stylesheet" />
<link href="assets/css/bootstrap-responsive.css" rel="stylesheet" />
<link href="assets/css/jquery-ui-1.8.16.custom.css" rel="stylesheet" />
<style type="text/css">
	body {padding-top: 60px; padding-bottom: 40px;}
	.form-signin {
		text-align:center;
        max-width: 250px;
        padding: 19px 29px 29px;
        margin: 100px auto;
        background-color: #fff;
        border: 1px solid #e5e5e5;
        -webkit-border-radius: 5px;
           -moz-border-radius: 5px;
                border-radius: 5px;
        -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.05);
           -moz-box-shadow: 0 1px 2px rgba(0,0,0,.05);
                box-shadow: 0 1px 2px rgba(0,0,0,.05);
	}
	.form-signin .form-signin-heading, .form-signin .checkbox {margin-bottom: 10px;}
	.form-signin input[type="text"], .form-signin input[type="password"] {font-size: 16px; height: auto; margin-bottom: 15px; padding: 7px 9px;}
	.show_total {width:100px; display:inline-block;}
	.ratanya {width:90px; display:inline-block; text-align:right;}
	td.nodata {text-align:center}
</style>
</head>

<body>
	<?php if($this->session->userdata('logged_in') === TRUE): ?>
	<!--NavBar-->
	<div class="navbar navbar-fixed-top">
    	<div class="navbar-inner">
        	<div class="container">
				<a class="brand" href="<?php echo base_url(); ?>"><?php echo get_setting('nama_celluler'); ?></a>                
                <!--User Menu-->
                <div class="btn-group pull-right">
                	<a href="" class="btn dropdown-toggle" data-toggle="dropdown"><i class="icon-user"></i> <?php echo $this->session->userdata('user') ?> <b class="caret"></b></a>
                   	<ul class="dropdown-menu">
                    	<li><a href="admin/setting"><i class="icon-cog"></i> Setting</a></li>
                    	<li><a href="logout"><i class="icon-off"></i> Logout</a></li>
                    </ul>
                </div>
                <!--End User Menu-->
            </div>
        </div>
    </div>
    <!--End NavBar-->
	<div class="container">
        <div class="row-fluid">
            <div class="span3">
           		<div class="well sidebar-nav">
                    <?php $this->load->view('template/admin/sidebar'); ?>   
                </div>
            </div>
            <div class="span9">          
                <div class="row-fluid">
                    <div class="span12">
                    	<?php $this->load->view('content/admin/'.$main_content); ?>
                    </div>
                </div>
            </div>
        </div>      
        
    	<hr>
        <footer>
        <p>&copy; 2013 <?php echo get_setting('nama_celluler'); ?></p>
        </footer>	
    </div>  
    <?php else: ?>
    <div class="container">
        <form action="" method="post" class="form-signin">
            <legend class="form-signin-heading">Admin Login</legend>
            <input type="text" name="email" value="" class="input-block-level" placeholder="Email address">
            <input type="password" name="password" value="" class="input-block-level" placeholder="Password">
            <input type="submit" name="login" value="Login" class="btn btn-info span2" />
        </form>
    </div> <!-- /container -->   
    <?php endif; ?>   
</body>

<!--Load JS-->
<script src="assets/js/jquery-1.7.2.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/jquery-ui-1.8.16.custom.min.js"></script>

<?php if($this->session->userdata('logged_in') === TRUE): ?>
<script type="text/JavaScript">
$(function(){ 
	
});

function confirmDelete(){
	var agree = confirm("Are you sure you want to delete this?");
	if (agree)
		 return true ;
	else
		 return false ;
}

function get_harga(id){	
	if(id){
		var a="<?php echo site_url('admin/transaksi/get_harga_by_kode') ?>" + "/" + id;		
		$.ajax ({
			url: a ,
			success: function(msg){
				$("#total").val(msg)
			}
		});
	}		
}

function get_transaksi(urlnya,month){		
	var a= urlnya + "/" + month;
	$.ajax ({
		url: a ,
		success: function(msg){
			window.location = msg;
		}
	});	
}

function hutangnya(id){		
	var url="<?php echo site_url('admin/rekap_member/hutangnya') ?>" + "/" + id;	
	$.ajax ({
		url: url ,
		success: function(msg){
			var data = $.parseJSON(msg);
			$(".modal-footer").html(data.button);
			$("#detail_hutang_body").html(data.tbody);
			$("#detail_hutang_foot").html(data.tfoot);
			$('#hutangnya').modal({
				show : true,
				backdrop : 'static',
			});
		}
	});	
}

function send_tagihan(){
	var url=$('.send_mail').attr("href");
	$.ajax ({
		url: url ,
		success: function(msg){
			if(msg == 'sukses'){
				alert('Tagihan telah dikirim ke email member.');
			} else {
				alert('Email gagal terkirim.');
			}
			
			$('#hutangnya').modal('hide'); 		
		}
	});			
}

function tampilkan_tglbayar(status){
	if(status == 1){
		$("#tgl_bayar").show();
	} else {
		$('input[name="tgl_bayar"]').val('');
		$("#tgl_bayar").hide();
	}
}
</script>
<!--JQuery UI Date Picker-->
<script>
	$(function(){
						
		$(".datepick").datepicker({
			changeMonth: true,
			changeYear: true,
			firstDay: 1,
			yearRange: "1945:c"
		});	
		
		$(".monthly").datepicker({
			changeMonth: true,
			changeYear: true,
			showButtonPanel: true,
			dateFormat: 'MM yy',
			onClose: function(dateText, inst) { 				
				var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
				var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
				$(this).datepicker('setDate', new Date(year, month, 1));				
				
				get_transaksi( $( ".urlnya" ).val(), $( ".monthly" ).val());
			},					
			
			/*beforeShow: function(input, inst) { 
				$('.ui-datepicker-calendar').css('display','none');
			}*/
		});		
				
	});	
</script>
<!--JQuery UI Auto Complete-->
<script>
	(function( $ ) {
		$.widget( "ui.combobox", {
			_create: function() {
				var input,
					self = this,
					select = this.element.hide(),
					selected = select.children( ":selected" ),
					value = selected.val() ? selected.text() : "",
					wrapper = $( "<span>" )
						.addClass( "ui-combobox" )
						.insertAfter( select );

				input = $( "<input>" )
					.appendTo( wrapper )
					.val( value )
					.addClass( "ui-state-default" )
					.autocomplete({
						delay: 0,
						minLength: 0,
						source: function( request, response ) {
							var matcher = new RegExp( $.ui.autocomplete.escapeRegex(request.term), "i" );
							response( select.children( "option" ).map(function() {
								var text = $( this ).text();
								if ( this.value && ( !request.term || matcher.test(text) ) )
									return {
										label: text.replace(
											new RegExp(
												"(?![^&;]+;)(?!<[^<>]*)(" +
												$.ui.autocomplete.escapeRegex(request.term) +
												")(?![^<>]*>)(?![^&;]+;)", "gi"
											), "<strong>$1</strong>" ),
										value: text,
										option: this
									};
							}) );
						},
						select: function( event, ui ) {
							ui.item.option.selected = true;
							self._trigger( "selected", event, {
								item: ui.item.option
							});
						},
						change: function( event, ui ) {
							get_harga($('#kodeautocomplete').val());
							
							if ( !ui.item ) {
								var matcher = new RegExp( "^" + $.ui.autocomplete.escapeRegex( $(this).val() ) + "$", "i" ),
									valid = false;
								select.children( "option" ).each(function() {
									if ( $( this ).text().match( matcher ) ) {
										this.selected = valid = true;
										return false;
									}
								});
								if ( !valid ) {
									// remove invalid value, as it didn't match anything
									$( this ).val( "" );
									$("#total").val('')
									select.val( "" );
									input.data( "autocomplete" ).term = "";
									return false;
								}
							}
						}
					})
					.addClass( "ui-widget ui-widget-content ui-corner-left" );

				input.data( "autocomplete" )._renderItem = function( ul, item ) {
					return $( "<li></li>" )
						.data( "item.autocomplete", item )
						.append( "<a>" + item.label + "</a>" )
						.appendTo( ul );
				};				
			},

			destroy: function() {
				this.wrapper.remove();
				this.element.show();
				$.Widget.prototype.destroy.call( this );
			}
		});
	})( jQuery );

	var notujuan = <?php echo json_encode(get_no_tujuan()) ?>;
	var nama_member = <?php echo json_encode(get_member('nama_member')) ?>;

	$(function() {
		$( "#memberautocomplete" ).combobox();
		$( "#kodeautocomplete" ).combobox();
		$( "#notujuan" ).autocomplete({
			source: notujuan
		});
		$( "#nama_member" ).autocomplete({
			source: nama_member
		});
	});
</script>  
<?php endif; ?>
</html>
