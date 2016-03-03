<?php
//Geolocation plugin for GWPRESS. Created 3/2/2016.

//Admin listing
if(empty($plugins)) {
    $plugins = array();
}
$plugin = array(
    'plugin_title' => 'Geolocation',
    'plugin_url' => '/admin/plugin/geolocation/list',
    'plugin_description' => 'A geolocation plugin for GWPRESS.'
);
array_push($plugins, $plugin);

$plugin = array(
    'plugin_title' => 'Geolocation Categories',
    'plugin_url' => '/admin/plugin/geolocation/categories/list',
    'plugin_description' => 'A geolocation plugin for GWPRESS.'
);
array_push($plugins, $plugin);

//Routes
if(empty($plugin_routes)) {
    $plugin_routes = array();
}
//Main page
$plugin_route = array(
    'plugin_url' => '/admin/plugin/geolocation/list',
    'plugin_page_name' => 'geolocation/geolocation.php'
);
array_push($plugin_routes, $plugin_route);

//Add geolocation
$plugin_route = array(
    'plugin_url' => '/admin/plugin/geolocation/add',
    'plugin_page_name' => 'geolocation/geolocation_add.php'
);
array_push($plugin_routes, $plugin_route);

//Edit geolocation
$plugin_route = array(
    'plugin_url' => '/admin/plugin/geolocation/edit',
    'plugin_page_name' => 'geolocation/geolocation_edit.php'
);
array_push($plugin_routes, $plugin_route);

//Delete geolocation
$plugin_route = array(
    'plugin_url' => '/admin/plugin/geolocation/delete',
    'plugin_page_name' => 'geolocation/geolocation_delete.php'
);
array_push($plugin_routes, $plugin_route);

//Install geolocation
$plugin_route = array(
    'plugin_url' => '/admin/plugin/geolocation/install',
    'plugin_page_name' => 'geolocation/geolocation_install.php'
);
array_push($plugin_routes, $plugin_route);

//Ajax address lookup
$plugin_route = array(
    'plugin_url' => '/admin/ajax/address_lookup',
    'plugin_page_name' => 'geolocation/address_lookup.php'
);
array_push($plugin_routes, $plugin_route);

//Geolocation categories page
$plugin_route = array(
    'plugin_url' => '/admin/plugin/geolocation/categories/list',
    'plugin_page_name' => 'geolocation/geolocation_categories.php'
);
array_push($plugin_routes, $plugin_route);

//Add geolocation category
$plugin_route = array(
    'plugin_url' => '/admin/plugin/geolocation/categories/add',
    'plugin_page_name' => 'geolocation/geolocation_category_add.php'
);
array_push($plugin_routes, $plugin_route);

//Edit geolocation category
$plugin_route = array(
    'plugin_url' => '/admin/plugin/geolocation/categories/edit',
    'plugin_page_name' => 'geolocation/geolocation_category_edit.php'
);
array_push($plugin_routes, $plugin_route);

//Delete geolocation
$plugin_route = array(
    'plugin_url' => '/admin/plugin/geolocation/categories/delete',
    'plugin_page_name' => 'geolocation/geolocation_category_delete.php'
);
array_push($plugin_routes, $plugin_route);

class Geolocation {

    public function __construct() {
    }

    public static function geoloc_load($id) {
        if(empty($id)) {
            $post = array();
            $flash = new Flash();
            $flash->flash('flash_message', 'Geolocation does not exist!', 'warning');
            header("Location: ".BASE_URL);
        } else {
            $post = db_select_row("SELECT * FROM geo WHERE id = ".$id);
            if(empty($post)) {
                $flash = new Flash();
                $flash->flash('flash_message', 'Geolocation does not exist!', 'warning');
                header("Location: ".BASE_URL);
            }
        }
        return $post;
    }

