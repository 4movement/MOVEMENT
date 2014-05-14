<html>
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript" src="assets/js/masonry-docs/masonry.pkgd.min.js"></script>
<script type="text/javascript" src="assets/js/scrollpagination.js"></script>   
<script>
$('#container').masonry({
  columnWidth: 350,
  itemSelector: '.item',
  "gutter": 20,
  "isFitWidth": true
});
</script>

<style>
/*set the vertical length*/
#movement_list .item {
	margin-bottom:30px;
}

/* center container with CSS */
#fit-width .masonry {
  margin: 0 auto;
}

</style>

</head>
<body>
<div id="movement_list"  class="masonry js-masonry"  data-masonry-options='{ "columnWidth": 350, "itemSelector": ".item","gutter": 20, "isFitWidth": true}'>       
        <div class="item"><img src="assets/img/sample.jpg" /></div>
        <div class="item"><img src="assets/img/sample.jpg" /></div>
        <div class="item"><img src="assets/img/sample.jpg" /></div>
        <div class="item"><img src="assets/img/sample.jpg" /></div>
		<div class="item"><img src="assets/img/sample.jpg" /></div>
		<div class="item"><img src="assets/img/sample.jpg" /></div>
		<div class="item"><img src="assets/img/sample.jpg" /></div>
		<div class="item"><img src="assets/img/sample.jpg" /></div>
</div> 
</body>

</html>