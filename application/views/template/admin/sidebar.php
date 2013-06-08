<ul class="nav nav-list">
    <li class="nav-header">Main Menu</li>                            
        <li <?php if($this->uri->segment(2) == 'kode') echo "class='active'" ?>><a href="<?php echo site_url('admin/kode') ?>">Kode Pulsa</a></li>                           
        <li <?php if($this->uri->segment(2) == 'member') echo "class='active'" ?>><a href="<?php echo site_url('admin/member') ?>">Data Member</a></li>                      
        <li <?php if($this->uri->segment(2) == 'transaksi') echo "class='active'" ?>><a href="<?php echo site_url('admin/transaksi') ?>">Data Transaksi</a></li>           
        <li <?php if($this->uri->segment(2) == 'deposit') echo "class='active'" ?>><a href="<?php echo site_url('admin/deposit') ?>">Data Deposit</a></li>
    
    <li class="nav-header">Rekap</li>                            
        <li <?php if($this->uri->segment(2) == 'rekap_transaksi') echo "class='active'" ?>><a href="<?php echo site_url('admin/rekap_transaksi') ?>">Rekap Transaksi</a></li> 
        <li <?php if($this->uri->segment(2) == 'rekap_member') echo "class='active'" ?>><a href="<?php echo site_url('admin/rekap_member') ?>">Rekap Member</a></li> 
    
    <li class="nav-header">Setting</li>                                    
        <!--<li><a href="">Profil</a></li>-->                            
        <li <?php if($this->uri->segment(2) == 'admin_manage') echo "class='active'" ?>><a href="<?php echo site_url('admin/admin_manage') ?>">Admin Manage</a></li> 
        <li <?php if($this->uri->segment(2) == 'change_password') echo "class='active'" ?>><a href="<?php echo site_url('admin/change_password') ?>">Change Password</a></li>
</ul> 
