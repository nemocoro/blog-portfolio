<?php
    include '../class/post.php';
    include '../class/category.php';

    $post = new Post();
    $category = new Category();

    $post_id = isset($_GET["id"])?$_GET["id"]:NULL;
    $post_details = $post->getPost($post_id);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Edit Post</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.3/css/all.css" integrity="sha384-SZXxX4whJ79/gErwcOYf+zWLeJdY/qpuqC4cAa9rOGUstPomtqpuNWT9wdPEn2fk" crossorigin="anonymous">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a href="#" class="navbar-brand">Blog</a>
            
            <button class="navbar-toggler" data-toggle="collapse" data-target="#menu">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="menu">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a href="#" class="nav-link">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">Users</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">Posts</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">Categories</a>
                    </li>
                </ul>
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a href="#" class="nav-link">Welcome, <?php echo $_SESSION["firstname"]." ".$_SESSION["lastname"]; ?>!</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="jumbotron-fluid bg-info">
        <div class="container py-5">
            <h1 class="text-white display-4"><i class="fas fa-pen"></i> Update Post</h1>
        </div>
    </div>
    <div class="container" style="margin-bottom: 7%;">
        <div class="row mt-5">
            <div class="col-5 mx-auto">
                <!-- DISPLAY ERROR / SUCCESS MESSAGE -->
                <?php
                    if( isset($_SESSION["success"]) && isset($_SESSION["message"]))
                    {
                        $class = ($_SESSION["success"]==0)?"danger":"success";
                        $message = $_SESSION["message"];

                        //UNSET / remove session variables
                        unset($_SESSION["success"]);
                        unset($_SESSION["message"]);
                ?>
                    <div class="alert alert-<?php echo $class;?>" role="alert">
                        <?php echo $message;?>
                    </div>
                <?php        
                    }
                ?>
            </div>
        </div>
        <div class="row">
            <div class="col-5 mx-auto">
                <form action="../action/update-post-action.php" method="POST">
                    <input type="number" name="post_id" value="<?php echo $post_id;?>" hidden>
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" name="title" id="title" class="form-control" value="<?php echo $post_details["post_title"];?>">
                    </div>
                    <div class="form-group">
                        <label for="date">Date</label>
                        <input type="date" class="form-control" name="date" id="date" value="<?php echo $post_details["date_posted"];?>">
                    </div>
                    <div class="form-group">
                        <label for="category">Category</label>
                        <select class="form-control" name="category" id="category">
                            <option value="" selected>Editorial</option>
                            <?php $category->displayCategoriesAsOptions($post_details["category_id"]);?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="message">Message</label>
                        <textarea class="form-control" name="message" id="message" cols="30" rows="10"><?php echo $post_details["post_message"];?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="author">Author</label>
                        <select name="author" id="author" class="form-control">
                            <?php $post->displayAuthorAsOptions($post_details["account_id"]);?>
                        </select>
                    </div>
                    <input type="submit" value="Update" name="update" id="update" class="btn btn-block btn-info">
                </form>
            </div>
        </div>
    </div>     
    <footer class="footer bg-light fixed-bottom pt-3 border-top">
        <div class="container">
            <p class="text-center text-muted">&copy; 2021 | Your Name</p>
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
</body>
</html>