<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
<div class="container">

	<div class="navbar-header">
		<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</button>
		<a class="navbar-brand" href=""><?php echo $site_name; ?></a>
	</div>

	<div class="navbar-collapse collapse">

		<ul class="nav navbar-nav">
			<?php foreach ($menu as $parent => $parent_params): ?>

				<?php if (empty($parent_params['children'])): ?>

					<?php $active = ($current_uri==$parent_params['url'] || $ctrler==$parent); ?>
					<li <?php if ($active) echo 'class="active"'; ?>>
						<a href='<?php echo $parent_params['url']; ?>'>
							<?php echo $parent_params['name']; ?>
						</a>
					</li>

				<?php else: ?>

					<?php $parent_active = ($ctrler==$parent); ?>
					<li class='dropdown <?php if ($parent_active) echo 'active'; ?>'>
						<a data-toggle='dropdown' class='dropdown-toggle' href='#'>
							<?php echo $parent_params['name']; ?> <span class='caret'></span>
						</a>
						<ul role='menu' class='dropdown-menu'>
							<?php foreach ($parent_params['children'] as $name => $url): ?>
								<li><a href='<?php echo $url; ?>'><?php echo $name; ?></a></li>
							<?php endforeach; ?>
						</ul>
					</li>

				<?php endif; ?>

			<?php endforeach; ?>
		</ul>

		<?php if ( !empty($available_languages) ): ?>
			<ul class="nav navbar-nav navbar-right">
				<li class="dropdown">
					<a data-toggle='dropdown' class='dropdown-toggle' href='#'>
						<i class="fa fa-globe"></i><?php echo $language; ?>
						<span class='caret'></span>
					</a>
					<ul role='menu' class='dropdown-menu'>
						<?php foreach ($available_languages as $abbr => $item): ?>
						<li><a href="language/set/<?php echo $abbr; ?>"><?php echo $item['label']; ?></a></li>
						<?php endforeach; ?>
					</ul>
				</li>
                                
                                <?php // Messages: style can be found in dropdown.less?>
                                <li class="dropdown messages-menu">
                                  <?php // Menu toggle button ?>
                                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="fa fa-envelope-o"></i>
                                    <span class="label label-success">4</span>
                                  </a>
                                  <ul class="dropdown-menu">
                                    <li class="header">You have 4 messages</li>
                                    <li>
                                      <?php // inner menu: contains the messages ?>
                                      <ul class="menu">
                                        <li><?php // start message ?>
                                          <a href="#">
                                            <div class="pull-left">
                                              <?php // User Image ?>
                                              <img src="../../dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
                                            </div>
                                            <?php // Message title and timestamp ?>
                                            <h4>
                                              Support Team
                                              <small><i class="fa fa-clock-o"></i> 5 mins</small>
                                            </h4>
                                            <?php // The message ?>
                                            <p>Why not buy a new awesome theme?</p>
                                          </a>
                                        </li>
                                        <?php // end message ?>
                                      </ul>
                                      <?php // /.menu ?>
                                    </li>
                                    <li class="footer"><a href="#">See All Messages</a></li>
                                  </ul>
                                </li>
                                <?php // /.messages-menu ?>

                                <?php // Notifications Menu ?>
                                <li class="dropdown notifications-menu">
                                  <?php // Menu toggle button ?>
                                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="fa fa-bell-o"></i>
                                    <span class="label label-warning">10</span>
                                  </a>
                                  <ul class="dropdown-menu">
                                    <li class="header">You have 10 notifications</li>
                                    <li>
                                      <?php // Inner Menu: contains the notifications ?>
                                      <ul class="menu">
                                        <li><?php // start notification ?>
                                          <a href="#">
                                            <i class="fa fa-users text-aqua"></i> 5 new members joined today
                                          </a>
                                        </li>
                                        <?php // end notification ?>
                                      </ul>
                                    </li>
                                    <li class="footer"><a href="#">View all</a></li>
                                  </ul>
                                </li>
                                <?php // Tasks Menu ?>
                                <li class="dropdown tasks-menu">
                                  <?php // Menu Toggle Button ?>
                                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="fa fa-flag-o"></i>
                                    <span class="label label-danger">9</span>
                                  </a>
                                  <ul class="dropdown-menu">
                                    <li class="header">You have 9 tasks</li>
                                    <li>
                                      <?php // Inner menu: contains the tasks ?>
                                      <ul class="menu">
                                        <li><?php // Task item ?>
                                          <a href="#">
                                            <?php // Task title and progress text ?>
                                            <h3>
                                              Design some buttons
                                              <small class="pull-right">20%</small>
                                            </h3>
                                            <?php // The progress bar ?>
                                            <div class="progress xs">
                                              <?php // Change the css width attribute to simulate progress ?>
                                              <div class="progress-bar progress-bar-aqua" style="width: 20%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                                <span class="sr-only">20% Complete</span>
                                              </div>
                                            </div>
                                          </a>
                                        </li>
                                        <?php // end task item ?>
                                      </ul>
                                    </li>
                                    <li class="footer">
                                      <a href="#">View all tasks</a>
                                    </li>
                                  </ul>
                                </li>
                                <?php // User Account Menu ?>
                                <li class="dropdown user user-menu">
                                  <?php // Menu Toggle Button ?>
                                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <?php // The user image in the navbar?>
                                    <img src="assets/images/github.png" class="user-image" alt="User Image">
                                    <?php // hidden-xs hides the username on small devices so only the image appears. ?>
                                    <span class="hidden-xs">Alexander Pierce</span>
                                  </a>
                                  <ul class="dropdown-menu">
                                    <?php // The user image in the menu ?>
                                    <li class="user-header">
                                      <img src="assets/images/github.png" class="img-circle" alt="User Image">

                                      <p>
                                        Alexander Pierce - Web Developer
                                        <small>Member since Nov. 2012</small>
                                      </p>
                                    </li>
                                    <?php // Menu Body ?>
                                    <li class="user-body">
                                      <div class="row">
                                        <div class="col-xs-4 text-center">
                                          <a href="#">Followers</a>
                                        </div>
                                        <div class="col-xs-4 text-center">
                                          <a href="#">Sales</a>
                                        </div>
                                        <div class="col-xs-4 text-center">
                                          <a href="#">Friends</a>
                                        </div>
                                      </div>
                                      <?php // /.row ?>
                                    </li>
                                    <?php // Menu Footer?>
                                    <li class="user-footer">
                                      <div class="pull-left">
                                        <a href="#" class="btn btn-default btn-flat">Profile</a>
                                      </div>
                                      <div class="pull-right">
                                        <a href="#" class="btn btn-default btn-flat">Sign out</a>
                                      </div>
                                    </li>
                                  </ul>
                                </li>
			</ul>
		<?php endif; ?>
		<ul class="nav navbar-nav">
            
	</div>

</div>
</nav>