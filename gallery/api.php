<?php
include "db.php";
header("Content-Type: application/json");
$action = $_POST['action'] ?? $_GET['action'] ?? '';

if($action=="upload"){
    $allowed=['jpg','jpeg','png','gif','webp'];
    $f=$_FILES['file']??null;
    $title=htmlspecialchars(trim($_POST['title']??''));
    if(!$f||$f['error']!=0){echo json_encode(["ok"=>false,"msg"=>"No file selected"]);exit;}
    $ext=strtolower(pathinfo($f['name'],PATHINFO_EXTENSION));
    if(!in_array($ext,$allowed)){echo json_encode(["ok"=>false,"msg"=>"Only JPG, PNG, GIF, WEBP allowed"]);exit;}
    if($f['size']>5000000){echo json_encode(["ok"=>false,"msg"=>"Max file size is 5MB"]);exit;}
    $newname=time()."_".uniqid().".".$ext;
    if(!is_dir("uploads")) mkdir("uploads",0777,true);
    if(move_uploaded_file($f['tmp_name'],"uploads/".$newname)){
        $orig=htmlspecialchars($f['name']);
        mysqli_query($conn,"INSERT INTO images(filename,original_name,title) VALUES('$newname','$orig','$title')");
        echo json_encode(["ok"=>true,"msg"=>"Image uploaded successfully"]);
    } else {
        echo json_encode(["ok"=>false,"msg"=>"Upload failed. Check uploads/ folder."]);
    }
}
elseif($action=="list"){
    $q=mysqli_query($conn,"SELECT * FROM images ORDER BY id DESC");
    $data=[];while($r=mysqli_fetch_assoc($q))$data[]=$r;
    echo json_encode($data);
}
elseif($action=="delete"){
    $id=intval($_POST['id']);
    $row=mysqli_fetch_assoc(mysqli_query($conn,"SELECT filename FROM images WHERE id=$id"));
    if($row){@unlink("uploads/".$row['filename']);}
    mysqli_query($conn,"DELETE FROM images WHERE id=$id");
    echo json_encode(["ok"=>true,"msg"=>"Image deleted"]);
}
elseif($action=="stats"){
    $total=mysqli_fetch_row(mysqli_query($conn,"SELECT COUNT(*) FROM images"))[0];
    echo json_encode(["total"=>$total]);
}
?>