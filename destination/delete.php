<?php
    include("../connexion.php");
?>

<?php
   if($_GET['id']){
    $id = $_GET['id'];
    $sql = "DELETE FROM destinations WHERE id = :id";
    $statement= $connect->prepare($sql);
    $statement->bindValue(':id', $id, PDO::PARAM_STR);
    $statement->execute();
    header('Location: index.php');
   }else{
    echo"aucun element selectionner";
   }
?>
