<?php

namespace app\controllers\admin;

use app\models\admin\Product;
use app\models\AppModel;
use ishop\App;
use ishop\libs\Pagination;

class ProductController extends AppController {

    public function indexAction(){
//        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
//        $perpage = 10;
//        $count = \R::count('product');
//        $pagination = new Pagination($page, $perpage, $count);
//        $start = $pagination->getStart();
        $categories = \R::getAll("SELECT * FROM category");
        if(!empty($_GET['category'])) {
            $products = \R::getAll("SELECT product.*, category.title AS cat FROM product JOIN category ON category.id = product.category_id WHERE `product`.`category_id` = :id ORDER BY product.title", ['id' => $_GET['category']]);
        } else {
            $products = \R::getAll("SELECT product.*, category.title AS cat FROM product JOIN category ON category.id = product.category_id ORDER BY product.title");
        }
        foreach ($products as $key => $product) {
            $count = \R::count('order_product', '`product_id` = :id', ['id' => $product['id']]);
            $products[$key]['count'] = $count;
        }
        $this->setMeta('Список товаров');
        $this->set(compact('products', 'categories'));
    }

    public function addImageAction(){
        if(isset($_GET['upload'])){
            if($_POST['name'] == 'single'){
                $wmax = App::$app->getProperty('img_width');
                $hmax = App::$app->getProperty('img_height');
            }else{
                $wmax = App::$app->getProperty('gallery_width');
                $hmax = App::$app->getProperty('gallery_height');
            }
            $name = $_POST['name'];
            $product = new Product();
            $product->uploadImg($name, $wmax, $hmax);
        }
    }

    public function editAction(){
        if(!empty($_POST)){
            $id = $this->getRequestID(false);
            $product = new Product();
            $data = $_POST;
            $data['status'] = isset($data['status']) ? 2 : 1;
            $data['hit'] = isset($data['hit']) ? 2 : 1;
            $data['novinki'] = isset($data['novinki']) ? 2 : 1;
            $product->load($data);
            $product->getImg();
            if(!$product->validate($data)){
                $product->getErrors();
                redirect();
            }
            if($product->update('product', $id)){
                $product->editFilter($id, $data);
                $product->editRelatedProduct($id, $data);
                $product->saveGallery($id);
                $alias = AppModel::createAlias('product', 'alias', $data['title'], $id);
                $product = \R::load('product', $id);
                $product->alias = $alias;
                $product->status = $data['status'];
                $product->hit = $data['hit'];
                $product->hit = $data['novinki'];
                \R::store($product);
                $_SESSION['success'] = 'Изменения сохранены';
                redirect();
            }
        }

        $id = $this->getRequestID();
        $product = \R::load('product', $id);
        App::$app->setProperty('parent_id', $product->category_id);
        $filter = \R::getCol('SELECT attr_id FROM attribute_product WHERE product_id = ?', [$id]);
        $related_product = \R::getAll("SELECT related_product.related_id, product.title FROM related_product JOIN product ON product.id = related_product.related_id WHERE related_product.product_id = ?", [$id]);
        $gallery = \R::getCol('SELECT img FROM gallery WHERE product_id = ?', [$id]);
        $this->setMeta("Редактирование товара {$product->title}");
        $this->set(compact('product', 'filter', 'related_product', 'gallery'));
    }

    public function addAction(){
        if(!empty($_POST)){
            if(\R::count('product') < 1000) {
                $product = new Product();
                $data = $_POST;
                $data['status'] = isset($data['status']) ? 2 : 1;
                $data['hit'] = isset($data['hit']) ? 2 : 1;
                $data['novinki'] = isset($data['novinki']) ? 2 : 1;
                $product->load($data);
                $product->getImg();

                if (!$product->validate($data)) {
                    $product->getErrors();
                    $_SESSION['form_data'] = $data;
                    redirect();
                }

                if ($id = $product->save('product')) {
                    $product->saveGallery($id);
                    $alias = AppModel::createAlias('product', 'alias', $data['title'], $id);
                    $p = \R::load('product', $id);
                    $p->alias = $alias;
                    $p->status = $data['status'];
                    $p->hit = $data['hit'];
                    $p->novinki = $data['novinki'];
                    \R::store($p);
                    $product->editFilter($id, $data);
                    $product->editRelatedProduct($id, $data);
                    $_SESSION['success'] = 'Товар добавлен';
                }
            } else {
                $_SESSION['error'] = 'Много товаров';
            }
            redirect();
        }

        $this->setMeta('Новый товар');
    }

    public function relatedProductAction(){
        /*$data = [
            'items' => [
                [
                    'id' => 1,
                    'text' => 'Товар 1',
                ],
                [
                    'id' => 2,
                    'text' => 'Товар 2',
                ],
            ]
        ];*/

        $q = isset($_GET['q']) ? $_GET['q'] : '';
        $data['items'] = [];
        $products = \R::getAssoc('SELECT id, title FROM product WHERE title LIKE ? LIMIT 10', ["%{$q}%"]);
        if($products){
            $i = 0;
            foreach($products as $id => $title){
                $data['items'][$i]['id'] = $id;
                $data['items'][$i]['text'] = $title;
                $i++;
            }
        }
        echo json_encode($data);
        die;
    }

    public function deleteGalleryAction(){
        $id = isset($_POST['id']) ? $_POST['id'] : null;
        $src = isset($_POST['src']) ? $_POST['src'] : null;
        if(!$id || !$src){
            return;
        }
        if(\R::exec("DELETE FROM gallery WHERE product_id = ? AND img = ?", [$id, $src])){
            @unlink(WWW . "/images/$src");
            exit('1');
        }
        return;
    }

}