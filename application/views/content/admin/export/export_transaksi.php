<?php 
	$tgl = date('M Y', strtotime($this->session->userdata('bulan')));
	$membernya = !empty($member)? $member['nama_member'] : '';
	$header = get_setting('nama_celluler')." \r\nData Transaksi $membernya $tgl \r\n\r\n";
	
	if(!empty($data_query)):$i=1;
		$header .= "Total"."\t Rp. ".number_format($totalnya['total'], 2)."\r\n";	
		$header .= "No"."\t"."Tanggal"."\t"."Nama"."\t"."Kode"."\t"."No Tujuan"."\t"."Harga"."\r\n";
	foreach($data_query as $dt):			
		$header .= $i++."\t".date('d/m/Y',$dt['tgl'])."\t".$dt['nama_member']."\t".$dt['kode']."\t".(string)$dt['no_tujuan']."\t".$dt['total']."\r\n";
	endforeach;
	endif;
	
	$file = 'Transaksi '.$membernya.' '.$tgl.'.xls';
	header('Content-type: application/vnd.ms-excel'); 
	header('Content-Disposition: attachment; filename='.$file); 
	header('Pragma: no-cache'); 
	header('Expires: 0'); 	
	echo  $header;
?>