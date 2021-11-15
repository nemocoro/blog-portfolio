<?php
    include '../class/post.php';

    if( isset($_POST["update"]) )
    {
        //INPUT
        $post_id = $_POST["post_id"];
        $post_title = $_POST["title"];
        $date_posted = $_POST["date"];
        $category = $_POST["category"];
        $message = $_POST["message"];
        $author = $_POST["author"];

        $post = new Post();

        $post->updatePost($post_id,$post_title,$date_posted,$category,$message,$author);
    }

?>