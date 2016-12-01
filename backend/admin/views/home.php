<div class="row">
    <div>
        <iframe src="http://spy.ecorr.web.id/widgets/public_traffic_source_data/zakode_ecorr_web_id_1" frameborder="0" width="700" height="300" style=""></iframe>
        <iframe src="http://spy.ecorr.web.id/widgets/public_country_report_data/zakode_ecorr_web_id_1" frameborder="0" width="650" height="450" style=""></iframe>
        <iframe src="http://spy.ecorr.web.id/widgets/public_content_overview_data/zakode_ecorr_web_id_1" frameborder="0" width="550" height="420" style=""></iframe>
        
    </div>

	<div class="col-md-4">
		<?php echo modules::run('adminlte/widget/box_open', 'Shortcuts'); ?>
			<?php echo modules::run('adminlte/widget/app_btn', 'fa fa-user', 'Account', 'panel/account'); ?>
			<?php echo modules::run('adminlte/widget/app_btn', 'fa fa-sign-out', 'Logout', 'panel/logout'); ?>
		<?php echo modules::run('adminlte/widget/box_close'); ?>
	</div>

	<div class="col-md-4">
		<?php echo modules::run('adminlte/widget/info_box', 'yellow', $count['users'], 'Users', 'fa fa-users', 'user'); ?>
	</div>
        

</div>
