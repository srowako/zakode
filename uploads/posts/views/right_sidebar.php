<div class="box box-primary">
<div class="box-body box-profile">
  <img class="profile-user-img img-responsive img-circle" src="../../dist/img/user4-128x128.jpg" alt="User profile picture">

  <h3 class="profile-username text-center">Nina Mcintire</h3>

  <p class="text-muted text-center">Software Engineer</p>

  <ul class="list-group list-group-unbordered">
    <li class="list-group-item">
      <b>Followers</b> <a class="pull-right">1,322</a>
    </li>
    <li class="list-group-item">
      <b>Following</b> <a class="pull-right">543</a>
    </li>
    <li class="list-group-item">
      <b>Friends</b> <a class="pull-right">13,287</a>
    </li>
  </ul>

  <a href="#" class="btn btn-primary btn-block"><b>Follow</b></a>
</div>
<!-- /.box-body -->
</div>


        <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Recent Posts</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <!--<strong><i class="fa fa-book margin-r-5"></i> Education</strong>-->
              <?php if(!empty($getRecentPosts)):?>
                    <?php foreach ($getRecentPosts as $post):?>
                      <div class="list-group-item">
                        <?php if(!empty($post['featured_image'])):?>
                        <div class="row-picture">
                            <img class="img-responsive" class="circle" src="<?php echo base_url().$post['featured_image']?>" alt="icon">
                        </div>
                        <?php endif;?>
                        <div class="row-content">
                            <h4><a href="<?php echo site_url('blog/'.$post['slug']) ?>"><?php echo $post['title'] ?></a></h4>
                        </div>
                      </div>
                      <div class="list-group-separator"></div>
                    <?php endforeach;?>
                  <?php endif;?>
            </div>
            <!-- /.box-body -->
        </div>
        
        <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Categories</h3>
            </div>
            <div class="box-body">
                <?php if(!empty($getCategories)):?>
                    <?php foreach($getCategories as $category):?>
                        <li><a href="<?php echo site_url('category/'.$category['slug'])?>"><?php echo $category['name']?></a></li>
                    <?php endforeach;?>
                <?php endif;?>
            </div>
        </div>

        <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Tags</h3>
            </div>
            <div class="box-body">
                <?php if(!empty($getTags)):?>
                    <?php foreach($getTags as $tag):?>
                        <a  href="<?php echo site_url('tag/'.$tag['slug'])?>">
                            <small class="label pull-center bg-blue"><?php echo $tag['name']?></small>
                        </a>
                    <?php endforeach;?>
                <?php endif;?>
            </div>
        </div>