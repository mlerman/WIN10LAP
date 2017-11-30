function showPopUp(ele_id) {
    //frm = document.getElementById("debugconsole");
    jQuery("#"+ele_id).fadeIn(400);
    //frm.style.display="inline";        
}

function hidePopUp(ele_id) {
    //frm = document.getElementById("debugconsole");
    //frm.style.display="none";        
    jQuery("#"+ele_id).fadeOut(700);
}

function showLoginForm() {
    frm = document.getElementById("login_box");
    frm.style.display="inline";        
}

function hideLoginForm() {
    frm = document.getElementById("login_box");
    frm.style.display="none";        
}

// Content box size adjustment using jQuery
function ExpandContent() { 
    container = jQuery('.content_container');
    button = jQuery('#changeSizeButton');
    if (container.css('left') == "0px") {
        container.animate({left: 224}, 310);
        button.text('Expand');
    } else {
        container.animate({left: 0}, 310);
        button.text('Contract');
    }
}


//
// AJAX Call to set session.internal to xilinx:'private'
//
//function async_change_disclosure(viewSelection) {
//    jQuery.ajax({
//        type: "POST",
//        data: {disclosure_type: viewSelection},
//        success: function(data, textStatus) {
//            if (viewSelection == 'private') {
//                jQuery("#pubButton").css("background-color","inherit");
//                jQuery("#priButton").css("background-color","#FFCF01");
//                jQuery("#mod_public").css('display','none');
//                jQuery("#mod_private").css('display','inline');
//
//            } else if (viewSelection == 'public') {
//                jQuery("#priButton").css("background-color","inherit");
//                jQuery("#pubButton").css("background-color","#FFCF01");
//                jQuery("#mod_private").css('display','none');
//                jQuery("#mod_public").css('display','inline');
//            } else {
//                alert("Incorrect disclosure type.")
//            }
//        },
//        error: function() {
//            alert("Sorry, cannot update view: AJAXERR.")
//        },
//        });
//    return true
//}

function async_change_disclosure(viewSelection) {
    jQuery.ajax({
        type: "POST",
        data: {disclosure_type: viewSelection},
        dataType: 'html',
        success: function(data, textStatus) {
            if (viewSelection == 'private') {
                jQuery("#pubButton").css("background-color","inherit");
                jQuery("#priButton").css("background-color","#FFCF01");
                jQuery("#dynamic_content").html(data);

            } else if (viewSelection == 'public') {
                jQuery("#priButton").css("background-color","inherit");
                jQuery("#pubButton").css("background-color","#FFCF01");
                jQuery("#dynamic_content").html(data);
            } else {
                alert("Incorrect disclosure type.")
            }
        },
        error: function() {
            alert("Sorry, cannot update view: AJAXERR.")
        },
        });
    return true
}

function async_get_history(request) {
    jQuery.ajax({
        type: "GET",
        data: request,
        success: function(data, textStatus) {
            jQuery("<DIV id=\"log_history\" class=\"popup\">" + 
                   "<DIV class=\"popup_close_button\" onclick=\"hidePopUp(\'log_history\')\"> Close </DIV><BR>" +
                   data + 
                   " </DIV>").insertBefore("#dynamic_content");
            jQuery('#log_history').fadeIn(400);
        },
        error: function() {
            alert("Sorry, cannot update view: AJAXERR.")
        },
        });
    return true
}

//rkulkar
function ajax_show_hide(divid){        
    
    if (jQuery("#"+divid).is(":visible"))
        jQuery("#"+divid).hide();                          
    else
        jQuery("#"+divid).show();                          
    
}
    
/* Makes an ajax query on clicking the search button - rkulkar */
function ajax_show_res(source_flag,restr_flag,content){       
    
    /* source_flag = 0 --> search performed, get results and show them */
    /* source_flag = 1 --> page reloaded, get results and but DON'T show them */
    
    /* NO content       --> Searched from textbox */
    /* content EXISTS --> Searched from the links in sidebar (trustzone, porlist etc) */
    
    /* restr_flag = 0 --> Searched from textbox hence no restriction*/
    /* restr_flag = 1 --> Searched from the links in sidebar (trustzone, porlist etc) hence search ONLY attributes */
    
    if(source_flag == 0) {    
    
        //jQuery("#srch_status").html("Searching ...............");   
        jQuery("#dynamic_content").hide();
        jQuery("#srchresults").show();
        jQuery("#clearSearch").show();
        jQuery("#srch_status").hide();
        jQuery('#swap_views').html("XregDB");
    }
    else if(source_flag == 1){
            jQuery("#srchresults").hide();
            jQuery("#clearSearch").hide();
            
    }
    
    if (!content) {         
        content =  jQuery("#search").val();        
    }    
    
        
    if (content != '') {
        //alert("GET");
        jQuery.ajax(
            {
                type:'GET',                           
                data: {search: content,restr:restr_flag},            
                success: function(data){                        
                tab = format_srch_res(data,content);            
                
                //jQuery("#srchresults").html(tab);   
                jQuery("#srchresults").prepend(tab);   
                        
                    
                },
                error:function(){
                alert("Error");
                } 
            }
        );
    }    
}


