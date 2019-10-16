<?php
include "connection.php"; 
session_start();


if(isset($_POST['login']))
{
    extract($_POST);
    // echo $email."<br>";
    // echo $pass."<br>";
    
    $query = "SELECT * FROM registers WHERE user_email = '$email' AND user_password = md5('$pass')";
    $res = mysqli_query($conn, $query);
            if (mysqli_num_rows($res)>0) {
                ?><script> alert('Login Successfully')</script> <?php
                // header("location:javascript://history.go(-1)");
                $data=mysqli_fetch_assoc($res);
                
                $_SESSION['login']=array('user_id'=>$data['user_id'], 'user_name'=>$data['user_fullname'], 'user_email'=>$data['user_email'], 'user_number'=>$data['user_phone']);
                
                header("refresh:0;url=".$_SERVER['HTTP_REFERER']);
            }
            else
            {
                ?><script> alert('Invalid User And Password')</script> <?php
                header("refresh:0;url=".$_SERVER['HTTP_REFERER']);
            }
    // 
}


if(isset($_POST['signup']))
{
    extract($_POST);
    $query1 = "SELECT * FROM registers WHERE user_email = '$email' AND user_phone = '$mobile'";
    $res1 = mysqli_query($conn, $query1);
    
    $query2 = "SELECT * FROM registers WHERE user_email = '$email'";
    $res2 = mysqli_query($conn, $query2);
    
    $query3 = "SELECT * FROM registers WHERE user_phone = '$mobile'";
    $res3 = mysqli_query($conn, $query3);
    
    if(mysqli_num_rows($res1)>0) {
        ?><script> alert('Email And Mobile Number Already Exists')</script> <?php
        header("refresh:0;url=".$_SERVER['HTTP_REFERER']);
    }
    elseif(mysqli_num_rows($res2)>0) {
        ?><script> alert('Email Already Exists')</script> <?php
        header("refresh:0;url=".$_SERVER['HTTP_REFERER']);
    }
    elseif(mysqli_num_rows($res3)>0) {
        ?><script> alert('Mobile Number Already Exists')</script> <?php
        header("refresh:0;url=".$_SERVER['HTTP_REFERER']);
    }
    else
    {
        $sql = "INSERT INTO registers (user_phone, user_fullname, user_email, user_password)
                    VALUES ('$mobile', '$Name', '$email', md5('$pass'))";
        $insert=mysqli_query($conn, $sql);
        $last_id = mysqli_insert_id($conn);
        
        if($last_id)
        {
            $query4 = "SELECT * FROM registers WHERE user_id = '$last_id'";
            $res4 = mysqli_query($conn, $query1);
            $data=mysqli_fetch_assoc($res4);
            $_SESSION['login']=array('user_id'=>$data['user_id'], 'user_name'=>$data['user_fullname'], 'user_email'=>$data['user_email'], 'user_number'=>$data['user_phone']);
            
            ?><script> alert('Signup Successfully')</script> <?php
            header("refresh:0;url=".$_SERVER['HTTP_REFERER']);
        }
        else{
            ?><script> alert('Something Went Wrong\n Signup Not Successfully')</script> <?php
            header("refresh:0;url=".$_SERVER['HTTP_REFERER']);
        }
    }
    
}

?>