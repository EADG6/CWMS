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
	/* report page range label */
	function minrange(ele,id){
		minsup = $(ele).val()
		$('#'+id).html(minsup)
		$.ajax({
			url:'ajax.php',
			data:{"minsup":minsup},
			success:function(data){
				if(data.empty==0){
					var htmls;
					for(var i=0;i<data.cut2.length;i++){
						items = data.cut2[i][0].split(',');
						item_html = '<td>'+items[0]+'</td><td>'+items[1]+'</td>'
						htmls += '<tr>'+item_html+'<td><b>'+data.cut2[i][1]+'</b></td><td>'+data.cut2[i][2]+'</td><td>'+data.cut2[i][3]+'</td></tr>'
					}
					if(data.cut3.length>0){
						htmls += '<tr><th>Associate Products 1</th><th>Associate Products 2</th><th>Associate Products 3</th><th class="text-center" colspan=3>Support</th></tr>'
						for(var i=0;i<data.cut3.length;i++){
							items = data.cut3[i][0].split(',');
							item_html = '<td>'+items[0]+'</td><td>'+items[1]+'</td><td>'+items[2]+'</td>'
							htmls += '<tr>'+item_html+'<td class="text-center" colspan=3><b>'+data.cut3[i][1]+'</b></td></tr>'
						}
					}
					$('#resbody').html(htmls)
					$('#nores').hide()
				}else{
					$('#resbody').html('')
					$('#nores').show()
				}
			},
			type:'POST',
			dataType:'json',
			beforeSend:function(){
				
			}
		});
		
	}