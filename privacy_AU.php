<!doctype html>
<?php 
if(isset($_SERVER["HTTP_HOST"]) && $_SERVER["HTTP_HOST"]!="localhost"){
	if(isset($_SERVER["REQUEST_URI"]) && ($_SERVER["REQUEST_URI"]=="/index.php?page=privacy_AU" || $_SERVER["REQUEST_URI"]=="/privacy_AU")){
		header("HTTP/1.1 301 Moved Permanently");
		header("Location: privacy-policy/");
		exit;
	}
	
}
?>
<html land="en">
	<head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="rating" content="general" />
        <meta name="Language" content="en" />
        <meta name="robots" content="all" />
        <meta name="robots" content="index,follow" />
        <meta name="re-visit" content="7 days" />
        <meta name="distribution" content="global" />    
        <?php if(SITE_COUNTRY == "AU"){?>    
        <title><?php echo COUNTRY_DEMONYM; ?> Number, <?php echo COUNTRY_DEMONYM; ?> Virtual Phone Number | Sticky Numbers <?php echo COUNTRY_NAME; ?> </title>
        <meta name="description" content="Sticky Number is a leading company provides Australia numbers, Australia Virtual phone numbers with guarantee of best performance and reliability. For more information visit us online!"/>
		<?php }else{ ?>
		<title>Free <?php echo COUNTRY_DEMONYM; ?> Number, Free <?php echo COUNTRY_DEMONYM; ?> Virtual Phone Number | Sticky Numbers <?php echo COUNTRY_NAME; ?> </title>
        <meta name="description" content="<?php echo SITE_DOMAIN; ?> is a leading company provides free <?php echo COUNTRY_DEMONYM; ?> number, Free <?php echo COUNTRY_DEMONYM; ?> Virtual phone numbers with guarantee of best performance and reliability. For more information visit us online!"/>
		<?php } ?>
		<!--[if lt IE 9]>
			<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->		
		<meta name="viewport" content="width=device-width, initial-scale=1"/>
		<!-- Adding "maximum-scale=1" fixes the Mobile Safari auto-zoom bug: http://filamentgroup.com/examples/iosScaleBug/ -->
        
        <!-- CSS STYLING -->        
        <link rel="stylesheet" media="all" href="css/core.css"/>
        <link rel="stylesheet" media="all" href="css/misc.css"/>
        
        <!-- JS -->
        <script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
        <script src="js/jquery.slides.min.js"></script>
        <script src="js/scrolltopcontrol.js"></script>
        <script src="js/jquery-ui-1.10.3.custom.min.js"></script>
        
         <!-- SlidesJS Required: Initialize SlidesJS with a jQuery doc ready -->
		  <script>
		  var country_iso = "";
		  var plan_period = 'M';//Hard coded until the annual payment is enabled in the system
		  var choosen_plan = 0;
		  var pay_amount = 0;
		  var purchase_type = 'new_did';

            $(document).ready(function(){
                
            	$("#submit_form_news").click(function(){
            		var emailid = document.getElementById("email_news").value;
            		var submit_url = "./mcapi/inc/store-address.php?ajax=1&email="+emailid;
            		  $.ajax({url:submit_url, success:function(result){
            		    alert(result);
            		  }});
            	});
                    
                $('#did_country').change(function() {
                    country_iso = $(this).val();

                    $('#div-free-trials').hide();
                    
                    $('#city option').remove();
                    if (country_iso == '') {
                        $('#city').append('<option value="">Please select a city</option');
                        return true;                        
                    }
                    
                    $('#city').append('<option value="">Loading...</option');
                    $('#city').attr('disabled', 'disabled');
                    
                    var url = './ajax/ajax_load_did_cities.php';
                
                    $.get(url, {'country_iso' : country_iso}, function(response){
                        var data = jQuery.parseJSON(response);  
                        $('#city').removeAttr('disabled');
                        $('#city option').remove();
                        $('#city').append('<option value="">Please select a city</option'); 
                        $(data).each(function(index, item) {
                            $('#city').append('<option value="'+$.trim(item['city_prefix'])+'">'+item['city_name']+' '+item['city_prefix']+' ($'+item['sticky_monthly_plan1']+'/month)</option>');
                        });
                        
                    });    
                    
                }); //on did_country change

                <?php 
                	if(trim($sel_did_country_code)!=""){
                ?>
                		 $('#did_country').change();
                		 setTimeout(function(){$('select[name="city"]').find('option[value="<?php echo $sel_did_city_code; ?>"]').attr("selected",true);$('#div-free-trials').show();},1800);
                <?php		
                	}//end of if(trim($sel_did_country_code)!=""){
                ?>                

                $('#city').change(function() {
					if($('#city').val()==99999){
						$('#div-free-trials').show();
					}else{
						$('#div-free-trials').hide();
					}
				});
                
                $('#country').change(function() {
                	$('#number').focus();
                    $('#number').val( '+' + $(this).val())
                }); //on country change
                
                $('#number').keyup(function(event) {
                        var val = $(this).val();
                        if (val.length == 0) {
                            $(this).val('+')
                            return true;
                        }
                        
                        if (val[0] != '+') {
                            val = '+' + val;
                        }
                        
                        var tmp = val;
                        
                        var last_char = val[ val.length -1 ]
                        var char_code = val.charCodeAt(val.length - 1) 
                        if ((char_code < 48 || char_code > 57)) {
                            tmp = '';
                            for(var i=0; i < val.length - 1; i++) {
                                tmp += val[i]         
                            }
                                 
                        } 
                        
                        $(this).val( tmp )
                        
                        var option_value = tmp.replace('+','')
                        
                        if ($("#country option[value='" + option_value + "']").length > 0) {
                            $('#country').val( option_value )
                        }  
                        
                });

                $('#btn-continue-step1').mousedown(function(event) {
                    if(validate_step1()==true){
                    	$('#fwd_cntry').val($('#country').val());
						$('#forwarding_number').val($('#number').val());
						$('#did_country_code').val($("#did_country").val());
						$('#did_city_code').val($("#city").val());
						$('#vnum_country').val($("#did_country option:selected").text());
						$('#vnum_city').val($("#city option:selected").text());
						$('#frm-step1').submit();
                    }
                });
            });

			function validate_step1(){
				if($('#did_country').val() == ""){
					alert("Please select a country for your virtual number.");
					$('#did_country').focus();
					return false;
				}
				if($('#city').val() == ""){
					alert("Please select a city for your virtual number.");
					$('#city').focus();
					return false;
				}
				if($('#country').val() == ""){
					alert("Please select call forwarding country.");
					return false;
				}
				//first clean up destination number
				var dest = $('#number').val();
				if(dest.length == 0){
					$('#number').val('+');
					dest = $('#number').val();
				}
				if(dest.charCodeAt(0) != 43){
					$('#number').val('+'+dest);
					dest = $('#number').val();
				}
				var clean_dest = '+';
				for(var i=1;i<=dest.length;i++){
					if(dest.charCodeAt(i)<48 || dest.charCodeAt(i)>57){
						//dont'take this character.
					}else{
						clean_dest += dest.charAt(i);
					}
				}
				$('#number').val(clean_dest);
				//end of clenup destination number
				if($('#number').val().length <= 10){
					alert("Please enter call forwarding number with area code (min 10 digits)");
					$('#number').focus();
					//The following three lines set cursor at end of existing input value
					var tmpstr = $('#number').val();//Put val in a temp variable
                    $('#number').val('');//Blank out the input
                    $('#number').val(tmpstr);//Refill using temp variable value
					return false;
				}
				return true;
			}//end of function validate_step1

          </script>
          <!-- End SlidesJS Required -->
        <?php if(SITE_COUNTRY!="COM"){?>
        <!--Start of Zopim Live Chat Script-->
		<script type="text/javascript">
		window.$zopim||(function(d,s){var z=$zopim=function(c){z._.push(c)},$=z.s=
		d.createElement(s),e=d.getElementsByTagName(s)[0];z.set=function(o){z.set.
		_.push(o)};z._=[];z.set._=[];$.async=!0;$.setAttribute('charset','utf-8');
		$.src='//v2.zopim.com/?1piIDUavtFoOMB89h2pj9OK8cT8CswZK';z.t=+new Date;$.
		type='text/javascript';e.parentNode.insertBefore($,e)})(document,'script');
		</script>
		<!--End of Zopim Live Chat Script-->
        <?php } ?>
	</head>
	
	<body lang="en">
        
        <!-- Top Bar --->
	    <div class="topbar">
	         <!-- content -->
	         <div class="wrapper">
	              <div class="container">
	                  <div class="info"><span class="Mtop2"><img src="images/mail.png"/></span>&nbsp;<span class="Mleft5"><?php echo ACCOUNT_CHANGE_EMAIL; ?></span></div>
	                  <div class="logintop">
	                  		<?php if(isset($_SESSION['user_logins_id']) && trim($_SESSION['user_logins_id'])!=""){ ?>
	                  			Hi <?php echo $_SESSION['user_name']; ?>&nbsp;<a href="dashboard/index.php">My Account</a>
                                		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="dashboard/logout.php">Logout</a>
	                  		<?php }else{ ?>
	                  			<?php if(isset($_GET['error']) && $_GET['error']=='failed' ) { ?> <div style='color:red;'>Member details incorrect,try again.</div><?php } ?>
		                       	<form name="toplogin" id="toplogin" action="dashboard/login.php" method="post">
		                       	<div class="login-input"><input name="email" type="text" class="input" placeholder="Username"/></div>
		                       	<div class="login-input"><input name="password" type="password" class="input" placeholder="Password"/><a href="index.php?page=forgot_password_AU">Forgot Password</a></div>
		                       	<div class="loginbtn-box"><input onclick="javascript:document.getElementById('toplogin').submit();" type="button" class="loginbtn" value="Login"/></div>
		                       	<input type="hidden" name="site_country" value="AU" />
                                <input type="hidden" name="front_page_login" value="2926354" id="front_page_login">
		                       	</form>
		                    <?php } //End of else part of no login session?>
	                  </div>
	              </div>
	         </div>
	         <!-- content closed -->         
	    </div>
	    <!-- Top Bar Closed --->
	    
	    <?php require "menu_and_logo.php"; ?>

