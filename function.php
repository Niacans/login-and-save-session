<?php
require 'config.php';

if(isset($_POST["action"])){
  if($_POST["action"] == "insert"){
    insert();
  }
  else if($_POST["action"] == "edit"){
    edit();
  }
  else{
    delete();
  }
}
function insert(){
  global $mysql_db;
  
  $name = $_POST["name"];
  $email = $_POST["email"];
  $gender = $_POST["gender"];
  $status = $_POST["status"];

  $query = "INSERT INTO users (name, email, gender, status) VALUES (:name, :email, :gender, :status)";
  $stmt = $mysql_db->prepare($query);
  $stmt->bindParam(':name', $name, PDO::PARAM_STR);
  $stmt->bindParam(':email', $email, PDO::PARAM_STR);
  $stmt->bindParam(':gender', $gender, PDO::PARAM_STR);
  $stmt->bindParam(':status', $status, PDO::PARAM_INT);
  $stmt->execute();
  echo "Berhasil input data.";
}

function edit(){
  global $mysql_db;

  $id = $_POST["id"];
  $name = $_POST["name"];
  $email = $_POST["email"];
  $gender = $_POST["gender"];
  $status = $_POST["status"];

  $query = "UPDATE users SET name = :name, email = :email, gender = :gender, status = :status WHERE id = :id";
  $stmt = $mysql_db->prepare($query);
  $stmt->bindParam(':name', $name, PDO::PARAM_STR);
  $stmt->bindParam(':email', $email, PDO::PARAM_STR);
  $stmt->bindParam(':gender', $gender, PDO::PARAM_STR);
  $stmt->bindParam(':status', $status, PDO::PARAM_INT);
  $stmt->bindParam(':id', $id, PDO::PARAM_INT);
  $stmt->execute();
  echo "Berhasil mengedit data.";
}

function delete(){
  global $mysql_db;

  $id = $_POST["action"];

  $query = "DELETE FROM users WHERE id = :id";
  $stmt = $mysql_db->prepare($query);
  $stmt->bindParam(':id', $id, PDO::PARAM_INT);
  $stmt->execute();
  echo "Data Berhasil di hapus";
}

