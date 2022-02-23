<?php

require_once 'page-restriction-menu-settings.php';

function papr_show_premium_plans(){
	?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <div class="papr-background">
        <b><div style="text-align:center; font-size: 25px; margin-top: 1em; margin-bottom: 0.75em;">Page and Post Restriction</div></b>
        <div class="papr-subheading">
            You are currently on the Free version of the plugin
        </div>
        <br>
        <input type="hidden" value="<?php echo papr_is_customer_registered();?>" id="papr_customer_registered">
        <div class="papr-pricing-div" style="width: 50%;">
            <header style="height: 65px;padding: 1em 0.9em 1.6em;pointer-events: auto;text-align: center;color: #2f6062;background-color: transparent;">
                <p style="margin-bottom: 15px;text-transform: uppercase; font-weight: 700; font-size: 20px; margin-top: 0px;" >Choose Your Plan</p>
            </header>
            <div class="cd-pricing-body" style="text-align: center;">
                <ul class="cd-pricing-features">
                    <li>Restrict specific Pages/Posts</li>
                    <li>Restrict Complete Site</li>
                    <li>Restrict based on User Roles</li>
                    <li>Restrict based on User's Login Status</li>
                    <li>Number of Restricted Pages/Posts</li>
                    <li>Error Message to Restricted User</li>
                    <li>Restrict Pages/Posts while Creating (Meta Box)</li>
                    <li>Restrict Category Page</li>
                    <li>Restrict posts of a particular Category</li>
                    <li>Restrict Category based on User Roles</li>
                    <li>Redirect Restricted User to a URL</li>
                    <li>Redirect Restricted User to WordPress Login Page</li>
                    <li>Restrict Entire Custom Post type</li>
                    <li>Integration with SAML/OAuth SSO</li>
                    <li><a style="color:blue; font-size:14px;" href="https://www.miniorange.com/contact"><b>Contact us</b></a></li>
                    <li></li>
                </ul>

            </div>
        </div>

        <div class="papr-pricing-div" style="width: 25%;">
            <header style="height: 65px;padding: 1em 0.9em 1.6em;pointer-events: auto;text-align: center;color: #2f6062;background-color: transparent;">
                <p style="margin-bottom: 15px;text-transform: uppercase; font-weight: 700; font-size: 20px; margin-top: 0px;" >Premium</p>
                <div class="cd-price" >
                    <span class="cd-currency">$</span>
                    <span class="cd-value">149*</span>
                </div>
            </header>
            <div class="cd-pricing-body" style="text-align: center;">
                <ul class="cd-pricing-features">
                    <li><i class="fa fa-check available"></i></li>
                    <li><i class="fa fa-check available"></i></li>
                    <li><i class="fa fa-check available"></i></li>
                    <li><i class="fa fa-check available"></i></li>
                    <li><i class="fa fa-check available"></i></li>
                    <li><i class="fa fa-check available"></i></li>
                    <li><i class="fa fa-check available"></i></li>
                    <li><i class="fa fa-check available"></i></li>
                    <li><i class="fa fa-check available"></i></li>
                    <li><i class="fa fa-check available"></i></li>
                    <li><i class="fa fa-check available"></i></li>
                    <li><i class="fa fa-check available"></i></li>
                    <li><i class="fa fa-times unavailable"></i></li>
                    <li><i class="fa fa-times unavailable"></i></li>
                    <li><a style="color:blue; font-size:14px;" href="https://www.miniorange.com/contact"><b>Contact us</b></a></li>
                    <li></li>
                </ul>
            </div>
        </div>

        <div class="papr-pricing-div" style="width: 25%;">
            <header style="height: 65px;padding: 1em 0.9em 1.6em;pointer-events: auto;text-align: center;color: #2f6062;background-color: transparent;">
                <p style="margin-bottom: 15px;text-transform: uppercase; font-weight: 700; font-size: 20px; margin-top: 0px;" >Enterprise</p>
                <div class="cd-price" >
                    <span class="cd-currency">$</span>
                    <span class="cd-value">249*</span>
                </div>
            </header>
            <div class="cd-pricing-body" style="text-align: center;">
                <ul class="cd-pricing-features">
                    <li><i class="fa fa-check available"></i></li>
                    <li><i class="fa fa-check available"></i></li>
                    <li><i class="fa fa-check available"></i></li>
                    <li><i class="fa fa-check available"></i></li>
                    <li><i class="fa fa-check available"></i></li>
                    <li><i class="fa fa-check available"></i></li>
                    <li><i class="fa fa-check available"></i></li>
                    <li><i class="fa fa-check available"></i></li>
                    <li><i class="fa fa-check available"></i></li>
                    <li><i class="fa fa-check available"></i></li>
                    <li><i class="fa fa-check available"></i></li>
                    <li><i class="fa fa-check available"></i></li>
                    <li><i class="fa fa-check available"></i></li>
                    <li><i class="fa fa-check available"></i></li>
                    <li><a style="color:blue; font-size:14px;" href="https://www.miniorange.com/contact"><b>Contact us</b></a></li>
                    <li></li>
                </ul>
            </div>
        </div>

        <div style="text-align:left; font-size:12px; padding-top: 1em;">
            <h3></h3>
            <div style="margin-right: 20px; margin-left: 20px;">

            </div>

            <h3 style="padding: 0px 10px; padding-left: 5px;">* Cost applicable for one instance only. Licenses are perpetual and the Support Plan includes 12 months of maintenance (support and version updates). You can renew maintenance after 12 months at 50% of the current license cost.</h3>

            <h3>10 Days Return Policy -</h3>
            At miniOrange, we want to ensure you are 100% happy with your purchase. If the premium plugin you purchased is
            not working as advertised and you've attempted to resolve any issues with our support team, which couldn't get
            resolved. We will refund the whole amount within 10 days of the purchase. Please email us at <b><a href="mailto:info@xecurify.com">info@xecurify.com</a></b>
            for any queries regarding the return policy.

        </div>
        <br>
    </div>

    <form style="display:none;" id="loginform"
          action="<?php echo get_option('papr_host_name') . '/moas/login'; ?>"
          target="_blank" method="post">
        <input type="email" name="username" value="<?php echo get_option( 'papr_admin_email' ); ?>"/>
        <input type="text" name="redirectUrl"
               value="<?php echo get_option('papr_host_name') . '/moas/initializepayment'; ?>"/>
        <input type="text" name="requestOrigin" id="requestOrigin"/>
    </form>
    <a  id="paprbacktoaccountsetup" style="display:none;" href="<?php echo admin_url( "admin.php?page=page_restriction&tab=account_setup" ); ?>">Back</a>

    <style>

        .papr-background{
            display:block;
            margin-top:1px;
            background-color:rgba(255, 255, 255, 255);
            padding-left:15px;
            padding-right:15px;
            border:solid 1px rgba(255, 255, 255, 255);
        }
        .papr-subheading{
            text-align:center;
            color: rgb(233, 125, 104);
            font-size: 20px;
        }
        .unavailable{
            color: red;
        }

        html {
            font-size: 62.5%;
        }
        html * {
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        .papr-pricing-div{
            float: left;
        }
        .cd-currency, .cd-value {
            font-size: 4rem;
            font-weight: 300;
        }
        .cd-currency {
            display: inline-block;
            margin-top: 10px;
            vertical-align: top;
            font-size: 2rem;
            font-weight: 700;
        }
        .cd-pricing-features {
            width: auto;
            word-wrap: break-word;
            padding: 0em 0em;
        }
        .cd-pricing-features li {
            padding: 0.75em 1em;
            margin: 0px !important;
            font-size: 1.2em;
            text-align: center;
            white-space: initial;
            line-height:1.1em;
            color: #2f6062;
            float: none;
            width: auto;
        }
        .cd-pricing-features li:nth-of-type(2n+1) {
            background-color: rgba(23, 61, 80, 0.06);
        }

        .cd-pricing-footer {
            position: relative;
            height: auto;
            padding: 1.8em 0;
            text-align: center;
        }

        .cd-select {
            position: static;
            display: inline-block;
            height: auto;
            padding: 1.3em 3em;
            color: #FFFFFF;
            border-radius: 2px;
            background-color: #0c1f28;
            font-size: 1.4rem;
            text-indent: 0;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

    </style>
	<?php
}