<!DOCTYPE html>
<html>
<head>
  <title>Messenger</title>
  <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
  <script>
    $(document).ready(function(){
      setInterval(function(){
      $("#message_body").load(" #message_body > *");
    }, 500);
    });
  </script>
  <link rel="stylesheet" href="messenger_status.css">

  <?php

    require("classes/class_Message.php");
    $Messenger = new Messenger;

    $form_content = "";

      function set_url($url){
        echo("<script>history.replaceState({},'','$url');</script>");
      }

      function write_right($text){
        echo "<div id=\"msg_outer_div\">";
        echo "<div class=\"msg_inner right\">";
        echo "<div class=\"msg_text_div right\">";
        echo "<span class=\"msg_span\">" . $text . "</span>";
        echo "</div></div></div>";
      }

      function write_left($text){
        echo "<div id=\"msg_outer_div\">";
        echo "<div class=\"msg_inner left\">";
        echo "<div class=\"msg_text_div left\">";
        echo "<span class=\"msg_span\">" . $text . "</span>";
        echo "</div></div></div>";
      }

      function write_friend($name, $surname, $url){
        echo "<a href=\"$url\">";
        if($url == "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"){
          echo "<div class=\"friend_div\" id=\"choosen_friend\">";
        }else{
          echo "<div class=\"friend_div\">";
        }
        echo "<p class=\"friend_text\">", $name," ", $surname, "</p>";
        echo "</div>";
        echo "</a>";
      }

  ?>
</head>
<body>
  <div class="inline_block" id="page">
    <?php include "top_bar.php";?>
    <div class="inline_block" id="content">
      <!-- friends list -->
      <div class="inline_block" id="friends_list">
        <?php
          $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
          $actual_link = explode("?", $actual_link);
          $friend_id = "";
          if(count($actual_link) > 1){
            $friend_id = explode("=", $actual_link[1]);
            if(count($friend_id) > 1){
              $friend_id = $friend_id[1];
            }else{
              $friend_id = "";
            }
          }
          $Messenger->set_friend_id($friend_id);
          foreach($Messenger->read_friends() as $key){
            $url = $actual_link[0] . "?friend=" . $key[user_id];
            write_friend($key[firstname], $key[lastname], $url);
          }
          if (!isset($_SESSION)) {
            session_start();
          }
          if($_SERVER["REQUEST_METHOD"] == "POST"){
              if(!empty($_POST["form_content"])){
                $_SESSION['postdata'] = $_POST["form_content"];
                unset($_POST);
                header("Location: "."http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");
                $Messenger->write_message($_SESSION['postdata']);
                exit;
              }
            }
        ?>
      </div>
      <!-- messages -->
      <div class="inline_block" id="msg_hole">
        <div class="inline_block" id="message_body">

          <?php
            $data = $Messenger->read_messages();
            foreach($data as $key){
              if($key[message_sender_id] == $Messenger->get_id() && $key[message_recipient_id] == $Messenger->get_friend_id()){
                write_right($key[message_text]);
              }
              if($key[message_sender_id] == $Messenger->get_friend_id() && $key[message_recipient_id] == $Messenger->get_id()){
                write_left($key[message_text]);
              }
            }
           ?>
        </div>
        <script>
          var message_body = document.querySelector('#message_body');
          message_body.scrollTop = message_body.scrollHeight - message_body.clientHeight;
        </script>
        <?php include "form.php";?>
      </div>
    </div>
  </div>
</body>
</html>
