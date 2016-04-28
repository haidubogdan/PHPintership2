/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(function() {

    $("section").on("click","#show_cv-html",function (){

        $("#cv_to_html_form").toggle(".OFF");
    });
    $("section").on("click","#show_bc-html",function (){
        $("#bc_to_html_form").toggle(".OFF");;
    });
    
});