/* Displays results on clicking the search button - rkulkar */
function format_srch_res(srchresults,content) {
    
    
    myObj = JSON.parse(srchresults);    
    
    var res_table = '';
    var res_table_cnt = '';
    var cnt_stats;
    var j = 1;
    var mod_cnt = 0, reg_cnt = 0, bf_cnt = 0;
    var unique_mods = new Array();
    var unique_regs = new Array();
    var unique_bfs = new Array();
    
    
    if(myObj.length == 0) {
        document.getElementById('result_cnt').innerHTML = "No Results found. For '"+content+"'. One of the reasons could be restricted content.";
        
    }
    else {
        document.getElementById('result_cnt').innerHTML = "";
    
    for (i in myObj) {  
        unique_mods.push(myObj[i][1]);        
        unique_regs.push(myObj[i][7]);        
        unique_bfs.push(myObj[i][15]);        
        
        if(i > 0) {
            //if its a new module
            if (myObj[i][1] !=  myObj[i-1][1]) {
                
                //end last bitfield table
                //mod_cnt  += 1               
                res_table += '</table><br>';                
                //res_table += build_mod_table(myObj[i],myObj);
                res_table += build_reg_table(myObj[i]);
                res_table += build_bf_table(myObj[i]);
                
                j+=1;                                

            }
            // if its a new register create Register and Bit-Field tables
            else if (myObj[i][7] !=  myObj[i-1][7]) {
                //reg_cnt   += 1; 
                //bf_cnt    += 1; 
                
                res_table += build_reg_table(myObj[i]);
                res_table += build_bf_table(myObj[i]);
                
            }
            //its the same module and same register so append to Bit-field table
            else {
                 //bf_cnt    += 1; 
                 res_table += append_bf_table(myObj[i]);
            }
        
        }
        //if its the first result loop build all tables
        else {
                //mod_cnt   += 1;
                //reg_cnt   += 1; 
                //bf_cnt    += 1;                 
                //res_table += build_mod_table(myObj[i],myObj);
                res_table += build_reg_table(myObj[i]);
                res_table += build_bf_table(myObj[i]);
                j+=1;
             
        }
        
        
    }    
    
    mod_cnt = count_unique(unique_mods);
    reg_cnt = count_unique(unique_regs);
    bf_cnt  = count_unique(unique_bfs);
    
    cnt_stats = "<span class='count'>"+mod_cnt+" Modules found. "+reg_cnt+" Registers found. "+bf_cnt+" Bit-fields found for '<font color='red'>"+content+"</font>'</span>";
    res_table_cnt = cnt_stats + res_table;
    return res_table_cnt;
    }
                        
}

/* Builds the Module table - rkulkar */
function build_mod_table(result,myObj){

    //var res_hdr = "<span class='count'>"+myObj.length+" Results found."+" For "+document.getElementById('search').value+"</span>";
    var mod_hdr = 'Module: '+ '<span class="result_names">'+result[2]+'-->'+result[1]+'</span>';
   
    var str = '</table>';
    //str    += res_hdr; 
    str    += '</table><br><span class="header">==============================================================================================================================================================================</span>'; 
    
    //handle modules with names in CAPS
    
    result[2] = handle_spl_mod(result[2]);
    //if (result[2] == ('afi' || 'gem0' || 'iic' || 'spi' || 'uart')) {
    
    
    
    
    str += '<br><DIV class="header"><A href="./module?mod_id='+result[2]+'">'+ mod_hdr +'</A></DIV>';
    str += '<table class="mod_search">'; 
    
        
    str += '<tr><th>Module</th><td>'         + result[1]                 + '</td></tr>' +
           '<tr><th>Module Type</th><td>'    + result[2]                 + '</td></tr>' +
           '<tr><th>Module Address</th><td>' + result[3].toUpperCase()   + '</td></tr>' +
           '<tr><th>Version</th><td>'        + result[4]                 + '</td></tr>' +
           '<tr><th>Description</th><td>'    + result[5]                 + '</td></tr>' ;    
                
    str += '</table>';
        
    return str;
    
}

/* Builds the Register table - rkulkar */
function build_reg_table(result){
    
    var reg_link = "'"+"module?mod_id="+result[1]+"#"+result[1]+"___"+result[7].toUpperCase()+"'";
    var mod_link = "'"+"module?mod_id="+result[1]+"'";    
        
    var reg_hdr = 'Module: '+'<span class="result_names" onclick="div_redirect('+mod_link+')">'+result[1]+'</span>, Register: <span class="result_names" onclick="div_redirect('+reg_link+')">'+result[7].toUpperCase()+'</span>';
    var str = '</table><br><span class="separator_line">==============================================================================================================================================================================</span>'; 
    str += '<DIV class="header">'+ reg_hdr +'</DIV>';
    str += '<table class="search">'; 
    
    str += '<tr><th width=20%>Register name</th>' +
           '<th width=10%>Address</th>'           +
           '<th width=10%>Width</th>'             +
           '<th width=10%>Type</th>'              +
           '<th width=20%>Reset Value</th>'       +
           '<th width=40%>Description</th></tr>';    
        
    str += '<tr><td width=20%>'  + result[7].toUpperCase() +
        '</td><td width=10%>'    + result[9].toUpperCase() +
        '</td><td width=10%>'    + result[10]              +
        '</td><td width=10%>'    + result[11]              + 
        '</td><td width=10%>'    + result[12].toUpperCase()+
        '</td><td width=40%>'    + result[13]              +
        '</td></tr>';       
                             
    str += '</table><br>';
    
    return str;

}

