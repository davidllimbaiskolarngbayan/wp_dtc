<?php
    /**
     * Template Name: Grab Merdeka
     * User: David Tyre Company
     * Date: 28 Jul 2022
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
	background-color: #e8edf2;
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

iframe {
	width: 100%;
	height: 100%;
}

.main-banner{
	padding-left:80px;
	padding-right:80px;
}

.main-banner img{
	width:80%;
}

@media(max-width: 768px) {
	.main-banner{
		padding-left:0;
		padding-right:0;
	}
	
	.main-banner img{
		width:100%;
	}	
	
}

</style> 
</head>
<body <?php body_class(array(SITE_LOCALE, SITE_LANG) ); ?> data-spy="scroll" data-target=".navbar" data-offset="75">
<?php
$seo_jsonfile = file_get_contents(get_template_directory() . "/grab/grab_stores_data.json");
$seo_json_a = json_decode($seo_jsonfile, true); 
?> 
<div id="wrapper"> 
	<div class="row main-banner center">
		<div class="col-md-12">
			<img src="/wp-content/themes/dtc-theme/grab/merdeka2022/Merdeka _landing_page_banner.jpg" alt="Grab Merdeka Banner" class="img-responsive center nolazyload" width="100%">	
		</div>
	</div>
	<div class="row">
		<iframe src="https://forms.office.com/Pages/ResponsePage.aspx?id=Zomek4WSmkqfBAiH7-iq4FWeH8wkivZApi0mPpPu3qNUREg5STJWWFZPSUVSUTE2QUFRR1ZCSE1LTS4u&embed=true" frameborder="0" marginwidth="0" marginheight="0" style="border: none; max-width:100%; max-height:100vh" allowfullscreen webkitallowfullscreen mozallowfullscreen msallowfullscreen> </iframe>	
	</div>
</div>

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