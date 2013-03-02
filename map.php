<?php
include('header.php');
?>

      <div>
        <ul class="breadcrumb">
          
          <li>
            <a href="index.php" class="ajax-link">Dashboard</a> <span class="divider">/</span>
          </li>

          <li>
            <a href="#">Map</a>
          </li>

        </ul>
      </div>
      <?php echo $bonus_methods -> get_map() ?> 

<?php include('footer.php'); ?>