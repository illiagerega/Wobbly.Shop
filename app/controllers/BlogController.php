<?php

namespace app\controllers;

use app\lib\Pagination;
use app\core\Model;
use app\models\Blog;

class BlogController extends AppController {

    public function indexAction(){
        $pagination = new Pagination($this->route, $this->model->postsCount());
		$vars = [
			'pagination' => $pagination->get(),
			'list' => $this->model->postsList($this->route),
		];
		$this->view->render('Новини', $vars);
    }

}