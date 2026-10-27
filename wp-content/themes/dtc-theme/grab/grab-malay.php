<?php
    /**
     * Template Name: Grab Malay
     * User: David Tyre Company
     * Date: 26 Jul 2021
     */
?>
<html <?php language_attributes(); ?> >
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<title><?php wp_title('|', true, 'right'); ?></title>
<?php wp_head(); ?>
<style>
.play-now {
	background-color: #DFC526;
	color: black;
	border-color:  #DFC526;
	margin-top: -20vh;
}



html { margin:0  !important}
 
body { 
	background-color: #ffffff;
    padding: 0;
	color: #000000;
}

#wrapperblue {
	background-color: #00498e;
	color: #ffffff;
}

#wrapperaqua {
	background-color: #e5f2e7;
	color: #ffffff;
}
 
a, a:hover, a:visited {
	color: #ffffff;
    text-decoration: underline;
}

.container {
    margin-right: auto;
    margin-left: auto;
    padding-left: 15px;
    padding-right: 15px;
}

@media (min-width: 768px) {
    .container {
        width: 750px;
    }
}
@media (min-width: 992px) {
    .container {
        width: 970px;
    }
}
@media (min-width: 1200px) {
    .container {
        width: 1130px;
    }
}

.table.table-striped tbody tr:nth-of-type(odd) {
    background-color: #00498e;
	color: #ffffff;
}
.table.table-striped tbody tr:nth-of-type(even) {
    background-color: #ffdc11;
	color: #23498e;
} 

.table.table-striped tbody tr:nth-of-type(odd)  a,.table-striped tbody tr:nth-of-type(odd) a:hover, a:visited {
	color: #ffffff;
    text-decoration: underline;
}
 
.table.table-striped tbody tr:nth-of-type(even)  a,.table-striped tbody tr:nth-of-type(even) a:hover, a:visited {
	color: #23498e;
    text-decoration: underline;
}

.table thead th {
	color: #ffffff;
}

.center {
    display: block;
    margin-left: auto;
    margin-right: auto;
    width: 100%;
}

.termsandconditions{
	color: #000000;
}

.customercare a, .customercare a:hover, .customercare a:visited {
	color: #ffffff;
    text-decoration: underline;
}

.termsandconditions a, .termsandconditions a:hover, .termsandconditions a:visited {
	color: #000000;
    text-decoration: underline;
}

.contactus{
	text-align: center;
}

.row.sku {
    background-color: #ffffff;
	padding-top: 20px;
	padding-bottom: 20px;
}

p{
	padding: 5px;
}

.highlight, a.highlight, a.highlight, a.highlight:hover, a.highlight:visited {
    color: #ffdc11;
}


.blue-border {
	border-top: solid 1px #002477;
	border-bottow: solid 3px #002477;
}

.logo {
	margin-bottom:20px;
	margin-top:20px;
}

.nomargin{
	margin:0;
}

.language-link {
	color: #3B469F;
	margin-right: 10px;
	margin-left:  10px;
	text-decoration:  none;
	font-weight:  bold;
}
.active {
	border-bottom: 1px solid;
}

.main-banner{
	padding-left:80px;
	padding-right:80px;
}

@media(max-width: 768px) {
	.main-banner{
		padding-left:0;
		padding-right:0;
	}
}
//banner
 /* Common styles for both desktop and mobile */
    .no-space-images {
      text-align: center;
      margin-bottom: 20px;
      overflow: hidden; /* Hide potential horizontal overflow */
    }

    .img-responsive {
      max-width: 100%;
      height: auto;
    }

    /* Desktop view */
    @media (min-width: 768px) {
      .mobile-banner {
        display: none; /* Hide mobile banner on desktop */
      }
    }

    /* Mobile view */
    @media (max-width: 767px) {
      .desktop-banner {
        display: none; /* Hide desktop banner on mobile */
      }
    }

