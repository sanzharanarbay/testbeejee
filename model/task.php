<?php

class task
{
    // table fields
    public $id;
    public $username;
    public $email;
	public $task_text;
	public $checked;
    // message string
    public $id_msg;
    public $username_msg;
    public $email_msg;
	public $task_text_msg;
	public $checked_msg;
    // constructor set default value
    function __construct()
    {
        $id=0;$username=$email=$task_text="";
        $id_msg=$username_msg=$email_msg=$task_text_msg="";
    }
}

?>