<?php

require("./dashboard/classes/Did_Countries.class.php");
require("./dashboard/classes/Country.class.php");
$did_countries_obj = new Did_Countries();
$did_countries = $did_countries_obj->getAvailableCountries();

$country = new Country();
$countries = $country->getAllCountry();

?>       

	<!-- Banner -->
    <div class="wrapper">
         <div class="container Mtop40">
              <img src="images/inner-banner.jpg"/>
         </div>
    </div>
    <!-- Banner Closed -->

    <!-- Main wrapper starts here -->
    <div class="wrapper">
         <div class="container">         
              <div class="row Mtop20">
                   <!-- Left -->
                   <div class="contact-leftbox">
                     	<div class="heading">Privacy Policy</div>
                     
                        <div class="row Mtop20 f14"> 
                        
                        <p class="Mtop20">
                        <strong>Who are we?</strong><br/><br/>

<?php echo SITE_DOMAIN; ?> provides voice and data services around the world. <?php echo SITE_DOMAIN; ?> supplies a wide range of communications products and services, including voice, data, and offering a comprehensive range of managed and packaged communications solutions.
When we refer to "we" or "our" we are referring to <?php echo SITE_DOMAIN; ?> as the context requires.<br/><br/>
<strong>What does this privacy policy cover?</strong><br/><br/>

