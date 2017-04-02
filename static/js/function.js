	/* admin Login Page */
	function showSignForm(){
		$('#signInput').show()
		$('#signInput .form-control').attr("required",true)
		$('[name="formlabel"]').html('Already Had Account')
		$('[name="log"]').html('Sign up')
		$('[name="log"]').attr('name','sign')
		$('[name="pwd"]').change(function(){checkpwd()})
		$('[name="formlabel"]').click(function(){location.href="login.php"})
		$('[name="pwd"]').val('')
		checkNewName('admin')
	}
	/* Show real password */
	function seepwd(i){
		pwd = document.getElementsByName(i)[0];
		pwd.type='text';
		this.onmouseup = function(){
			pwd.type='password';
		};
	}
	/* Set time stamp to now */
	function setTimeToNow(){
		document.getElementsByName('reqsDate')[0].valueAsDate = new Date(new Date().setDate(new Date().getDate()+2))
	}
	/* Date must later than tomorrow */
	function checkDate(){
		reqDate = document.getElementsByName('reqsDate')[0].valueAsDate
		reqDate = reqDate.setDate(reqDate.getDate()-2)
		if(reqDate < new Date().getTime()){
			alert("The test drive request time must later than today");
			setTimeToNow();
		}
	}
	/* Add 0 in date time when it less than 10*/
	function add0(e){
		if(e.toString().length==1){
			return '0'+e;
		}else{
			return e
		}
	}
	/* Print current time */
	function printTime(){
		var d = new Date();
		var year = d.getFullYear();
		var day = add0(d.getDate());
		var month = add0(d.getMonth()+1);
		var hours = add0(d.getHours());
		var mins = add0(d.getMinutes());
		var secs = add0(d.getSeconds());
		$('#time').html(year+'/'+month+'/'+day+'&nbsp;'+hours+':'+mins+':'+secs);
	}
	/* use ajax to Check username if exist */
	function checkNewName(pg){
		$('[name="username"]').val($('[name="username"]').val().replace(" ",""))
		if($('[name="username"]').val().length>0 && $('[name="sign"]').length>0){
			$.ajax({
				url:'ajax.php',
				data:{"usercheck":encodeURI(encodeURI($('[name="username"]').val())),"page":pg},
				success:function(data){
					if(data.used=='used'){
						$('[name="username"]').attr('class','form-control alert-danger')
						$('[name="username"]').next().attr('class','seepwd alert-danger')
						$('[name="username"]').next().children('i').attr('class','fa fa-close')
						$('[name="sign"]').attr('disabled','true')
					}else if(data.used=='ok'){
						$('[name="username"]').attr('class','form-control alert-success')
						$('[name="username"]').next().attr('class','seepwd alert-success')
						$('[name="username"]').next().children('i').attr('class','fa fa-check')
					}else if(data.used=='empty'){
						$('[name="username"]').attr('class','form-control')
						$('[name="username"]').next().attr('class','seepwd hidden')
					}
				},
				type:'POST',
				dataType:'json',
				beforeSend:function(){
					$('[name="username"]').next().attr('class','seepwd btn-warning')
					$('[name="username"]').next().children('i').attr('class','fa fa-spinner fa-spin')
				}
			});
		}else{
			$('[name="username"]').attr('class','form-control')
			$('[name="username"]').next().attr('class','seepwd hidden')
		}
	}
	/* use ajax to change order rate */
	function changeRate(){
		if(confirm('Do you want to Rate the order?')){
			starsnum = $('[name="ratelevel"]').val();
			orid = $('[name="rateordid"]').val();
			$.ajax({
				url:'ajax.php',
				data:{"rate":starsnum,"orderid":orid},
				type:'POST'
			});
			stars = ''
			for(var v=0;v<starsnum;v++){
				stars += "<i class='fa fa-star'></i>"
			}
			$('#rate'+orid).html(stars)
			$('#rate'+orid).attr('onclick',"rateOrder('"+orid+"','"+starsnum+"')")
		}$('#modal-rate').click()
	}
	/* use ajax to change order status */
	function changeOrdStatus(){
		if(confirm('Do you want to change the order status?')){
			orid = $('[name="ordstatusid"]').val();
			status = $('[name="orderstatus"]').val();
			statusname = $('[name="statusname"]').val();
			$.ajax({
				url:'ajax.php',
				data:{"status":status,"orderid":orid},
				type:'POST'
			});
			if(status==3){
				unpaidstyle(orid);
			}else if(status<=2){
				normalstyle(orid,status);
			}
			$('#status'+orid).html(statusname)
			if(status==2){
				$('#status'+orid).html("<i class='fa fa-spinner fa-spin'></i> "+statusname)
			}
		}$('#modal-status').click()
	}
	/* use ajax to check customer username */
	function checkCusName(){
		$('[name="username"]').val($('[name="username"]').val().replace(" ",""))
		if($('[name="username"]').val().length>0){
			$.ajax({
				url:'ajax.php',
				data:{"usercheck":encodeURI(encodeURI($('[name="username"]').val())),"page":'employee'},
				success:function(data){
					if(data.used=='used'){
						$('[name="username"]').attr('class','form-control alert-danger')
						$('[name="username"]').next().attr('class','alert-danger')
						$('[name="username"]').next().children('i').attr('class','fa fa-close')
						$('[name="submit"]').attr('disabled',true)
					}else if(data.used=='ok'){
						$('[name="username"]').attr('class','form-control alert-success')
						$('[name="username"]').next().attr('class','alert-success')
						$('[name="username"]').next().children('i').attr('class','fa fa-check')
						$('[name="submit"]').attr('disabled',false)
					}else if(data.used=='empty'){
						$('[name="username"]').attr('class','form-control')
						$('[name="username"]').next().attr('class','hidden')
						$('[name="submit"]').attr('disabled',true)
					}
				},
				type:'POST',
				dataType:'json',
				beforeSend:function(){
					$('[name="username"]').next().attr('class','seepwd btn-warning')
					$('[name="username"]').next().children('i').attr('class','fa fa-spinner fa-spin')
				}
			});
		}else{
			$('[name="username"]').attr('class','form-control')
			$('[name="username"]').next().attr('class','seepwd hidden')
		}
	}
	/* Check password when sign up */
	function checkpwd(){
		var pwd = document.getElementsByName('pwd')[0];
		var pwdconf = document.getElementsByName('pwdConfirm')[0];
		var btnsubmit = document.getElementsByName('sign')[0];
			if(pwd.value.length<4){
				alert("Your password length is too short! Please type more than 3 word");
				pwd.className = 'form-control alert-danger';
				pwdconf.className = 'form-control';
				pwd.value = '';
				pwdconf.value = '';
				pwd.focus();
				btnsubmit.disabled = true;
			}else{
				if(pwd.value == pwdconf.value){
					pwd.className = 'form-control alert-success';
					pwdconf.className = 'form-control alert-success';
					btnsubmit.disabled = false;
				}else{
					pwdconf.className = 'form-control alert-danger';
					pwdconf.value = '';
					btnsubmit.disabled = true;
				}
			}
	}
	/* upload picture function */
	/* function fileSelected(page) {
		file = $('#img')[0].files[0];
		if (file) {
			if (file.size > 20*1024*1024){
				alert('Warning: Picture must be less than 20 MB!');
				window.location.href='index.php?page='+page;
			}else{
				var ext=file.name.substring(file.name.lastIndexOf('.'),file.name.length).toUpperCase();
				if(ext!='.BMP'&&ext!='.GIF'&&ext!='.JPG'&&ext!='.JPEG'&&ext!='.PNG'){
					alert('Please upload image file!(png,gif,jpg,bmp)');
					window.location.href='index.php?page='+page;
				}else{
					var data = new FormData();
					data.append("img",file)
					var path = page=='car' ? 'car':'article';
					data.append("path",path)
					var xhr = new XMLHttpRequest();
					xhr.onreadystatechange = function(){
						if(xhr.readyState==4 && xhr.status==200){
							 resp=JSON.parse(xhr.responseText);
							 switch(resp.status){
								case 0:filename = $('#imgname').val(resp.filename);break; 
								case 1:alert('Upload Fail');break;
								case 2:alert('No File');break;
							 }
							 $('#thumbnail').attr('src',window.URL.createObjectURL($('#img')[0].files[0]))
							 $('#thumbnail').show();
						}
					}
					xhr.upload.onprogress = function(evt){
						//console.log(evt)
						var loaded = evt.loaded;
						var tot = evt.total;
						var per = Math.floor(100*loaded/tot);
						$('#upres').show();
						$('#upres label').html(per+'%')
						$('#upres div').css('width',per+'%')
					}
					xhr.open('post','./ajax.php');
					xhr.send(data)
				}
			}
		}
	} */
	function creProSoldChart(data_quan,labels,timecond,data_rev){
		$('#ProSold').show();
		$('#ProPri').show();
		var proSoldQuan = $("#ProSoldChart");
		var proSoldPri = $("#ProPriChart");
		var myProSoldQuan = new Chart(proSoldQuan, {
			type: 'horizontalBar',//bar or horizontalBar
			data: {
				labels: labels,
				datasets: [
					{
						label: "Sold",
						backgroundColor: 'rgba(54, 162, 235, 0.5)',
						borderColor: 'rgba(54, 162, 235, 1)',
						borderWidth: 1,
						data: data_quan,
					}
				]
			},
			options: {
				responsive: true,
				title: {
					display: true,
					text: 'Products Sold in '+timecond
				},
				scales: {
					xAxes: [{
						position: "top",
						ticks: {
							beginAtZero:true,
							suggestedMin: 0,
							suggestedMax: 10
						}
					}],
					yAxes: [{
						stacked: true,
						position: "left",
						
					}]
				}
			}
		});
		var myProSoldPri = new Chart(proSoldPri, {
			type: 'horizontalBar',
				data:  {
				labels: labels,
				datasets: [
					{
						label: "Revenues",
						backgroundColor: 'rgba(255, 99, 132, 0.2)',
						borderColor: 'rgba(255,99,132,1)',
						borderWidth: 1,
						data: data_rev,
					}
				]
			},
			options: {
				responsive: true,
				title: {
					display: true,
					text: 'Products Sold Revenues in '+timecond
				},
				scales: {
					xAxes: [{
						position: "top",
						ticks: {
							beginAtZero:true,
							suggestedMin: 0,
							suggestedMax: 50
						}
					}],
					yAxes: [{
						position: "left",
						
					}]
				}
			}
		});
	}
	function creSoldProp(timecond,timestamp){
		$.ajax({
			url:'ajax.php',
			data:{"diagram":"soldProp","timecond":timecond},
			type:'POST',
			success:function(data){
				labels_soldProp = data.labels;
				quan_soldProp = data.quan;
				pri_soldProp = data.price;
				creSoldPropChart(labels_soldProp,quan_soldProp,pri_soldProp,timestamp)
			},
			dataType: 'json'
		});
	}
	function creSoldPropChart(labels_soldProp,data_soldProp,data_soldPriProp,timestamp){
		$('#soldProp').show();
		var soldProp = $("#SoldPropChart");
		var mysoldProp = new Chart(soldProp, {
			type: 'doughnut',
			data: {
				labels: labels_soldProp,
				datasets: [
					{
						data: data_soldProp,
						backgroundColor: [
							"#FF6384",
							"#36A2EB",
							"#FFCE56"
						],
						hoverBackgroundColor: [
							"#FF6384",
							"#36A2EB",
							"#FFCE56"
						]
					},{
						data: data_soldPriProp,
						backgroundColor: [
							'rgba(255, 99, 132, 0.7)',
							'rgba(54, 162, 235, 0.7)',
							'rgba(255, 159, 64, 0.7)'
						],
						hoverBackgroundColor:  [
							'rgba(255, 99, 132, 0.5)',
							'rgba(54, 162, 235, 0.5)',
							'rgba(255, 159, 64, 0.5)'
							
						]
					}
				]
			},
			options: {
				responsive: true,
				title: {
					display: true,
					text: 'Solds & Revenues Proportion in '+timestamp
				},
				animation:{
					animateScale:true
				}
			}
		});	
	}
	function creOrdTrend(timecond,timestamp){
		$.ajax({
			url:'ajax.php',
			data:{"diagram":"ordTrend","timecond":timecond},
			type:'POST',
			success:function(data){
				labels_time = data.date
				data_tot = data.totquan
				data_ord = data.totord
				data_dri = data.Drinks
				data_acc = data.Accessories
				data_ser = data.Service
				creOrdTrendChart(labels_time,data_tot,data_dri,data_acc,data_ser,timestamp)
			},
			dataType: 'json'
		});
	}
	function creOrdTrendChart(labels_time,data_tot,data_dri,data_acc,data_ser,timestamp){
		$('#ordTrend').show();
		var ordTrend = $("#OrdTrendChart");
		var data_line =  {
			labels: labels_time,
			datasets: [{
				label: 'Total Quantities',
				data: data_tot,
				fill: false,
				borderColor: "rgba(75,192,192,1)",
				backgroundColor: "rgba(75,192,192,0.2)",
				pointHoverRadius: 5
			},{
				label: 'Total Orders',
				data: data_ord,
				fill: false,
				pointHoverRadius: 5,
			},{
				label: 'Drinks',
				data: data_dri,
				backgroundColor: "rgba(255, 206, 86, 0.2)",
				borderColor: 'rgba(255, 206, 86, 0.7)',
				pointHoverRadius: 5,
			},{
				label: 'Accessories',
				data: data_acc,
				backgroundColor: 'rgba(54, 162, 235, 0.1)',
				borderColor: 'rgba(54, 162, 235, 0.7)',
				pointHoverRadius: 5
			},{
				label: 'Service',
				data: data_ser,
				backgroundColor: "rgba(255,99,132,0.2)",
				borderColor: 'rgba(255,99,132,0.9)',
				pointHoverRadius: 5
			}]
		};
		var myOrdTrendChart = new Chart(ordTrend, {
			type: 'line',
			data: data_line,
			options: {
				responsive: true,
				title: {
					display: true,
					text: 'Sales Trends in '+timestamp
				},
				scales: {
					xAxes: [{
						type: 'time',
						position: 'bottom',
						time: {
							displayFormats: {
								day: "DD MMM, YY"
							}
						}
					}]
				}
			}
		});
	}
	
