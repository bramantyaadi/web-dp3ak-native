<?php
$ambiliden = mysqli_query($koneksi, "SELECT * FROM identitas LIMIT 1");
$tiden = mysqli_fetch_array($ambiliden);
  
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="robots" content="index, follow" />
<link rel="shortcut icon" href="<?php echo $tiden['favicon']; ?>">
<meta name="author" content="<?php echo $tiden['email']; ?>">
<meta name="content_type" content="Standard" />

<title><?php include "dina_titel.php"; ?></title>
<meta name="description" content="<?php include "dina_meta1.php"; ?>">
<meta name="keywords" content="<?php include "dina_meta2.php"; ?>">
<!-- <meta property="fb:app_id" content="161134343906646" /> -->
<meta property="og:site_name" content="<?php echo $tiden['nama_website']; ?>"/>
<meta property="og:title" content="Website Resmi <?php echo $tiden['nama_pemilik']; ?>" />
<meta property="og:url" content="<?php echo $tiden['alamat_website']; ?>"/>
<meta property="og:description" content="Selamat Datang di Web Portal Resmi <?php echo $tiden['nama_pemilik']; ?>. Web ini menyediakan segala informasi mengenai <?php echo $tiden['nama_pemilik']; ?>. Informasi pemerintahan, informasi desa dan berita." />
<meta property="og:type" content="website" />

<meta property="article:author" content="<?php echo $tiden['facebook']; ?>" />
<meta property="article:publisher" content="<?php echo $tiden['facebook']; ?>" />
    
    
	<!-- w3 CSS -->
	<link type="text/css" href="<?php echo "$f[folder]/"; ?>assets/css/w3.css" rel="stylesheet" />
	<!-- Style Custom CSS -->
	<link type="text/css" href="<?php echo "$f[folder]/"; ?>assets/css/style-landing-pages.css" rel="stylesheet" />
    <!-- Font Awesome CSS -->
    <link type="text/css" href="<?php echo "$f[folder]/"; ?>assets/css/font-awesome.min.css" rel="stylesheet" />
	<!-- Util CSS -->
	<link type="text/css" href="<?php echo "$f[folder]/"; ?>assets/css/util.css" rel="stylesheet" />
	<!-- owl.carousel CSS -->
	<link rel="stylesheet" href="<?php echo "$f[folder]/"; ?>assets/css/owl.carousel.min.css">
	<!-- owl.carousel CSS -->
	<link rel="stylesheet" href="<?php echo "$f[folder]/"; ?>assets/css/owl.theme.default.min.css">
	
	<!-- Bootstrap core CSS -->
	<link type="text/css" href="<?php echo "$f[folder]/"; ?>assets_baru/css/bootstrap.min.css" rel="stylesheet">
	<!-- style custom CSS -->
	<link type="text/css" href="<?php echo "$f[folder]/"; ?>assets_baru/css/style.css" rel="stylesheet" />
    <!-- custom CSS for this web -->
    <link rel="stylesheet" type="text/css" href="<?php echo "$f[folder]/"; ?>assets_baru/css/<?php echo $tiden['wtemp']; ?>.css" />

    <!-- sharingButton -->
    <link rel="stylesheet" type="text/css" href="<?php echo "$f[folder]/"; ?>assets_baru/css/rrssb.css" />

    <!-- bts css -->
    <link href="<?php echo "$f[folder]/"; ?>assets_baru/css/bootstrap-touch-slider.css" rel="stylesheet" media="all">

    <!-- slick carousel -->
    <link rel="stylesheet" type="text/css" href="<?php echo "$f[folder]/"; ?>js/jquery.slick/1.6.0/slick.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo "$f[folder]/"; ?>js/jquery.slick/1.6.0/slick-theme.css"/>

    <!-- font roboto -->
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    
    <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,600;0,700;0,800;1,300;1,400;1,600;1,700;1,800&display=swap" rel="stylesheet">

	<script src="<?php echo "$f[folder]/"; ?>assets/js/modernizr.custom.js"></script>
	
