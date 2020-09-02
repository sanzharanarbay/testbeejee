<?php session_unset();
$servername='localhost';
$username='root';
$password='';
$dbname = "beejeetest";
$conn=mysqli_connect($servername,$username,$password,"$dbname");
if(!$conn){
die('Could not Connect My Sql:' .mysql_error());
}
$limit = 3;  
if (isset($_GET["page"])) {
    $page  = $_GET["page"]; 
    } 
    else{ 
    $page=1;
    };

if (isset($_GET["orderBy"])) {
    $orderBy = $_GET["orderBy"]; 
    } 
    else{ 
    $orderBy='id';
    };  

$start_from = ($page-1) * $limit;  
$result = mysqli_query($conn,"SELECT * FROM tasks ORDER BY $orderBy ASC LIMIT $start_from, $limit");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tasks</title>
    <link href="~/../libs/fontawesome/css/font-awesome.css" rel="stylesheet" />    
    <link rel="stylesheet" href="~/../libs/bootstrap.css"> 
    <script src="~/../libs/jquery.min.js"></script>
    <script src="~/../libs/bootstrap.js"></script>
    <style type="text/css">
        .wrapper{
            width: 650px;
            margin: 0 auto;
        }
        .page-header h2{
            margin-top: 0;
        }
        table tr td:last-child a{
            margin-right: 15px;
        }
    </style>
    <script type="text/javascript">
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();   
        });
    </script>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header clearfix">
                        <a href="index.php" class="btn btn-success pull-left">Home</a>
                        <a href="view/login.php" class="btn btn-primary pull-right">Login</a>
                        <br><br><br>
                        <h2 class="pull-left">Tasks</h2>
                        <a href="view/insert.php" class="btn btn-danger pull-right">Add Task</a>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-6">
                            <h4>Сортировать ПО:</h4>
                        </div>
                         <div class="col-md-6">
                            <input type="hidden" id="page" value="<?php echo $page; ?>">
                            <form action="?" method="GET" onchange="sort()">
                            <select name="orderBy" id="my_select" class="form-control">
                            <option value="id">Выберите сортировку по</option>
                            <option value="username">Имя пользователя</option>
                            <option value="email">Email</option>
                            <option value="checked">Статус</option>
                        </select>
                    </form>
                        </div>
                                        </div>
                    <?php
                        if($result->num_rows > 0){
                            echo "<table class='table table-bordered table-striped'>";
                                echo "<thead>";
                                    echo "<tr>";
                                        echo "<th>#</th>";                                        
                                        echo "<th>Username</th>";
                                        echo "<th>Email</th>";
                                        echo "<th>Text</th>";
                                        echo "<th>Status</th>";
                                        echo "<th>Action</th>";
                                    echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                while($row = mysqli_fetch_array($result)){
                                    $status = "";
                                    if($row['checked'] == false){
                                         $status = "Not checked!";
                                    }else{
                                        $status = "Checked!";
                                    }
                                    echo "<tr>";
                                        echo "<td>" . $row['id'] . "</td>";                                        
                                        echo "<td>" . $row['username'] . "</td>";
                                        echo "<td>" . $row['email'] . "</td>";
                                        echo "<td>" . $row['task_text'] . "</td>";
                                         echo "<td>" . $status . "</td>";
                                        echo "<td>";
                                        echo "<a href='index.php?act=delete&id=". $row['id'] ."' title='Delete Record' data-toggle='tooltip'><i class='fa fa-trash'></i></a>";
                                        echo "</td>";
                                    echo "</tr>";
                                }
                                echo "</tbody>";                            
                            echo "</table>";
                            // Free result set
                            mysqli_free_result($result);
                        } else{
                            echo "<p class='lead'><em>No records were found.</em></p>";
                        }
                    ?>
                </div>
                <?php  

                $result_db = mysqli_query($conn,"SELECT COUNT(id) FROM tasks"); 
                $row_db = mysqli_fetch_row($result_db);  
                $total_records = $row_db[0];  
                $total_pages = ceil($total_records / $limit); 
                /* echo  $total_pages; */
                $pagLink = "<ul class='pagination'>";  
                for ($i=1; $i<=$total_pages; $i++) {
                              $pagLink .= "<li class='page-item'><a class='page-link' href='index.php?page=".$i."'>".$i."</a></li>";   
                }
                echo $pagLink . "</ul>";  
                ?>
            </div>        
        </div>
    </div>

   <script type="text/javascript">
  function sort(option){
     var option = $('#my_select').val();
     var page = $('#page').val();
   window.location = window.location.pathname+'?page='+page+'&orderBy='+option;
}
</script>
</body>
</html>