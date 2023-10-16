<div id="compose_div">
  <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . '?'.http_build_query($_GET));?>">
    <input type="text" placeholder="Type message" name="form_content" value="<?php echo $form_content;?>" id="compose">
    <input type="submit" name="submit" value="Send">
  </form>
</div>
