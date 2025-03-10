<?php 
/**
* Template for Knowledge
* Used in: taxonomy-knowledgebase-category.php, taxonomy-mt-knowledge-features.php, taxonomy-mt-knowledge-type.php, search.php
**/

  // List THUMBNAIL

do_action( 'wildnest_before_main_content' );
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('post'); ?> >
  <div class="container <?php echo esc_attr($page_spacing); ?>">
      <div class="row">
      <!-- POST CONTENT -->
        <div class="col-md-12 main-content">
          <?php the_content(); ?>
          <div class="clearfix"></div>
        </div>
      </div>

  </div> <!-- container -->
</article>