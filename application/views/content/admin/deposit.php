<h3>Deposit</h3>

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
    <li <?php if($this->uri->segment(3) == 'view' || $this->uri->segment(3) == '') echo "class='active'" ?>><a href="<?php echo site_url('admin/'.$this->uri->segment(2).'/view'); ?>">View Deposit</a></li>
    <li <?php if($this->uri->segment(3) == 'add') echo "class='active'" ?>><a href="<?php echo site_url('admin/'.$this->uri->segment(2).'/add'); ?>">Add Deposit</a></li>
    <?php if($this->uri->segment(3)=='edit'): ?>
    <li class='active'><a href="<?php echo current_url() ?>">Edit Deposit</a></li>
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
            <label class="control-label">Nominal</label>               
            <div class="controls">             
            <input type="text" name="nominal" value="<?php echo set_value('nominal', isset($default['nominal'])?$default['nominal']:''); ?>" class="span3" />
        	</div> 
        </div>           
        <div class="control-group">
            <label class="control-label">Tanggal</label>               
            <div class="controls">             
            <input type="text" name="tgl" value="<?php echo set_value('tgl', isset($default['tgl'])? date('m/d/Y',$default['tgl']):''); ?>" class="span3 datepick" />
        	</div> 
        </div>  
        <div class="control-group">
            <label class="control-label">Status</label>               
            <div class="controls">             
            <select name="status" class="span2" onchange="tampilkan_tglbayar(this.value)">
                <option value="0" <?php echo set_select('status', 0, isset($default['status']) && $default['status'] == 0 ? TRUE : FALSE); ?>>Terhutang</option>
                <option value="1" <?php echo set_select('status', 1, isset($default['status']) && $default['status'] == 1 ? TRUE : FALSE); ?>>Lunas</option>
            </select>
        	</div> 
        </div>                   
        <div class="control-group" id="tgl_bayar" <?php echo (isset($default['status']) && $default['status'] == 1)? '' : 'style="display:none"'; ?>>
            <label class="control-label">Tanggal Bayar</label>               
            <div class="controls">             
            <input type="text" name="tgl_bayar" value="<?php echo set_value('tgl_bayar', isset($default['tgl_bayar'])? date('m/d/Y',$default['tgl_bayar']):''); ?>" class="span3 datepick" />
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

<style>
.ui-datepicker-calendar {
    display: none;
    }
</style>

<div class="control-group">
    <label class="control-label">Pilih Bulan</label>               
    <div class="controls">   
    <input type="hidden" class="urlnya" value="<?php echo site_url('admin/deposit/get_deposit_by_month'); ?>" />          
    <input type="text" name="bulan" value="<?php echo $this->session->userdata('bulan'); ?>" class="span3 monthly" />
    </div> 
</div> 

<?php if($this->session->userdata('bulan')): ?>

<h5>
<div><span class="show_total">Terhutang</span> : <?php echo format_amount($totalnya['terhutang']); ?></div>
<div><span class="show_total">Lunas</span> : <?php echo format_amount($totalnya['lunas']); ?></div>
<div><span class="show_total">Totalnya</span> : <?php echo format_amount($totalnya['total']); ?></div>
</h5>

	<table class="table table-condensed table-striped">
    <thead>
        <tr>
            <th>No</th>
            <th>Tanggal</th>
            <th>Nominal</th>
            <th>Status</th>
            <th>Tanggal Bayar</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
    	<?php if(!empty($data_query)):?>
        <?php $i=1+$this->uri->segment(4);?>
			<?php foreach($data_query as $dt):?>
                <tr>	
                    <td><?php echo $i++ ?></td>
                    <td><?php echo date('d/m/Y',$dt['tgl']) ?></td>
                    <td><?php echo format_amount($dt['nominal']) ?></td>
                    <td><?php echo ($dt['status'] == 0)? 'Terhutang' : 'Lunas' ?></td>                    
                    <td><?php echo (isset($dt['tgl_bayar']))? date('d/m/Y',$dt['tgl_bayar'])  : '-' ?></td>
                    <td>
                        <a href="<?php echo site_url('admin/'.$this->uri->segment(2).'/edit/'.$dt['iddeposit']); ?>" class="btn btn-info btn-mini">Edit</a>
                   		<a href="<?php echo site_url('admin/'.$this->uri->segment(2).'/delete/'.$dt['iddeposit']); ?>" onclick="return confirmDelete()" class="btn btn-danger btn-mini">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
        		<tr>	
                    <td colspan="6" class="nodata muted">No Data</td>
                </tr>
        <?php endif; ?>        
    </tbody>
    </table>
    <?php echo !empty($paging)? $paging : '' ; ?>
    
    <?php if(!empty($data_query)):?>
	<a href="<?php echo site_url('admin/'.$this->uri->segment(2).'/export'); ?>" class="btn btn-success btn-mini">Export .xls</a>
    <?php endif ?>
    
<?php endif; ?>
<?php endif; ?>