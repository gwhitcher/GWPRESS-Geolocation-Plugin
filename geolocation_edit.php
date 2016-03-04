<?php
$id = mysqli_real_escape_string(db_connect(), $_GET['id']);
$info = new Geolocation();
$post = $info->geoloc_load($id);
if(!empty($_POST)) {
    $category_id_post = $_POST['category_id'];
    $category_id = implode(",", $category_id_post);
    $title = $_POST['title'];
    $body = $_POST['body'];
    $address = $_POST['address'];
    $featured = $_POST['featured'];
    $lat = $_POST['lat'];
    $lng = $_POST['lng'];
    $metadescription = $_POST['metadescription'];
    $metakeywords = $_POST['metakeywords'];
    $status = $_POST['status'];
    $post = new Geolocation();
    $post->geoloc_save($id, ''.$category_id.'', ''.$title.'', ''.$body.'', ''.$address.'', ''.$featured.'', ''.$lat.'', ''.$lng.'', ''.$metadescription.'', ''.$metakeywords.'', ''.$status.'');
}
$categories = db_select("SELECT * FROM geo_cat");
?>
<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
    <h1 class="page-header">Geolocation: <?php echo $post['title'];?></h1>
    <form class="form-horizontal" enctype="multipart/form-data" method="post" accept-charset="utf-8" action="<?php echo BASE_URL; ?>/admin/plugin/geolocation/edit?id=<?php echo $id;?>">

        <div class="form-group">
            <label for="category_id" class="col-sm-2 control-label">Category ID</label>
            <div class="col-sm-10">
                <select name="category_id[]" id="category_id" class="form-control" required multiple>
                    <?php foreach ($categories as $category) { ?>
                        <?php
                        echo '<option ';
                        $post_categories = $post['category_id'];
                        $category_ids = explode(',',$post_categories);
                        if (in_array($category['id'], $category_ids)) {
                            echo 'selected="selected"';
                        }
                        echo 'value="'.$category['id'].'">';
                        echo $category['title'];
                        echo '</option>';
                        ?>
                    <?php } ?>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label for="title" class="col-sm-2 control-label">Title</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="title" name="title" placeholder="Title" value="<?php echo $post['title'];?>" required>
            </div>
        </div>

        <div class="form-group">
            <label for="body" class="col-sm-2 control-label">Body</label>
            <div class="col-sm-10">
                <textarea id="body" name="body" class="form-control" rows="3" placeholder="Body"><?php echo $post['body'];?></textarea>
            </div>
        </div>

        <div class="form-group">
            <label for="address" class="col-sm-2 control-label">Address</label>
            <div class="col-sm-10">
                <textarea id="address" name="address" class="form-control" rows="3" placeholder="Address" required><?php echo $post['address'];?></textarea>
            </div>
        </div>

        <div class="form-group">
            <label for="featured" class="col-sm-2 control-label">Featured Image</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="featured" name="featured" placeholder="Featured Image" value="<?php echo $post['featured'];?>">
            </div>
        </div>

        <div id="response-container">
            <div class="form-group">
                <label for="lat" class="col-sm-2 control-label">Latitude</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="lat" name="lat" placeholder="Latitude" value="<?php echo $post['lat'];?>">
                </div>
            </div>

            <div class="form-group">
                <label for="lng" class="col-sm-2 control-label">Longitude</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="lng" name="lng" placeholder="Longitude" value="<?php echo $post['lng'];?>">
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="metadescription" class="col-sm-2 control-label">Meta Description</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="metadescription" name="metadescription" placeholder="Meta Description" value="<?php echo $post['metadescription'];?>">
            </div>
        </div>

        <div class="form-group">
            <label for="metakeywords" class="col-sm-2 control-label">Meta Keywords</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="metakeywords" name="metakeywords" placeholder="Meta Keywords" value="<?php echo $post['metakeywords'];?>">
            </div>
        </div>

        <div class="form-group">
            <label for="status" class="col-sm-2 control-label">Status</label>
            <div class="col-sm-10">
                <select class="form-control" name="status" id="status">
                    <option <?php if($post['status'] == 0) echo 'selected="selected"'; ?> value="0">Draft</option>
                    <option <?php if($post['status'] == 1) echo 'selected="selected"'; ?> value="1">Published</option>
                </select>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" id="submit" name="submit" class="btn btn-default">Submit</button>
            </div>
        </div>
    </form>
</div>
<script src="<?php echo ADMIN_THEME_URL; ?>/js/jquery.min.js"></script>
<script type="text/javascript">
    $(function() {
        $("#address").bind("change", function() {
            $.ajax({
                type: "GET",
                url: "<?php echo BASE_URL;?>/admin/ajax/address_lookup",
                data: "address="+$("#address").val(),
                success: function(data) {
                    $("#response-container").html(data);
                }
            });
        });
    });
</script>