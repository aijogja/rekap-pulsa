<h3>Rekap Member</h3>

<!-- Menampilakan Tab -->
<ul class="nav nav-tabs">
    <li <?php if($this->uri->segment(3) == '' || $this->uri->segment(3) == 'view') echo "class='active'" ?>><a href="<?php echo site_url('admin/'.$this->uri->segment(2)); ?>">Member Terhutang</a></li>
</ul>
<!-- End Menampilkan Tab -->

<table class="table table-condensed table-striped">
<thead>
    <tr>
        <th>No</th>
        <th>Member</th>
        <th>Hutang</th>
    </tr>
</thead>
<tbody>
    <?php if(!empty($data_query)):?>
    <?php $i=1+$this->uri->segment(4);?>
        <?php foreach($data_query as $dt):?>
            <tr>	
            	<?php if($dt['idmember'] && ($dt['hutang']+$dt['hutang_lama'])) $actionya = "onclick=\"hutangnya('".$dt['idmember']."')\""; else $actionya = ""; ?>
                <td><?php echo $i++ ?></td>
                <td><span <?php echo $actionya ?> style="cursor:pointer"><?php echo $dt['nama_member'] ?></span></td>
                <td><?php echo format_amount($dt['hutang']+$dt['hutang_lama']) ?></td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
            <tr>	
                <td colspan="3" class="nodata muted">No Data</td>
            </tr>
    <?php endif; ?>        
</tbody>
</table>
<?php echo !empty($paging)? $paging : '' ; ?>

<div id="dialog_message" title="Detail Hutang">
	
</div>
