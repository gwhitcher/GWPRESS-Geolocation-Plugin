<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
    <h1 class="page-header">Geolocation Plugin</h1>
    <p>If you have not already make sure and run the <a href="<?php echo BASE_URL; ?>/admin/plugin/geolocation/install">install</a>.</p>
    <a class="btn btn-success" href="<?php echo BASE_URL; ?>/admin/plugin/geolocation/add">New</a>
    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead>
            <tr>
                <th>#</th>
                <th>Title</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $pagination = new Paginator();
            $pagination_limit = 10;
            $posts = $pagination->pagination($pagination_limit, 'geo');
            foreach($posts as $post) {
                echo '<tr>';
                echo '<td>'.$post['id'].'</td>';
                echo '<td>'.$post['title'].'</td>';
                echo '<td><a class="btn btn-warning" href="'.BASE_URL.'/admin/plugin/geolocation/edit?id='.$post['id'].'">Edit</a></td>';
                echo '<td><a class="delete btn btn-danger"" href="'.BASE_URL.'/admin/plugin/geolocation/delete?id='.$post['id'].'">Delete</a></td>';
                echo '</tr>';
            }
            ?>
            </tbody>
        </table>
        <?php $pagination->pagination_links($pagination_limit, 'geo'); ?>
    </div>

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCKcOXgfh9JCLGO-0NSifmCh9jSXdIU8oo" type="text/javascript"></script>
    <script src="<?php echo BASE_URL; ?>/gw-content/plugins/geolocation/google_map.js" type="text/javascript"></script>
    <div>
        <input type="text" id="addressInput" size="10"/>
        <select id="radiusSelect">
            <option value="25" selected>25mi</option>
            <option value="100">100mi</option>
            <option value="200">200mi</option>
            <option value="10000">10000mi</option>
        </select>

        <input type="button" onclick="searchLocations()" value="Search"/>
    </div>
    <div><select id="locationSelect" style="width:100%;display: none;"></select></div>
    <div id="map" style="width: 100%; height: 80%"></div>








</div>