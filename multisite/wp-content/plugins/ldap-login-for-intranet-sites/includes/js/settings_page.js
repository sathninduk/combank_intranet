jQuery(document).ready(function () {
    jQuery("#auth_help").click(function () {
        jQuery("#auth_troubleshoot").toggle();
    });
	jQuery("#conn_help").click(function () {
        jQuery("#conn_troubleshoot").toggle();
    });
	
	jQuery("#conn_help_user_mapping").click(function () {
        jQuery("#conn_user_mapping_troubleshoot").toggle();
    });

    jQuery("#toggle_am_content").click(function () {
        jQuery("#show_am_content").toggle();
    });

    jQuery("#help_curl_title").click(function () {
    	jQuery("#help_curl_desc").slideToggle(400);
    });

    jQuery("#help_ldap_title").click(function () {
    	jQuery("#help_ldap_desc").slideToggle(400);
    });

    jQuery("#connect_using_ldaps").click(function () {
        jQuery("#connect_ldaps_server").slideToggle(400);
    });
    
    jQuery("#help_ping_title").click(function () {
    	jQuery("#help_ping_desc").slideToggle(400);
    });

    jQuery("#help_selinuxboolen_title").click(function () {
        jQuery("#help_selinuxboolen_desc").slideToggle(400);
    });
    
    jQuery("#help_invaliddn_title").click(function () {
    	jQuery("#help_invaliddn_desc").slideToggle(400);
    });
    
    jQuery("#help_invalidsf_title").click(function () {
    	jQuery("#help_invalidsf_desc").slideToggle(400);
    });
    
    jQuery("#help_seracccre_title").click(function () {
    	jQuery("#help_seracccre_desc").slideToggle(400);
    });
    
    jQuery("#help_sbase_title").click(function () {
    	jQuery("#help_sbase_desc").slideToggle(400);
    });
    
    jQuery("#help_sfilter_title").click(function () {
    	jQuery("#help_sfilter_desc").slideToggle(400);
    });
    
    jQuery("#help_ou_title").click(function () {
    	jQuery("#help_ou_desc").slideToggle(400);
    });
    
    jQuery("#help_loginusing_title").click(function () {
    	jQuery("#help_loginusing_desc").slideToggle(400);
    });
    
    jQuery("#help_diffdist_title").click(function () {
    	jQuery("#help_diffdist_desc").slideToggle(400);
    });
    
    jQuery("#help_rolemap_title").click(function () {
    	jQuery("#help_rolemap_desc").slideToggle(400);
    });
    
    jQuery("#help_multiplegroup_title").click(function () {
    	jQuery("#help_multiplegroup_desc").slideToggle(400);
    });
    
    jQuery("#help_curl_warning_title").click(function () {
    	jQuery("#help_curl_warning_desc").slideToggle(400);
    });
    
    jQuery("#help_ldap_warning_title").click(function () {
    	jQuery("#help_ldap_warning_desc").slideToggle(400);
    });

    jQuery('#multisite_basic_number_of_subsites_dropdown_div').change(function () {
        var selected_subsite_index = jQuery('#standard_number_of_subsites_dropdown').prop('selectedIndex');
        showTotalPrice("Basic","multisite",selected_subsite_index);
    });

    jQuery('#multisite_advance_number_of_subsites_dropdown_div').change(function () {

        var selected_subsite_index = jQuery('#advance_number_of_subsites_dropdown').prop('selectedIndex');
        showTotalPrice("plus","multisite",selected_subsite_index);
    });

    jQuery('#multisite_dirc_sync_number_of_subsites_dropdown_div').change(function () {
        var selected_subsite_index = jQuery('#dirc_sync_number_of_subsites_dropdown').prop('selectedIndex');
        showTotalPrice("direc_sync","multisite",selected_subsite_index);
    });
    jQuery('#multisite_kerberos_ntlm_number_of_subsites_dropdown_div').change(function () {
        var selected_subsite_index = jQuery('#kerberose_ntml_number_of_subsites_dropdown').prop('selectedIndex');
        showTotalPrice("kerberose_Ntlm","multisite",selected_subsite_index);
    });
    jQuery('#multisite_multiple_ldap_number_of_subsites_dropdown_div').change(function () {
        var selected_subsite_index = jQuery('#multiple_ldap_number_of_subsites_dropdown').prop('selectedIndex');
        showTotalPrice("multiple_ldap","multisite",selected_subsite_index);
    });
    jQuery('#multisite_direc_sreach_number_of_subsites_dropdown_div').change(function () {
        var selected_subsite_index = jQuery('#direc_search_number_of_subsites_dropdown').prop('selectedIndex');
        showTotalPrice("direc_search","multisite",selected_subsite_index);
    });
    jQuery('#multisite_buddyPress_number_of_subsites_dropdown_div').change(function () {
        var selected_subsite_index = jQuery('#buddyPress_number_of_subsites_dropdown').prop('selectedIndex');
        showTotalPrice("buddyPress","multisite",selected_subsite_index);
    });

    jQuery('#multisite_inclusive_number_of_subsites_dropdown_div').change(function () {
        var selected_subsite_index = jQuery('#inclusive_number_of_subsites_dropdown').prop('selectedIndex');
        showTotalPrice("inclusive","multisite",selected_subsite_index);
    });




    function showTotalPrice(planType,sites,selected_subsite_index) {
        var subsite_price = [0, 60, 90, 160, 200, 240, 300, 360, 400, 500, 550, 600, 650, 700, 999];
        var total_price = 0;
        var total_susite_price = 0;

        if (planType === "Basic") {
            total_price = 99;
            if (selected_subsite_index != null) {

                total_susite_price = subsite_price[selected_subsite_index];
                total_price = total_price + total_susite_price;
            }
        }
        else if (planType === "plus") {

            total_price = 199;

            if (selected_subsite_index != null) {
                total_susite_price = subsite_price[selected_subsite_index];
                total_price = total_price + total_susite_price;

            }

        }
        else if (planType === "direc_sync") {

            total_price = 349;

            if (selected_subsite_index != null) {

                total_susite_price = subsite_price[selected_subsite_index];
                total_price = total_price + total_susite_price;

            }
        }
        else if (planType === "kerberose_Ntlm") {

            total_price = 349;

            if (selected_subsite_index != null) {

                total_susite_price = subsite_price[selected_subsite_index];
                total_price = total_price + total_susite_price;

            }
        }
        else if (planType === "multiple_ldap") {

            total_price = 249;

            if (selected_subsite_index != null) {

                total_susite_price = subsite_price[selected_subsite_index];
                total_price = total_price + total_susite_price;

            }
        }
        else if (planType === "direc_search") {

            total_price = 299;

            if (selected_subsite_index != null) {

                total_susite_price = subsite_price[selected_subsite_index];
                total_price = total_price + total_susite_price;

            }
        }

        else if (planType === "buddyPress") {

            total_price = 299;

            if (selected_subsite_index != null) {

                total_susite_price = subsite_price[selected_subsite_index];
                total_price = total_price + total_susite_price;

            }
        }

        else if (planType === "inclusive") {

            total_price = 449;

            if (selected_subsite_index != null) {

                total_susite_price = subsite_price[selected_subsite_index];
                total_price = total_price + total_susite_price;

            }
        }


        if (planType === "Basic") {

            var span = document.getElementById("multisite_basic_total_price"),
                text = document.createTextNode('$' + total_price);
            span.innerHTML = '';
            span.appendChild(text);
        }
        else if (planType === "plus") {

            var span = document.getElementById("multisite_advance_total_price"),
                text = document.createTextNode('$' + total_price);
            span.innerHTML = '';
            span.appendChild(text);

        }
        else if (planType === "direc_sync") {

            var span = document.getElementById("multisite_direc_sync_total_price"),
                text = document.createTextNode('$' + total_price);
            span.innerHTML = '';
            span.appendChild(text);

        }
        else if (planType === "kerberose_Ntlm") {

            var span = document.getElementById("multisite_kerberose_ntlm_total_price"),
                text = document.createTextNode('$' + total_price);
            span.innerHTML = '';
            span.appendChild(text);

        }
        else if (planType === "multiple_ldap") {

            var span = document.getElementById("multisite_multiple_ldap_total_price"),
                text = document.createTextNode('$' + total_price);
            span.innerHTML = '';
            span.appendChild(text);

        }
        else if (planType === "direc_search") {

            var span = document.getElementById("multisite_direc_search_total_price"),
                text = document.createTextNode('$' + total_price);
            span.innerHTML = '';
            span.appendChild(text);

        }
        else if (planType === "buddyPress") {

            var span = document.getElementById("multisite_buddyPress_total_price"),
                text = document.createTextNode('$' + total_price);
            span.innerHTML = '';
            span.appendChild(text);

        }

        else if (planType === "inclusive") {

            var span = document.getElementById("multisite_inclusive_total_price"),
                text = document.createTextNode('$' + total_price);
            span.innerHTML = '';
            span.appendChild(text);

        }
    }
});