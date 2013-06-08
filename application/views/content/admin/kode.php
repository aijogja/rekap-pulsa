<h3>Kode Pulsa</h3>

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
    <li <?php if($this->uri->segment(3) == 'view' || $this->uri->segment(3) == '') echo "class='active'" ?>><a href="<?php echo site_url('admin/'.$this->uri->segment(2)); ?>">View Kode</a></li>
    <li <?php if($this->uri->segment(3) == 'add') echo "class='active'" ?>><a href="<?php echo site_url('admin/'.$this->uri->segment(2).'/add'); ?>">Add Kode</a></li>
    <?php if($this->uri->segment(3)=='edit'): ?>
    <li class='active'><a href="<?php echo current_url() ?>">Edit Kode</a></li>
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
            <label class="control-label">Kode</label>               
            <div class="controls">             
            <input type="text" name="kode" value="<?php echo set_value('kode', isset($default['kode'])?$default['kode']:''); ?>" class="span2" />
        	</div> 
        </div>  
        <div class="control-group">
            <label class="control-label">Provider</label>               
            <div class="controls">             
            <input type="text" name="provider" value="<?php echo set_value('provider', isset($default['provider'])?$default['provider']:''); ?>" class="span3" />
        	</div> 
        </div>  
        <div class="control-group">
            <label class="control-label">Harga</label>               
            <div class="controls">             
            <input type="text" name="harga" value="<?php echo set_value('harga', isset($default['harga'])?$default['harga']:''); ?>" class="span3" />
        	</div> 
        </div>                    	                    	                   
        <div class="control-group">
            <div class="controls">
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
            <th>Kode</th>
            <th>Provider</th>
            <th>Harga</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
    	<?php if(!empty($data_query)):?>
        <?php $i=1+$this->uri->segment(4);?>
			<?php foreach($data_query as $dt):?>
                <tr>	
                    <td><?php echo $i++ ?></td>
                    <td><?php echo $dt['kode'] ?></td>
                    <td><?php echo $dt['provider'] ?></td>
                    <td><?php echo format_amount($dt['harga']) ?></td>
                    <td>
                        <a href="<?php echo site_url('admin/'.$this->uri->segment(2).'/edit/'.$dt['idkode']); ?>" class="btn btn-info btn-mini">Edit</a>
                   		<a href="<?php echo site_url('admin/'.$this->uri->segment(2).'/delete/'.$dt['idkode']); ?>" onclick="return confirmDelete()" class="btn btn-danger btn-mini">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
        		<tr>	
                    <td colspan="5" class="nodata muted">No Data</td>
                </tr>
        <?php endif; ?>        
    </tbody>
    </table>
    <?php echo !empty($paging)? $paging : '' ; ?>
    
<?php endif; ?>