<?php
include "db.php";
header("Content-Type: application/json");
$action = $_POST['action'] ?? $_GET['action'] ?? '';

if($action=="list"){
    $s=$_GET['search']??'';$c=$_GET['course']??'';
    $w="WHERE 1";
    if($s) $w.=" AND (full_name LIKE '%$s%' OR email LIKE '%$s%')";
    if($c) $w.=" AND course='$c'";
    $q=mysqli_query($conn,"SELECT * FROM students $w ORDER BY id DESC");
    $data=[];while($r=mysqli_fetch_assoc($q))$data[]=$r;
    echo json_encode($data);
}
elseif($action=="get"){
    $id=intval($_GET['id']);
    echo json_encode(mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM students WHERE id=$id")));
}
elseif($action=="add"){
    $name=htmlspecialchars(trim($_POST['full_name']));
    $email=htmlspecialchars(trim($_POST['email']));
    $course=htmlspecialchars(trim($_POST['course']));
    $year=intval($_POST['year']);$gpa=floatval($_POST['gpa']);
    if(!$name){echo json_encode(["ok"=>false,"msg"=>"Full name is required"]);exit;}
    mysqli_query($conn,"INSERT INTO students(full_name,email,course,year,gpa) VALUES('$name','$email','$course','$year','$gpa')");
    echo json_encode(["ok"=>true,"msg"=>"Student record added"]);
}
elseif($action=="edit"){
    $id=intval($_POST['id']);
    $name=htmlspecialchars(trim($_POST['full_name']));
    $email=htmlspecialchars(trim($_POST['email']));
    $course=htmlspecialchars(trim($_POST['course']));
    $year=intval($_POST['year']);$gpa=floatval($_POST['gpa']);
    mysqli_query($conn,"UPDATE students SET full_name='$name',email='$email',course='$course',year='$year',gpa='$gpa' WHERE id=$id");
    echo json_encode(["ok"=>true,"msg"=>"Student record updated"]);
}
elseif($action=="delete"){
    $id=intval($_POST['id']);
    mysqli_query($conn,"DELETE FROM students WHERE id=$id");
    echo json_encode(["ok"=>true,"msg"=>"Record deleted"]);
}
elseif($action=="courses"){
    $q=mysqli_query($conn,"SELECT DISTINCT course FROM students WHERE course!='' ORDER BY course");
    $list=[];while($r=mysqli_fetch_row($q))$list[]=$r[0];
    echo json_encode($list);
}
elseif($action=="stats"){
    $total=mysqli_fetch_row(mysqli_query($conn,"SELECT COUNT(*) FROM students"))[0];
    $avg=mysqli_fetch_row(mysqli_query($conn,"SELECT ROUND(AVG(gpa),2) FROM students"))[0];
    $cors=mysqli_fetch_row(mysqli_query($conn,"SELECT COUNT(DISTINCT course) FROM students"))[0];
    $top=mysqli_fetch_assoc(mysqli_query($conn,"SELECT full_name,gpa FROM students ORDER BY gpa DESC LIMIT 1"));
    echo json_encode(["total"=>$total,"avg"=>$avg,"cors"=>$cors,"top"=>$top?$top['full_name']:'—']);
}
?>