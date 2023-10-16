<!DOCTYPE html>
<html>
<head>
  <title>Newsfeed</title>
  <link rel="stylesheet" href="messenger_status.css">
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script>
      if ( window.history.replaceState ) {
          window.history.replaceState( null, null, window.location.href );
      }
    </script>
    <script>
      $(document).ready(function(){
        setInterval(function(){
        $("#status_body").load(" #status_body > *");
      }, 500);
      });
    </script>
    <?php
      require("classes/class_Status.php");
      $Status = new Status;
    ?>
</head>
<body>
  <div class="inline_block" id="page">
    <?php include "top_bar.php";?>
    <div class="inline_block" id="content">
      <div class="inline_block blank_space">
      </div>
      <div class="inline_block" id="status_div">
        <div class="inline_block" id="status_body">
        <?php
          if (!isset($_SESSION)) {
            session_start();
          }
          if($_SERVER["REQUEST_METHOD"] == "POST"){
            if(!empty($_POST["form_content"])){
              $_SESSION['postdata'] = $_POST["form_content"];
              unset($_POST);
              header("Location: ".$_SERVER['PHP_SELF']);
              $Status->write_post($_SESSION['postdata']);
              exit;
            }
          }
          unset($_POST);
          $query = $Status->read_status();
          foreach($query as $key){
            echo "<div class=\"post_div\">";
            echo "<p class=\"post_name\"><b>", $key[firstname], " " ,$key[lastname], "</b></p>";
            echo "<p class=\"inline_block\">", $key[status_content] ,"</p>";
            echo "</div>";
          }
        ?>
        </div>
        <?php include "form.php";?>
      </div>
      <div class="inline_block blank_space">
      </div>
    </div>
</body>
</html>
