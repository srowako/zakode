<?php

class Slides_model extends MY_Model {

	protected $where = array('status' => 'active');
	protected $order_by = array('pos', 'ASC');
	protected $upload_fields = array('image_url' => SLIDE_PHOTO);
}