<div class="row">
	<div class="col-lg-12">
		<?php
			echo form_open(uri_string(), "class='form-horizontal'");
			echo $printTable;

			if(Modules::run('role/has_role', 'create_role'))
				echo anchor('/admin/role/create', t('AddRole'));

			echo btn(t('Updates', t('roles')));

		 ?>
	</div>
</div>
<script type="text/javascript">
var table;

$(document).ready(function() {

    //datatables
    table = $('#roleList').DataTable({ 

        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.

        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo site_url('admin/role')?>",
            "type": "POST"
        },

        //Set column definition initialisation properties.
        "columnDefs": [
        { 
            "targets": [ -1 ], //last column
            "orderable": false, //set not orderable
        },
        ],

    });

    //datepicker
    $('.datepicker').datepicker({
        autoclose: true,
        format: "yyyy-mm-dd",
        todayHighlight: true,
        orientation: "top auto",
        todayBtn: true,
        todayHighlight: true,  
    });

});    
function delete_role(id)
{
    if(confirm('Are you sure delete this data?'))
    {
        // ajax delete data to database
        $.ajax({
            url : "<?php echo site_url('admin/role/ajax_delete')?>/"+id,
            type: "POST",
            dataType: "JSON",
            success: function(data)
            {
                //if success reload ajax table
                $('#modal_form').modal('hide');
                reload_roleList();
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error deleting data');
            }
        });

    }
}

function reload_roleList()
{
    table.ajax.reload(null,false); //reload datatable ajax 
}
</script>