<?php
if($_SERVER["REQUEST_METHOD"]=="POST"){
    $bookid=$_POST["bookid"];
    $title=$_POST["title"];
    $author=$_POST["author"];
    $publisher=$_POST["publisher"];
    $price=$_POST["price"];
    $copies=$_POST["copies"];
    $rack=$_POST["rack"];
    $category=$_POST["category"];

    try{
        require_once "dbh.inc.php";
        $query="INSERT INTO book values(?,?,?,?,?,?,?,?,?);";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$bookid,$title,$author,$publisher,$price,$copies,$copies,$rack,$category]);
        $pdo = null;
        $stmt=null;
        header("Location: ../addcopies.php?bookid=$bookid&copies=$copies");
        die(); 

    } catch(PDOException $e){
        die("Query failed : ". $e->getMessage());
    }
    
}
else{
    header("Location: ../index.php");
    exit();
}
?>