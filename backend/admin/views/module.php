<?php  if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<p><?php echo "These are the modules uploaded in your site. Newly uploaded modules need to be installed. You can also deactivate, activate or desinstall all installed modules."?>
<table class="table table-bordered">
    <thead>
        <tr>
            <th width="3%" class="center">#</th>
            <th width="20%"><?php echo "Name" ?></th>
            <th width="37%"><?php echo "Description"?></th>
            <th width="10%"><?php echo "Version"?></th>				
            <th width="30%" colspan="3"><?php echo "Action"?></th>
        </tr>
    </thead>
    <tbody>
<?php $i = 1; foreach ($modules as $row): ?>
<?php if ($i % 2 != 0): $rowClass = 'odd'; else: $rowClass = 'even'; endif;?>
    <tr class="<?php echo $rowClass?>">
        <td class="center"><?php echo $i?></td>
        <td><?php echo $row['name']?></td>
        <td><?php echo $row['description']?></td>
        <td><?php echo $row['version']?></td>
        <td>
        <?php if ($row['status'] == 1 && $row['ordering'] >= 100): ?>
        <a href="<?php echo site_url('admin/module/move/up/'. $row['name'])?>"><img src="<?php echo base_url() ?>assets/images/moveup.gif" width="16" height="16" title="<?php echo "Move up"?>"/></a>
        <a href="<?php echo site_url('admin/module/move/down/'. $row['name'])?>"><img src="<?php echo base_url() ?>assets/images/movedown.gif" width="16" height="16" title="<?php echo "Move down"?>"/></a>
        </td>
        <?php endif; ?>
        <td>
        <?php if ($row['status'] == 1 && $row['ordering'] >= 100): ?>
        <a href="<?php echo site_url('admin/module/deactivate/'. $row['name'])?>"><?php echo "Deactivate"?></a>
        <?php elseif ($row['status'] == 0) : ?>
        <a href="<?php echo site_url('admin/module/activate/'. $row['name'])?>"><?php echo "Activate"?></a>
        <?php endif; ?>
        </td>
        <td>
        <?php if ($row['status'] == 0  && $row['ordering'] >= 100): ?>
        <a href="<?php echo site_url('admin/module/uninstall/'. $row['name'])?>"><?php echo "Uninstall"?></a>
        <?php elseif ($row['status'] == -1): ?>
        <a href="<?php echo site_url('admin/module/install/'. $row['name'])?>"><?php echo "Install"?></a>
        <?php else: ?>
                <?php if (isset($row['nversion']) && $row['nversion'] > $row['version']) : ?>
                <a href="<?php echo site_url('admin/module/update/'. $row['name'])?>"><span style='color: #FF0000'><?php echo "Update"?></span></a>
                <?php endif; ?>
        <?php endif; ?>
        </td>
    </tr>
<?php $i++; endforeach;?>
         
	</tbody>
</table>

<!-- [Content] end -->

