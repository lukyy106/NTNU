<?php
  require("classes/class_Database.php");

  class Messenger extends Database{
    private $ID = "0";
    private $friend_id = "";

    public function get_id(){
      return $this->ID;
    }

    public function get_friend_id(){
      return $this->friend_id;
    }

    public function set_friend_id($friend_id){
      $this->friend_id = $friend_id;
    }

    private function write_message_private($text){
      $connection = Database::connect();
      $query = "";
      $date = date('Y-m-d H:i:s');
      $query = "INSERT INTO `messages`(`message_time`, `message_sender_id`, `message_recipient_id`, `message_text`) VALUES" . "(\"". $date . "\", " . $this->ID . ", $this->friend_id, '" . $text . "')";
      $data = mysqli_query($connection, $query);
      Database::disconnect($connection);
      //return $query;
    }

    public function write_message($text){
      return $this->write_message_private($text);
    }

    private function read_messages_private(){
      $connection = Database::connect();
      $data = mysqli_query($connection, "SELECT * FROM `messages` WHERE `message_sender_id` = $this->ID AND `message_recipient_id` = $this->friend_id OR `message_sender_id` = $this->friend_id AND `message_recipient_id` = $this->ID");
      Database::disconnect($connection);
      return $data;
    }

    public function read_messages(){
      $data = Messenger::read_messages_private();
      return $data;
    }
    private function read_friends_private(){
      $connection = Database::connect();
      $data = mysqli_query($connection, "SELECT us.user_id, us.firstname, us.lastname FROM userDetails AS us JOIN friends ON us.user_id = friends.friend_id WHERE friends.user_id LIKE $this->ID");
      Database::disconnect($connection);
      return $data;
    }

    public function read_friends(){
      $data = Messenger::read_friends_private();
      return $data;
    }
  }

?>
