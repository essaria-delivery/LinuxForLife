<style>
    .alert-dismissable .close, .alert-dismissible .close {
    position: relative;
    top: -2px;
     right: 0px; 
    color: inherit;
}
</style>
<nav class="navbar navbar-transparent navbar-absolute">
                <div class="container-fluid">
                    <div class="navbar-minimize">
                        <button id="minimizeSidebar" class="btn btn-round btn-white btn-fill btn-just-icon">
                            <i class="material-icons visible-on-sidebar-regular">more_vert</i>
                            <i class="material-icons visible-on-sidebar-mini">view_list</i>
                        </button>
                    </div>
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="#"> <?php echo $this->lang->line("Dashboard");?> </a>
                    </div>
                    
                    
                    <div class="collapse navbar-collapse">
                        <ul class="nav navbar-nav navbar-right">
                            <!--<li>-->
                            <!--    <a href="#pablo" class="dropdown-toggle" data-toggle="dropdown">-->
                            <!--        <i class="material-icons">dashboard</i>-->
                            <!--        <p class="hidden-lg hidden-md">Dashboard</p>-->
                            <!--    </a>-->
                            <!--</li>-->
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="material-icons"></i>
                                        <?php 

                                            echo ($this->session->userdata('language') == "arabic") ? "ar" : "en";
                                            // if($this->session->userdata('language') == "arabic") { echo ($this->session->userdata('language') == "arabic") ? "ar" : "en" ;}  
                                            // if($this->session->userdata('language') == "spanish"){ echo ($this->session->userdata('language') == "spanish") ? "sp" : "en" ;}

                                        ?>
                                    <i class="material-icons"></i><?php //echo ($this->session->set_userdata('language,english')); echo "en";  ?>
                                    <i class="material-icons"></i>
                                    <!--<span class="notification">5</span>-->
                                    <p class="hidden-lg hidden-md">
                                        Notifications
                                        <b class="caret"></b>
                                    </p>
                                </a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="?lang=english">English</a>
                                    </li>
                                    <li>
                                        <a href="?lang=arabic">Arabic</a>
                                    </li>
                                    <!--<li>-->
                                    <!--    <a href="?lang=arabic">Arabic</a>-->
                                    <!--</li>-->
                                    
                                    
                                </ul>
                            </li>
                            <!--<li>-->
                            <!--    <a href="#pablo" class="dropdown-toggle" data-toggle="dropdown">-->
                            <!--        <i class="material-icons">person</i>-->
                            <!--        <p class="hidden-lg hidden-md">Profile</p>-->
                            <!--    </a>-->
                            <!--</li>-->
                            <li class="separator hidden-lg hidden-md"></li>
                        </ul>
                        <!--<form class="navbar-form navbar-right" role="search">-->
                        <!--    <div class="form-group form-search is-empty">-->
                        <!--        <input type="text" class="form-control" placeholder="Search">-->
                        <!--        <span class="material-input"></span>-->
                        <!--    </div>-->
                        <!--    <button type="submit" class="btn btn-white btn-round btn-just-icon">-->
                        <!--        <i class="material-icons">search</i>-->
                        <!--        <div class="ripple-container"></div>-->
                        <!--    </button>-->
                        <!--</form>-->
                    </div>
                    
                    
                </div>
            </nav>