<?php $page_styles = ['/styles/banner.css'];
require base_path('views/partials/head.php') ?>
<?php require base_path('views/partials/sidebar.php') ?>


<!-- Your HTML code goes here -->

<main class="main-col">
   <?php require base_path('views/partials/banner.php') ?>
   <section>
      <pre>
         <?= print_r($schools) ?>
      </pre>
   </section>
</main>

<?php require base_path('views/partials/footer.php') ?>