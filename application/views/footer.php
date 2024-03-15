<div class="clear"></div>

		<div class="footer-top">
    	<div class="container">
       	<div class="only-mb">
      			<h4>Contact Us</h4>
       			<ul>
       				<li><a>Via Text</a></li>
       				<li><a>Via Email</a></li>
       				<li><a>Call Us Now</a></li>
       				<li><a>Login</a></li>
       			</ul>
       		
       	</div>
        	<div class="only-desktop">
        	<h3>Contact Us</h3>
            <div class="locations">
            
            	<div class="ft-icons"><i class="fa fa-map-marker" aria-hidden="true"></i>
</div>
                <div class="ft_text"><span class="iohd">Bio Health Check</span>1125 E 17th St., Suite E210, Santa Ana, CA 92701</div>
            </div>
            <div class="locations">
            
            	<div class="ft-icons"><i class="fa fa-envelope-o" aria-hidden="true"></i>

</div>
                <div class="ft_text">Ph:  
+ 1 (0) 333.444.212 <br>
info@biohealthcheck.com
</div>
            </div>
            <a href="#" class="logins">Login</a>
            </div>
           
        </div>
    </div>
		
	
		
 		<div class="footer-copy">
   			<div class="container"><div class="copy">© 2017 Bio Health Check. All Rights Reserved. </div>
   			<div class="copy powerd">Powered By: Abaska Technologies</div></div>
   		</div>
</body>
 <script src="<?php echo base_url()?>/frontend/boostrap/jquery-1.9.1.min.js"></script>
 <script src="<?php echo base_url()?>/frontend/boostrap/bootstrap.min.js"></script>
    <script src="<?php echo base_url()?>/frontend/js/owl.carousel.js"></script>


    <!-- Demo -->

    <style>
    #owl-demo .item{
        margin: 3px;
    }
    #owl-demo .item img{
        display: block;
        width: 100%;
        height: auto;
    }
    </style>


    <script>
    $(document).ready(function() {
      $("#owl-demo").owlCarousel({
        autoPlay: 3000,
        items : 4,
        itemsDesktop : [1199,3],
        itemsDesktopSmall : [979,3]
      });

    });
    </script>





  <!-- FlexSlider -->
  <script defer src="<?php echo base_url()?>/frontend/js/jquery.flexslider.js"></script>

  <script type="text/javascript">
     
     
      
    $(function(){
      SyntaxHighlighter.all();
    });
    $(window).load(function(){

      // Vimeo API nonsense
      var player = document.getElementById('player_1');
      $f(player).addEvent('ready', ready);

      function addEvent(element, eventName, callback) {
        (element.addEventListener) ? element.addEventListener(eventName, callback, false) : element.attachEvent(eventName, callback, false);
      }

      function ready(player_id) {
        var froogaloop = $f(player_id);

        froogaloop.addEvent('play', function(data) {
          $('.flexslider').flexslider("pause");
        });

        froogaloop.addEvent('pause', function(data) {
          $('.flexslider').flexslider("play");
        });
      }


      // Call fitVid before FlexSlider initializes, so the proper initial height can be retrieved.
      $(".flexslider")
        .fitVids()
        .flexslider({
          animation: "slide",
          useCSS: false,
          animationLoop: false,
          smoothHeight: true,
          start: function(slider){
            $('body').removeClass('loading');
          },
          before: function(slider){
            $f(player).api('pause');
          }
      });
    });
  </script>

   <!-- Syntax Highlighter -->

  <!-- Optional FlexSlider Additions -->
    <script src="<?php echo base_url()?>/frontend/js/froogaloop.js"></script>
	<script src="<?php echo base_url()?>/frontend/js/jquery.fitvid.js"></script>
	<script src="<?php echo base_url()?>/frontend/js/demo.js"></script>

  
</html>
