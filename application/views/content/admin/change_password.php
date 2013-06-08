<h3>Change Password</h3>

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

<?php if(validation_errors()): ?>
	<div class="alert alert-error">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <?php echo validation_errors(); ?>
    </div>
<?php endif?>
                
<form action="" method="post">
    <fieldset>        
    	<div class="control-group">
            <label class="control-label">Username</label>                
            <div class="controls">
            <input type="text" name="user" class="span8" value="<?php echo set_value('user', isset($default['user'])?$default['user']:''); ?>"  />
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">New Password</label>                
            <div class="controls">
            <input type="password" name="password" class="span8" value=""  />
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Confirm Password</label>                
            <div class="controls">
            <input type="password" name="repassword" class="span8" value=""  />
            </div>
        </div>
        <div class="control-group">
            <div class="controls">
            <input type="hidden" name="simpan" value="simpan" />
            <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </div>
   </fieldset>
</form>