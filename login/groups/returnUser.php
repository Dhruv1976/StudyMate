<?php 

$id;

function returnName($group_id,$user_id,$groupname,$username){
    if($group_id){
        $id=$group_id;
        $result= fetchQuery("select 'groupname' from `groups` where group_id = ".$id,"study_mate");
        return  $result[0]['groupname'];
    } 
    if($user_id){
        $id=$user_id;
        $result= fetchQuery("select username from `login_accounts` where user_id = ".$id,"study_mate");
        return  $result[0]['username'];
    } 
    if($groupname){
        $id=$groupname;
        $result= fetchQuery("select group_id from `groups` where groupname = '".$id."'","study_mate");
        return  $result[0]['group_id'];
    } 
    if($username){
        $id=$username;
        $result= fetchQuery("select user_id from `login_accounts` where username = '".$id."'","study_mate");
        print_r($result);
        return  $result[0]['user_id'];
    }
    return "invalid function use"; 
}

if($_POST){
    // include("dbconnect.php");
    
    if(!empty($_POST['group'])){
        $result= json_encode(fetchQuery("select status as count from `group_status_list` where 'admin_id' = ".$_SESSION['user_id']." and  groupname = '"
        .$_POST['group']."'","study_mate"));
        print_r($result);
    }
}

?>