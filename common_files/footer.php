<?php
echo "
<script>
// -- Site variables
    
    // Top Menu Links
    const topNavLinksArray = [
        {title: \"Yellow Pages\", url: \"#\"},
        {title: \"Common Login\", url: \"#\"},
        {title: \"Combank.lk\", url: \"#\"},
        {title: \"ComBank Digital\", url: \"#\"},   // To add a new link, duplicate and edit this line
    ];
    
    // Departments
    const combankDepartmentsArray = [
        {department: \"Home\", url: \"home\"},
        {department: \"AML\", url: \"aml\"},  // To add a new link, duplicate and edit this line
    ];

    
    
    
    
    
    
    
    
    
    
    
// -- Advanced Scripting Functions
// Base URL
const base_url = window.location.origin;
// Page
const url_path =  window.location.href;
const the_url_path_arr = url_path.split('/');
const current_page =  the_url_path_arr[3];

// - Top navigation links
async function combankTopNavLinks () {
    // Element
    document.getElementById(\"top-navigation\").innerHTML = '<div class=\"menu-top-menu-container\"><ul id=\"top-menu\" class=\"menu\"></ul></div>';
    // Top Nav Script
    let linksArrayLength = topNavLinksArray.length;
    for (let i = 0; i < linksArrayLength; i++) {
        const node = document.createElement(\"li\");
        const node2 = document.createElement(\"a\");
        node2.setAttribute(\"href\", topNavLinksArray[i].url);
        const textNode = document.createTextNode(topNavLinksArray[i].title);
        node.appendChild(node2);
        node2.appendChild(textNode);
        document.getElementById(\"top-menu\").appendChild(node);
    }
}
combankTopNavLinks ();

// - Top navigation - Departments
function combankTopNavDeps () {
    // Departments Element
    document.getElementsByClassName(\"top-bar-social\")[0].innerHTML = 
     '<img class=\"top-nav-cmb-logo\" src=\"http://combank.intranet.com/home/wp-content/uploads/2022/02/combank_intra_header.png\">' +
     '<select id=\"combank-departments-top-nav\" onchange=\"combankTopNavDepsOnclick(this.value)\" class=\"combank-top-nav-deps-select\"></select>' + 
     '';
    // Departments Script
    let linksArrayLength = combankDepartmentsArray.length;
    for (let i = 0; i < linksArrayLength; i++) {
        const node = document.createElement(\"option\");
        node.setAttribute(\"value\", combankDepartmentsArray[i].url);
        node.setAttribute(\"id\", \"combank-departments-top-nav-\" + combankDepartmentsArray[i].url);
        const textNode = document.createTextNode(combankDepartmentsArray[i].department);
        node.appendChild(textNode);
        document.getElementById(\"combank-departments-top-nav\").appendChild(node);
    }
    document.getElementById(\"combank-departments-top-nav-\" + current_page).setAttribute(\"selected\", \"\");
}
combankTopNavDeps ();
function combankTopNavDepsOnclick(path) {
    window.location.href = base_url + '/' + path;
}

// Header image
function combankHeaderImage () {
    document.getElementsByClassName(\"header-ad\")[0].innerHTML = 
    //'<img alt=\"\" class=\"combank_header_image\" src=\"http://combank.intranet.com/home/wp-content/uploads/2022/02/combank_intra_header-2.png\">';
    '';
}
combankHeaderImage ();










</script>
";


?>