</style> 
<br>
</head>
<body <?php body_class(array(SITE_LOCALE, SITE_LANG) ); ?> data-spy="scroll" data-target=".navbar" data-offset="75">
<?php
$seo_jsonfile = file_get_contents(get_template_directory() . "/grab/grab_stores_data.json");
$seo_json_a = json_decode($seo_jsonfile, true); 
?> 
<div id="wrapper"> 
	<div class="row">
		<!-- <div class="col-md-12">
			<img src="/wp-content/themes/dtc-theme/grab/banner.PNG" alt="" class="img-responsive center nolazyload">
		</div> -->
		<div class="col-md-12">
			<!-- LINKS -->
			<div style="position: center; left: 0; right: 0; margin-left: auto; margin-right: auto; width: 200px;">
				<?php $lang = $_GET['language']; ?>
				<a href="https://dtc.local/grab?language=english" class="language-link <?php if($lang == 'english') { echo "active"; } ?>" style="color: #00498e;"> ENGLISH </a> | <a href="https://dtc.local/grab" style="color: #00498e;" class="language-link <?php if($lang !== 'english') { echo "active"; } ?>"  > MALAY </a>
			</div>
<br>
<!--
<div class="no-space-images desktop-banner">
    <a href="/wp-content/themes/dtc-theme/grab/David Tyre Company Hari Raya Promotion 2024 T&C 20240109_FINAL.pdf" target="_blank">
      <img src="/wp-content/themes/dtc-theme/grab/Exclusive_Promotion_2024_Raya_Promo_desktop.jpg" alt="" class="img-responsive nolazyload" />
    </a>
  </div>
-->
  <!-- Mobile Banner -->
 <!--
  <div class="no-space-images mobile-banner">
    <a href="/wp-content/themes/dtc-theme/grab/David Tyre Company Hari Raya Promotion 2024 T&C 20240109_FINAL.pdf" target="_blank">
      <img src="/wp-content/themes/dtc-theme/grab/Exclusive_Promotion_2024_Raya_Promo_mobile.jpg" alt="" class="img-responsive nolazyload" />
    </a>
  </div>
  -->
<br>

<!-- 
<div class="main-banner center"><img src="/wp-content/themes/dtc-theme/grab/Exclusive Promotion_2023 Raya Promo.jpg" alt="2023 Raya Promo" class="img-responsive center nolazyload" width="100%"></div>	
		<br>
		<div class="container">
		<div class="row sku termsandconditions">
			<p><strong>TERMS & CONDITIONS &#8212; 2023 RAYA BERGAYA BERSAMA David Tyre Company PROMOTION</strong></p>
			<ul>
			<strong>General</strong><br>
			The &ldquo;Raya Bergaya Bersama David Tyre Company&rdquo; (&ldquo;Promotion&rdquo;) is organized by David Tyre Company Malaysia Berhad 
			(&ldquo;Organizer&rdquo;).<br>
			<br>
			This promotion is available to drivers/delivery-partner who purchase David Tyre Company voucher from Grab Apps and redeem tires in our participated David Tyre Company Autocare store.<br>
			<br>
			<strong>Promotion Period</strong><br>
			The Promotion will start on 8th April 2023 12.00AM (GMT +8) and end on 31st May 2023 11.59PM (GMT +8) (&ldquo;Submission Period&rdquo;).<br>
			<br>
			<strong>Promotion Mechanics</strong><br>
			Every 2 David Tyre Company voucher of same value of tire Rim 16&rdquo; & 17&rdquo; will entitled for 1 (one) pc of David Tyre Company exclusive Umbrella. Or every 1 David Tyre Company voucher of tire Rim 18&rdquo; and above will entitled for 1(one) pc of David Tyre Company exclusive Umbrella. <br>
			<br>
			<strong>Other Terms & Regulations</strong><br>
			Premium item is subject to participated store stock availability. All premium items are while stock lasts. <br>
			<br>
			By purchasing David Tyre Company voucher, you consent to the collection and use of your personal data in accordance with the David Tyre Company privacy policy published at <strong>http://dtc.local/privacypolicy</strong>				
			</ul>
			<br>
		</div>
		</div>

