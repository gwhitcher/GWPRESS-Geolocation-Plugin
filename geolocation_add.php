<?php
if(!empty($_POST)) {
    $category_id_post = $_POST['category_id'];
    $category_id = implode(",", $category_id_post);
    $title = $_POST['title'];
    $body = $_POST['body'];
    $address = $_POST['address'];
    $featured = $_POST['featured'];
    $longitude = $_POST['longitude'];
    $latitude = $_POST['latitude'];
    $metadescription = $_POST['metadescription'];
    $metakeywords = $_POST['metakeywords'];
    $status = $_POST['status'];
    $post = new Geolocation();
    $post->geoloc_save('', ''.$category_id.'', ''.$title.'', ''.$body.'', ''.$address.'', ''.$featured.'', ''.$longitude.'', ''.$latitude.'', ''.$metadescription.'', ''.$metakeywords.'', ''.$status.'');
}
$categories = db_select("SELECT * FROM geo_cat");
?>
<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
    <h1 class="page-header">Add Geolocation</h1>
    <form class="form-horizontal" enctype="multipart/form-data" method="post" accept-charset="utf-8" action="<?php echo BASE_URL; ?>/admin/plugin/geolocation/add">

        <div class="form-group">
            <label for="category_id" class="col-sm-2 control-label">Category ID</label>
            <div class="col-sm-10">
                <select name="category_id[]" id="category_id" class="form-control" required multiple>
                    <?php foreach ($categories as $category) { ?>
                        <?php
                        echo '<option ';
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
                <input type="text" class="form-control" id="title" name="title" placeholder="Title" required>
            </div>
        </div>

        <div class="form-group">
            <label for="body" class="col-sm-2 control-label">Body</label>
            <div class="col-sm-10">
                <textarea id="body" name="body" class="form-control" rows="3" placeholder="Body"></textarea>
            </div>
        </div>

        <div class="form-group">
            <label for="address" class="col-sm-2 control-label">Address</label>
            <div class="col-sm-10">
                <textarea id="address" name="address" class="form-control" rows="3" placeholder="Address"></textarea>
            </div>
        </div>

        <div class="form-group">
            <label for="featured" class="col-sm-2 control-label">Featured Image</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="featured" name="featured" placeholder="Featured Image">
            </div>
        </div>

        <div id="response-container">
            <div class="form-group">
                <label for="longitude" class="col-sm-2 control-label">Longitude</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="longitude" name="longitude" placeholder="Longitude">
                </div>
            </div>

            <div class="form-group">
                <label for="latitude" class="col-sm-2 control-label">Latitude</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="latitude" name="latitude" placeholder="Latitude">
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="metadescription" class="col-sm-2 control-label">Meta Description</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="metadescription" name="metadescription" placeholder="Meta Description">
            </div>
        </div>

        <div class="form-group">
            <label for="metakeywords" class="col-sm-2 control-label">Meta Keywords</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="metakeywords" name="metakeywords" placeholder="Meta Keywords">
            </div>
        </div>

        <div class="form-group">
            <label for="status" class="col-sm-2 control-label">Status</label>
            <div class="col-sm-10">
                <select class="form-control" id="status" name="status">
                    <option value="0">Draft</option>
                    <option value="1">Published</option>
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