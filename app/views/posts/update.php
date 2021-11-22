<?php
    require_once APPROOT . '/views/includes/head.php';
?>
    <div class="container">
        <?php
            require_once APPROOT . '/views/includes/navigation.php';
        ?>
        <div class="form-container">
            <h1>Update Post</h1>
            <form action="<?php echo URLROOT . '/posts/update/' . $data['id']; ?>" method="POST">
                <input type="text" name="title" placeholder="Title*" value="<?php echo $data['title']; ?>">
                <?php if($data['titleError']) : ?>
                    <div class="errors">
                        <?php echo $data['titleError']; ?>
                    </div>
                <?php endif; ?>

                <textarea name="body" placeholder="Body*"><?php echo $data['body']; ?></textarea>
                <?php if($data['bodyError']) : ?>
                    <div class="errors">
                        <?php echo $data['bodyError']; ?>
                    </div>
                <?php endif; ?>

                <button class="btn btn-wide" type="submit">Update</button>
            </form>
        </div>
    </div>
<?php
    require_once APPROOT . '/views/includes/foot.php';
?>