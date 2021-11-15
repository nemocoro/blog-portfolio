<?php
    require_once 'database.php';

    class Category extends Database
    {
        private $conn;

        public function __construct()
        {
            $this->conn = $this->connect();
        }

        public function displayCategoriesAsOptions($id=NULL)
        {
            $sql = "SELECT * FROM categories";
            $result = $this->conn->query($sql);

            if($result && $result->num_rows>0)
            {
                while($row=$result->fetch_assoc())
                {
                    if($id==$row["category_id"])
                    {
                        echo "<option value='".$row['category_id']."' selected>".$row["category_name"]."</option>";
                    }
                    else
                    {
                        echo "<option value='".$row['category_id']."'>".$row["category_name"]."</option>";
                    }
                }
            }
            else
            {
                echo "<option selected disabled>No categories to display</option>";
            }
        }

        public function displayCategoriesAsRows()
        {
            $sql = "SELECT * FROM categories";
            $result = $this->conn->query($sql);
            
            if($result && $result->num_rows >0)
            {
                while($row = $result->fetch_assoc())
                {
                    echo 
                    "<tr>
                        <td>{$row['category_id']}</td>
                        <td>{$row['category_name']}</td>
                        <td>
                            <a href='#' class='btn btn-warning text-white btn-sm btn-block'>Update</a>
                        </td>
                        <td>
                            <button type='button'  data-toggle='modal' data-target='#deleteModal{$row['category_id']}' class='btn btn-danger btn-sm btn-block'>Delete</button>
                        </td>";

                    //display modal / dialog box
                    echo 
                    "<div class='modal fade'id='deleteModal{$row['category_id']}' tabindex='-1' aria-labelledby='deleteModal{$row['category_id']}' aria-hidden='true'>
                    <div class='modal-dialog'>
                      <div class='modal-content'>
                        <div class='modal-header'>
                          <h5 class='modal-title'>Delecte Category</h5>
                          <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                            <span aria-hidden='true'>&times;</span>
                          </button>
                        </div>
                        <div class='modal-body'>
                          <p>Are you sure you want to delete the category <span class='font-weight-bold'>{$row['category_name']}</span>?</p>
                        </div>
                        <div class='modal-footer'>
                          <button type='button' class='btn btn-outline-secondary btn-sm' data-dismiss='modal'>Cancel</button>
                          <a href='../action/delete-action.php?id={$row['category_id']}' type='button' class='btn btn-danger btn-sm'>Delete</a>
                        </div>
                      </div>
                    </div>
                  </div>";

                    echo "</tr>"; 
                }         
            }
            else
            {
                echo "<tr><td class='text-center' colspan='4'>No Categories to display</td></tr>";
            }

        }

        public function deleteCategory($category_id)
        {
            $sql = "DELETE FROM categories WHERE category_id = $category_id";

            $result = $this->conn->query($sql);
            
            if($result)
            {
                $_SESSION["success"] = 1;
                $_SESSION["message"] = "You have successfully deleted the category.";
                header("Location:../views/categories.php");
            }
            else
            {
                $_SESSION["success"] = 0;
                $_SESSION["message"] = "Failed to delete category. Kindly try again.";
                header("Location:../views/categories.php");
            }
        }
    }
?>