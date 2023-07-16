     <?php
      if (!empty($_SESSION['errors'])) {
         foreach ($_SESSION['errors'] as $error) { ?>
           <div class="alert alert-danger"><?php echo $error ?>&#128532;</div>
     <?php };
      };
      unset($_SESSION['errors']);
      ?>