</head>
<body>

<?php include "content.php";?>

<!-- GetButton.io widget -->
<script type="text/javascript">
    (function () {
        var options = {
            whatsapp: "+62895348771070", // WhatsApp number
            call_to_action: "Message us", // Call to action
            position: "right", // Position may be 'right' or 'left'
        };
        var proto = document.location.protocol, host = "getbutton.io", url = proto + "//static." + host;
        var s = document.createElement('script'); s.type = 'text/javascript'; s.async = true; s.src = url + '/widget-send-button/js/init.js';
        s.onload = function () { WhWidgetSendButton.init(host, proto, options); };
        var x = document.getElementsByTagName('script')[0]; x.parentNode.insertBefore(s, x);
    })();
</script>
<!-- /GetButton.io widget -->
<!--Disini Batas SCRIPT-->
<script src="<?php echo "$f[folder]/"; ?>assets/plugins/jquery/dist/jquery.min.js"></script>
<script src="<?php echo "$f[folder]/"; ?>assets/plugins/feather-icons/dist/feather.min.js"></script>

<script src="<?php echo "$f[folder]/"; ?>assets/js/owl.carousel.min.js"></script>
    <!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->

<!-- core JS -->
<script src="<?php echo "$f[folder]/"; ?>assets_baru/js/bootstrap.min7433.js?ver=3.3.7"></script>
<script src="<?php echo "$f[folder]/"; ?>assets_baru/js/scripts97de.js?ver=1.0.5"></script>
<!-- .core JS -->
<!-- sharingButton -->
<script type="text/javascript" src="<?php echo "$f[folder]/"; ?>assets_baru/js/rrssb.min.js"></script>
<!-- bts js -->
<script src="<?php echo "$f[folder]/"; ?>assets_baru/js/bootstrap-touch-slider.js"></script>
<!-- slickCarousel -->
<script type="text/javascript" src="<?php echo "$f[folder]/"; ?>assets_baru/js/slick.min.js"></script>
<!-- di bawah ini adalah konfigurasi // don't bother edit it nanti tak pukul -->

<!-- slick config -->
<script type="text/javascript">
	$(document).ready(function(){
		$('.slider-kecil').slick({
			autoplay: true,
			infinite: true,
			slidesToShow: 4,
			slidesToScroll: 1,
			lazyLoad: 'ondemand',
			/*dots: true,*/
			variableWidth: true,
			arrows:true
		});
	});
</script>

<script type="text/javascript">
$('.owl-carousel').owlCarousel({
    loop:true,
    margin:10,
    responsiveClass:true,
    responsive:{
        0:{
            items:1,
            nav:true
        },
        600:{
            items:3,
            nav:false
        },
        1000:{
            items:5,
            nav:true,
            loop:false
        }
    }
})
</script>


<script type="text/javascript">
$('.owl-slider').owlCarousel({
    margin:10,
    loop:true,
    autoWidth:true,
    items:1
})
</script>

<script type="text/javascript">
$(function() {
	$('.gambarnya').on('click', function() {
		$('.enlargeImageModalSource').attr('src', $(this).attr('src'));
		$('#enlargeImageModal').modal('show');
	});
});
</script>

<!-- bts config -->
<script type="text/javascript">
  $(document).ready(function() {
	$('#bootstrap-touch-slider').bsTouchSlider();
  });
</script>

<!-- popup config -->
<script type="text/javascript"> 
$(document).ready(function(){
	var my_cookie = $.cookie($('.modal-check').attr('name'));
	if (my_cookie && my_cookie == "true") {
		$(this).prop('checked', my_cookie);
		console.log('checked checkbox');
	}
	else{
		$('#PopupModal').modal('show');
		console.log('uncheck checkbox');
	}

	$(".modal-check").change(function() {
		$.cookie($(this).attr("name"), $(this).prop('checked'), {
			path: '/',
			expires: 1
		});
	});
});
</script>
<script src="<?php echo "$f[folder]/"; ?>assets_baru/js/jquery.cookie.js"></script>
<!-- end of popup -->



