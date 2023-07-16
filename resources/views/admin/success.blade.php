     <?php
     if (!empty($_SESSION['success'])) {
        foreach ($_SESSION['success'] as $success) {

           ?>
             <div class="alert w-100 text-center lead  alert-success"><?php echo $success ?> &#128522;</div>
     <?php }
     }
        unset($_SESSION['success']);
        ?>