This privacy policy only applies to how <?php echo SITE_DOMAIN; ?> deals with your personal information. It does not apply to any other company or to any other company's websites even if you access them through <?php echo SITE_DOMAIN; ?>. If you disclose your personal information to other companies your information will be dealt with according to their privacy practices.<br/><br/>

<strong>What personal information do we collect about you, and when do we collect it?</strong><br/><br/>

We may ask you for information to enable us to provide a service to you and we collect this information by telephone, written correspondence or via a website. We may ask you for information including your name, private/business address, contact telephone numbers and email address. We may also ask you for other information that relates to the service you are using or ordering. For example, we may need your credit card number to charge you for certain services.<br/><br/>
When you (or someone using your telephone line) make a telephone call or send a fax that uses our telephone network or connect to the world wide web, we keep a record of that call (including the number called). We also receive from other operators information about calls made over our network, where we need that information for connecting and billing purposes.<br/><br/>
If someone abuses or damages the telephone network, for example by making offensive or nuisance calls, we may keep information relating to that abuse.<br/><br/>
We have information about your use of our services (such as the amount of time you spend on-line), which we use to manage our network, and for billing. We may also use this information for marketing products and services but we will give the option to opt out of receiving this material.<br/><br/>
We may ask you from time to time about what use you make of the services we provide, what other services you would like us to provide in the future, and for other information, such as lifestyle data.<br/><br/>
We may also monitor and record our communications with you, including e-mails and phone conversations. Information which we collect may then be used for training purposes, quality assurance, to record details about the products and services you order from us. <br/><br/>


<strong>What personal information do we collect about you from other companies and organisations?</strong><br/><br/>

We may receive personal information about you from other companies and organisations (for example, for marketing purposes) and we rely on these third parties to obtain your consent for us to use this information.<br/><br/>

<strong>Do we share your personal information with anyone else?</strong><br/><br/>
As a normal part of our business we share with other communications companies information for connecting and charging for calls over each others networks.<br/><br/>
We sometimes use other companies to provide services to you or to provide services to us. To enable them to do this, we may need to share your personal information with them.<br/><br/> 
We may provide information, in response to properly made requests, for the purposes of the prevention and detection of crime, and the apprehension or prosecution of offenders. We may also provide information for the purpose of safeguarding national security. We also provide information when required to do so by law, for example under a court order, or in response to properly made demands, under powers contained in legislation.<br/><br/>


