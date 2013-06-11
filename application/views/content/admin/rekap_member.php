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

<!-- Modal -->
<div id="hutangnya" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="Hutanf" aria-hidden="true">
    <div class="modal-header">
    	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    	<h5 id="myModalLabel">Detail Hutang</h5>
    </div>
    <div class="modal-body">
		<table class="table table-condensed table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Kode</th>
                    <th>No Tujuan</th>
                    <th>Total</th>                    
            	</tr>
            </thead>
            <tbody id="detail_hutang_body">
                
            </tbody>  
            <tfoot id="detail_hutang_foot">
            </tfoot>  
        </table>
    </div>
    <div class="modal-footer">
    </div>
</div>