<!-- form validate config -->
<script src="<?php echo "$f[folder]/"; ?>js/jquery.validation/1.16.0/jquery.validate.min.js"></script>
<script type="text/javascript">
	$(document).ready(function () {

	$('#formku').validate({ // initialize the plugin
		rules: {
			nik: {
				required: true
			},
			nama: {
				required: true
			}
		}
	});

});
</script>

<script type="text/javascript">
$(document).ready(function(ev){
	$('#custom_carousel').on('slide.bs.carousel', function (evt) {
	  $('#custom_carousel .controls li.active').removeClass('active');
	  $('#custom_carousel .controls li:eq('+$(evt.relatedTarget).index()+')').addClass('active');
	})
});
</script>

<!-- shrink logo config -->
<script type="text/javascript">
	$(window).scroll(function() {
	  if ($(document).scrollTop() > 40) {
		$('.navbar-header').addClass('shrink');
	  } else {
		$('.navbar-header').removeClass('shrink');
	  }
	  // if ($(document).scrollTop() >= 200) {
	  //   $("nav.navbar-fixed-top").autoHidingNavbar();
	  // }
	});
</script>

<!-- fb comments -->
<script>(function(d, s, id) {
var js, fjs = d.getElementsByTagName(s)[0];
if (d.getElementById(id)) return;
js = d.createElement(s); js.id = id;
js.src = "../../connect.facebook.net/id_ID/all.js#xfbml=1&appId=89533811750";
fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));
</script>

<script type="text/javascript" src="<?php echo "$f[folder]/"; ?>assets_baru/js/jquery.marquee.min.js"></script>
<script type="text/javascript">

var use_debug = false;
function debug(){
	 if( use_debug && window.console && window.console.log ) console.log(arguments);
}

// on DOM ready
$(document).ready(function (){
	 $(".marquee").marquee({
		  loop: -1
		  // this callback runs when the marquee is initialized
		  , init: function ($marquee, options){
				debug("init", arguments);
				// shows how we can change the options at runtime
				if( $marquee.is("#marquee2") ) options.yScroll = "bottom";
		  }
		  // this callback runs before a marquee is shown
		  , beforeshow: function ($marquee, $li) {
				debug("beforeshow", arguments);

				// check to see if we have an author in the message (used in #marquee6)
				var $author = $li.find(".author");
				// move author from the item marquee-author layer and then fade it in

				if( $author.length ){
					 $("#marquee-author").html("<span style='display:none;'>" + $author.html() + "</span>").find("> span").fadeIn(850);
				}
		  }

		  // this callback runs when a has fully scrolled into view (from either top or bottom)
		  , show: function (){
				debug("show", arguments);
		  }

		  // this callback runs when a after message has being shown
		  , aftershow: function ($marquee, $li){
				debug("aftershow", arguments);

				// find the author
				var $author = $li.find(".author");

				// hide the author
				if( $author.length ) $("#marquee-author").find("> span").fadeOut(250);
		  }
	 });
});

var iNewMessageCount = 0;

function addMessage(selector){
	
	 // increase counter
	 iNewMessageCount++;

	 // append a new message to the marquee scrolling list
	 var $ul = $(selector).append("<li>New message #" + iNewMessageCount + "</li>");

	 // update the marquee
	 $ul.marquee("update");

}

function pause(selector){
	 $(selector).marquee('pause');
}

function resume(selector){
	 $(selector).marquee('resume');
}
//-->
</script>

<script type='text/javascript'>

var months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
var myDays = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
var date = new Date();
var day = date.getDate();
var month = date.getMonth();
var thisDay = date.getDay(),
	thisDay = myDays[thisDay];
var yy = date.getYear();
var year = (yy < 1000) ? yy + 1900 : yy;


function checkTime(i) {
	if (i<10) {
		i="0" + i;
	}
	return i;
}
//-->
</script>
    <script>
        feather.replace()
    </script>
</body>
</html>