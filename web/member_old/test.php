<HTML>
<HEAD>
<style type="text/css">
#loadingImg{
position:absolute;
width:300px;
top:0px;
left:50%;
margin-left:-120px;
text-align:center;
padding:7px 0 0 0;
font:bold 11px Arial, Helvetica, sans-serif;
}
</style>
<script type="text/javascript" src="jquery-1.2.6.js"></script>
<script type="text/javascript">
$(document).ready(function () {
  $('#btn').click(function (){
         $.ajax({
         url: 'hello.php',
         cache: false,
         dataType: 'html',
             type:'GET',
         data: { name: $('#name').val()},
         error: function(xhr) {
           alert('Ajax request 發生錯誤');
         },
         success: function(response) {
                   $('#msg').html(response);
           $('#msg').fadeIn();
         }
     });
  });
 $('#clean').click(function(){
    $('#msg').html("");
    // document.getElementById('msg').innerHTML = "";
 });
$("#loadingImg").ajaxStart(function(){
   $(this).show();
});
$("#loadingImg").ajaxStop(function(){
   $(this).hide();
});
})
</script>
</HEAD>
<BODY>
<div id="loadingImg" style="display:none"><img src="loading.gif"> loading...</div>
<br><br><br>
<div align="center">
Enter your name <br>
<input type="text" id="name"> <br>
<input type="button" value="send" id="btn">
<input type="button" value="reset" id="clean">
<br><br><br>
<div id="msg"> </div>
</div>
</BODY>
</HTML>
