<?php
        require '../model/task.php'; 
        session_start();             
        $task=isset($_SESSION['taskl0'])?unserialize($_SESSION['taskl0']):new task();            
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Record</title>
    <link rel="stylesheet" href="../libs/bootstrap.css">
    <style type="text/css">
        .wrapper{
            width: 500px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h2>Update Task</h2>
                    </div>
                    <p>Please fill this form and submit to add sports record in the database.</p>
                    <form action="../index.php?act=update" method="post" >
                        <div class="form-group <?php echo (!empty($task->username_msg)) ? 'has-error' : ''; ?>">
                            <label>Username</label>
                            <input type="text" name="username" class="form-control" value="<?php echo $task->username; ?>">
                            <span class="help-block"><?php echo $task->username_msg;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($task->email_msg)) ? 'has-error' : ''; ?>">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" value="<?php echo $task->email; ?> ">
                            <span class="help-block"><?php echo $task->email_msg;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($task->task_text_msg)) ? 'has-error' : ''; ?>">
                            <label>Text</label>
                            <textarea name="task_text" class="form-control">
                                <?php echo $task->task_text; ?>
                            </textarea> 
                            <span class="help-block"><?php echo $task->task_text_msg;?></span>
                        </div>
                        <div class="form-group">
                            <label>Checked</label>
                           <input type="checkbox" name="checked"  value="1" <?php if($task->checked === 1) echo 'checked="checked"';?> />
                        </div>
                        <input type="hidden" name="id" value="<?php echo $task->id; ?>"/>
                        <input type="submit" name="updatebtn" class="btn btn-primary" value="Submit">
                        <a href="../index.php" class="btn btn-default">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>