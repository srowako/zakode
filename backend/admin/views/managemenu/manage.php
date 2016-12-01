	 <script>
            var BASEURL = "<?php echo base_url().'admin/';?>";
            var TOKEN = "<?php echo "123456s" ?>";	  
            var SHOWEDITOR=''; 
               
     </script>
<div class="container-fluid menu-hidden sidebar-hidden-phone fluid menu-left">
     <?php 
       
   if(isset($top_menu)&&isset($top_menu_detail))
   {
   ?>
    <div id="tab_holder" class="widget widget-tabs widget-tabs widget-tabs-gray">

        
    <!-- Tabs Heading -->
    
    <div class="widget-head">
        <ul id="top_menu_tab">
        <?php foreach ($top_menu as $tmenu) {
                   
               ?>
            <li <?php if($top_menu_id == $tmenu->id){?>class="active" <?php }?>>
                <a class="glyphicons " href="<?php echo base_url('admin/managemenu/menu/'.$tmenu->id);?>" >
                    <i></i>
                    <span id="top_menu_title_<?=$tmenu->id?>"><?=$tmenu->title?>
                        <span class="id_menu">(<?php echo $tmenu->id;?>)</span>
                    </span>
                </a>
            </li>
           <?php }?>
        </ul>
    </div>
    
    <!-- // Tabs Heading END -->

    <div class="widget-body">
        <div class="tab-content">

            <!-- Tab content -->
            <div id="tabAll" class="tab-pane widget-body-regular active">
                	<div class="row-fluid">
                <!-- Column -->
                <div class="span6">    
                    
                    <div class="col-md-12">  
      <div class="well">
        <p class="lead"><a href="#newModal" class="btn btn-default pull-right" data-toggle="modal"><span class="glyphicon glyphicon-plus-sign"></span> new menu item</a> Menu:</p>
        <div class="dd" id="nestable">
            <?php 
                echo  $this->zakode_menu_model->get_menu($top_menu_id);             
            ?>
        </div>

        <p id="success-indicator" style="display:none; margin-right: 10px;">
          <span class="glyphicon glyphicon-ok"></span> Menu order has been saved
        </p>
      </div>
    </div>
  </div>
  </div>
  </div>
            <!-- // Tab content END -->
            <a title="Permission" href='javascript:;' class='top_menu_permission_toggle' rel='<?php echo $top_menu_id?>' onclick="get_permission_data(<?php echo $top_menu_id?>)"><i class="icon-edit icon-2x"></i></a>  
            <a title="Edit" href='javascript:;' class='top_menu_edit_toggle' rel='<?php echo $top_menu_id?>' onclick="get_edit_data(<?php echo $top_menu_id?>)"><i class="icon-edit icon-2x"></i></a>  
            <a title="Delete" onclick="if(confirm('Do you want to delete this Menu, this will delete all its sub menu ?')){window.location.href='<?php echo base_url('admin/managemenu/delete_top_menu/'.$top_menu_id)?>';}" href="javascript:;"><i class="icon-trash icon-2x"></i></a>   
        </div>
    </div>
</div>
   <?php }?>
    </div>
<!-- Delete item Modal -->
   <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display:none;">
     <div class="modal-dialog">
       <div class="modal-content">
		   <form action="<?php echo base_url('admin/managemenu/delete');?>" method="post" class="form-horizontal" id="delete_menu_item">
         <input type="hidden" name="_token" value="">
          <div class="modal-header">
            
            <h4 class="modal-title">Provide details of the new menu item</h4>
          </div>
          
          <div class="modal-body">
            <p>Are you sure you want to delete this menu item, this will delete all its sub menu ?</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            <input type="hidden" name="delete_id" id="postvalue" value="" />
            <input type="submit" class="btn btn-danger" value="Delete Item" />
          </div>
         </form>
       </div><!-- /.modal-content -->
     </div><!-- /.modal-dialog -->
   </div><!-- /.modal -->
   
   <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display:none;">
     <div class="modal-dialog">
       <div class="modal-content">
         
          <form action="<?php echo base_url('admin/managemenu/edit');?>" method="post" class="form-horizontal" id="edit_menu_item">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <div class="modal-header">
            
            <h4 class="modal-title">Provide details of the new menu item</h4>
          </div>
          <div class="modal-body">
             
             <div class="form-group">
                <label for="url" class="col-lg-2 control-label label-control">URL</label>
                <div class="col-lg-10">
                 <input type="text" name="edit_url" value="" id="edit_url" class="span12 required">
                </div>
            </div>
         
             
             <div class="form-group">
                <label for="label" class="col-lg-2 control-label label-control">Navigation Label</label>
                <div class="col-lg-10">
                  <input type="text" name="edit_label" value="" id="edit_label" class="span12 required">
                </div>
            </div>
              
