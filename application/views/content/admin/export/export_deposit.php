<?php 
	$tgl = date('M Y', strtotime($this->session->userdata('bulan')));
	$header = get_setting('nama_celluler')." \r\nData Deposit $tgl \r\n\r\n";
	
	if(!empty($data_query)):$i=1;
		$header .= "Terhutang"."\t Rp. ".number_format($totalnya['terhutang'], 2)."\r\n";
		$header .= "Lunas"."\t Rp. ".number_format($totalnya['lunas'], 2)."\r\n";
		$header .= "Total"."\t Rp. ".number_format($totalnya['total'], 2)."\r\n";	
		$header .= "No"."\t"."Tanggal"."\t"."Nominal"."\t"."Status"."\t"."Tanggal Bayar"."\r\n";
	foreach($data_query as $dt):			
		$status = ($dt['status'] == 0)? 'Terhutang' : 'Lunas';
		$date = ($dt['tgl_bayar'])? date('d/M/Y',$dt['tgl_bayar'])  : '';
		
		$header .= $i++."\t".date('d/M/Y',$dt['tgl'])."\t".$dt['nominal']."\t".$status."\t".$date."\r\n";
	endforeach;
	endif;
	
	$file = 'Deposit '.$tgl.'.xls';
	header('Content-type: application/vnd.ms-excel'); 
	header('Content-Disposition: attachment; filename='.$file); 
	header('Pragma: no-cache'); 
	header('Expires: 0'); 	
	echo  $header;
?>