/* Builds the Bit-field table - rkulkar */
function build_bf_table(result){       
    
    var reg_link = "'"+"module?mod_id="+result[1]+"#"+result[1]+"___"+result[7].toUpperCase()+"'";
    var mod_link = "'"+"module?mod_id="+result[1]+"'";
    //alert("REG_LINK :"+reg_link);
    
    var bf_hdr =  'Module: '+'<span class="result_names" onclick="div_redirect('+mod_link+')">'+result[1]+'</span>, Register: <span class="result_names" onclick="div_redirect('+reg_link+')">'+result[7].toUpperCase()+'</span>,   Bit-Field Details';
    
    var str = '</table>'; 
    str += '<DIV class="header">'+ bf_hdr +'</DIV>';    
    str += '<table class="bf_header">'; 
    str += '<tr><th width=20%>Field Name</th><th width=10%>Bits</th><th width=10%>Type</th><th width=10%>Reset Value</th><th width=50%>Description</th></tr>';    
        
    str += '<tr><td width=20%>' + result[15] +
        '</td><td width=10%>'   + result[16] +
        '</td><td  width=10%>'  + result[17] +
        '</td><td width=10%>'   + result[18] + 
        '</td><td width=50%>'   + result[19] +
        '</td></tr>';
        
    
    return str;

}

/* Prints any javascript dictionary type object - rkulkar */
function print_dict(dict) {
    
    var str = '';
    
    for (item in dict) {
        str += '<td>' + item + ':' + dict[item] +'</td>';
    }
    return str;
}

/* Appends to the Register table - rkulkar */
function append_reg_table(result) {

var str = '';
str += '<tr><td width=20%>'      + result[7]                +
       '</td><td width=10%>'     + result[9].toUpperCase()  +
       '</td><td width=10%>'     + result[10]               +
       '</td><td width=10%>'     + result[11]               + 
       '</td>'+'<td width=10%>'  + result[12].toUpperCase() +
       '</td>' +'<td width=40%>' + result[13]               +
       '</td></tr>';       
        
return str;        

}

/* Appends to the Bit-field table - rkulkar */
function append_bf_table(result) {

var str = '';
str += '<tr><td width=20%>'  + result[15] +
       '</td><td width=10%>' + result[16] +
       '</td><td width=10%>' + result[17] +
       '</td><td width=10%>' + result[18] + 
       '</td><td width=50%>' + result[19] + 
       '</td></tr>';

return str;        

}

/* Swaps between the search view and xregdb view */
function swap_srch_main(div1,div2) {

    if (jQuery("#"+div1).is(":visible")) {
        jQuery('#swap_views').html("XregDB");
        jQuery("#clearSearch").show();
        jQuery("#"+div1).hide();
        jQuery("#"+div2).show();
        jQuery("#srch_status").hide();
    }
    else {
        jQuery('#swap_views').html("Search Results");
        jQuery("#clearSearch").hide();
        jQuery("#srch_status").show();
        jQuery("#"+div1).show();        
        jQuery("#"+div2).hide();
        
    }
   
 
}

function handle_spl_mod(mod) {
    if (mod == 'afi' || mod == 'iic' || mod == 'gem' || mod == 'spi' || mod == 'uart') {
        mod = mod.toUpperCase();        
    }
    else if (mod == 'l2cpl310') {
            mod = 'L2Cpl310';
    }
    return mod;
}

function clear_srch_res() {

    jQuery.ajax(
            {
                type:'GET',                           
                data: {clearSearch: jQuery("#clearSearch").val()},            
                success: function(data){                                        
                jQuery("#srch_status").html("Search Results Cleared !!");                
                jQuery("#srch_status").show();
                jQuery("#srchresults").html("");   
                                        
                    
                },
                error:function(){
                alert("Error");
                } 
            }
        );
    
}

//find the number of unique elements in an array
function count_unique(origArr) {  
    var newArr = [],  
        origLen = origArr.length,  
        found,  
        x, y;  
          
    for ( x = 0; x < origLen; x++ ) {  
        found = undefined;  
        for ( y = 0; y < newArr.length; y++ ) {  
            if ( origArr[x] === newArr[y] ) {   
              found = true;  
              break;  
            }  
        }  
        if ( !found) newArr.push( origArr[x] );      
    }  
   return newArr.length;  
};  

function div_redirect(link) {
    //alert(link);
    jQuery("#srchresults").hide();
    jQuery("#dynamic_content").show();
    window.location = link;
}
