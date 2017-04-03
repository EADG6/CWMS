	function creProSoldChart(data_quan,labels,timecond,data_rev){
		totalQuan = 0;
		for(i=0;i<data_quan.length;i++){
			totalQuan += data_quan[i];
		}
		if(totalQuan>0){
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
	}
	function creSoldProp(timecond,timestamp){
		$.ajax({
			url:'ajax.php',
			data:{"diagram":"soldProp","timecond":timecond},
			type:'POST',
			success:function(data){
				if(data.status!='empty'){
					labels_soldProp = data.labels;
					quan_soldProp = data.quan;
					pri_soldProp = data.price;
					creSoldPropChart(timestamp)
				}
			},
			dataType: 'json'
		});
	}
	function creSoldPropChart(timestamp){
		$('#soldProp').show();
		var soldProp = $("#SoldPropChart");
		var mysoldProp = new Chart(soldProp, {
			type: 'doughnut',
			data: {
				labels: labels_soldProp,
				datasets: [
					{
						data: quan_soldProp,
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
						data: pri_soldProp,
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
		var timetype = timestamp.indexOf('day')>0 ? 'min':'day';
		$.ajax({
			url:'ajax.php',
			data:{"diagram":"ordTrend","timecond":timecond,'timetype':timetype},
			type:'POST',
			success:function(data){
				if(data.status!='empty'){
					labels_time = data.date
					data_tot = data.totquan
					data_ord = data.totord
					data_dri = data.Drinks
					data_acc = data.Accessories
					data_ser = data.Service
					creOrdTrendChart(timestamp)
				}
			},
			dataType: 'json'
		});
	}
	function creOrdTrendChart(timestamp){
		$('#ordTrend').show();
		var ordTrend = $("#OrdTrendChart");
		var time_min =  {
			parser: "HH:mm:ss",
			minUnit: "minute",
			displayFormats: {
				minute: "HH:mm:ss"
			}
		};
		var time_day = {
			parser: "YYYY-MM-DD",
			minUnit: "day",
			displayFormats: {
				day: "DD MMM, YY"
			}
		}
		var timeformat = timestamp.indexOf('day')>0 ? time_min:time_day;
		var data_line =  {
			labels: labels_time,
			datasets: [{
				label: 'Total Quantities',
				data: data_tot,
				fill: false,
				borderColor: "rgba(75,192,192,1)",
				backgroundColor: "rgba(75,192,192,0.2)",
				pointHoverRadius: 5,
				lineTension: 0.1
			},{
				label: 'Total Orders',
				data: data_ord,
				fill: false,
				pointHoverRadius: 5,
				lineTension: 0.1
			},{
				label: 'Drinks',
				data: data_dri,
				backgroundColor: "rgba(255, 206, 86, 0.2)",
				borderColor: 'rgba(255, 206, 86, 0.7)',
				pointHoverRadius: 5,
				lineTension: 0.1
			},{
				label: 'Accessories',
				data: data_acc,
				backgroundColor: 'rgba(54, 162, 235, 0.1)',
				borderColor: 'rgba(54, 162, 235, 0.7)',
				pointHoverRadius: 5,
				lineTension: 0.1
			},{
				label: 'Service',
				data: data_ser,
				backgroundColor: "rgba(255,99,132,0.2)",
				borderColor: 'rgba(255,99,132,0.9)',
				pointHoverRadius: 5,
				lineTension: 0.1
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
						time: timeformat
					}],
					yAxes: [{
						ticks: {
							beginAtZero:true
						}
					}]
				}
			}
		});
	}
	function crefinanTrend(){
		$.ajax({
			url:'ajax.php',
			data:{"diagram":"finanTrend"},
			type:'POST',
			success:function(data){
				data_reve = data.reve
				data_rech = data.rech
				data_pay = data.pay
				crefinanTrendChart()
			},
			dataType: 'json'
		});
	}
	function crefinanTrendChart(){
		$('#finanTrend').show();
		var finanTrend = $("#FinanTrendChart");
		var data_finanTrend =  {
			datasets: [{
				label: 'Payment',
				data: data_pay,
				fill: false,
				backgroundColor: "rgba(255,99,132,0.2)",
				borderColor: 'rgba(255,99,132,0.9)',
				pointHoverRadius: 5,
				lineTension: 0.2
			},{
				label: 'Sales Revenues',
				data: data_reve,
				borderColor: "rgba(75,192,192,1)",
				backgroundColor: "rgba(75,192,192,0.2)",
				pointHoverRadius: 5,
				lineTension: 0.2
			},{
				label: 'Recharge',
				data: data_rech,
				backgroundColor: 'rgba(54, 162, 235, 0.1)',
				borderColor: 'rgba(54, 162, 235, 0.7)',
				pointHoverRadius: 5,
				lineTension: 0.2
			}]
		};
		var myfinanTrendChart = new Chart(finanTrend, {
			type: 'line',
			data: data_finanTrend,
			options: {
				responsive:true,
				title: {
					display: true,
					text: 'Sales Revenues'
				},
				scales: {
					xAxes: [{
						type: 'time',
						position: 'bottom',
						time: {
							parser: "YYYY-MM-DD",
							minUnit: "day",
							displayFormats: {
								day: "DD MMM, YY"
							}
						}
					}],
					yAxes: [{
						ticks: {
							beginAtZero:true
						}
					}]
				}
			}
		});
	}
	function creOrdStaChart(){
		$('#ordSta').show();
		var ordSta = $('#ordStaChart');
		$.ajax({
			url:'ajax.php',
			data:{"diagram":"ordSta"},
			type:'POST',
			success:function(data){
				var myordStaChart = new Chart(ordSta,{
					type: 'pie',
					data: {
						labels: data.labels,
						datasets: [{
							data: data.quan,
							backgroundColor: [
								"#36A2EB",
								"#FFCE56",
								"#FF6384",
								"#4BC0C0"
							]
						}]
					},
					options: {
						responsive: true,
						title: {
							display: true,
							text: 'Paid Orders Proportion'
						},
						animation:{
							animateScale:true
						}
					}
				});
			},
			dataType: 'json'
		});
	}
	function creCusTransacChart(){
		$('#cusTransac').show();
		var cusTransac = $('#cusTransacChart');
		$.ajax({
			url:'ajax.php',
			data:{"diagram":"cusTransac"},
			type:'POST',
			success:function(data){
				var mycusTransacChart = new Chart(cusTransac,{
					type: 'bar',
					data: {
						labels: ['Balance','Recharge','Payment'],
						datasets: [{
							label: "Customers' Transactions",
							data: data,
							backgroundColor: [
								"#FFCE56",
								"#FF6384",
								"#4BC0C0"
							],
							borderWidth: 1
						}]
					},
					options: {
						responsive: true,
						title: {
							display: true,
							text: 'Transactions Statistics'
						},
						scales: {
							xAxes: [{
								stacked: false,
								position: "bottom",
								ticks: {
									beginAtZero:true
								}
							}],
						},
					}
				});
			},
			dataType: 'json'
		});
	}