        <?php foreach ($posts as $post): ?>
        <div class="box box-widget">
            <div class="box-header with-border">
              <div class="user-block">
                <img class="img-circle" src="../dist/img/user1-128x128.jpg" alt="User Image">
                <span class="box-title"><a href="demo/blog_post/<?php echo $post->id; ?>"><?php echo $post->title; ?></a></span>
                <span class="description"><?php echo $post->author->first_name; ?> <?php echo $post->author->last_name; ?> - <?php echo $post->publish_time; ?></span>
              </div>
              <!-- /.user-block -->
              <div class="box-tools">
                <button type="button" class="btn btn-box-tool" data-toggle="tooltip" title="Mark as read">
                  <i class="fa fa-circle-o"></i></button>
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
              <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <img class="img-responsive pad" src="../dist/img/photo2.png" alt="Photo">
              <?php echo $post->content; ?>
              <button type="button" class="btn btn-default btn-xs"><i class="fa fa-share"></i> Share</button>
              <button type="button" class="btn btn-default btn-xs"><i class="fa fa-thumbs-o-up"></i> Like</button>
              <span class="pull-right text-muted">127 likes - 3 comments</span>
            </div>
            <!-- /.box-body -->
<!--            <div class="box-footer box-comments">
              <div class="box-comment">
                 User image 
                <img class="img-circle img-sm" src="../dist/img/user3-128x128.jpg" alt="User Image">

                <div class="comment-text">
                      <span class="username">
                        Maria Gonzales
                        <span class="text-muted pull-right">8:03 PM Today</span>
                      </span> /.username 
                  It is a long established fact that a reader will be distracted
                  by the readable content of a page when looking at its layout.
                </div>
                 /.comment-text 
              </div>
               /.box-comment 
              <div class="box-comment">
                 User image 
                <img class="img-circle img-sm" src="../dist/img/user4-128x128.jpg" alt="User Image">

                <div class="comment-text">
                      <span class="username">
                        Luna Stark
                        <span class="text-muted pull-right">8:03 PM Today</span>
                      </span> /.username 
                  It is a long established fact that a reader will be distracted
                  by the readable content of a page when looking at its layout.
                </div>
                 /.comment-text 
              </div>
               /.box-comment 
            </div>-->
            <!-- /.box-footer -->
            <div class="box-footer">
              <span class="pull-left text-muted"><?php echo $post->category->title; ?></span>
              <span class="pull-right text-muted">
                <?php $count_tags = count($post->tags); ?>
                <?php for ($i=0; $i<$count_tags; $i++): ?>
                        <?php echo ($i<$count_tags-1) ? $post->tags[$i]->title.',' : $post->tags[$i]->title; ?>
                <?php endfor; ?>
              </span>
            </div>
            <!-- /.box-footer -->
        </div>
        <?php endforeach; ?>
        <div class="row text-center">
	<div class="col col-md-12">
		<p>Results: <strong><?php echo $counts['from_num']; ?></strong> to <strong><?php echo $counts['to_num']; ?></strong> (total <strong><?php echo $counts['total_num']; ?></strong> results)</p>
		<?php echo $pagination; ?>
	</div>
        </div>


