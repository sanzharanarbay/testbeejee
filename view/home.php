<?php 
	session_start(); 

	if (!isset($_SESSION['username'])) {
		$_SESSION['msg'] = "You must log in first";
		header('location: login.php');
	}

	if (isset($_GET['logout'])) {
		session_destroy();
		unset($_SESSION['username']);
		header("location: login.php");
	}
$db = mysqli_connect('localhost', 'root', '', 'beejeetest');
	$query = "SELECT * FROM tasks";
			$results = mysqli_query($db, $query);

?>
<!DOCTYPE html>
<html>
<head>
	<title>Home</title>
	<link rel="stylesheet" type="text/css" href="style.css">
	 <link href="../libs/fontawesome/css/font-awesome.css" rel="stylesheet" />    
    <link rel="stylesheet" href="../libs/bootstrap.css"> 
    <script src="../libs/jquery.min.js"></script>
    <script src="../libs/bootstrap.js"></script>
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
</head>
<body>
	<div class="header">
		<h2>Home Page</h2>
	</div>
	<div class="content">

		<!-- notification message -->
		<?php if (isset($_SESSION['success'])) : ?>
			<div class="error success" >
				<h3>
					<?php 
						echo $_SESSION['success']; 
						unset($_SESSION['success']);
					?>
				</h3>
			</div>
		<?php endif ?>

		<!-- logged in user information -->
		<?php  if (isset($_SESSION['username'])) : ?>
			<p>Welcome <strong><?php echo $_SESSION['username']; ?></strong></p>
			<p> <a class="btn btn-danger" href="home.php?logout='1'">logout</a> </p>
		<?php endif ?>
	</div> <br><br>
 <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <?php
                        if($results->num_rows > 0){
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
                                while($row = mysqli_fetch_array($results)){
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
                                        echo "<a href='../index.php?act=update&id=". $row['id'] ."' title='Update Record' data-toggle='tooltip'><i class='fa fa-edit'></i></a>";
                                        echo "</td>";
                                    echo "</tr>";
                                }
                                echo "</tbody>";                            
                            echo "</table>";
                            // Free result set
                            mysqli_free_result($results);
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