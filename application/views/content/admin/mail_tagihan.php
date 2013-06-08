<h4 style='color:#0088CC'>Info detail</h4>
<table>
<tr>
	<td style='width:100px'>No Hape</td>
	<td><?php echo $member['hape'] ?></td>
</tr>
<tr>
	<td>Email</td>
	<td><?php echo $member['email'] ?></td>
</tr>
</table>
<h4 style='color:#0088CC'>Tagihan</h4>
Berikut adalah rincian tagihan Anda sampai <span style='color:#D64B45'><?php echo date('d F Y', time()) ?></span>.
<table style="width:500px; margin-top:10px; border:1px solid #000; border-collapse:collapse;">
<thead>
	<tr style="background:#48AECC">
    	<th>No</th>
        <th>Tanggal</th>
        <th>Kode</th>
        <th>No Tujuan</th>
        <th>Harga</th>
	</tr>
</thead>
<tbody style='border:1px solid #000;'>
	<?php $i=0; ?>
    <?php $totalnya = $total_hutang['total']+$member['hutang_2012']-$member['balance']; ?>
	<?php foreach($tagihan as $tag): $i++; ?>
	<tr <?php if($i%2 == 0) echo "style='background:#D9EDF7'" ?>>
    	<td align="center"><?php echo $i ?></td>
    	<td align="center"><?php echo date('d/m/Y',$tag['tgl']) ?></td>
        <td align="center"><?php echo $tag['kode'] ?></td>
        <td align="center"><?php echo $tag['no_tujuan'] ?></td>
        <td align="center">Rp. <span style='width:90px; display:inline-block; text-align:right'><?php echo number_format($tag['total'],2,',','.') ?></span></td>
    </tr>
    <?php endforeach; ?>

	<tr style='border-top:1px solid #000'><td colspan='4' style="text-align:right; padding-right:20px">Total</td><td align="center" style='background:#D9EDF7; border-left:1px solid #000'>Rp. <span style='width:90px; display:inline-block; text-align:right'><?php echo number_format($total_hutang['total'],2,',','.'); ?></span></td></tr>
    <?php if($member['hutang_2012']): ?>
    <tr><td colspan='4' style="text-align:right; padding-right:20px">Hutang 2012</td><td align="center" style='background:#D9EDF7; border-left:1px solid #000'>Rp. <span style='width:90px; display:inline-block; text-align:right'><?php echo number_format($member['hutang_2012'],2,',','.'); ?></span></td></tr>
    <?php endif; ?>    
	<tr><td colspan='4' style="text-align:right; padding-right:20px">Balance</td><td align="center" style='color:#5CB65C; background:#D9EDF7; border-left:1px solid #000'>Rp. <span style='width:90px; display:inline-block; text-align:right'><?php echo number_format($member['balance'],2,',','.'); ?></span></td></tr>
    <tr><td colspan='4' style="text-align:right; padding-right:20px">Total Hutang</td><td align="center" style='border-top:1px solid #000; border-left:1px solid #000; color:#D64B45; background:#D9EDF7'>Rp. <span style='width:90px; display:inline-block; text-align:right'><?php echo number_format($totalnya,2,',','.'); ?></span></td></tr>
</tbody>
</table>
<br />
Demikian informasi dari kami. Jika Anda merasa ada transaksi yang mencurigakan, tidak usah segan-segan untuk menghubungi kami. Terima kasih.<br /><br />

<?php echo get_setting('nama_celluler') ?>

