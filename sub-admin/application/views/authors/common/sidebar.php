<?php 
if($this->session->userdata('language') == "arabic")
{
    echo "<style> .main-panel.ps-container.ps-theme-default.ps-active-y { float: left; } </style>";
?>
<style type="text/css">
    .main-panel.ps-container.ps-theme-default.ps-active-y {
        float: left;
    }
    
    .sidebar[data-background-color="black"] .nav li i, .off-canvas-sidebar[data-background-color="black"] .nav li i {
        color: rgba(255, 255, 255, 0.8);
        float:right;
        margin-left: 10px;
    }
    .card-stats .card-header {
        float: right;
        text-align: center;
    }
    .card .card-header.card-header-icon {
        float: right;
    }
    .card .card-header.card-header-icon + .card-content .card-title {
        padding-bottom: 15px;
        float: right;
    }
    div.dataTables_wrapper div.dataTables_filter {
        text-align: right;
        padding-top:20px;
    }
    .pull-right {
        border: 1px solid purple;
        padding: 2px 25px;
        float: right;
        margin: 0px 20px;
    }
    .animation-transition-general, .sidebar .nav p, .off-canvas-sidebar .nav p, .off-canvas-sidebar .user .photo,  .off-canvas-sidebar .user a, .login-page .card-login, .lock-page .card-profile {
        text-align:right;
    }
    
    @media (min-width: 992px)
    {
        .main-panel {
            float:left;
        }
        .sidebar-mini .main-panel {
            margin-left: 0px;
        }
    }
    .sidebar .nav i, .off-canvas-sidebar .nav i {
        font-size: 24px;
        float: left;
        margin-right: 0px;
        line-height: 30px;
        width: 30px;
        text-align: right;
        color: #a9afbb;
    }
    .paginate_button {
        padding: 5px !important;
    }
    .dataTables_paginate a {
        outline: 0;
        padding: 5px;
    }
    
</style>
<style>
    li.active:focus{ border:none; }
    
    .wrapper {
    position: relative;
    top: 0;
    height: 109vh !important;
}
</style>
<?php
}
?>

<div class="sidebar" data-active-color="rose" data-background-color="black" data-image="<?php echo base_url($this->config->item("new_theme")."/assets/img/sidebar-1.jpg"); ?> " 
<?php if($this->session->userdata('language') == "arabic"){ echo 'style="left: unset;right: 0"'; } ?> >

            
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
            
            <script type="text/javascript">
            	$(function(){
            		$('.nav a').filter(function(){return this.href==location.href}).parent().addClass('active').siblings().removeClass('active')
            		$('.nav a').click(function(){
            			$(this).parent().addClass('active').siblings().removeClass('active')	
            		})
            	})
	        </script>
            <div class="logo" style="padding:0px">
                <a href="<?php echo $this->config->item('base_url');?>" class="simple-text"  style="padding:0px">
                    <img src="<?php echo $this->config->item('base_url').'/uploads/download.png' ; ?>" width="100%" alt=""  style="padding:0px">
                </a>
            </div>
            <div class="logo logo-mini"  style="padding:0px">
                <a href="<?php echo $this->config->item('base_url'); ?>" class="simple-text" style="padding:0px">
                    <img src="<?php echo $this->config->item('base_url').'/uploads/download.png' ; ?>" width="100%" alt=""  style="padding:0px">
                </a>
            </div>
            <div class="sidebar-wrapper">
                <div class="user">
                    <div class="photo">
                        <?php 
                            $sess = $this->session->all_userdata();
                            
                            $z = $sess['sub_admin']['user_id'];
                            $img=$this->db->query("SELECT * FROM `authors` where user_id='".$z."' ") ;
                            $image= $img->row();
                            //echo $z;
                            $base=$this->config->item('base_url');
                            $base=str_replace('/sub-admin','',$base)
                        ?>
                        <img src="<?= $base.'/uploads/profile/'.$image->user_image ?>" />
                    </div>
                    <div class="info">
                        <a data-toggle="collapse" href="#collapseExample" class="collapsed">
                            <?php echo "".$sess['sub_admin']['user_name']."" ; ?>
                            <b class="caret"></b>
                        </a>
                        <div class="collapse" id="collapseExample">
                            <ul class="nav">
                                <!--li>
                                    <a href="#">My Profile</a>
                                </li-->
                                <li>
                                    <a href="<?php echo site_url("main/edit_mainuser/".$z); ?>" ><?php echo $this->lang->line("Edit Profile");?></a>
                                </li>
                                <li>
                                    <a href="<?php echo site_url("main/signout") ?>" ><?php echo $this->lang->line("Log Out");?></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <ul class="nav ">
                    <li>
                        <a href="<?php echo site_url("main/dashboard"); ?>" >
                            <i class="material-icons">dashboard</i>
                            <p><?php echo $this->lang->line("dashboard");?></p>
                        </a>
                    </li>
                    <li class="">
                        <a href="<?php echo site_url("main/users"); ?>">
                            <i class="material-icons">store</i>
                            <?php echo $this->lang->line("List Store Users");?>
                        </a>
                    </li>
                    <li class="">
                        <a href="<?php echo site_url("main/orders"); ?>">
                            <i class="material-icons">play_for_work</i>
                            <?php echo "Orders"; ?>
                        </a>
                    </li>
                    <!--<li class="">-->
                    <!--    <a href="<?php echo site_url("main/socity"); ?>">-->
                    <!--        <i class="material-icons">pin_drop</i>-->
                    <!--        <p><?php echo $this->lang->line("Socity");?></p>-->
                    <!--    </a>-->
                    <!--</li>-->
                    <!--<li class="">-->
                    <!--    <a href="<?php echo site_url("main/city"); ?>">-->
                    <!--        <i class="material-icons">map</i>-->
                    <!--        <p><?php echo $this->lang->line("City");?></p>-->
                    <!--    </a>-->
                    <!--</li>-->
                    
                    <li class="">
                        <a href="<?php echo site_url("main/all_delivery"); ?>">
                            <i class="material-icons">map</i>
                            <p><?php echo $this->lang->line("Delivery Boy");?></p>
                        </a>
                    </li>
                    <li class="">
                        <a href="<?php echo site_url("main/notification"); ?>">
                            <i class="material-icons">notifications_active</i>
                            <p><?php echo $this->lang->line("Notification");?></p>
                        </a>
                    </li>
                </ul>
            </div>
        </div>