<strong>How can I manage <?php echo SITE_DOMAIN; ?>'s contact with me for marketing purposes?</strong><br/><br/>

You may choose not to receive marketing information from <?php echo SITE_DOMAIN; ?> and, if you are already receiving such information from us, you can ask us to stop at any time. If you would like <?php echo SITE_DOMAIN; ?> not email you with details of products, services and special offers, please email us or log into your member account.<br/><br/> 
<strong>How do we protect your personal information?</strong><br/><br/>

We are serious about guarding the security of your personal information and the details of any transactions made. We take appropriate organisational and technical security measures to protect your data against unauthorised disclosure or processing. We use a secure server to store the information you give us when you register or make an order (including your credit card details and your password). <br/><br/>



<strong>Does <?php echo SITE_DOMAIN; ?>'s privacy policy protect me when I use <?php echo SITE_DOMAIN; ?>'s website?</strong><br/><br/>

You do not have to register to access most of our websites. However, if you provide information via the "contact us" or any of the other interactive features, you indicate your consent to our use of your personal data in the manner described in this privacy policy.<br/><br/>
If you do register on one of our websites, we may ask you to provide personal details such as name, address, e-mail address, telephone number and, where appropriate, <?php echo SITE_DOMAIN; ?> account number. We also ask you to choose a password, and may ask you to complete a password security question and answer.<br/><br/>
Once you have registered on one of our websites, we may keep a record of your use of any of the services made available via that particular website. <br/><br/>
If you choose not to register with us and only browse our websites, we may gather information to help make your visit to our website more satisfying. However, this information will not identify you personally. <br/><br/>
If you have registered for any of the services available through our websites you may choose to cancel that registration at any time. You can do this by sending an e-mail to us. <br/><br/>
If you have registered you have direct control over information in your personal profile on our website. You can access and change this information at any time by using the "Account Details" link.<br/><br/>
Over and above what <?php echo SITE_DOMAIN; ?> does to safeguard your privacy and security on-line, there are a number of things you can do to protect yourself from Internet fraud:
Choose a password (letters and digits) you can remember but others will not guess, change it regularly and, if you do write it down, keep it somewhere safe and secure.<br/><br/>
When you have finished your session on our website, make sure you prevent your details being seen by anyone that you do not wish to see them. So, if you have registered and logged in, remember to log off.<br/><br/>
Clear any cache so there is no record of any transactions left on screen - both Netscape and Internet Explorer let you do this.<br/><br/>
We also recommend you then close your browser so any history of the session is cleared. As an extra precaution, your session on <?php echo SITE_DOMAIN; ?> will time out if you have not used the site for a period of time.<br/><br/>
We collect information from visitors to our websites to help us to make improvements to the websites and to the services we make available. We know, for instance, how many visitors there are to each website, when they visited, for how long and to which areas of our website they went. We may share this information with our advertisers and to other companies which offer their goods or services on our websites. It helps to show these organisations how effective our websites are as sales channels for their products. <br/><br/>
We may also track you if you go to websites carrying our banners.<br/><br/>



<strong>What is a cookie?</strong><br/><br/>

A "cookie" is a text file containing small amounts of information which a server downloads to your personal computer (PC) or mobile when you visit a website. The server then sends a cookie back to the originating website each time you subsequently visit it, or if you visit another website which recognises that cookie.<br/><br/>
There are different types of cookies which are used to do different things, such as letting you navigate between different pages on a website efficiently, remembering preferences you have given a website, and improving your overall experience. Others are used to provide you with advertising which is more tailored to your interests, or to measure the number of site visits and the most popular pages users visit.<br/><br/>
Some cookies are allocated to your PC only for the duration of your visit to a website, and these are called session based cookies. These automatically expire when you close down your browser.<br/><br/>
Another type of cookie known as a "persistent". These cookies would remain on your PC for a period of time.<br/><br/>


<strong>Browser settings</strong><br/><br/>

Cookies can be removed from your PC using browser settings but there will still be some deterioration in the service you receive (for example, you may receive many pop up boxes containing the same advertisements or you may not be able to access a page you earlier personalised).<br/><br/>
Your browser lets you choose whether to accept, not to accept or to be warned before accepting cookies.<br/><br/>

These can be found in the advanced preferences.<br/><br/>


<strong>Are third party sites covered by this policy?</strong><br/><br/>

