<h3>Transaksi</h3>

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
    <li <?php if($this->uri->segment(3) == 'view' || $this->uri->segment(3) == '') echo "class='active'" ?>><a href="<?php echo site_url('admin/'.$this->uri->segment(2).'/view'); ?>">View Transaksi</a></li>
    <li <?php if($this->uri->segment(3) == 'add') echo "class='active'" ?>><a href="<?php echo site_url('admin/'.$this->uri->segment(2).'/add'); ?>">Add Transaksi</a></li>
    <?php if($this->uri->segment(3)=='edit'): ?>
    <li class='active'><a href="<?php echo current_url() ?>">Edit Transaksi</a></li>
    <?php endif; ?>
    <?php if($this->uri->segment(3)=='cari'): ?>
    <li class='active'><a href="<?php echo current_url() ?>">Cari</a></li>
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
            <label class="control-label">Member</label>               
            <div class="controls">             
            <select name="membernya" class="span3" id="memberautocomplete">
                <option value="" >- Pilih Member -</option>
                <?php foreach(get_member() as $member): ?>
                <option value="<?php echo $member['idmember'] ?>" <?php echo set_select('membernya', $member['idmember'], isset($default['membernya']) && $default['membernya'] == $member['idmember'] ? TRUE : FALSE); ?>><?php echo $member['nama_member'] ?></option>
                <?php endforeach; ?>
            </select>
        	</div> 
        </div>  
        <div class="control-group">
            <label class="control-label">Kode</label>               
            <div class="controls">             
            <select name="kodenya" class="span2" id="kodeautocomplete">
                <option value="" >- Pilih Kode -</option>
                <?php foreach(get_kode() as $kode): ?>
                <option value="<?php echo $kode['idkode'] ?>" <?php echo set_select('kodenya', $kode['idkode'], isset($default['kodenya']) && $default['kodenya'] == $kode['idkode'] ? TRUE : FALSE); ?>><?php echo $kode['kode'] ?></option>
                <?php endforeach; ?>
            </select>
        	</div> 
        </div>  
        <div class="control-group">
            <label class="control-label">No Tujuan</label>               
            <div class="controls">             
            <input type="text" name="no_tujuan" id="notujuan" value="<?php echo set_value('no_tujuan', isset($default['no_tujuan'])?$default['no_tujuan']:''); ?>" class="span3" />
        	</div> 
        </div>  
        <div class="control-group">
            <label class="control-label">SN</label>               
            <div class="controls">             
            <input type="text" name="sn" value="<?php echo set_value('sn', isset($default['sn'])?$default['sn']:''); ?>" class="span3" />
        	</div> 
        </div>  
        <div class="control-group">
            <label class="control-label">Tanggal</label>               
            <div class="controls">             
            <input type="text" name="tgl" value="<?php echo set_value('tgl', isset($default['tgl'])? date('m/d/Y',$default['tgl']):''); ?>" class="span3 datepick" />
        	</div> 
        </div>  
        <div class="control-group">
            <label class="control-label">Total</label>               
            <div class="controls">             
            <input type="text" name="total" id="total" value="<?php echo set_value('total', isset($default['total'])?$default['total']:''); ?>" readonly="readonly" class="span3" />
        	</div> 
        </div>  
        <div class="control-group">
            <label class="control-label">Status</label>               
            <div class="controls">             
            <select name="status" class="span2">
                <option value="0" <?php echo set_select('status', 0, isset($default['status']) && $default['status'] == 0 ? TRUE : FALSE); ?>>Terhutang</option>
                <option value="1" <?php echo set_select('status', 1, isset($default['status']) && $default['status'] == 1 ? TRUE : FALSE); ?>>Lunas</option>
            </select>
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
    <input type="hidden" class="urlnya" value="<?php echo site_url('admin/transaksi/get_transaksi_by_month'); ?>" />          
    <input type="text" name="bulan" value="<?php echo $this->session->userdata('bulan'); ?>" class="span3 monthly" />
    </div> 
</div> 

<?php if($this->session->userdata('bulan')): ?>

    <form class="form-search" method="post" action="admin/transaksi/cari">
        <div class="input-append">
            <input type="text" name="cari" id="nama_member" class="span14 input-medium search-query" placeholder="  Cari berdasarkan nama ... !!!">
            <button class="btn" type="submit">Cari</button>
        </div>
    </form>    
	<h5>Totalnya : <?php echo format_amount($totalnya['total']); ?></h5>
	<table class="table table-condensed table-striped">
    <thead>
        <tr>
            <th>No</th>
            <th>Tanggal</th>
            <th>Nama</th>
            <th>Kode</th>
            <th>No Tujuan</th>
            <th>Harga</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
    	<?php if(!empty($data_query)):?>
			<?php foreach($data_query as $dt):?>
                <tr>	
                    <td><?php echo $i++ ?></td>
                    <td><?php echo date('d/m/Y',$dt['tgl']) ?></td>
                    <td><?php echo $dt['nama_member'] ?></td>
                    <td><?php echo $dt['kode'] ?></td>
                    <td><?php echo $dt['no_tujuan'] ?></td>
                    <td><?php echo format_amount($dt['total']) ?></td>
                    <td><?php echo ($dt['status'] == 0)? 'Terhutang' : 'Lunas' ?></td>
                    <td>
                        <a href="<?php echo site_url('admin/'.$this->uri->segment(2).'/edit/'.$dt['idtransaksi']); ?>" class="btn btn-info btn-mini">Edit</a>
                   		<a href="<?php echo site_url('admin/'.$this->uri->segment(2).'/delete/'.$dt['idtransaksi']); ?>" onclick="return confirmDelete()" class="btn btn-danger btn-mini">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
        		<tr>	
                    <td colspan="8" class="nodata muted">No Data</td>
                </tr>
        <?php endif; ?>        
    </tbody>
    </table>
    <?php echo !empty($paging)? $paging : '' ; ?>  
      
    <?php if(!empty($data_query)):?>
    <?php $member = ($this->uri->segment(3) == 'cari')? $this->uri->segment(4) : '';  ?>
	<a href="<?php echo site_url('admin/'.$this->uri->segment(2).'/export/'.$member); ?>" class="btn btn-success btn-mini">Export .xls</a>
    <?php endif ?>
    
<?php endif; ?>
<?php endif; ?>