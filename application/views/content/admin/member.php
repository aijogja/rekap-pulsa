<h3>Member</h3>

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
    <li <?php if($this->uri->segment(3) == 'view' || $this->uri->segment(3) == '') echo "class='active'" ?>><a href="<?php echo site_url('admin/'.$this->uri->segment(2)); ?>">View Member</a></li>
    <li <?php if($this->uri->segment(3) == 'add') echo "class='active'" ?>><a href="<?php echo site_url('admin/'.$this->uri->segment(2).'/add'); ?>">Add Member</a></li>
    <?php if($this->uri->segment(3)=='edit'): ?>
    <li class='active'><a href="<?php echo current_url() ?>">Edit Member</a></li>
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
            <input type="text" name="nama_member" value="<?php echo set_value('nama_member', isset($default['nama_member'])?$default['nama_member']:''); ?>" class="span3" />
        	</div> 
        </div>  
        <div class="control-group">
            <label class="control-label">No Hape</label>               
            <div class="controls">             
            <input type="text" name="hape" value="<?php echo set_value('hape', isset($default['hape'])?$default['hape']:''); ?>" class="span3" />
        	</div> 
        </div>  
        <div class="control-group">
            <label class="control-label">Email</label>               
            <div class="controls">             
            <input type="text" name="email" value="<?php echo set_value('email', isset($default['email'])?$default['email']:''); ?>" class="span3" />
        	</div> 
        </div>  
        <div class="control-group">
            <label class="control-label">Balance</label>               
            <div class="controls">             
            <input type="text" name="balance" value="<?php echo set_value('balance'); ?>" class="span3" />
        	</div> 
        </div>  
        <div class="control-group">
            <label class="control-label">Hutang (lama)</label>               
            <div class="controls">             
            <input type="text" name="hutang_2012" value="<?php echo set_value('hutang_2012', isset($default['hutang_2012'])?$default['hutang_2012']:''); ?>" class="span3" />
            <p class="text-info"><em>* Hutang yang belum masuk rekap sistem.</em></p>
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

    <form class="form-search" method="post" action="">
    	<div class="input-append">
            <input type="text" name="cari" class="span14 input-medium search-query" placeholder="  Nama, No Hape, Email ... !!!">
            <button class="btn" type="submit">Cari</button>
        </div>
    </form>
    
    <h5>Total Hutang : <?php echo format_amount($totalnya['hutang_2012']); ?></h5>

	<table class="table table-condensed table-striped">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Hape</th>
            <th>Email</th>
            <th>Balance</th>
            <th>Hutang 2012</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
    	<?php if(!empty($data_query)):?>
        <?php $i=1+$this->uri->segment(4);?>
			<?php foreach($data_query as $dt):?>
                <tr>	
                    <td><?php echo $i++ ?></td>
                    <td><?php echo $dt['nama_member'] ?></td>
                    <td><?php echo $dt['hape'] ?></td>
                    <td><?php echo $dt['email'] ?></td>
                    <td><?php echo format_amount($dt['balance']) ?></td>
                    <td><?php echo format_amount($dt['hutang_2012']) ?></td>
                    <td>
                        <a href="<?php echo site_url('admin/'.$this->uri->segment(2).'/edit/'.$dt['idmember']); ?>" class="btn btn-info btn-mini">Edit</a>
                   		<a href="<?php echo site_url('admin/'.$this->uri->segment(2).'/delete/'.$dt['idmember']); ?>" onclick="return confirmDelete()" class="btn btn-danger btn-mini">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
        		<tr>	
                    <td colspan="7" class="nodata muted">No Data</td>
                </tr>
        <?php endif; ?>        
    </tbody>
    </table>
    <?php echo !empty($paging)? $paging : '' ; ?>
    
<?php endif; ?>