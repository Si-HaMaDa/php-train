 <html>

 <body>

     <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <input type="text" name="fname" value="mine">
         <input type="submit">
     </form>

     <?php
        echo $_GET["fname"];
        echo '<br>';
        echo $_SERVER["REQUEST_METHOD"];
        ?>

 </body>

 </html>