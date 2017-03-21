<script>
/**if choose input week, show the input form, otherwise hide it*/
var ifweek = function (){
	var weekNumInput = document.getElementById('inputtime');
	var timestamp = document.getElementById('timestamp');
	if(timestamp.value =='input_week'){
		weekNumInput.style.display='inline';
		timestamp.onchange = function(){
			weekNumInput.style.display='none';
			timestamp.onchange = ifweek;
		};
	}
};
</script>
<form action="<?php $page?>" class='col-xs-12' method='POST'>
    <div class='form-group col-sm-3'>
		<select name="timestamp" class="form-control" id='timestamp' onchange='ifweek()'>
			<option value='today' selected>Today</option>
			<option value='yesterday'>Yesterday</option>
			<option value='this_week'>This Week</option>
			<option value='this_month'>This Month</option>	
			<option value='this_7_day'>In 7 Day</option>
			<option value='all'>All Time</option>
			<option value='input_week'>Input Week...</option>
		</select>
	</div>
<?php
	$timeres = $mysql->fetch($mysql->query('select year(now()),week(now(),1)'));
	$weeknum = $timeres[1];
	$yearnum = $timeres[0];
?>
	<div class='form-group col-sm-9'>
		<div id='inputtime' style='display:none;'>
			<div class='col-sm-2'>
				<label for='weeknum'>Week:</label>
				<input type='number' name='weeknum' id='weeknum' class="form-control" placeholder='Week' min='0' max='53' value='<?php echo $weeknum;?>'/>
			</div>
			<div class='col-sm-2'>
				<label for='yearnum'>Year:</label>
				<input type='number' name='yearnum' id='yearnum' class="form-control" placeholder='Year' min='2015' max='<?php echo $yearnum;?>' value='<?php echo $yearnum;?>'/>
			</div>
		</div>
		<div class='col-sm-2'>
			<label>Unpaid only <input type='checkbox' name='unpaid'/></label> 
		</div>
		<div class='col-sm-2'>
			<button type='submit' value='OK' class="btn btn-primary">OK</button>
		</div>
	</div>
</form>
<?php
	/**some sql condition to use*/
	$all = '';
	$today ="where date =(current_date())";
	$yesterday ="where date = DATE_SUB(CURDATE(),INTERVAL 1 DAY)";
	$this_7_day = "where DATE_SUB(CURDATE(), INTERVAL 7 DAY) <= date";
	$this_month = "where month(date) = month(now())";
	$this_week = "where week(date,1) = week(now(),1)";
	if(isset($_POST['timestamp'])){
		if(isset($_POST['weeknum']) && $_POST['timestamp']=='input_week'){
/**get the week number, change it on the input form, and change sql condition*/		
			$timestamp = 'this_week';
			$condition = $this_week;
			echo "<script>document.getElementById('timestamp').value = '$timestamp'</script>";
			if(!empty($_POST['yearnum'])){$yearnum = inputCheck($_POST['yearnum']);}
			if($_POST['weeknum']!=''){$weeknum = inputCheck($_POST['weeknum']);}
			$timestamp = "week $weeknum of $yearnum";
			$condition = "where week(date,1) = $weeknum and year(date) = $yearnum";
			echo "<script>document.getElementById('timestamp').value = 'input_week';ifweek();$('#weeknum').val('$weeknum');</script>";
		}else{
			$timestamp=inputCheck($_POST['timestamp']);
			$condition = $$timestamp;
			echo "<script>document.getElementById('timestamp').value = '$timestamp'</script>";
		}
	}else{
		$condition=$today;
		$timestamp='today';
	}
	if(isset($_POST['unpaid'])){
		echo "<script>document.getElementsByName('unpaid')[0].checked = true</script>";
		if($timestamp == 'all'){
			$condition = 'WHERE status = 0';
		}else{
			$condition .= ' AND status = 0';
		}
		$unpaidAdj = '<mark>unpaid</mark>';
	}else{
		$unpaidAdj = '';
	}
?>
