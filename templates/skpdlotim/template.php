<?php
error_reporting(0);

$ambiliden=mysql_query("SELECT * FROM identitas LIMIT 1");
$tiden=mysql_fetch_array($ambiliden);
  
 ?>

<!DOCTYPE html>
<html lang="en-US">

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

<!-- Bootstrap core CSS -->
<link href="<?php echo "$f[folder]/"; ?>assets_baru/css/bootstrap.min.css" rel="stylesheet">

<!-- Bootstrap custom CSS -->
<link href="<?php echo "$f[folder]/"; ?>assets_baru/css/style.css" rel="stylesheet" />

<!-- Font Awesome CSS -->
<link href="<?php echo "$f[folder]/"; ?>assets/css/font-awesome.min.css" rel="stylesheet" />

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



</head>

<body>
<div class="container">
	<div class="row">
		
	</div>
	<!-- / row -->
</div>



<!-- navigasi menu -->
<header>
<?php include "header.php"; ?>
</header>
<!-- .navigasi menu -->

<?php include "content.php"; ?>
<style type="text/css">
	.border-kanan {
		border-right: 1px groove rgba(249, 249, 249, 0.52);
	}

	.border-kiri {
		border-left: 1px groove rgba(249, 249, 249, 0.52);
	}
</style>

<!-- Footer -->
<footer>
	<div class="container">
		<div class="row">
			
			<div class="col-sm-4 border-kanan">
				<h5 class="myriadpro margin-bottom-15">Kontak Kami</h5>

				<ul class="fa-ul margin-top-15">
					<li><i class="fa-li fa-md link-default fa fa-home"></i>
					<?php echo nl2br($tiden['alamat']); ?></li>
					<li><i class="fa-li fa-md link-default fa fa-envelope"></i>
					<a href="mailto:<?php echo $tiden['email']; ?>"><?php echo $tiden['email']; ?></a></li>
					<li><i class="fa-li fa-md link-default fa fa-fax"></i>
					<?php echo $tiden['telpon']; ?></li>
				</ul>

				<ul class="list-inline icon-social icon-social-color circle">
						<li class="instagram margin-right-5 margin-top-10">
							<a target="_BLANK" href="<?php echo $tiden['fb']; ?>" title="Facebook">
							<i class="fa fa-facebook"></i>
							<span class="sr-only">Facebook</span>
							</a>
						</li>
						<li class="instagram margin-right-5 margin-top-10">
							<a target="_BLANK" href="<?php echo $tiden['twitter']; ?>" title="Twitter">
							<i class="fa fa-twitter"></i>
							<span class="sr-only">Twitter</span>
							</a>
						</li>
						<li class="instagram margin-right-5 margin-top-10">
							<a target="_BLANK" href="<?php echo $tiden['tube']; ?>" title="Youtube">
							<i class="fa fa-youtube"></i>
							<span class="sr-only">Youtube</span>
							</a>
						</li>
						<li class="instagram margin-right-5 margin-top-10">
							<a target="_BLANK" href="<?php echo $tiden['ig']; ?>" title="Instagram">
							<i class="fa fa-instagram"></i>
							<span class="sr-only">Instagram</span>
							</a>
						</li>
				</ul>
			</div>

			<div class="col-sm-4 border-custom-left border-custom-right margin-bottom-15">
			<?php
              $ip      = $_SERVER['REMOTE_ADDR']; // Mendapatkan IP komputer user
              $tanggal = date("Ymd"); // Mendapatkan tanggal sekarang
              $waktu   = time(); // 

              // Mencek berdasarkan IPnya, apakah user sudah pernah mengakses hari ini 
              $s = mysql_query("SELECT * FROM statistik WHERE ip='$ip' AND tanggal='$tanggal'");
              // Kalau belum ada, simpan data user tersebut ke database
              if(mysql_num_rows($s) == 0){
                mysql_query("INSERT INTO statistik(ip, tanggal, hits, online) VALUES('$ip','$tanggal','1','$waktu')");
              } 
              else{
                mysql_query("UPDATE statistik SET hits=hits+1, online='$waktu' WHERE ip='$ip' AND tanggal='$tanggal'");
              }

              $pengunjung       = mysql_num_rows(mysql_query("SELECT * FROM statistik WHERE tanggal='$tanggal' GROUP BY ip"));
              $totalpengunjung  = mysql_result(mysql_query("SELECT COUNT(hits) FROM statistik"), 0); 
              $hits             = mysql_fetch_assoc(mysql_query("SELECT SUM(hits) as hitstoday FROM statistik WHERE tanggal='$tanggal' GROUP BY tanggal")); 
              $totalhits        = mysql_result(mysql_query("SELECT SUM(hits) FROM statistik"), 0); 
              $tothitsgbr       = mysql_result(mysql_query("SELECT SUM(hits) FROM statistik"), 0); 
              $bataswaktu       = time() - 300;
              $pengunjungonline = mysql_num_rows(mysql_query("SELECT * FROM statistik WHERE online > '$bataswaktu'"));
            ?>
				<h5 class="myriadpro margin-bottom-15">Statistik</h5>
					<b><font size="5"><?php echo number_format($tothitsgbr,0,',','.'); ?></font></b><br>
						<i class="fa fa-user"></i> Pengunjung hari ini: <?php echo $pengunjung; ?> <br>
						<i class="fa fa-users"></i> Total pengunjung: <?php echo number_format($totalpengunjung,0,',','.'); ?> <br><br>
						<i class="fa fa-bar-chart"></i> Hits hari ini: <?php echo number_format($hits['hitstoday'],0,',','.'); ?> <br><br>
						<i class="fa fa-user-o"></i> Pengunjung Online: <?php echo $pengunjungonline; ?> <br><br>
			</div> <!-- .col-md-6 -->
			<div class="col-sm-4 border-kiri margin-bottom-15">
				<h5 class="myriadpro margin-bottom-15">Media Sosial</h5>
				<iframe src="http://www.facebook.com/plugins/likebox.php?href=<?php echo $tiden['facebook']; ?>&amp;width=350px&amp;height=350&amp;colorscheme=light&amp;show_faces=true&amp;header=true&amp;stream=false&amp;show_border=true&amp;appId=352861198057415" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:100%; height:220px;" allowTransparency="true"></iframe>
			</div> <!-- .col-md-6 -->
		</div> <!-- .row -->
	</div> <!-- .container -->

	<!-- footer-copyright -->
	<div class="footer-copyright custom">
		<div class="container">
			<div class="row">
				<div class="col-xs-12 text-center">
					<p class="copyright-text">
					Copyright &copy; 2020 Website Resmi <?php echo $tiden['nama_pemilik']; ?> All Right Reserved. Powered by <a target="_blank" href="http://msnsolutindo.com"> msnsolutindo </a>
					</p>

				</div> <!-- .col-xs-12 -->
			</div> <!-- .row -->
		</div> <!-- .container -->
	</div> <!-- .footer-copyright -->
</footer>
<!-- /.Footer -->

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->

<!-- core JS -->
<script src="<?php echo "$f[folder]/"; ?>js/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
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

<!-- carousel config -->
<script type="text/javascript">
  $('.carousel').carousel({
		pause: "false"
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
<!--//
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
<!--
var months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
var myDays = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
var date = new Date();
var day = date.getDate();
var month = date.getMonth();
var thisDay = date.getDay(),
	thisDay = myDays[thisDay];
var yy = date.getYear();
var year = (yy < 1000) ? yy + 1900 : yy;
//-->
<!--
function checkTime(i) {
	if (i<10) {
		i="0" + i;
	}
	return i;
}
//-->
</script>

</body>

</html>
