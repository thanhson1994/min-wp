<?php 
/**
 * index.php
 *
 * The main template file.
 */
 ?>

<?php get_header(); ?>

        <div class="page-blog container-fluid">
        <div class="w-40"></div>
          <div class="row">

            

            <div class="posts col-md-9">
              <div class="row">
                <!-- Post -->
                <?php if ( have_posts() ) : while( have_posts() ) : the_post(); ?>
                    <?php get_template_part( 'content', get_post_format() ); ?>
                <?php endwhile; ?>

                <?php else : ?>
                    <?php get_template_part( 'content', 'none' ); ?>
                <?php endif; ?>
                <!-- /.post -->

             

              </div>
			</div>
			<aside class="sidebar col-md-3 col-md-offset-1">

         <?php  
         get_sidebar();
          ?>
            </aside>

          </div>
        </div>
<?php get_footer(); ?>