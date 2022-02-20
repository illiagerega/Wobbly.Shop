<?php

namespace app\models;

class Blog extends AppModel {

    
    public function postsCount() {
		return $this->db->column('SELECT COUNT(id) FROM posts');
	}

}