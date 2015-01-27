<?php
$profile_link = bp_loggedin_user_domain() . $bp->profile->slug . 'profile/change-cover';
if (bp_is_user() ):
?>

<?php  if ( function_exists( 'rtmedia_get_featured' ) ) : ?>

  <div class="profile-header">
  	<div class="cover-image">

          <?php if ( rtmedia_get_featured() == NULL && bp_is_my_profile() )  :?>

          <a href="<?php echo $profile_link ?>">
          <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/no-cover-bg.jpg"/>
          </a>

          <?php elseif ( rtmedia_get_featured() == NULL ): ?>

         <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/cover-bg.jpg"/>

        <?php else: ?>

        <?php if (bp_is_my_profile() ) :?>
        <a href="<?php echo $profile_link ?>">
          <i class="fa fa-camera"></i>
        </a>
        <?php endif;?>

        <?php rtmedia_featured(); ?>

          <?php endif;?>

  	</div>

  <?php if ( wp_is_mobile() ) : ?>
        <button type="button" class="navbar-toggle navbar-toggle-left" data-toggle="offcanvas">
        <span class="sr-only">Toggle Sidebar</span>
          <i class="fa fa-bars"></i><?php _e('More about', 'cfcommunity'); ?> <?php bp_displayed_user_username(); ?>
      </button>
  <div class="mobile-avatar">
      <?php bp_displayed_user_avatar( 'type=full' ); ?>
  </div>
  <?php endif;?>

</div>
<?php endif; ?>

<?php if (bp_is_group() ): ?>
  <div class="profile-header">
    <div class="cover-image">
          <?php if ( rtmedia_get_featured() == NULL ) : ?>
              <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/cover-bg.jpg"/>
          <?php else: ?>
                <?php rtmedia_featured(); ?>
          <?php endif;?>
    </div>


  <?php if ( wp_is_mobile() ) : ?>
        <button type="button" class="navbar-toggle navbar-toggle-left" data-toggle="offcanvas">
        <span class="sr-only">Toggle Sidebar</span>
          <i class="fa fa-bars"></i>Group Navigation
      </button>
  <div class="mobile-avatar">
       <?php bp_group_avatar() ?>
  </div>
  <?php endif;?>

</div>
<?php endif; ?>

<?php endif; ?>

<div class="page-header">
  <h1>
    <span><?php the_title(); ?></span>
  </h1>
</div>