<?php
include 'include/header.php';
?>

  <!-- Header -->
  <header id="head">
    <div class="container">
             <div class="heading-text">              
              <h1 class="animated flipInY delay1">Wait no more, start checking out our classes or call to enquire!</h1>
              <p>We gathered the best instructors in the town to provide you the best teaching material.</p>
            </div>
            
          <div class="fluid_container">                       
                    <div class="camera_wrap camera_emboss pattern_1" id="camera_wrap_4">
                        <div data-thumb="assets/images/slides/thumbs/img1.jpg" data-src="assets/images/slides/img1.jpg">
                            <h2>We develop.</h2>
                        </div> 
                        <div data-thumb="assets/images/slides/thumbs/img2.jpg" data-src="assets/images/slides/img2.jpg">
                        </div>
                        <div data-thumb="assets/images/slides/thumbs/img3.jpg" data-src="assets/images/slides/img3.jpg">
                        </div> 
                    </div><!-- #camera_wrap_3 -->
                </div><!-- .fluid_container -->
    </div>
  </header>
  <!-- /Header -->

  <div class="container">
    <div class="row">
          <div class="col-md-6">
            <div class="grey-box-icon">
              <div class="icon-box-top grey-box-icon-pos">
                <img src="assets/images/1.png" alt="" />
              </div><!--icon box top -->
              <h4>Courses</h4>
              <p>Get all the recognised skills you need for a truly desirable IT career.</p>
                 <p><a href="#"><em>Read More</em></a></p>
            </div><!--grey box -->
          </div><!--/span3-->
          <div class="col-md-6">
            <div class="grey-box-icon">
              <div class="icon-box-top grey-box-icon-pos">
                <img src="assets/images/2.png" alt="" />
              </div><!--icon box top -->
              <h4>Contact our Staff</h4>
              <p>Contact our staff for enquire!</p>
            </div><!--grey box -->
          </div><!--/span3-->
        </div>
    </div>

<!-- JavaScript libs are placed at the end of the document so the pages load faster -->
<script src="assets/js/modernizr-latest.js"></script> 
<script type='text/javascript' src='assets/js/jquery.min.js'></script>
<script type='text/javascript' src='assets/js/fancybox/jquery.fancybox.pack.js'></script>
<script type='text/javascript' src='assets/js/jquery.mobile.customized.min.js'></script>
<script type='text/javascript' src='assets/js/jquery.easing.1.3.js'></script> 
<script type='text/javascript' src='assets/js/camera.min.js'></script> 
<script src="assets/js/bootstrap.min.js"></script> 
<script src="assets/js/custom.js"></script>

    <script>
    jQuery(function(){
      
      jQuery('#camera_wrap_4').camera({
                transPeriod: 500,
                time: 3000,
        height: '600',
        loader: 'false',
        pagination: true,
        thumbnails: false,
        hover: false,
                playPause: false,
                navigation: false,
        opacityOnGrid: false,
        imagePath: 'assets/images/'
      });

    });
      
  </script> 
  
 <footer id="footer">
 
    <div class="container">
      <div class="row">
        <div class="footerbottom">
        <div class="float-md-right"> 
		  <div class="footerwidget"> 
		   <h4>Contact</h4> 
			<div class="contact-info"> 
				<p>IT Academy Asia is a platform created for people who are looking to training courses related to I.T. ranging from Microsoft Office courses to Photoshop graphic design classes.</p>
				<i class="fa fa-map-marker"></i> 109-3, Jalan Dwitasik 1, Bandar Sri Permaisuri, 56000, Kuala Lumpur.<br>
				<i class="fa fa-phone"></i>+6 (012) 3868932 <br>
				<i class="fa fa-envelope-o"></i> info@itacademyasia.com
			</div> 
		  </div><!-- end widget --> 
        </div>
        </div>
      </div>

      <div class="clear"></div>
      <!--CLEAR FLOATS-->
    </div>
       
<?php
include 'include/footer.php';
?>