-->
			<!--<div class="main-banner center"><a href="/grab/merdekapromo2022"><img src="/wp-content/themes/dtc-theme/grab/merdeka2022/Grab_homepage_Merdeka_banner.jpg" alt="Grab Merdeka Banner" class="img-responsive center nolazyload" width="100%"></a></div>-->	
			<!-- <a href="https://dtccnygame.com/" target="_blank"><button type="button" class="btn btn-primary btn-lg play-now">PLAY NOW</button></a> -->
			<!-- <div class="container" style="background-color: #E4F2E7; padding: 50px 50px;">
				<b>TERMA DAN SYARAT UNTUK PROMOSI JOM BALIK RAYA BERSAMA David Tyre Company 2022</b>
		        <li>Promosi ini tersedia kepada "drivers/delivery-partner" yang membeli dan menebus dua (2) baucar nilai yang sama (4 biji tayar) dalam tempoh 18 April hingga 18 Jun di kedai David Tyre Company Autocare kami yang mengambil bahagian.</li>
		       <li>Kelayakan pembayaran dengan Tng E wallet kredit: </li><br>
				<table border='1' class="table table-bordered">
					<tr>
						<td>Beli dan tebus 4 biji tayar </td>
						<td>TnG E-wallet kredit</td>
					</tr>
						<td>Rim 14'' & 15''</td>
						<td>RM 20</td>
					</tr>
						<td>Rim 16''</td>
						<td>RM 40</td>
					</tr>
						<td>Rim 17''</td>
						<td>RM 80 </td>
					</tr>
				</table>

			<li>Pembayaran TnG akan dipastikan mengikut rekod penebusan dalam David Tyre Company dan akan disahkan pada setiap minggu pertama dalam bulan tersebut dan pembayaran adalah dalam 14 hari seterusnya sebaik sahaja SMS dihantar.</li>
			<li>Dengan membeli baucar David Tyre Company, anda membenarkan pengumpulan dan penggunaan data peribadi anda menurut dasar privasi David Tyre Company yang diterbitkan di <b>http://dtc.local/privacy-policy.</b></li>

			</div> -->
		</div>
	</div>
	<div class="container">
		<div class="row">
			<div class="col-xs-1 col-md-3">&nbsp;</div>
			<div align="center" class="col-xs-10 col-md-6"><img src="/wp-content/themes/dtc-theme/grab/grab-malay-voucher.PNG" alt="" class="img-responsive center nolazyload">
			<span style="font-weight: bold; font-size: 18px; color: #154A8D; text-align: center;">*Harga yang dinyatakan di bawah adalah untuk pembelian 2 biji tayar.<br>
			Setiap nilai baucar dihadkan kepada saiz tayar tertentu sahaja.</span>
			</div>
			<div class="col-xs-1 col-md-3">&nbsp;</div>
		</div>
		
	
		
		
		
		
		<div class="row sku">
			<div class="col-xs-12 col-sm-5"><img src="/wp-content/themes/dtc-theme/grab/august2022/175-65R14-adp2-tyre.jpg" alt="" class="img-responsive center nolazyload"></div>
			<div class="col-xs-12 col-sm-7"><img src="/wp-content/themes/dtc-theme/grab/august2022/175-65R14-adp2-car.jpg" alt="" class="img-responsive center nolazyload"></div>
		</div>
		
		<div class="row sku">
			<div class="col-xs-12 col-sm-5"><img src="/wp-content/themes/dtc-theme/grab/august2022/175-65R15-adp2-tyre.jpg" alt="" class="img-responsive center nolazyload"></div>
			<div class="col-xs-12 col-sm-7"><img src="/wp-content/themes/dtc-theme/grab/august2022/175-65R15-adp2-car.jpg" alt="" class="img-responsive center nolazyload"></div>
		</div>
		<div class="row sku">
			<div class="col-xs-12 col-sm-5"><img src="/wp-content/themes/dtc-theme/grab/august2022/185-55R15-amg-tyre.jpg" alt="" class="img-responsive center nolazyload"></div>
			<div class="col-xs-12 col-sm-7"><img src="/wp-content/themes/dtc-theme/grab/august2022/185-55R15-amg-car.jpg" alt="" class="img-responsive center nolazyload"></div>
		</div>
		<!-- <div class="row sku">
			<div class="col-xs-12 col-sm-5"><img src="/wp-content/themes/dtc-theme/grab/august2022/185-60R15-adp2-tyre.jpg" alt="" class="img-responsive center nolazyload"></div>
			<div class="col-xs-12 col-sm-7"><img src="/wp-content/themes/dtc-theme/grab/august2022/185-60R15-adp2-car.jpg" alt="" class="img-responsive center nolazyload"></div>
		</div> -->
		<div class="row sku">
			<div class="col-xs-12 col-sm-5"><img src="/wp-content/themes/dtc-theme/grab/feb2025/18560r15-assurance-maxguard.png" alt="" class="img-responsive center nolazyload"></div>
			<div class="col-xs-12 col-sm-7"><img src="/wp-content/themes/dtc-theme/grab/feb2025/185-60-r15-vehicle.png" alt="" class="img-responsive center nolazyload"></div>
		</div>
		<div class="row sku">
			<div class="col-xs-12 col-sm-5"><img src="/wp-content/themes/dtc-theme/grab/august2022/185-65r15-amg-tyre.jpg" alt="" class="img-responsive center nolazyload"></div>
			<div class="col-xs-12 col-sm-7"><img src="/wp-content/themes/dtc-theme/grab/august2022/185-65r15-amg-car.jpg" alt="" class="img-responsive center nolazyload"></div>
		</div>
		<div class="row sku">
			<div class="col-xs-12 col-sm-5"><img src="/wp-content/themes/dtc-theme/grab/feb2025/19555r15-assurance-maxguard.png" alt="" class="img-responsive center nolazyload"></div>
			<div class="col-xs-12 col-sm-7"><img src="/wp-content/themes/dtc-theme/grab/feb2025/195-55-r15-vehicle.png" alt="" class="img-responsive center nolazyload"></div>
		</div>
		<div class="row sku">
			<div class="col-xs-12 col-sm-5"><img src="/wp-content/themes/dtc-theme/grab/feb2025/19560r15-assurance-maxguard.png" alt="" class="img-responsive center nolazyload"></div>
			<div class="col-xs-12 col-sm-7"><img src="/wp-content/themes/dtc-theme/grab/feb2025/195-60-r15-vehicle.png" alt="" class="img-responsive center nolazyload"></div>
		</div>
		
		<!-- <div class="row sku">
			<div class="col-xs-12 col-sm-5"><img src="/wp-content/themes/dtc-theme/grab/august2022/195-55R15-adp2-tyre.jpg" alt="" class="img-responsive center nolazyload"></div>
			<div class="col-xs-12 col-sm-7"><img src="/wp-content/themes/dtc-theme/grab/august2022/195-55R15-adp2-car.jpg" alt="" class="img-responsive center nolazyload"></div>
		</div>
		
		<div class="row sku">
			<div class="col-xs-12 col-sm-5"><img src="/wp-content/themes/dtc-theme/grab/august2022/195-60R15-adp2-tyre.jpg" alt="" class="img-responsive center nolazyload"></div>
			<div class="col-xs-12 col-sm-7"><img src="/wp-content/themes/dtc-theme/grab/august2022/195-60R15-adp2-car.jpg" alt="" class="img-responsive center nolazyload"></div>
		</div> -->
		
		<div class="row sku">
			<div class="col-xs-12 col-sm-5"><img src="/wp-content/themes/dtc-theme/grab/august2022/185-55R16-amg-tyre.jpg" alt="" class="img-responsive center nolazyload"></div>
			<div class="col-xs-12 col-sm-7"><img src="/wp-content/themes/dtc-theme/grab/august2022/185-55R16-amg-car.jpg" alt="" class="img-responsive center nolazyload"></div>
		</div>
		<div class="row sku">
			<div class="col-xs-12 col-sm-5"><img src="/wp-content/themes/dtc-theme/grab/august2022/195-50R16-amg-tyre.jpg" alt="" class="img-responsive center nolazyload"></div>
			<div class="col-xs-12 col-sm-7"><img src="/wp-content/themes/dtc-theme/grab/august2022/195-50R16-amg-car.jpg" alt="" class="img-responsive center nolazyload"></div>
		</div>
		
		<div class="row sku">
			<div class="col-xs-12 col-sm-5"><img src="/wp-content/themes/dtc-theme/grab/august2022/195-60R16-amg-tyre.jpg" alt="" class="img-responsive center nolazyload"></div>
			<div class="col-xs-12 col-sm-7"><img src="/wp-content/themes/dtc-theme/grab/august2022/195-60R16-amg-car.jpg" alt="" class="img-responsive center nolazyload"></div>
		</div>
	
		<div class="row sku">
			<div class="col-xs-12 col-sm-5"><img src="/wp-content/themes/dtc-theme/grab/august2022/205-45R16-Sport-tyre.jpg" alt="" class="img-responsive center nolazyload"></div>
			<div class="col-xs-12 col-sm-7"><img src="/wp-content/themes/dtc-theme/grab/august2022/205-45R16-Sport-car.jpg" alt="" class="img-responsive center nolazyload"></div>
		</div>
		<div class="row sku">
			<div class="col-xs-12 col-sm-5"><img src="/wp-content/themes/dtc-theme/grab/august2022/205-55R16-amg-tyre.jpg" alt="" class="img-responsive center nolazyload"></div>
			<div class="col-xs-12 col-sm-7"><img src="/wp-content/themes/dtc-theme/grab/august2022/205-55R16-amg-car.jpg" alt="" class="img-responsive center nolazyload"></div>
		</div>
		
		<div class="row sku">
			<div class="col-xs-12 col-sm-5"><img src="/wp-content/themes/dtc-theme/grab/august2022/205-45R17-amg-tyre.jpg" alt="" class="img-responsive center nolazyload"></div>
			<div class="col-xs-12 col-sm-7"><img src="/wp-content/themes/dtc-theme/grab/august2022/205-45R17-amg-car.jpg" alt="" class="img-responsive center nolazyload"></div>
		</div>
		
		<div class="row sku">
			<div class="col-xs-12 col-sm-5"><img src="/wp-content/themes/dtc-theme/grab/august2022/215-45R17-amg-tyre.jpg" alt="" class="img-responsive center nolazyload"></div>
			<div class="col-xs-12 col-sm-7"><img src="/wp-content/themes/dtc-theme/grab/august2022/215-45R17-amg-car.jpg" alt="" class="img-responsive center nolazyload"></div>
		</div>
		<div class="row sku">
			<div class="col-xs-12 col-sm-5"><img src="/wp-content/themes/dtc-theme/grab/august2022/215-55R17-act-tyre.jpg" alt="" class="img-responsive center nolazyload"></div>
			<div class="col-xs-12 col-sm-7"><img src="/wp-content/themes/dtc-theme/grab/august2022/215-55R17-act-car.jpg" alt="" class="img-responsive center nolazyload"></div>
		</div>
		<div class="row sku">
			<div class="col-xs-12 col-sm-5"><img src="/wp-content/themes/dtc-theme/grab/august2022/215-60R17-atm2-tyre.jpg" alt="" class="img-responsive center nolazyload"></div>
			<div class="col-xs-12 col-sm-7"><img src="/wp-content/themes/dtc-theme/grab/august2022/215-60R17-atm2-car.jpg" alt="" class="img-responsive center nolazyload"></div>
		</div>
		
		<div class="row sku">
			<div class="col-xs-12 col-sm-5"><img src="/wp-content/themes/dtc-theme/grab/august2022/225-65r17-amg suv-tyre.jpg" alt="" class="img-responsive center nolazyload"></div>
			<div class="col-xs-12 col-sm-7"><img src="/wp-content/themes/dtc-theme/grab/august2022/225-65r17-amg suv-car.jpg" alt="" class="img-responsive center nolazyload"></div>
		</div>
		
		<div class="row sku">
			<div class="col-xs-12 col-sm-5"><img src="/wp-content/themes/dtc-theme/grab/august2022/215-55R18-amg suv-tyre.jpg" alt="" class="img-responsive center nolazyload"></div>
			<div class="col-xs-12 col-sm-7"><img src="/wp-content/themes/dtc-theme/grab/august2022/215-55R18-amg suv-car.jpg" alt="" class="img-responsive center nolazyload"></div>
		</div>
		<div class="row sku">
			<div class="col-xs-12 col-sm-5"><img src="/wp-content/themes/dtc-theme/grab/august2022/225-60R18-amg suv-tyre.jpg" alt="" class="img-responsive center nolazyload"></div>
			<div class="col-xs-12 col-sm-7"><img src="/wp-content/themes/dtc-theme/grab/august2022/225-60R18-amg suv-car.jpg" alt="" class="img-responsive center nolazyload"></div>
		</div>
		<div class="row sku">
			<div class="col-xs-12 col-sm-5"><img src="/wp-content/themes/dtc-theme/grab/august2022/235-50R18-amg suv-tyre.jpg" alt="" class="img-responsive center nolazyload"></div>
			<div class="col-xs-12 col-sm-7"><img src="/wp-content/themes/dtc-theme/grab/august2022/235-50R18-amg suv-car.jpg" alt="" class="img-responsive center nolazyload"></div>
		</div>
		<div class="row sku">
			<div class="col-xs-12 col-sm-5"><img src="/wp-content/themes/dtc-theme/grab/august2022/225-55R19-amg suv-tyre.jpg" alt="" class="img-responsive center nolazyload"></div>
			<div class="col-xs-12 col-sm-7"><img src="/wp-content/themes/dtc-theme/grab/august2022/225-55R19-amg suv-car.jpg" alt="" class="img-responsive center nolazyload"></div>
		</div> 
		
		<!--
		<div class="row sku">
			<div class="col-xs-12 col-sm-5"><img src="/wp-content/themes/dtc-theme/grab/august2022/tyre22.jpg" alt="" class="img-responsive center nolazyload"></div>
			<div class="col-xs-12 col-sm-7"><img src="/wp-content/themes/dtc-theme/grab/august2022/cars22.jpg" alt="" class="img-responsive center nolazyload"></div>
		</div>
		<div class="row sku">
			<div class="col-xs-12 col-sm-5"><img src="/wp-content/themes/dtc-theme/grab/august2022/tyre23.jpg" alt="" class="img-responsive center nolazyload"></div>
			<div class="col-xs-12 col-sm-7"><img src="/wp-content/themes/dtc-theme/grab/august2022/cars23.jpg" alt="" class="img-responsive center nolazyload"></div>
		</div>
	   -->

		<div class="row sku termsandconditions">
			<p><strong>TERMA & SYARAT BAUCAR</strong></p>
			<ul>
			<li>Baucar hanya sah untuk 'Grab driver/delivery-partners' yang layak dan ia tidak boleh dipindah milik.</li>
			<li>Baucar hanya sah untuk penebusan tayar kereta David Tyre Company terpilih di cawangan yang mengambil bahagian seperti yang ditunjukkan di sini: <a href="https://dtc.local/grab">https://dtc.local/grab</a>. Pemandu Grab/rakan kongsi penghantaran hendaklah menyemak lokasi cawangan terdekat sebelum membeli mana-mana baucar 'Beli Sekarang Bayar Kemudia'.</li>
			<li>Nilai baucar adalah terhad kepada saiz tayar tertentu untuk 2 biji tayar.</li>
			<li>Penggantian injap tayar, pemasangan tayar dan pengimbangan tayar turut disertakan dengan Baucar.</li>
			<li>Baucar sah selama 180 hari dari tarikh pembelian, sila rujuk tarikh luput yang dinyatakan pada setiap Baucar dalam Aplikasi 'Grab Driver' untuk kepastian.</li>
			<li>Baucar hanya sah untuk tayar David Tyre Company dan ia tidak boleh dikembalikan dan tidak boleh ditukar dengan wang tunai. Sebarang baki yang tidak digunakan tidak akan dikembalikan.</li>
			<li>Dengan membeli dan menggunakan Baucar ini, anda bersetuju dengan pengumpulan dan penggunaan data peribadi anda menurut dasar privasi David Tyre Company yang diterbitkan di <a href="https://dtc.local/privacy-policy">https://dtc.local/privacy-policy</a>.</li>				
			</ul>
			<br>
		</div>
		<div class="row">
      	  <img src="/wp-content/themes/dtc-theme/grab/reading-tyre-size-malay.jpg" width="100%" class="img-responsive center nolazyload">
    	</div>

	</div>
