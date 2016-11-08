<!DOCTYPE html>
<html>
<?php echo $template['partials']['fe_header']; ?>
<?php // ADD THE CLASS layout-top-nav TO REMOVE THE SIDEBAR. ?>
<body class="hold-transition skin-blue layout-top-nav">
<div class="wrapper">

  <header class="main-header">
    <nav class="navbar navbar-static-top">
      <div class="container">
        <div class="navbar-header">
          <a href="" class="navbar-brand"><b>Ecorr</b>LTE</a>
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
            <i class="fa fa-bars"></i>
          </button>
        </div>
            <?php echo $template['partials']['fe_navbar']; ?>
      </div>
    </nav>
  </header>
  <?php // Full Width Column ?>
  <div class="content-wrapper">
    <div class="container">
      <?php // Content Header (Page header) ?>
      <section class="content-header">
        <h1>
          Top Navigation
          <small>Example 2.0</small>
        </h1>
        <?php echo $template['partials']['fe_breadcrumb']; ?>
      </section>

      <?php // Main content ?>
      <section class="content">
<!--         <div class="callout callout-info">
          <h4>Tip!</h4>

          <p>Add the layout-top-nav class to the body tag to get this layout. This feature can also be used with a
            sidebar! So use this class if you want to remove the custom dropdown menus from the navbar and use regular
            links instead.</p>
        </div>
        <div class="callout callout-danger">
          <h4>Warning!</h4>

          <p>The construction of this layout differs from the normal one. In other words, the HTML markup of the navbar
            and the content will slightly differ than that of the normal layout.</p>
        </div> -->
        <div class="box box-default">
            <?php // echo $template['body']; ?>
          <div class="box-header with-border">
            <h3 class="box-title"><?php echo $page_title; ?></h3>
          </div>
          <div class="box-body">
            <?php echo $template['body']; ?>
          </div>
          <?php // /.box-body ?>
        </div>
        <?php // /.box ?>
      </section>
      <?php // /.content ?>
    </div>
    <?php // /.container ?>
  </div>
  <?php // /.content-wrapper ?>
  <?php echo $template['partials']['fe_javascript']; ?>

  
</div>
<?php // ./wrapper ?>

<?php echo $template['partials']['fe_footer']; ?>
</body>
</html>
