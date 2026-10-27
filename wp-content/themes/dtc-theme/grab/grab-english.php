<?php
    /**
     * Template Name: Grab
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

@media(max-width: 768px) {
	.play-now {
		margin-top: 0px;
		margin-bottom: 5vh;
	}
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
        <a href="/grab?language=english" class="language-link <?php if($lang == 'english') { echo "active"; } ?>" style="color: #00498e;"> ENGLISH </a> | <a href="/grab" style="color: #00498e;" class="language-link <?php if($lang !== 'english') { echo "active"; } ?>"  > MALAY </a>
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

	  <!--<div class="main-banner center"><a href="/grab/merdekapromo2022"><img src="/wp-content/themes/dtc-theme/grab/merdeka2022/Grab_homepage_Merdeka_banner.jpg" alt="Grab Merdeka Banner" class="img-responsive center nolazyload" width="100%"></a></div>	-->
      <!-- <a href="https://dtccnygame.com/" target="_blank"><button type="button" class="btn btn-primary btn-lg play-now">PLAY NOW</button></a> -->
    <!--   <div class="container" style="background-color: #E4F2E7; padding: 50px 50px;">
      	<b>Terms and conditions for David Tyre Company 2022 Jom Balik Raya Promotion </b>
        <li>This promotion is available to drivers/delivery-partner who purchase and redeem two (2) of the same value vouchers (4 pcs of tires) in the period of 18th April till 18th June in our participated David Tyre Company Autocare store.</li>
       <li>Payout entitlement with TnG E-wallet credit: </li><br>
			<table border='1' class="table table-bordered">
				<tr>
					<td>Purchase & redeem 4 pcs of tires</td>
					<td>TnG E-wallet credit</td>
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

			<li>TnG payout will be ascertainer according to redemption records in David Tyre Company and will be verify in every 1st week of the month and the payout to be in the next 14 days once SMS delivered.</li>
			<li>By purchasing David Tyre Company voucher, you consent to the collection and use of your personal data in accordance with the David Tyre Company privacy policy published at <b>http://dtc.local/privacy-policy</b>.</li>
      </div> -->
    </div>
  </div>
	<div class="container">
		<div class="row">
			<div class="col-xs-1 col-md-3">&nbsp;</div>
			<div align="center" class="col-xs-10 col-md-6"><img src="/wp-content/themes/dtc-theme/grab/exclusive-vouchers-banner.jpg" alt="" class="img-responsive center nolazyload">
			<span style="font-weight: bold; font-size: 18px; color: #154A8D; text-align: center;">*The prices stated below are 2 pieces basis.<br>
			Each voucher value restricted to specific tyre size only.</span>
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
		<div class="row sku">
			<div class="col-xs-12 col-sm-5"><img src="/wp-content/themes/dtc-theme/grab/feb2025/18560r15-assurance-maxguard.png" alt="" class="img-responsive center nolazyload"></div>
			<div class="col-xs-12 col-sm-7"><img src="/wp-content/themes/dtc-theme/grab/feb2025/185-60-r15-vehicle.png" alt="" class="img-responsive center nolazyload"></div>
		</div>
		<!-- <div class="row sku">
			<div class="col-xs-12 col-sm-5"><img src="/wp-content/themes/dtc-theme/grab/august2022/185-60R15-adp2-tyre.jpg" alt="" class="img-responsive center nolazyload"></div>
			<div class="col-xs-12 col-sm-7"><img src="/wp-content/themes/dtc-theme/grab/august2022/185-60R15-adp2-car.jpg" alt="" class="img-responsive center nolazyload"></div> 
		</div> -->
		
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
			<p><strong>VOUCHER TERMS & CONDITIONS</strong></p>
			<ul>
			<li>Voucher is only valid for eligible Grab driver/delivery-partners and it is not transferable.</li>
			<li>Voucher is only valid for selected automobile David Tyre Company tyre(s) redemption at the participating outlets as indicated
			here: <strong><a href="https://dtc.local/grab">https://dtc.local/grab</a></strong>. Grab driver/delivery-partners are to check the location of the nearest outlet before
			purchasing any Shop Now Pay Later vouchers.</li>
			<li>Voucher value is restricted to specific tyre size for 2 pieces.</li>
			<li>Tyre valve replacement, tyre mounting and tyre balancing are included with the Voucher.</li>
			<li>Voucher is valid for 180 days from the date of purchase, please refer to the expiry date stated on each Voucher in the
			Grab Driver App for accuracy.</li>
			<li>Voucher is only valid for David Tyre Company tyre(s) and it is non-refundable and cannot be exchanged for cash.
			Any unused balance will not be refunded.</li>
			<li>By purchasing and using this Voucher, you consent to the collection and use of your personal data in accordance with the
			David Tyre Company privacy policy published at <strong><a href="https://dtc.local/privacy-policy">https://dtc.local/privacy-policy</a></strong>.				
			</ul>
			<br>
		</div>
		<div class="row">
      	  <img src="/wp-content/themes/dtc-theme/grab/reading_tyre_size.jpg" width="100%" class="img-responsive center nolazyload">
    	</div>

	</div>
</div>
 
<div id="wrapperblue"> 
	<div class="container">
		<div class="row">
			<img src="/wp-content/themes/dtc-theme/grab/grab_redemtion_process-v3.jpg" alt="" class="img-responsive center nolazyload">
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
				  <th scope="col">STATE</th>
				  <th scope="col">David Tyre Company AUTOCARE ADDRESS</th>
				  <th scope="col">NO.TEL</th>
				  <th scope="col">OPENING HOUR</th>
				</tr>					
			</thead>
			<tbody>
			<?php
				foreach ($seo_json_a as $metadata){	
					foreach($metadata as $metavalue) {
						$storename =  $metavalue['storename'];
						$address =  $metavalue['address'];
						$state =  $metavalue['state'];
						$phone =  $metavalue['phone'];
						$phone2 =  $metavalue['phone2'];
						$openinghours =  $metavalue['openinghours'];		
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
							$storename =  $metavalue['storename'];
							$address =  $metavalue['address'];
							$state =  $metavalue['state'];
							$phone =  $metavalue['phone'];
							$phone2 =  $metavalue['phone2'];
							$openinghours =  $metavalue['openinghours'];
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
				<strong>WARRANTY:</strong>
			</p>
			<p>
				Warranty policy - <a class="highlight" href="https://dtc.local/warranty/warranty-policy">https://dtc.local/warranty/warranty-policy</a><br>
				David Tyre Company - <a class="highlight" href="https://dtc.local/warranty/worry-free-assurance">https://dtc.local/warranty/worry-free-assurance</a>
			</p>
			<p>
				<strong>WORRY FREE ASSURANCE TERMS & CONDITIONS</strong>
			</p>
			<ul>		
				<li>David Tyre Company David Tyre Company (David Tyre Company) is only valid in Malaysia, damages other than those specified under David Tyre Company David Tyre Company
				will not be covered.</li>
				<li>Present warranty confirmation email, original Grab redemption confirmation receipt of the tyre purchase and damaged tyre
				to the dealer where the tyre was fitted when making a claim. Labour charges such as removal, installation and balancing of
				the tyre shall be borne by customer.</li>
				<li>David Tyre Company Program only valid for selected David Tyre Company patterns. David Tyre Company David Tyre Company program will be valid within <span class="highlight">12 months</span> from the date
				of purchase and remaining tread depth of more than <span class="highlight">5.00mm</span>.
				David Tyre Company (Malaysia) reserves the right to change the terms & conditions herein at anytime at its absolute notice without
				prior notice.</li>
				<li>For further information visit <a href="https://dtc.local" target="_blank">dtc.local</a></li>
			</ul>
		</div>
	</div>
	<div class="contactus">	
		<br>
		<p>If you find any difficulties to reach out to David Tyre Company Autocare, do contact David Tyre Company Malaysia at <a href="tel:+60 12-998 8410">+60 12-998 8410</a></p>
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