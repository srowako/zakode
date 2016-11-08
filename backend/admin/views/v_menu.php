                    <div id="load"></div>                    
                    <div class="row">
                        <div class="col-md-3">
                            <div class="panel panel-default">
                                <div class="panel-heading ui-draggable-handle">
                                </div>
                                <div class="panel-body">
                                    <menu id="nestable-menu">
                                        <button type="button" data-action="expand-all">Expand All (-)</button>
                                        <button type="button" data-action="collapse-all">Collapse All (+)</button>
                                    </menu>
                                    <table>
                                        <tr>
                                            <div class="form-group">
                                                <label class="control-label">Label</label>
                                                <input class="form-control" type="text" id="label" placeholder="Fill label" required >
                                            </div>
                                        </tr>
                                        <tr>
                                            <div class="form-group">
                                                <label class="control-label">Link</label>
                                                <input class="form-control" type="text" id="link" placeholder="Fill link" required>
                                            </div>
                                        </tr>
                                        <tr>
                                            <div class="form-group">
                                                <label class="control-label">Icon</label>
                                                <input class="form-control" type="text" id="icon" placeholder="Fill icon">
                                            </div>
                                        </tr>
                                    </table>
                                    <input type="hidden" id="id">
                                </div>      
                                <div class="panel-footer">
                                    <button id="submit">Submit</button> <button id="reset">Reset</button>
                                </div>                            
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="panel panel-primary">
                                <div class="panel-heading ui-draggable-handle">
                                </div>
                                <div class="panel-body">
                                    <div class="cf nestable-lists">
                                        <div class="dd" id="nestable">
                                            <?php
                                            $ref   = [];
                                            $items = [];
                                            foreach ($result->result() as $data) {
                                                $thisRef = &$ref[$data->id];
                                                $thisRef['parent'] = $data->parent_id;
                                                $thisRef['label'] = $data->title_en;
                                                $thisRef['link'] = $data->url;
                                                $thisRef['id'] = $data->id;
                                                $thisRef['icon'] = $data->icon;
                                               if($data->parent_id == NULL) {
                                                    $items[$data->id] = &$thisRef;
                                               } else {
                                                    $ref[$data->parent_id]['child'][$data->id] = &$thisRef;
                                               }
                                            } 
                                            echo Modules::run('admin/menu/get_menu',$items); 
                                            ?>
                                        </div>
                                    </div>
                                    <input type="hidden" id="nestable-output">                                    
                                </div>
                                <div class="panel-footer">
                                    <button id="save">Save</button>
                                </div>                                                                                          
                            </div>
                        </div>                    
                    </div>
                <br/><br />
<script>

$(document).ready(function()
{

    var updateOutput = function(e)
    {
        var list   = e.length ? e : $(e.target),
            output = list.data('output');
        if (window.JSON) {
            output.val(window.JSON.stringify(list.nestable('serialize')));//, null, 2));
        } else {
            output.val('JSON browser support required for this demo.');
        }
    };

    // activate Nestable for list 1
    $('#nestable').nestable({
        group: 1
    })
    .on('change', updateOutput);



    // output initial serialised data
    updateOutput($('#nestable').data('output', $('#nestable-output')));

    $('#nestable-menu').on('click', function(e)
    {
        var target = $(e.target),
            action = target.data('action');
        if (action === 'expand-all') {
            $('.dd').nestable('expandAll');
        }
        if (action === 'collapse-all') {
            $('.dd').nestable('collapseAll');
        }
    });


});
</script>

<script>
  $(document).ready(function(){
    $("#load").hide();
    $("#submit").click(function(){
//       $("#load").show();

       var dataString = { 
              label : $("#label").val(),
              link : $("#link").val(),
              id : $("#id").val(),
              icon : $("#icon").val()
            };
        $("#load").show();
        $.ajax({
            type: "POST",
            url: "menu/save_menu",
            data: dataString,
            dataType: "json",
            cache : false,
            success: function(data){
              $("#load").hide();
              if(data.type == 'add'){
                 $("#menu-id").append(data.menu);
//                 $("#load").hide();
              } else if(data.type == 'edit'){
                 $('#label_show'+data.id).html(data.label);
                 $('#link_show'+data.id).html(data.link);
                 $('#icon_show'+data.id).html(data.icon);
//                 $("#load").hide();
              }
              $('#label').val('');
              $('#link').val('');
              $('#id').val('');
              $('#icon').val('');
//              $("#load").hide();
            } ,error: function(xhr, status, error) {
              alert(error);
              $("#load").hide();
            },
        });
//        $("#load").hide();
    });

    $('.dd').on('change', function() {
        $("#load").show();
     
          var dataString = { 
              data : $("#nestable-output").val(),
            };

        $.ajax({
            type: "POST",
            url: "menu/save",
            data: dataString,
            cache : false,
            success: function(data){
              $("#load").hide();
            } ,error: function(xhr, status, error) {
              alert(error);
            },
        });
    });

    $("#save").click(function(){
         $("#load").show();
     
          var dataString = { 
              data : $("#nestable-output").val(),
            };

        $.ajax({
            type: "POST",
            url: "menu/save",
            data: dataString,
            cache : false,
            success: function(data){
              $("#load").hide();
              alert('Data has been saved');
          
            } ,error: function(xhr, status, error) {
              alert(error);
            },
        });
    });

 
    $(document).on("click",".del-button",function() {
        var x = confirm('Delete this menu?');
        var id = $(this).attr('id');
        if(x){
            $("#load").show();
             $.ajax({
                type: "POST",
                url: "menu/delete",
                data: { id : id },
                cache : false,
                success: function(data){
                  $("#load").hide();
                  $("li[data-id='" + id +"']").remove();
                } ,error: function(xhr, status, error) {
                  alert(error);
                },
            });
        }
    });

    $(document).on("click",".edit-button",function() {
        var id = $(this).attr('id');
        var label = $(this).attr('label');
        var link = $(this).attr('link');
        var icon = $(this).attr('icon');
        $("#id").val(id);
        $("#label").val(label);
        $("#link").val(link);
        $("#icon").val(icon);
    });

    $(document).on("click","#reset",function() {
        $('#label').val('');
        $('#link').val('');
        $('#id').val('');
        $('#icon').val('');
    });

  });

</script>