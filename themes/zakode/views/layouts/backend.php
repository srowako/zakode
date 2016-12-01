<?php echo $template['partials']['be_header']; ?>
<body class="<?php echo $body_class; ?>">
    <div class="wrapper">
        <?php echo $template['partials']['be_navbar']; ?>
	<?php // Left side column. contains the logo and sidebar ?>
	<aside class="main-sidebar">
		<section class="sidebar">
			<div class="user-panel" style="height:65px">
				<div class="pull-left info" style="left:5px">
					<p><?php echo $user->first_name; ?></p>
					<a href="panel/account"><i class="fa fa-circle text-success"></i> Online</a>
				</div>
			</div>
			<?php // (Optional) Add Search box here ?>
			<?php echo $template['partials']['be_menu_search']; ?>
			<?php echo $template['partials']['be_sidemenu']; ?>
		</section>
	</aside>

	<?php // Right side column. Contains the navbar and content of the page ?>
	<div class="content-wrapper">
		<section class="content-header">
                    
			<h1><?php echo $page_title; ?></h1>
                        <?php echo $template['partials']['be_breadcrumb']; ?>
		</section>
		<section class="content">
                        <?php echo $template['partials']['be_message']; ?>
			<?php echo $template['body']; ?>
			<?php echo $template['partials']['be_back_btn']; ?>
		</section>
	</div>
    </div>
<?php echo $template['partials']['be_javascript']; ?>
<?php echo $template['partials']['be_footer']; ?>

