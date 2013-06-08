<h3>Admin Management</h3>
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

<!-- Menampilakan Tab -->
<ul class="nav nav-tabs">
    <li <?php if($this->uri->segment(3) == '') echo "class='active'" ?>><a href="<?php echo site_url('admin/'.$this->uri->segment(2).'/'); ?>">View Admin</a></li>
    <li <?php if($this->uri->segment(3) == 'add') echo "class='active'" ?>><a href="<?php echo site_url('admin/'.$this->uri->segment(2).'/add'); ?>">Add Admin</a></li>
    <?php if($this->uri->segment(3) == 'edit'): ?>
    <li class='active'><a href="<?php echo current_url() ?>">Edit Admin</a></li>
    <?php endif; ?>
</ul>
<!-- End Menampilkan Tab -->

<?php if($this->uri->segment(3)=='add' || $this->uri->segment(3)=='edit'): ?>

<?php if(validation_errors()): ?>
	<div class="alert alert-error">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <?php echo validation_errors(); ?>
    </div>
<?php endif?>
                
	<form action="" method="post">
        <fieldset>   
        	<div class="control-group">
                <label class="control-label">Nama</label>                
                <div class="controls">
                <input type="text" name="user" class="span8" value="<?php echo set_value('user', isset($default['user'])?$default['user']:''); ?>"  />
                </div>
            </div>   
        	<div class="control-group">
                <label class="control-label">Email</label>                
                <div class="controls">
                <input type="text" name="email" class="span8" value="<?php echo set_value('email', isset($default['email'])?$default['email']:''); ?>" <?php if($this->uri->segment(4) == 'edit') echo "disabled='disabled'";  ?> />
                </div>
            </div>  
        	<div class="control-group">
                <label class="control-label">Password</label>                
                <div class="controls">
                <input type="password" name="pass" class="span8" value="" <?php if($this->uri->segment(3) == 'edit') echo "disabled='disabled'";  ?> />
                </div>
            </div>   
        	<div class="control-group">
                <label class="control-label">Re-Password</label>                
                <div class="controls">
                <input type="password" name="repassword" class="span8" value="" <?php if($this->uri->segment(3) == 'edit') echo "disabled='disabled'";  ?> />
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
    
<?php else: ?>

	<table class="table table-condensed table-striped">
    <thead>
        <tr>
            <th>No</th>
            <th>Username</th>
            <th>Email</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
    	<?php if($data_query): $i=1; ?>
			<?php foreach($data_query as $dt):?>
                <tr>	
                    <td><?php echo $i++ ?></td>
                    <td><?php echo !empty($dt['user'])? $dt['user'] : ''; ?></td>
                    <td><?php echo !empty($dt['email'])? $dt['email'] : ''; ?></td>
                    <td>
                        <a href="<?php echo site_url('admin/'.$this->uri->segment(2).'/'.$this->uri->segment(3).'/edit/'.$dt['idadmin']); ?>" class="btn btn-info btn-mini">Edit</a>
                        <?php if($dt['idadmin'] != 0): ?>
                   		<a href="<?php echo site_url('admin/'.$this->uri->segment(2).'/'.$this->uri->segment(3).'/delete/'.$dt['idadmin']); ?>" onclick="return confirmDelete()" class="btn btn-danger btn-mini">Delete</a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
        		<tr>	
                    <td colspan="4" class="nodata muted">No Data</td>
                </tr>
        <?php endif; ?>        
    </tbody>
    </table>
    
<?php endif; ?>