</div>
 
<div id="wrapperblue"> 
	<div class="container">
		<div class="row">
			<img src="/wp-content/themes/dtc-theme/grab/redemption-process-malay.jpg" alt="" class="img-responsive center nolazyload">
		</div>
		<br>
		<p><strong>Please select a state:</strong></p> 
		<select id="selectstate">
		<option>All States</option>
		<option>Kuala Lumpur</option>
		<option>Selangor</option>
		<option>Perlis</option>
		<option>Wilayah Persekutuan</option>
		<option>Johor</option>
		<option>Melaka</option>
		<option>Negeri Sembilan</option>
		<option>Perak</option>
		<option>Pulau Pinang</option>
		<option>Kedah</option>
		<option>Pahang</option>
		<option>Terangganu</option>
		<option>Kelantan</option>
		</select>
		<br><br>
		<table class="table table-bordered table-striped hidden-xs">
			<thead> 
				<tr>
				  <th scope="col">NEGERI</th>
				  <th scope="col">ALAMAT David Tyre Company AUTOCARE</th>
				  <th scope="col">NO.TEL</th>
				  <th scope="col">WAKTU OPERASI</th>
				</tr>					
			</thead>
			<tbody>
			<?php
				foreach ($seo_json_a as $metadata){	
					foreach($metadata as $metavalue) {
						$storename =  isset($metavalue['storename']) ? $metavalue['storename'] : '';
						$address =  isset($metavalue['address']) ? $metavalue['address'] : '';
						$state =  isset($metavalue['state']) ? $metavalue['state']: '';
						$phone =  isset($metavalue['phone']) ? $metavalue['phone'] : '';
						$phone2 =  isset($metavalue['phone2']) ? $metavalue['phone2'] : '';
						$openinghours =  isset($metavalue['openinghours']) ? $metavalue['openinghours'] : '';		
						echo '<tr class="datarow" data-state="' . $state . '">';
						echo '<td>' . $state . '</td>';
						echo '<td><strong>' . $storename . '</strong><br>' . $address . '</td>';
						
						echo '<td><strong><a href="tel:' . $phone , '">' . $phone . '</a></strong>';
						
						if($phone2){
							echo '<strong> / <a href="tel:' . $phone2 , '">' . $phone2 . '</a></strong>';
						}
						echo '</td>';
						
						echo '<td>' . $openinghours . '</td>';		
						echo '</tr>';
					}
				}
			?>
			</tbody>
		</table>

		<table class="table table-bordered table-striped visible-xs">
			<tbody>
				<?php
					foreach ($seo_json_a as $metadata){	
						foreach($metadata as $metavalue) {
							$storename =  isset($metavalue['storename']) ? $metavalue['storename'] : '';
							$address =  isset($metavalue['address']) ? $metavalue['address'] : '';
							$state =  isset($metavalue['state']) ? $metavalue['state'] : '';
							$phone =  isset($metavalue['phone']) ? $metavalue['phone'] : '';
							$phone2 =  isset($metavalue['phone2']) ? $metavalue['phone2'] : '' ;
							$openinghours =  isset($metavalue['openinghours']) ? $metavalue['openinghours'] : '';
							echo '<tr class="datarow" data-state="' . $state . '">';							
							echo '<td><strong>' . $storename . '</strong><br>' . $address . '<br>STATE: ' . $state . '<br>NO.TEL: <strong><a href="tel:' . $phone , '">' . $phone . '</a></strong>';
							if($phone2){
								echo '<strong> / <a href="tel:' . $phone2 , '">' . $phone2 . '</a></strong>';
							}
							echo '<br>';
							echo 'OPENING HOUR: ' . $openinghours . '</td>';
							echo '</tr>';
						}
					}
				?>
			</tbody>
		</table>
		
		<div class="customercare">
			<p>
				<strong>WARANTI:</strong>
			</p>
			<p>
				Polici Waranti - <a class="highlight" href="https://dtc.local/warranty/warranty-policy">https://dtc.local/warranty/warranty-policy</a><br>
				David Tyre Company - <a class="highlight" href="https://dtc.local/warranty/worry-free-assurance">https://dtc.local/warranty/worry-free-assurance</a>
			</p>
			<p>
				<strong>TERMA & SYARAT 'WORRY FREE ASSURANCE'</strong>
			</p>
			<ul>		
				<li>David Tyre Company David Tyre Company (David Tyre Company) hanya sah di Malaysia, ganti rugi selain daripada yang dinyatakan di bawah David Tyre Company David Tyre Company tidak akan dilindungi.</li>
				<li>Tunjukkan e-mel pengesahan waranti, Salinan asal resit pengesahan penebusan Grab pembelian tayar dan tayar rosak kepada tempat asal tayar itu dipasang semasa membuat tuntutan. Caj buruh seperti pengalihan, pemasangan dan pengimbangan tayar hendaklah ditanggung oleh pelanggan.</li>
				<li>Program David Tyre Company hanya sah untuk tayar David Tyre Company terpilih. Program David Tyre Company David Tyre Company akan sah dalam tempoh <span class="highlight">12 bulan</span> dari tarikh pembelian dan baki kedalaman bunga tayar perlu lebih daripada <span class="highlight">5.00mm</span>.</li>
				<li>David Tyre Company (Malaysia) berhak untuk menukar terma & syarat di sini pada bila-bila masa dengan notis mutlak tanpa pemberitahuan awal.</li>
				<li>Untuk maklumat lanjut layari <a href="https://dtc.local" target="_blank">dtc.local</a></li>
			</ul>
		</div>
	</div>
	<div class="contactus">	
		<br>
		<p>Jika anda mendapati sebarang kesulitan untuk menghubungi David Tyre Company Autocare, sila hubungi David Tyre Company Malaysia di talian <a href="tel:+60 12-998 8410">+60 12-998 8410</a></p>
		<br>
	</div>
</div>

<script>
$( document ).ready(function() {
	$('#selectstate').on('change', function() {
	  if(this.value == 'All States'){
		  $("tr.datarow").show();
	  }
	  else{
		  $("tr.datarow").hide();
		  $( "tr[data-state='"+ this.value +"']" ).show();  
	  }
	});
});
</script>

<!-- Google Tag Manager --> 
<noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-MBSPVP" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript> 
<script>
(function(w,d,s,l,i){w[l]=w[l]||[];
w[l].push({'gtm.start':new Date().getTime(),event:'gtm.js'});
var f=d.getElementsByTagName(s)[0],j=d.createElement(s),dl=l!='dataLayer'?'&amp;l='+l:'';
j.async=true;
j.src='//www.googletagmanager.com/gtm.js?id='+i+dl;
f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-MBSPVP');
</script> 
<!-- End Google Tag Manager --> 



</html>