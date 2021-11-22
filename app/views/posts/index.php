<?php
    require_once APPROOT . '/views/includes/head.php';
?>
    <div class="container">
        <?php
            require_once APPROOT . '/views/includes/navigation.php';
        ?>
        <div class="content">
            <div class="main-bar">
                <h1>Posts</h1>
                <?php if(isLoggedIn()) : ?>
                    <div>
                        <a class="btn" href="<?php echo URLROOT . '/posts/create'; ?>">Create</a>
                    </div>
                <?php endif; ?>
            </div>
            
            <?php foreach($data['posts'] as $post) : ?>
                <div class="post">
                    <h1><?php echo $post->title; ?></h1>
                    <p>Created by <span class="author"><?php echo $post->user_name; ?></span> on <span class="timestamp"><?php echo date('F d Y, H:i', strtotime($post->created_at)); ?></span></p>
                    <p class="text"><?php echo $post->body; ?></p>
                    <div class="btn-group">
                        <?php if(isLoggedIn() && $_SESSION['user_id'] == $post->user_id) : ?>
                            <div>
                                <a class="btn" href="<?php echo URLROOT . '/posts/update/' . $post->id; ?>">Update</a>
                            </div>
                            <form action="<?php echo URLROOT . '/posts/delete/' . $post->id; ?>" method="POST">
                                <button class="btn" type="submit">Delete</button>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
<?php
    require_once APPROOT . '/views/includes/foot.php';
?>