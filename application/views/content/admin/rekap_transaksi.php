<h3>Rekap Transaksi</h3>

<style>
.ui-datepicker-calendar {
    display: none;
    }
</style>

<div class="control-group">
    <label class="control-label">Pilih Bulan</label>               
    <div class="controls">  
    <input type="hidden" class="urlnya" value="<?php echo site_url('admin/rekap_transaksi/per_month'); ?>" />           
    <input type="text" name="bulan" value="<?php echo $this->session->userdata('bulan'); ?>" class="span3 monthly" />
    </div> 
</div> 

<?php if($this->session->userdata('bulan')): ?>

<!-- Menampilakan Tab -->
<ul class="nav nav-tabs">
    <li <?php if($this->uri->segment(3) == 'terhutang') echo "class='active'" ?>><a href="<?php echo site_url('admin/'.$this->uri->segment(2).'/terhutang'); ?>">Terhutang</a></li>
    <li <?php if($this->uri->segment(3) == 'lunas') echo "class='active'" ?>><a href="<?php echo site_url('admin/'.$this->uri->segment(2).'/lunas'); ?>">Lunas</a></li>
</ul>
<!-- End Menampilkan Tab -->

<style>
.ui-datepicker-calendar {
    display: none;
    }
</style>

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
        </tr>
    </thead>
    <tbody>
    	<?php if(!empty($data_query)):?>
        <?php $i=1+$this->uri->segment(4);?>
			<?php foreach($data_query as $dt):?>
                <tr>	
                    <td><?php echo $i++ ?></td>
                    <td><?php echo date('d/m/Y',$dt['tgl']) ?></td>
                    <td><?php echo $dt['nama_member'] ?></td>
                    <td><?php echo $dt['kode'] ?></td>
                    <td><?php echo $dt['no_tujuan'] ?></td>
                    <td><?php echo format_amount($dt['total']) ?></td>
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
 
 <?php endif; ?>