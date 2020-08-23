<?php
    require 'model/taskModel.php';
    require 'model/task.php';
    require_once 'config.php';

    session_status() === PHP_SESSION_ACTIVE ? TRUE : session_start();
    
	class tasksController 
	{

 		function __construct() 
		{          
			$this->objconfig = new config();
			$this->objsm =  new taskModel($this->objconfig);
		}
        // mvc handler request
		public function mvcHandler() 
		{
			$act = isset($_GET['act']) ? $_GET['act'] : NULL;
			switch ($act) 
			{
                case 'add' :                    
					$this->insert();
					break;						
				case 'update':
					$this->update();
					break;				
				case 'delete' :					
					$this -> delete();
					break;								
				default:
                    $this->list();
			}
		}		
        // page redirection
		public function pageRedirect($url)
		{
			header('Location:'.$url);
		}	
        // check validation
		public function checkValidation($task)
        {    $noerror=true;
            // Validate username        
            if(empty($task->username)){
                $task->username_msg = "Field is empty.";$noerror=false;
            } elseif(!filter_var($task->username, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
                $task->username_msg = "Invalid entry.";$noerror=false;
            }else{$task->username_msg ="";}            
            // Validate email            
            if(empty($task->email)){
                $task->email_msg = "Field is empty.";$noerror=false;     
            } elseif(!filter_var($task->email, FILTER_VALIDATE_EMAIL)){
                $task->email_msg = "Invalid entry.";$noerror=false;
            }else{$task->email_msg ="";}
            // Validate task_text
            if(empty($task->task_text)){
                $task->task_text_msg = "Field is empty.";$noerror=false;
            } elseif(!filter_var($task->task_text, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
                $task->task_text_msg = "Invalid entry.";$noerror=false;
            }else{$task->task_text_msg ="";} 
            return $noerror;
        }
        // add new record
		public function insert()
		{
            try{
                $task=new task();
                if (isset($_POST['addbtn'])) 
                {   
                    // read form value
                    $task->username = trim($_POST['username']);
                    $task->email = trim($_POST['email']);
                    $task->task_text = trim($_POST['task_text']);
                    $task->checked = false;
                    //call validation
                    $chk=$this->checkValidation($task);                    
                    if($chk)
                    {   
                        //call insert record            
                        $pid = $this -> objsm ->insertRecord($task);
                        if($pid>0){			
                            $this->list();
                        }else{
                            echo "Somthing is wrong..., try again.";
                        }
                    }else
                    {    
                        $_SESSION['taskl0']=serialize($task);//add session obj           
                        $this->pageRedirect("view/insert.php");                
                    }
                }
            }catch (Exception $e) 
            {
                $this->close_db();	
                throw $e;
            }
        }
        // update record
        public function update()
		{
            try
            {
                
                if (isset($_POST['updatebtn'])) 
                {
                    $task=unserialize($_SESSION['taskl0']);
                    $task->id = trim($_POST['id']);
                    $task->username = trim($_POST['username']);
                    $task->email = trim($_POST['email']); 
                    $task->task_text = trim($_POST['task_text']);  
                    $task->checked = trim($_POST['checked']);                 
                    // check validation  
                    $chk=$this->checkValidation($task);
                    if($chk)
                    {
                        $res = $this -> objsm ->updateRecord($task);	                        
                        if($res){			
                            $this->pageRedirect("view/home.php");                            
                        }else{
                            echo "Somthing is wrong..., try again.";
                        }
                    }else
                    {         
                        $_SESSION['taskl0']=serialize($task);      
                        $this->pageRedirect("view/update.php");                
                    }
                }elseif(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
                    $id=$_GET['id'];
                    $result=$this->objsm->selectRecord($id);
                    $row=mysqli_fetch_array($result);  
                    $task=new task();                  
                    $task->id=$row["id"];
                    $task->email=$row["email"];
                    $task->username=$row["username"];
                    $task->task_text=$row["task_text"];
                    $task->checked=$row["checked"];
                    $_SESSION['taskl0']=serialize($task);
                    $this->pageRedirect('view/update.php');
                }else{
                    echo "Invalid operation.";
                }
            }
            catch (Exception $e) 
            {
                $this->close_db();				
                throw $e;
            }
        }
        // delete record
        public function delete()
		{
            try
            {
                if (isset($_GET['id'])) 
                {
                    $id=$_GET['id'];
                    $res=$this->objsm->deleteRecord($id);                
                    if($res){
                        $this->pageRedirect('index.php');
                    }else{
                        echo "Somthing is wrong..., try again.";
                    }
                }else{
                    echo "Invalid operation.";
                }
            }
            catch (Exception $e) 
            {
                $this->close_db();				
                throw $e;
            }
        }
        public function list(){
            $result=$this->objsm->selectRecord(0);
            include "view/list.php";                                        
        }
    }
		
	
?>