    public static function geoloc_save($id, $category_id, $title, $body, $address, $featured, $longitude, $latitude, $metadescription, $metakeywords, $status) {
        $post_category_id = mysqli_real_escape_string(db_connect(), $category_id);
        $post_title = mysqli_real_escape_string(db_connect(), $title);
        $post_slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $post_title)));
        $post_body = mysqli_real_escape_string(db_connect(), $body);
        $post_address = mysqli_real_escape_string(db_connect(), $address);
        $post_featured = mysqli_real_escape_string(db_connect(), $featured);
        $post_longitude = mysqli_real_escape_string(db_connect(), $longitude);
        $post_latitude = mysqli_real_escape_string(db_connect(), $latitude);
        $post_metadescription = mysqli_real_escape_string(db_connect(), $metadescription);
        $post_metakeywords = mysqli_real_escape_string(db_connect(), $metakeywords);
        $post_status = mysqli_real_escape_string(db_connect(), $status);
        $post_created_date = date("Y-m-d H:i:s");
        $post_updated_date = date("Y-m-d H:i:s");
        if(empty($id)) {
            db_query("INSERT INTO geo (category_id, title, slug, body, address, featured, longitude, latitude, metadescription, metakeywords, status, created_date, updated_date) VALUES ('".$post_category_id."', '".$post_title."', '".$post_slug."', '".$post_body."', '".$post_address."', '".$post_featured."', '".$post_longitude."', '".$post_latitude."', '".$post_metadescription."', '".$post_metakeywords."', '".$post_status."', '".$post_created_date."', '".$post_updated_date."');");
            $flash = new Flash();
            $flash->flash('flash_message', 'Geolocation created!');
            header("Location: ".BASE_URL.'/admin/plugin/geolocation/list');
        } else {
            db_query("UPDATE ".MYSQL_DB.".geo SET category_id = '".$post_category_id."', title = '".$post_title."', slug = '".$post_slug."', body = '".$post_body."', address = '".$post_address."', featured = '".$post_featured."', longitude = '".$post_longitude."', latitude = '".$post_latitude."', metadescription = '".$post_metadescription."', metakeywords = '".$post_metakeywords."', status = '".$post_status."', updated_date = '".$post_updated_date."' WHERE id = ".$id.";");
            $flash = new Flash();
            $flash->flash('flash_message', 'Geolocation updated!');
            header("Location: ".BASE_URL.'/admin/plugin/geolocation/list');
        }
    }

    public static function geoloc_delete($id) {
        if(empty($id)) {
            $flash = new Flash();
            $flash->flash('flash_message', 'Geolocation does not exist!', 'warning');
            header("Location: ".BASE_URL.'/admin/plugin/geolocation/list');
        } else {
            db_query("DELETE FROM geo WHERE id = ".$id);
            $flash = new Flash();
            $flash->flash('flash_message', 'Geolocation deleted!');
            header("Location: ".BASE_URL.'/admin/plugin/geolocation/list');
        }
    }

    public static function read_more($text, $limit) {
        if (str_word_count($text, 0) > $limit) {
            $words = str_word_count($text, 2);
            $pos = array_keys($words);
            $text = substr($text, 0, $pos[$limit]) . '...';
            $text = strip_tags($text);
            $text = "<p class='readmore'>".$text."</p>";
        } else {
            $text = "<p class='readmore'>".$text."</p>";
        }
        return $text;
    }

    public static function geocat_load($id) {
        if(empty($id)) {
            $category = array();
            $flash = new Flash();
            $flash->flash('flash_message', 'Geolocation category does not exist!', 'warning');
            header("Location: ".BASE_URL.'/404');
        } else {
            $category = db_select_row("SELECT * FROM geo_cat where id ='".$id."'");
            if(empty($category)) {
                $flash = new Flash();
                $flash->flash('flash_message', 'Geolocation category does not exist!', 'warning');
                header("Location: ".BASE_URL.'/404');
            }
        }
        return $category;
    }

    public static function geocat_save($id, $title, $description, $featured, $metadescription, $metakeywords) {
        $category_title = mysqli_real_escape_string(db_connect(), $title);
        $category_slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $category_title)));
        $category_description = mysqli_real_escape_string(db_connect(), $description);
        $category_featured = mysqli_real_escape_string(db_connect(), $featured);
        $category_metadescription = mysqli_real_escape_string(db_connect(), $metadescription);
        $category_metakeywords = mysqli_real_escape_string(db_connect(), $metakeywords);
        if(empty($id)) {
            db_query("INSERT INTO geo_cat (title, slug, description, featured, metadescription, metakeywords) VALUES ('".$category_title."', '".$category_slug."', '".$category_description."', '".$category_featured."', '".$category_metadescription."', '".$category_metakeywords."');");
            $flash = new Flash();
            $flash->flash('flash_message', 'Geolocation category created!');
            header("Location: ".BASE_URL.'/admin/plugin/geolocation/categories/list');
        } else {
            db_query("UPDATE ".MYSQL_DB.".geo_cat SET title = '".$category_title."', slug = '".$category_slug."', description = '".$category_description."', featured = '".$category_featured."', metadescription = '".$category_metadescription."', metakeywords = '".$category_metakeywords."' WHERE id = ".$id.";");
            $flash = new Flash();
            $flash->flash('flash_message', 'Geolocation category updated!');
            header("Location: ".BASE_URL.'/admin/plugin/geolocation/categories/list');
        }
    }

    public static function geocat_delete($id) {
        if(empty($id)) {
            $flash = new Flash();
            $flash->flash('flash_message', 'Geolocation category does not exist!', 'warning');
            header("Location: ".BASE_URL.'/admin/plugin/geolocation/categories/list');
        } else {
            db_query("DELETE FROM geo_cat WHERE id = ".$id);
            $flash = new Flash();
            $flash->flash('flash_message', 'Geolocation category deleted!');
            header("Location: ".BASE_URL.'/admin/plugin/geolocation/categories/list');
        }
    }

    public static function geocat_id_search($string = '', $id = '') {
        $string_id = explode(',',$string);
        if (in_array($id, $string_id))
            return $id;
        else
            return $id;
    }

}