<ul class="sidebar-menu">
	<li class="header">MAIN NAVIGATION</li>
	<?php echo $this->multi_menu->render(); ?>	
	<?php if ( !empty($useful_links) ): ?>
		<li class="header">USEFUL LINKS</li>
		<?php foreach ($useful_links as $link): ?>
			<?php if ($this->ion_auth->in_group($link['auth']) ): ?>
			<li>
				<a href="<?php echo starts_with($link['url'], 'http') ? $link['url'] : base_url($link['url']); ?>" target='<?php echo $link['target']; ?>'>
					<i class="fa fa-circle-o <?php echo $link['color']; ?>"></i> <?php echo $link['name']; ?>
				</a>
			</li>
			<?php endif; ?>
		<?php endforeach; ?>
	<?php endif; ?>

</ul>