Third party Internet sites that you can link to from <?php echo SITE_DOMAIN; ?> website are not covered by our privacy policy, so we urge you to be careful when you enter any personal information online. <?php echo SITE_DOMAIN; ?> accepts no responsibility or liability for these sites.<br/><br/>
Other companies which advertise or offer their products or services on our website may also allocate cookies to your PC. The types of cookies they use and how they use the information generated by them will be governed by their own privacy policies and not ours.<br/><br/>

                        </p>
                                          
                        </div>
                   </div><!-- Left box end --.
                   
                   <!-- Right -->
                   <div class="contact-rightbox">
                        <div class="row">
                             <div class="get-started-box">
                            	<div class="get-started-white">
                            		<!--<div class="free-trials-2" id="div-free-trials"><img src="images/free-trials.png" width="175" height="97" alt="Free Trials No Restiction"></div>-->
                                	<div class="getstarted-btn-box"><div class="getstarted-btn">Get Started</div></div>
                                	<div class="getstarted-formbox">
                                		<div class="row">Please Select A Number :</div>
                                		<div class="row">
                                			<select class="selectP5" name="did_country" id="did_country">
	                                           <option value="">Please select a country</option>
	                                           <?php foreach($did_countries as $did_country) { ?>
	                                            <option value="<?php echo trim($did_country["country_iso"]); ?>" <?php if(trim($sel_did_country_code)!="" && trim($sel_did_country_code)==trim($did_country["country_iso"])){echo " selected "; } ?>><?php echo $did_country["country_name"] . ' ' . $did_country["country_prefix"] ?></option>
	                                           <?php } ?>
	                                      </select>
                                		</div>
                                		<div class="row">
                                			<select class="selectP5" name="city" id="city">
	                                           <option value="">Please select a city</option>
	                                      </select>
                                		</div>
                                		<div class="row">Please Enter Your Forwarding Number :</div>
                                		<div class="row">
                                			<select class="selectP5" name="country" id="country">
	                                           <option value="">Please Select Forwarding Country</option>
	                                           <?php foreach($countries as $country) { ?>
	                                                <option value="<?php echo trim($country['country_code']); ?>" <?php if(trim($sel_fwd_cntry) != "" && trim($sel_fwd_cntry)==trim($country["country_code"])){echo " selected "; } ?>><?php echo $country['printable_name'] . '+' . $country['country_code'] ?></option>
	                                           <?php } ?>
	                                           
	                                      </select>
                                		</div>
                                		<div class="row">
                                			<input type="text" class="input" placeholder="+" name="number" id="number" value="<?php echo $forwarding_number; ?>" />
                                		</div>
                                		<div class="row"><a class="slidesjs-navigation continue-btn" id="btn-continue-step1">Continue</a></div>
                                		<div class="row Mtop25"><img src="images/shadow.png"/></div>
                                	</div><!-- End of getstarted-formbox -->
                                </div><!-- End of get-started-white div tag -->
                            </div><!-- End of get-started-box div tag -->
                        </div>
                        
                         
                       <!-- Support -->
                       <div class="row relative">
                            <div class="heading">24/7 Support</div>                            
                            <div class="support-help<?php if(SITE_COUNTRY!="AU"){ echo "1"; } ?>"></div>                            
                       </div>
                       <!-- Support end-->
                       <div class="row Mtop150">
                       <!-- List -->
                       <div class="support-list">
                            <ul>
                               <li>Instant Account Activation</li>
                               <li>24/7 Server Monitoring</li>
                               <li>Complete Easy Manangement Tools</li>
                               <li>Accreditied <?php echo COUNTRY_DEMONYM; ?> Number Supplier</li>
                               <li>Wordwide Phone Number Routing</li>
                               <li>Free Voice Mail</li>                               
                            </ul>
                       </div>
                       </div>
                        
                   </div>
                   
              </div>
         </div>
    </div> 
    <!-- Main wrapper starts here Closed -->
       
       <form method="post" action="<?php echo SITE_URL?>index.php?choose_plan" name="frm-step1" id="frm-step1">
            <input type="hidden" value="" name="did_country_code" id="did_country_code">
            <input type="hidden" value="" name="did_city_code" id="did_city_code">
            <input type="hidden" value="" name="fwd_cntry" id="fwd_cntry">
            <input type="hidden" value="" name="forwarding_number" id="forwarding_number">
            <input type="hidden" value="" name="vnum_country" id="vnum_country">
            <input type="hidden" value="" name="vnum_city" id="vnum_city">
            <input type="hidden" value="choose_plan.php" name="next_page" id="next_page">
       </form>