<!--            <div class="form-group">
                <label for="title" class="col-lg-2 control-label label-control">Title Attribute</label>
                <div class="col-lg-10">
                  <input type="text" name="edit_title" value="" id="edit_title" class="span12 required">
                </div>
            </div>-->
           <div class="form-group">
                <label for="icon" class="col-lg-2 control-label label-control">Icon </label>
                <div class="col-lg-10">
                  <input type="text" name="edit_icon" value="" id="edit_icon" class="span12 required">
                </div>
            </div>
<!--           <div class="form-group">                
                <div class="col-lg-10">
                  <input type="checkbox" name="edit_new_tab" id="edit_new_tab" value="1">Open link in a new window/tab
                </div>
            </div>
            <div class="form-group">
                <label for="title" class="col-lg-2 control-label label-control">CSS Class(optional) </label>
                <div class="col-lg-10">
                  <input type="text" name="edit_css" value="" id="edit_css" class="span12 required">
                </div>
            </div>-->
             <div class="form-group">
                <label for="title" class="col-lg-2 control-label label-control">Description </label>
                <div class="col-lg-10">
                 <textarea name="edit_description" id="edit_description" class="span12 required"></textarea>
                </div>
            </div>
          
         </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            <input type="hidden" name="edit_id" id="editvalue" value="" />
            <input type="submit" class="btn btn-danger" value="Update Item" />
          </div>
         </form>
       </div><!-- /.modal-content -->
     </div><!-- /.modal-dialog -->
   </div><!-- /.modal -->
   
    <!-- Create new item Modal -->
   <div class="modal fade" id="newModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display:none;" >
     <div class="modal-dialog">
       <div class="modal-content">
        
        <form action="<?php echo base_url('admin/managemenu/add');?>" method="post" class="form-horizontal" id="add_menu_item">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <div class="modal-header">
            
            <h4 class="modal-title">Provide details of the new menu item</h4>
          </div>
          <div class="modal-body">
           <div class="form-group">
                    <label for="url" class="col-lg-2 control-label label-control">URL</label>
                    <div class="col-lg-10">
                     <input type="text" name="url" value="" id="url" class="span12 required">
                    </div>
            </div>
            <div class="form-group">
                <label for="label" class="col-lg-2 control-label label-control">Navigation Label</label>
                <div class="col-lg-10">
                  <input type="text" name="label" value="" id="label" class="span12 required">
                </div>
            </div>
            <div class="form-group">
                <label for="icon" class="col-lg-2 control-label label-control">Icon</label>
                <div class="col-lg-10">
                  <input type="text" name="icon" value="" id="icon" class="span12 required">
                </div>
            </div>
              
<!--            <div class="form-group">
                <label for="title" class="col-lg-2 control-label label-control">Title Attribute</label>
                <div class="col-lg-10">
                  <input type="text" name="title" value="" id="title" class="span12 required">
                </div>
            </div>-->
<!--            <div class="form-group">
                
                <div class="col-lg-10">
                  <input type="checkbox" name="newtab" id="new_tab" value="1">Open link in a new window/tab
                </div>
            </div>
             <div class="form-group">
                <label for="title" class="col-lg-2 control-label label-control">CSS Class(optional) </label>
                <div class="col-lg-10">
                  <input type="text" name="css" value="" id="css" class="span12 required">
                </div>
            </div>-->
             <div class="form-group">
                <label for="title" class="col-lg-2 control-label label-control">Description </label>
                <div class="col-lg-10">
                 <textarea name="description" id="description" class="span12 required"></textarea>
                </div>
            </div>
         </div>
         <div class="modal-footer">
             <input type="hidden" name="group_id" id="group_id" value="<?php echo $top_menu_id?>" />
           <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
           <button type="submit" class="btn btn-primary">Create</button>
         </div>
        </form>
       </div><!-- /.modal-content -->
     </div><!-- /.modal-dialog -->
   </div><!-- /.modal -->
<link href="<?php echo base_url('assets/css/quickmenu_manage_nestable.css')?>" rel="stylesheet" type="text/css" />
<script  src="<?php echo base_url('assets/js/quickmenu_manage.js')?>"></script>
<!-- Bootstrap -->
<!--<script  src="<?php // echo base_url('assets/js/quickmenu_manage_bootstrap.min.js')?>"></script>-->	   
 
