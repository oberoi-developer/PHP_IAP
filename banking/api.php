<?php
include 'db.php';

$action = $_REQUEST['action'] ?? '';

function json($arr){ echo json_encode($arr); exit; }

if($action=='create'){
  $name = $_POST['holder_name'];
  $bal = floatval($_POST['balance']);

  $acc = rand(10000000,99999999);

  $conn->query("INSERT INTO accounts(account_number,holder_name,balance) VALUES('$acc','$name',$bal)");

  json(['ok'=>true,'msg'=>'Account created']);
}

if($action=='list'){
  $res = $conn->query("SELECT * FROM accounts ORDER BY id DESC");
  $rows=[];
  while($r=$res->fetch_assoc()) $rows[]=$r;
  json($rows);
}

if($action=='stats'){
  $t = $conn->query("SELECT COUNT(*) c, SUM(balance) b FROM accounts")->fetch_assoc();
  $deps = $conn->query("SELECT SUM(amount) s FROM transactions WHERE type='deposit'")->fetch_assoc();
  $wits = $conn->query("SELECT SUM(amount) s FROM transactions WHERE type='withdraw'")->fetch_assoc();

  json([
    'total'=>$t['c']??0,
    'balance'=>$t['b']??0,
    'deps'=>$deps['s']??0,
    'wits'=>$wits['s']??0
  ]);
}

if($action=='get'){
  $id=$_GET['id'];
  $r=$conn->query("SELECT * FROM accounts WHERE id=$id")->fetch_assoc();
  json($r);
}

if($action=='deposit' || $action=='withdraw'){
  $id=$_POST['id'];
  $amt=floatval($_POST['amount']);
  $note=$_POST['note'];

  $acc=$conn->query("SELECT * FROM accounts WHERE id=$id")->fetch_assoc();

  if($action=='withdraw' && $acc['balance']<$amt){
    json(['ok'=>false,'msg'=>'Insufficient balance']);
  }

  $new = $action=='deposit' ? $acc['balance']+$amt : $acc['balance']-$amt;

  $conn->query("UPDATE accounts SET balance=$new WHERE id=$id");
  $conn->query("INSERT INTO transactions(account_id,type,amount,note) VALUES($id,'$action',$amt,'$note')");

  json(['ok'=>true,'msg'=>'Transaction successful','balance'=>$new]);
}

if($action=='history'){
  $id=$_GET['id'];
  $res=$conn->query("SELECT * FROM transactions WHERE account_id=$id ORDER BY id DESC");
  $rows=[];
  while($r=$res->fetch_assoc()) $rows[]=$r;
  json($rows);
}

if($action=='delete'){
  $id=$_POST['id'];
  $conn->query("DELETE FROM transactions WHERE account_id=$id");
  $conn->query("DELETE FROM accounts WHERE id=$id");
  json(['ok'=>true,'msg'=>'Deleted']);
}