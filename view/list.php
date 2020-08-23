<?php session_unset();?>
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
            </div>        
        </div>
    </div>
</body>
</html>