<?php
    require_once 'database.php';

    class Post extends Database
    {
        private $conn;

        public function __construct()
        {
            $this->conn = $this->connect();
        }

        public function displayPostsAsRows()
        {
            $sql = "SELECT post_id,post_title,category_name,date_posted FROM posts INNER JOIN categories ON posts.category_id = categories.category_id";
           
            $result = $this->conn->query($sql);
            
            if($result && $result->num_rows>0)
            {
                while($row = $result->fetch_assoc())
                {
                    echo "<tr>";
                    echo "<td>{$row['post_id']}</td>";
                    echo "<td>{$row['post_title']}</td>";
                    echo "<td>{$row['category_name']}</td>";
                    echo "<td>{$row['date_posted']}</td>";
                    echo "<td><a href='post-details.php?id={$row['post_id']}' class='btn btn-outline-dark btn-sm btn-block'><i class='fas fa-angle-double-right'></i> Details</a></td>";
                    echo "</tr>";
                }
            }
            else
            {
                echo "<tr><td class='text-center' colspan='5'>No posts to display.</td></tr>";
            }
        }

        public function getPost($post_id)
        {
            $sql = "SELECT post_id,post_title,post_message,date_posted,categories.category_id,category_name,users.account_id,first_name,last_name FROM posts INNER JOIN categories ON posts.category_id = categories.category_id INNER JOIN users ON posts.account_id=users.account_id WHERE post_id= $post_id";

            $result = $this->conn->query($sql);
            
            if($result && $result->num_rows>0)
            {
                return $result->fetch_assoc();
            }
            else
            {
                return FALSE;
            }
        }

        public function displayAuthorAsOptions($id = NULL)
        {
            $sql = "SELECT accounts.account_id,first_name, last_name, username FROM users INNER JOIN accounts ON users.account_id=accounts.account_id ";
            $result = $this->conn->query($sql);

            if($result && $result->num_rows>0)
            {
                while($row=$result->fetch_assoc())
                {
                    if($id==$row["account_id"])
                    {
                        echo "<option value='".$row['account_id']."' selected>".$row["first_name"]." ".$row["last_name"]." (".$row["username"].")</option>";
                    }
                    else
                    {
                        echo "<option value='".$row['account_id']."'>".$row["first_name"]." ".$row["last_name"]." (".$row["username"].")</option>";
                    }
                }
            }
            else
            {
                echo "<option selected disabled>No authors to display</option>";
            }
        }

        public function updatePost($post_id,$post_title,$date_posted,$category,$message,$author)
        {
            $sql = "UPDATE posts SET post_title='$post_title', date_posted = '$date_posted', category_id = $category, post_message =  '$message' WHERE post_id= $post_id";

            $result = $this->conn->query($sql);
            
            if($result)
            {
                $_SESSION["success"] = 1;
                $_SESSION["message"] = "Post successfully updated.";

                header("Location: ../views/dashboard.php");
            }
            else
            {
                $_SESSION["success"] = 0;
                $_SESSION["message"] = "Failed to update post. Kindly try again.";

                header("Location: ../views/update-post.php?id=$post_id");
            }
        }
    }
?>