<body>
<?php echo form_open_multipart('event/newevent');?>
<input type="text" disabled="disabled" value="id">
<input type="text" name="ne_name"><input type="date" name="ne_date_start"><input type="date" name="ne_date_end">
<select name="ne_category">
		<option value="1">Anti-smoking</option>
		<option value="2">Anti-unclear energy</option>
		<option value="3">Anti-War</option>
		<option value="4">Consumer</option>
		<option value="5">Education</option>
		<option value="6">Labour</option>
		<option value="7">LGBT</option>
		<option value="8">Reform</option>
		<option value="9">Political</option>
		<option value="10">Others</option>
</select>
<input type="text" name="ne_city">
<input type="time" name="ne_time_start"><input type="time" name="ne_time_end">
<input type="text" name="ne_location">
<input type="text" name="ne_host">
<input type="text" name="ne_url">

<br>
	
<textarea name="ne_intro" rows="4" cols="150" style="resize:none"></textarea><br>
<input type="file" name="userfile">	
<br><input type="submit" value="+">
	
</form>

<?php 
$div_odd = true;
foreach($moves_query as $row){?>
<div <?php if($div_odd == true){$div_odd = false;echo "style=\"background-color:#123456\"";}else{ $div_odd = true;} ?>>
<form name="<?php echo $row->id."_form" ?>" method="post" action="http://merry.ee.ncku.edu.tw/~smart0eddie/codeigniter/index.php/event/update">
<input name="id" type="text" value="<?php echo $row->id ?>" readonly="readonly" />
<input name="name"  type="text" id="<?php echo "name".$row->id?>" value="<?php echo $row->name ?>"/>
<input name="date_start" type="date" id="<?php echo "datestart".$row->id ?>" value="<?php echo $row->date_start?>"/>
<input name="date_end" type="date" id="<?php echo "date_end".$row->id?>" value="<?php echo $row->date_end?>" />
<select name="category">
¡@			<option <?php echo($row->category == 1)? "selected=\"selected\"":"";?> value="1">Anti-smoking</option>
¡@			<option <?php echo($row->category == 2)? "selected=\"selected\"":"";?> value="2">Anti-unclear energy</option>
¡@			<option <?php echo($row->category == 3)? "selected=\"selected\"":"";?> value="3">Anti-War</option>
			<option <?php echo($row->category == 4)? "selected=\"selected\"":"";?> value="4">Consumer</option>
			<option <?php echo($row->category == 5)? "selected=\"selected\"":"";?> value="5">Education</option>
			<option <?php echo($row->category == 6)? "selected=\"selected\"":"";?> value="6">Labour</option>
			<option <?php echo($row->category == 7)? "selected=\"selected\"":"";?> value="7">LGBT</option>
			<option <?php echo($row->category == 8)? "selected=\"selected\"":"";?> value="8">Reform</option>
			<option <?php echo($row->category == 9)? "selected=\"selected\"":"";?> value="9">Political</option>
			<option <?php echo($row->category == 10)? "selected=\"selected\"":"";?> value="10">Others</option>
</select>
<input name="city" type="text" id="<?php echo "city".$row->id?>" value="<?php echo $row->city?>" />
<input name="time_start" type="time" id="<?php echo "time_start".$row->id?>" value="<?php echo $row->time_start?>" />
<input name="time_end" type="time" id="<?php echo "time_end".$row->id?>" value="<?php echo $row->time_end?>" />
<input name="location" type="location" id="<?php echo "location".$row->id?>" value="<?php echo $row->location?>" />
<input name="url" type="url" id="<?php echo "url".$row->id?>" value="<?php echo $row->url?>" />
<input name="host" type="text" id="<?php echo "host".$row->id?>" value="<?php echo $row->host?>" />
<input name="host_account" type="text" id="<?php echo "host_account".$row->id?>" value="<?php echo $row->host_account?>" />
<br>
<textarea name="intro" id="<?php echo "intro".$row->id?>" rows="5" cols="150" style="resize:none"><?php echo $row->intro?></textarea>
<br>
<input type="submit" value="update">
</form>

<?php echo form_open_multipart('event/photo_upload');?>
	<input type="file" name="userfile">
	<input type="hidden" name = "id" value = "<?php echo $row->id;?>">
	<input type="submit" value="upload a photo">
</form>
<?php 
	$hidden = array('id'=>$row->id);  
	echo form_open('event/del','',$hidden);?>
	<input type = "submit" value= "delete">
</form>

<?php if (file_exists("/home/wp/smart0eddie/public_html/movement_photo/".$row->id."_s.jpg"))
	echo "<img src=\"http://merry.ee.ncku.edu.tw/~smart0eddie/movement_photo/".$row->id."_s.jpg\" ></img>";
?>

</div>
<?php } ?>

</body>
