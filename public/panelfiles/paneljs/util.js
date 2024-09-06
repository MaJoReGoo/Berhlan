$(document).ready(function () {  
   
    $("#intro").before("<div id='chars' style='float:right;font-weigth:strong;margin-right:150px; font-family:Verdana, Geneva, sans-serif; font-size:10px; color:#036'></div>");

$(function(){
   $('#intro').keyup(function(){
       limitChars('intro', 255, 'chars');
   })
   });
});  


$(document).ready(function () {  
   
    $("#intro").before("<div id='chars' style='float:right;font-weigth:strong;margin-right:150px; font-family:Verdana, Geneva, sans-serif; font-size:10px; color:#036'></div>");

$(function(){
   $('#intro').keyup(function(){
       limitChars('introb', 800, 'chars');
   })
   });
});  


function limitChars(textid, limit, infodiv) {
    var text = $('#'+textid).val();
    var textlength = text.length;
    if(textlength > limit) {
        $('#' + infodiv).html('Alcanzo '+limit+' Caracteres');
        $('#'+textid).val(text.substr(0,limit));
        return false;
    } else {
        $('#' + infodiv).html('Restan '+ (limit - textlength) +' Caracteres');
        return true;
    }
}
