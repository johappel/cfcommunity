<div class="row break">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

        <h2 class="section-title section"></i> <?php _e('What role does Cystic Fibrosis play in your life?', 'cfctranslation'); ?></h2>

        <div class="container">
          <ul id="myTab" class="nav nav-tabs">
            <li class="active"><a href="#noimage" data-toggle="tab"><i class="fa fa-chevron-circle-right"></i> <?php _e('I have CF', 'cfctranslation'); ?></a></li>
            <li class=""><a href="#leftimage" data-toggle="tab"><i class="fa fa-chevron-circle-right"></i> <?php _e('My family member/partner has CF', 'cfctranslation'); ?> </a></li>
            <li class=""><a href="#1-2-col" data-toggle="tab"><i class="fa fa-chevron-circle-right"></i> <?php _e('I work with CF', 'cfctranslation'); ?>  </a></li>
            <li class=""><a href="#rightimage" data-toggle="tab"><i class="fa fa-chevron-circle-right"></i> <?php _e('I have a CF related cause', 'cfctranslation'); ?></a></li>
          </ul>
        </div>

    </div>
</div>

<div class="container">
    <div id="myTabContent" class="tab-content">
      <div class="tab-pane fade active in" id="noimage">
        <div class="panel panel-default">
          <div class="panel-body">

            <div class="row">

              <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <h3><?php _e('Breaking news: Life with CF is different!', 'cfctranslation'); ?> </h3>
              </div>

              <div class="col-xs-12 col-sm-7 col-md-7 col-lg-7">
                <p><strong><?php _e('Just kidding, you already knew that.</strong> There is always a bunch of stuff going on that only others with CF truly understand. With CFCommunity we have created a place where we can hang out and talk about all the things that make life with CF different/awesome/lame/special.', 'cfctranslation'); ?>  
                </p>

                <p>
                  <?php _e('Hanging out online is not as good as throwing real life rave parties all across the world, but sadly that plan was scrapped early in our brainstorming process (segregation, pseudomonas blablabla). Instead we wasted blood, sweat and salty salty tears on creating an online meeting place where we would like to hang out and meet others with CF. ', 'cfctranslation'); ?>  
                </p>
                <p>
                  <?php _e('<strong>On CFCommunity you can create your profile, start a blog, talk to others with CF and share pictures of your cat nebulizing (that is a joke. do not actually do that!)</strong>. It is kinda similar to Facebook but 100% less lame and with 100% more privacy! It is just for people affected by CF and we have made it easy to find and connect with people in similar situations as you.', 'cfctranslation'); ?> 
                </p>

                <p>

                  <?php _e('We hope to see you on CFCommunity soon!', 'cfctranslation'); ?>  <br><br>

                  <?php _e('A virtual pseudomonas-free hug from,<br>
                  Bowe, Sarah & the rest of CFCommunity Team', 'cfctranslation'); ?> 


                </p>

              </div>

              <div class="col-xs-12 col-sm-5 col-md-5 col-lg-5 side-column">

                <?php
                get_template_part( 'buddypress/parts/members-loop' );
                ?>  

                <div style="clear:both;"></div> 

                <span>Join us and...</span>

                <a href="http://cfcommunity.net/register" class="btn-block btn btn-success" type="button">
                  <i class="fa fa-user"></i> <?php _e('Sign up for CFCommunity', 'cfctranslation'); ?> 
                </a>

              </div>
            </div>

          </div>
        </div>
      </div>
      <div class="tab-pane fade" id="leftimage">
        <div class="panel panel-default">
          <div class="panel-body">

            <div class="row">

              <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

                <img class="img-responsive full-width-img" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/type-cf.jpg" alt="cc-license" title="cc-license" /> 


                <h3 class="big-title"><?php _e('A meeting place for everyone affected by Cystic Fibrosis ', 'cfctranslation'); ?></h3>

              </div>

              <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

                <p><strong><?php _e('A baby sister. an older brother. a wife. a girlfriend. All the people in the pictures above deal with CF every day.', 'cfctranslation'); ?>  </strong></p>

                <p><?php _e('CFCommunity is not just for people who have CF. We have also made it for you; someone who loves someone with CF. A (grand)child, a sibling or your partner, we want to make it easy for you to connect with others in the same situation.', 'cfctranslation'); ?> </p>

                <p><?php _e('Every person who becomes a member of our community fills in their relationship with CF. We use this information (along with your location and age) to let you easily search for and connect with people on CFCommunity! ', 'cfctranslation'); ?></p>

                <p><?php _e('By using our Discussion Groups you can talk about specific subjects in-depth and in private. Finally if you need further support or want to stay up to date about all the medical news, our Causes page lets you easily find and connect with all the CF related initiatives out there! ', 'cfctranslation'); ?> </p>

                <p><?php _e('We hope to see you on CFCommunity soon!', 'cfctranslation'); ?> <br><br>

                  <?php _e('Bowe, Sarah & the rest of the CFCommunity Team<', 'cfctranslation'); ?></p>

                  <span>Join us and...</span>

                  <a href="http://cfcommunity.net/register" class="btn-block btn btn-success" type="button">
                    <i class="fa fa-user"></i> <?php _e('Sign up for CFCommunity', 'cfctranslation'); ?> 
                  </a>


                </div>


              </div>
            </div>
          </div>
        </div>
        <div class="tab-pane fade" id="1-2-col">
          <div class="panel panel-default">
            <div class="panel-body">
              <div class="row">

                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                  <h3><?php _e('Bringing all the Cystic Fibrosis related causes from across the world under one roof', 'cfctranslation'); ?>  </h3>
                </div>

                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">


                  <p><strong><?php _e('By creating a page for your cause on CFCommunity you can share news, post updates, brochures and connect with the people in our community.</strong> If you currently manage a Facebook Page for your cause you get the idea (with the big difference that we actually care about your cause and you reaching your audience without having to pay! ;-) ', 'cfctranslation'); ?>  </p> 

                  <p><?php _e('<strong>With CFCommunity we are not trying to get in the way of any of the existing CF related causes.</strong> It is our goal to make it as easy as possible for our community members to find and follow the causes that are important to them. If you would like to directly engage with our community you can choose to open a discussion forum but this is completely optional. ', 'cfctranslation'); ?>  </p> 

                  <p><?php _e('You can learn more about starting a Cause Page on CFCommunity by clicking here!', 'cfctranslation'); ?></p> 

                </div>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                  <?php 
                  $args = array(
                    'include' => "4,5,2",
                    'max' => 5
                    );
                  if ( bp_has_groups( $args) ) : 
                    ?>

                  <ul id="groups-list" class="item-list">
                    <?php while ( bp_groups() ) : bp_the_group(); ?>

                      <li>
                        <div class="item-avatar">
                          <a href="<?php bp_group_permalink() ?>"><?php bp_group_avatar( 'type=thumb&width=50&height=50' ) ?></a>
                        </div>

                        <div class="item">
                          <div class="item-title"><a href="<?php bp_group_permalink() ?>"><?php bp_group_name() ?></a></div>

                          <div class="item-desc"><?php bp_group_description_excerpt() ?></div>

                        </div>

                        <div class="clear"></div>
                      </li>

                    <?php endwhile; ?>
                  </ul>
                <?php else: ?> 
                <?php endif; ?>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="tab-pane fade" id="rightimage">
        <div class="panel panel-default">
          <div class="panel-body">
            <div class="row"> 

              <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <h3>A shared space for patients to talk amongst each other or with your staff</h3>
              </div>

              <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                <p>Due to segregation rules it's very hard for patients from the same hospital to ever meet. With CFCommunity we are building a platform where any hospital can very easily create a shared space for patients to talk amongst each other or with hospital staff. This is currently already done by some hospitals through Facebook but we strongly believe that Facebook is the wrong place for this due to lack of privacy and an commercial agenda. </p>
                <p>
                  When you create a discussion groups for your hospital a member of your staff has full control of who enters the group. Only after a person has been approved to enter the group the content will be viewable. Additionally your staff can upload documents/brochures to the group which can then directly be viewed by everyone inside the group. 
                </p>
              </div>

            </div>
          </div>
        </div>
      </div>
    </div>
</div>