<html>
    <head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="<?php echo base_url($this->config->item("new_theme")."/assets/img/apple-icon.png"); ?>" />
    <link rel="icon" type="image/png" href="<?php echo base_url($this->config->item("new_theme")."/assets/img/favicon.png"); ?>" />
    <title></title>
    <!-- Canonical SEO -->
    <link rel="canonical" href="//www.creative-tim.com/product/material-dashboard-pro" />

    <!-- Bootstrap core CSS     -->
    <link href="<?php echo base_url($this->config->item("new_theme")."/assets/css/bootstrap.min.css"); ?>" rel="stylesheet" />
    <!--  Material Dashboard CSS    -->
    <link href="<?php echo base_url($this->config->item("new_theme")."/assets/css/material-dashboard.css"); ?>" rel="stylesheet" />
    <!--  CSS for Demo Purpose, don't include it in your project     -->
    <link href="<?php echo base_url($this->config->item("new_theme")."/assets/css/demo.css"); ?>" rel="stylesheet" />
    <!--     Fonts and icons     -->
    <link href="<?php echo base_url($this->config->item("new_theme")."/assets/css/font-awesome.css"); ?>" rel="stylesheet" />
    <link href="<?php echo base_url($this->config->item("new_theme")."/assets/css/google-roboto-300-700.css"); ?>" rel="stylesheet" />
</head>
<body>
   
   
                                <div class="card-header card-header-icon" data-background-color="purple">
                                    <i class="material-icons">assignment</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title" ><?php echo $this->lang->line("All Categories");?></h4>
                                    <a class="pull-right" style="" href="<?php echo site_url("admin/addcategorie"); ?>">
                                        <?php echo $this->lang->line("ADD");?>
                                    </a>
                                    <div class="toolbar">
                                        <!--        Here you can write extra buttons/actions for the toolbar              -->
                                    </div>
                                    <div class="material-datatables">
                                        <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th><?php echo $this->lang->line("Cat ID");?></th>
                                                    <th><?php echo $this->lang->line("cat title");?></th>
                                                    <th><?php echo $this->lang->line("Parent Category");?></th>
                                                    <th><?php echo $this->lang->line("Image");?></th>
                                                    <th><?php echo $this->lang->line("Status");?></th>
                                                    <!--<th class="text-right"><?php echo $this->lang->line("Action");?></th>-->
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th><?php echo $this->lang->line("Cat ID");?></th>
                                                    <th><?php echo $this->lang->line("cat title");?></th>
                                                    <th><?php echo $this->lang->line("Parent Category");?></th>
                                                    <th><?php echo $this->lang->line("Image");?></th>
                                                    <th><?php echo $this->lang->line("Status");?></th>
                                                    <!--<th class="text-right"><?php echo $this->lang->line("Action");?></th>-->
                                                </tr>
                                            </tfoot>
                                            <tbody>
                                                <?php foreach($allcat as $acat){ ?>
                                                <tr>
                                                    <td class="text-center"><?php echo $acat->id; ?></td>
                                                    <td><?php echo $acat->title; ?></td>
                                                    <td><?php   if($acat->prtitle!=""){  echo $acat->prtitle; }else { echo "________"; }?></td>
                                                    <td><?php if($acat->image!=""){ ?><div class="cat-img" style="width: 50px; height: 50px;"><img width="100%" height="100%" src="<?php echo $this->config->item('base_url').'uploads/category/'.$acat->image; ?>" /></div> <?php } ?></td>
                                                    
                                                    <td><?php if($acat->status == "1"){ ?><span class="label label-success"> <?php echo $this->lang->line("Active");?></span><?php } else { ?><span class="label label-danger"> <?php echo $this->lang->line("Deactive");?></span><?php } ?></td>

                                                    <!--<td class="td-actions text-right"><div class="btn-group">-->
                                                    <!--        <?php echo anchor('admin/editcategory/'.$acat->id, '<button type="button" rel="tooltip" class="btn btn-success btn-round">-->
                                                    <!--        <i class="material-icons">edit</i>-->
                                                    <!--    </button>', array("class"=>"")); ?>-->

                                                    <!--        <?php echo anchor('admin/deletecat/'.$acat->id, '<button type="button" rel="tooltip" class="btn btn-danger btn-round">-->
                                                    <!--        <i class="material-icons">close</i>-->
                                                    <!--    </button>', array("class"=>"", "onclick"=>"return confirm('Are you sure delete?')")); ?>-->
                                                            
                                                    <!--    </div>-->
                                                    <!--</td>-->
                                                </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <!-- end content-->
                            </div>
                            <!--  end card  -->
                        </div>
                        <!-- end col-md-12 -->
                    </div>
                    <!-- end row -->
                </div>
            </div>
            
   
</body>
</html>