<?php include("includes/header.php"); ?>

<?php

$page = !empty($_GET['page']) ? (int)$_GET['page'] : 1;

$items_per_page = 4;

$items_total_count = Photo::count_all();

$paginate = new Paginate($page, $items_per_page, $items_total_count);

$sql = "SELECT * FROM photos ";
$sql .= "LIMIT {$items_per_page} ";
$sql .= "OFFSET {$paginate->offset()}";
$photos = Photo::find_this_query($sql);

?>

<div class="row">

    <!-- Blog Entries Column -->
    <div class="col-md-12">
        <div class="thumbnails row">
            <?php foreach ($photos as $photo) : ?>
                <div class="col-xs-6 col-md-3">
                    <a class="thumbnail" href="photo.php?id=<?php echo $photo->id; ?>">
                        <img class="image-responsive home_page_photo" src="admin/<?php echo $photo->image_path(); ?>" alt="">
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Blog Sidebar Widgets Column -->
    <!-- <div class="col-md-4">

        <?php //include("includes/sidebar.php"); 
        ?>

    </div> -->
    <!-- /.row -->

</div>

<?php include("includes/footer.php"); ?>