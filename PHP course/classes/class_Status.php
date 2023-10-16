<?php
  require("classes/class_Database.php");
  class Status extends Database{
    private $ID = "0";

    private function write_post_private($text){
      $connection = Database::connect();
      $query = "";
      $date = date('Y-m-d H:i:s');
      $query = "INSERT INTO `status`(`user_id`, `status_time`, `status_content`) VALUES" . " (" . "$this->ID, \"$date\", \"$text\")";
      $data = mysqli_query($connection, $query);
      Database::disconnect($connection);
      //return $query;
    }

    public function write_post($text){
      return $this->write_post_private($text);
    }

    private function read_status_private(){
      $connection = Database::connect();
      $data = mysqli_query($connection, "SELECT s.status_id, userDetails.firstname, userDetails.lastname, s.status_content, s.status_time FROM `status` AS s JOIN friends JOIN userDetails ON s.user_id = friends.friend_id  AND s.user_id = userDetails.user_id WHERE friends.user_id LIKE $this->ID OR s.user_id LIKE $this->ID ORDER BY status_id DESC");
      Database::disconnect($connection);
      return $data;
    }

    public function read_status(){
      $data = Status::read_status_private();
      return $data;
    }
  }
?>
