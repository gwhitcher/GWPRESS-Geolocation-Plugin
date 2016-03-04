<?php
class Geolocation_Install {

    public function __construct() {
    }

    public static function install() {
        //Check if database is already installed
        $database_lookup = db_select("SELECT * FROM geo");
        if(!empty($database_lookup)) {
            $flash = new Flash();
            $flash->flash('flash_message', 'GWPRESS Geolocation plugin already installed!  Remember to remove your install.php from your plugin geolocation directory.', 'danger');
            header("Location: ".BASE_URL."");
        } else {
            //Create geo table
            $sql = "CREATE TABLE geo (
id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
category_id VARCHAR(255),
title VARCHAR(255),
slug VARCHAR(255),
body TEXT,
address TEXT,
featured TEXT,
lat VARCHAR(255),
lng VARCHAR(255),
metadescription VARCHAR(255),
metakeywords VARCHAR(255),
status INT(11),
created_date DATETIME,
updated_date DATETIME
)";
            db_query($sql);

            //Create geolocation categories table
            $sql = "CREATE TABLE geo_cat (
id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
title VARCHAR(255),
slug VARCHAR(255),
description TEXT,
featured TEXT,
metadescription VARCHAR(255),
metakeywords VARCHAR(255)
)";
            db_query($sql);

            //Insert geolocation welcome post(s) into database.
            $post_category_id = 1;
            $post_title = 'Google Cambridge';
            $post_slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $post_title)));
            $post_body = 'This is a test post of the geolocation plugin for GWPRESS.';
            $post_address = '355 Main St, Cambridge, MA 02142';
            $post_featured = 'default.jpg';
            $post_latitude = '-71.0871087';
            $post_longitude = '42.3627572';
            $post_metadescription = METADESCRIPTION;
            $post_metakeywords = METAKEYWORDS;
            $post_status = 1;
            $post_created_date = date("Y-m-d H:i:s");
            $post_updated_date = date("Y-m-d H:i:s");
            db_query("INSERT INTO geo (category_id, title, slug, body, address, featured, lat, lng, metadescription, metakeywords, status, created_date, updated_date) VALUES (".$post_category_id.", '".$post_title."', '".$post_slug."', '".$post_body."', '".$post_address."', ".$post_featured.", '".$post_latitude."', '".$post_longitude."', '".$post_metadescription."', '".$post_metakeywords."', ".$post_status.", '".$post_created_date."', '".$post_updated_date."');");

            //Insert default category
            $category_title = 'Uncategorized';
            $category_slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $category_title)));
            $category_description = '<p>Posts that do not fall into other categories.</p>';
            $category_featured = 'default.jpg';
            $category_metadescription = METADESCRIPTION;
            $category_metakeywords = METAKEYWORDS;
            db_query("INSERT INTO geo_cat (title, slug, description, featured, metadescription, metakeywords) VALUES ('".$category_title."', '".$category_slug."', '".$category_description."', '".$category_featured."', '".$category_metadescription."', '".$category_metakeywords."');");

            //Flash message and forward to home.
            $flash = new Flash();
            $flash->flash('flash_message', 'GWPRESS geolocation plugin installed.  Thank you for choosing GWPRESS.');
            header("Location: ".BASE_URL."");
        }
    }

}