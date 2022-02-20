<?php

namespace app\controllers;

use app\models\Breadcrumbs;
use app\models\Category;
use app\widgets\filter\Filter;
use ishop\App;
use ishop\libs\Pagination;

class CategoryController extends AppController {

    public function viewAction(){
        $alias = $this->route['alias'];
        $category = \R::findOne('category', 'alias = ?', [$alias]);
        if(!$category){
            throw new \Exception('Страница не найдена', 404);
        }

        $breadcrumbs = Breadcrumbs::getBreadcrumbs($category->id);

        $cat_model = new Category();
        $ids = $cat_model->getIds($category->id);
        $ids = !$ids ? $category->id : $ids . $category->id;

        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $perpage = isset($_GET['limit']) ? (int)$_GET['limit'] : 9;
        //$perpage = App::$app->getProperty('pagination');

        $filter = Filter::getFilter();
        $sql = '';
        $orderBy = '';
        $andPrice = '';
        $cnt = Filter::getCountGroups($filter);
        if(!empty($_GET['ABC'])) {
            $orderBy = 'ORDER BY title';
        }
        if(!empty($_GET['priceMin']) && !empty($_GET['priceMax'])) {
            $andPrice = "AND price > {$_GET['priceMin']} AND price < {$_GET['priceMax']}";
        }
        $total = \R::count('product', "category_id IN ($ids) $sql_part");
        $pagination = new Pagination($page, $perpage, $total);
        $start = $pagination->getStart();

        if(!empty($filter)) {
            $sql = "SELECT id, articul, category_id, brand_id, SUBSTRING(title, 1, 45) as title, alias, content, price, old_price, status, keywords, description, img, hit, novinki, positiveRaiting, negativeRaiting  
            FROM product 
            WHERE status = '1' AND category_id IN ($ids) 
            AND id IN (SELECT product_id FROM attribute_product WHERE attr_id IN ($filter) 
            GROUP BY product_id 
            HAVING COUNT(product_id) = $cnt)
            {$andPrice}
            {$orderBy}
            LIMIT {$start}, {$perpage}";
        }
        else {
            $sql = "SELECT id, articul, category_id, brand_id, SUBSTRING(title, 1, 45) as title, alias, content, price, old_price, status, keywords, description, img, hit, novinki, positiveRaiting, negativeRaiting  
            FROM product 
            WHERE status = '1' AND category_id IN ($ids) 
            {$andPrice}
            {$orderBy}
            LIMIT {$start}, {$perpage}";
        }  
        $rows = \R::getAll($sql);
        $products = \R::convertToBeans( 'product', $rows );

        if($this->isAjax()){
            $this->loadView('filter', compact('products', 'total', 'pagination'));
        }

        $this->setMeta($category->title, $category->description, $category->keywords);
        $this->set(compact('products', 'breadcrumbs', 'pagination', 'total'));
    }

}