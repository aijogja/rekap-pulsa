<h3>Setting</h3>

<!-- Menampilkan Flashdata -->
<?php 
$flashdata = $this->session->flashdata('simpan');
if($flashdata['status'] == 'success'):
?>
<div class="alert alert-success">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
	<?php echo $flashdata['message']; ?>
</div>
<?php elseif($flashdata['status'] == 'failed'): ?>
<div class="alert alert-error">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
	<?php echo $flashdata['message']; ?>
</div>
<?php endif; ?>
<!-- End Menampilkan Flashdata -->

<?php if(validation_errors()): ?>
	<div class="alert alert-error">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <?php echo validation_errors(); ?>
    </div>
<?php endif?>

	<form action="" method="post" enctype="multipart/form-data">
		<fieldset>                    	
            <div class="control-group">
                <label class="control-label">Nama Celluler</label>                
                <div class="controls">
                <input type="text" name="nama_celluler" value="<?php echo set_value('nama_celluler', isset($default['nama_celluler'])?$default['nama_celluler']:''); ?>" class="span6" placeholder="ex : Ai Celluler" />
                </div>
            </div> 
            <div class="control-group">
                <label class="control-label">Email</label>                
                <div class="controls">
                <input type="text" name="email" value="<?php echo set_value('email', isset($default['email'])?$default['email']:''); ?>" class="span6" placeholder="Email untuk kirim email" />
                </div>
            </div>                                   
            <div class="control-group">
                <div class="controls">
                <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
       </fieldset>
    </form>