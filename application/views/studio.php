<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>카연갤 Studio</title>
  <link rel="shortcut icon" href="//nstatic.dcinside.com/dc/w/images/logo_icon.ico" />
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="/AdminLTE-3.0.0-alpha.2/plugins/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="/AdminLTE-3.0.0-alpha.2/dist/css/adminlte.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="/AdminLTE-3.0.0-alpha.2/plugins/iCheck/flat/blue.css">
  <!-- Morris chart -->
  <link rel="stylesheet" href="/AdminLTE-3.0.0-alpha.2/plugins/morris/morris.css">
  <!-- jvectormap -->
  <link rel="stylesheet" href="/AdminLTE-3.0.0-alpha.2/plugins/jvectormap/jquery-jvectormap-1.2.2.css">
  <!-- Date Picker -->
  <link rel="stylesheet" href="/AdminLTE-3.0.0-alpha.2/plugins/datepicker/datepicker3.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="/AdminLTE-3.0.0-alpha.2/plugins/daterangepicker/daterangepicker-bs3.css">
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="/AdminLTE-3.0.0-alpha.2/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-67526956-3"></script>
	<script>
	  window.dataLayer = window.dataLayer || [];
	  function gtag(){dataLayer.push(arguments);}
	  gtag('js', new Date());

	  gtag('config', 'UA-67526956-3');
	</script>
	<style>
		.progress-bar-vertical {
		  width: 40px;
		  min-height: 380px;
		  display: flex;
		  align-items: flex-end;
		  margin-left: 120px;
		  margin-top: 10px;
		  margin-bottom: 10px;
		  float: left;
		}

		.progress-bar-vertical .progress-bar {
		  width: 100%;
		  height: 0;
		  -webkit-transition: height 0.6s ease;
		  -o-transition: height 0.6s ease;
		  transition: height 0.6s ease;
		}
	</style>

    <script src="//nstatic.dcinside.com/dgn/gallery/js/jquery-3.2.1.min.js"></script>
	<!-- <script src="/application/views/studio.js"></script> -->
	<script>
		var agent = navigator.userAgent.toLowerCase();
console.log('blabla');
if ( (navigator.appName == 'Netscape' && navigator.userAgent.search('Trident') != -1) || (agent.indexOf("msie") != -1) ) {
	var oHTTP = new ActiveXObject("Microsoft.XMLHTTP");
	var vURL = "http://gall.dcinside.com/board/lists/?id=cartoon";
	oHTTP.open("GET", vURL, false);
	oHTTP.send();
	var obj = oHTTP.ResponseText;
	var username;
	if(obj.indexOf('style="cursor:pointer">로그인을 해 주시기 바랍니다.</strong>') > 0){
		username = '로그인을 해 주시기 바랍니다.';
	}
	else{
		var temp = obj.split('<div id="login_box" class="login_box">');
		temp = temp[1].split('<em>');
		temp = temp[1].split('</em>');
		username = temp[0];
	}

	$(document).ready(function(){				
		if(username.indexOf('로그인을 해 주시기 바랍니다.') >= 0)	{
			alert('디시인사이드 로그인을 먼저 해 주시기 바랍니다.');
			opener = self;
			window.close();
		}
		else{
			console.log(username);
			$('#username').text(username);

			$('#bar_reple').hide();
			$('#bar_chu').hide();
			$('#bar_gebichu').hide();
			$('#bar_aggro').hide();
			$('#bar_loyalty').hide();

			$('li').click(function(){
				if($(this).attr('tag') != ''){
					$('#bar_count').hide();
					$('#bar_reple').hide();
					$('#bar_chu').hide();
					$('#bar_gebichu').hide();
					$('#bar_aggro').hide();
					$('#bar_loyalty').hide();
					$('#'+$(this).attr('tag')).show();
				}
			});
			
			var weeks = new Array();
			var week_cur;
			var week_cur_flot;
			var weeks_cur;
			var page_cur;
			var cache = new Array();
			var cache_cur = 0;
			var averages = new Array();
			var averages_flot = new Array();
			var this_week_articles;
			
			var prev_7day = new Date();
			for(j=0; j<4; j++){
				weeks[j] = getWeek(prev_7day);
				prev_7day.setDate(prev_7day.getDate() - 7);
			}

			weeks_cur = j;
			week_cur = 0;
			week_cur_flot = 0;
			page_cur = 1;

			$("#list_average_title").text(weeks[week_cur]['month_of_startdate']+"월 "+weeks[week_cur]['week']+"주차 지표 평균");
			$("#best_title").text("주간 BEST :: "+weeks[week_cur]['month_of_startdate']+"월 "+weeks[week_cur]['week']+"주차("+weeks[week_cur]['month_of_startdate']+"/"+weeks[week_cur]['startdate']+" - "+weeks[week_cur]['month_of_enddate']+"/"+weeks[week_cur]['enddate']+")");

			averages[week_cur] = new Array();
        	averages[week_cur]['count'] = 0;
        	averages[week_cur]['chu'] = 0;
        	averages[week_cur]['bichu'] = 0;
        	averages[week_cur]['reple'] = 0;
        	averages[week_cur]['gebichu'] = 0;
        	averages[week_cur]['aggro'] = 0;
        	averages[week_cur]['loyalty'] = 0;

 			this_week_articles=0;

		    setAndGetCache(-1, -1, 0, 0, 0, true, true);

			$("#prev_week").click(function(){
            	if(week_cur+1 == weeks.length){
            		for(j=0; j<4; j++){
						weeks[weeks_cur+j] = getWeek(prev_7day);
						prev_7day.setDate(prev_7day.getDate() - 7);
					}
					weeks_cur = weeks_cur+j;
            	}
				week_cur++;
            	weekChange();
            });
            $("#next_week").click(function(){
            	if(week_cur > 0){
            		week_cur--;
					weekChange();
            	}
            });

            $("#prev_4weeks").click(function(){
            	if(weeks_cur == weeks.length){
            		for(j=0; j<4; j++){
						weeks[weeks_cur+j] = getWeek(prev_7day);
						prev_7day.setDate(prev_7day.getDate() - 7);
					}
            	}
				weeks_cur = Number(weeks_cur)+4;
				console.log('weeks_cur: '+weeks_cur);
            	weeksChange(-1, -1);
            });
            $("#next_4weeks").click(function(){
            	if(week_cur_flot > 7){
            		week_cur_flot -= 8;
					weeksChange(-1, -1);
            	}
            });				   

			$(document).ajaxStop(function(){
				$("#prev_week").attr("disabled", false);
            	$("#next_week").attr("disabled", false);
            	$("#prev_4weeks").attr("disabled", false);
            	$("#next_4weeks").attr("disabled", false);
	        });

		}

		function weeksChange(k, s){
			for(var t=0; t<4; t++){
        		$("#bar_"+(4-t)+"_count").html('<i class="fa fa-refresh fa-spin"></i>');
        		$("#bar_"+(4-t)+"_chu").html('<i class="fa fa-refresh fa-spin"></i>');
        		$("#bar_"+(4-t)+"_bichu").html('<i class="fa fa-refresh fa-spin"></i>');
        		$("#bar_"+(4-t)+"_reple").html('<i class="fa fa-refresh fa-spin"></i>');
        		$("#bar_"+(4-t)+"_gebichu").html('<i class="fa fa-refresh fa-spin"></i>');
        		$("#bar_"+(4-t)+"_aggro").html('<i class="fa fa-refresh fa-spin"></i>');
        		$("#bar_"+(4-t)+"_loyalty").html('<i class="fa fa-refresh fa-spin"></i>');
        	}
			for(s++; s<4; s++){
				console.log('weeksChange: '+s+'th loop start')
				console.log('averages_flot['+week_cur_flot+'] setting')
				averages_flot[week_cur_flot] = new Array();
            	averages_flot[week_cur_flot]['count'] = 0;
            	averages_flot[week_cur_flot]['chu'] = 0;
            	averages_flot[week_cur_flot]['bichu'] = 0;
            	averages_flot[week_cur_flot]['reple'] = 0;
            	averages_flot[week_cur_flot]['gebichu'] = 0;
            	averages_flot[week_cur_flot]['aggro'] = 0;
            	averages_flot[week_cur_flot]['loyalty'] = 0;
            	this_week_articles = 0;
        		if( getCacheToFlot(k, s) == 0)
        			return 0;

        	}
        	this_week_articles=0;
        	var top_value = new Array();
        	top_value['count'] = averages_flot[week_cur_flot-1]['count'];
        	top_value['chu'] = averages_flot[week_cur_flot-1]['chu'];
        	top_value['bichu'] = averages_flot[week_cur_flot-1]['bichu'];
        	top_value['reple'] = averages_flot[week_cur_flot-1]['reple'];
        	top_value['gebichu'] = averages_flot[week_cur_flot-1]['gebichu'];
        	top_value['aggro'] = averages_flot[week_cur_flot-1]['aggro'];
        	top_value['loyalty'] = averages_flot[week_cur_flot-1]['loyalty'];

        	if(top_value['count'] == 0) top_value['count'] = 1;
			if(top_value['chu'] == 0) top_value['chu'] = 1;
			if(top_value['bichu'] == 0) top_value['bichu'] = 1;
			if(top_value['reple'] == 0) top_value['reple'] = 1;
			if(top_value['gebichu'] == 0) top_value['gebichu'] = 1;
			if(top_value['aggro'] == 0) top_value['aggro'] = 1;
			if(top_value['loyalty'] == 0) top_value['loyalty'] = 1;

        	for(s=0; s<4; s++){
        		if(Number(averages_flot[week_cur_flot-1-s]['count']) >= Number(top_value['count']))
        			top_value['count'] = averages_flot[week_cur_flot-1-s]['count'];
        		if(Number(averages_flot[week_cur_flot-1-s]['chu']) >= Number(top_value['chu']))
        			top_value['chu'] = averages_flot[week_cur_flot-1-s]['chu'];
        		if(Number(averages_flot[week_cur_flot-1-s]['bichu']) >= Number(top_value['bichu']))
        			top_value['bichu'] = averages_flot[week_cur_flot-1-s]['bichu'];
        		if(Number(averages_flot[week_cur_flot-1-s]['reple']) >= Number(top_value['reple']))
        			top_value['reple'] = averages_flot[week_cur_flot-1-s]['reple'];
        		if(Number(averages_flot[week_cur_flot-1-s]['gebichu']) >= Number(top_value['gebichu']))
        			top_value['gebichu'] = averages_flot[week_cur_flot-1-s]['gebichu'];
        		if(Number(averages_flot[week_cur_flot-1-s]['aggro']) >= Number(top_value['aggro']))
        			top_value['aggro'] = averages_flot[week_cur_flot-1-s]['aggro'];
        		if(Number(averages_flot[week_cur_flot-1-s]['loyalty']) >= Number(top_value['loyalty']))
        			top_value['loyalty'] = averages_flot[week_cur_flot-1-s]['loyalty'];
        	}
        	if(Number(top_value['chu']) < Number(top_value['bichu']))
        		top_value['chu'] = top_value['bichu']
        	for(s=0; s<4; s++){
        		$("#bar_"+(4-s)+"_count").css("height", (averages_flot[week_cur_flot-4+s]['count']/top_value['count'])*100+"%");
        		$("#bar_"+(4-s)+"_count").text(averages_flot[week_cur_flot-4+s]['count']);
        		$("#bar_"+(4-s)+"_count").attr("title", averages_flot[week_cur_flot-4+s]['count']);
        		$("#bar_"+(4-s)+"_chu").css("height", (averages_flot[week_cur_flot-4+s]['chu']/top_value['chu'])*100+"%");
        		$("#bar_"+(4-s)+"_chu").text(averages_flot[week_cur_flot-4+s]['chu']);
        		$("#bar_"+(4-s)+"_chu").attr("title", averages_flot[week_cur_flot-4+s]['chu']);
        		$("#bar_"+(4-s)+"_bichu").css("height", (averages_flot[week_cur_flot-4+s]['bichu']/top_value['chu'])*100+"%");
        		$("#bar_"+(4-s)+"_bichu").text(averages_flot[week_cur_flot-4+s]['bichu']);
        		$("#bar_"+(4-s)+"_bichu").attr("title", averages_flot[week_cur_flot-4+s]['bichu']);
        		$("#bar_"+(4-s)+"_reple").css("height", (averages_flot[week_cur_flot-4+s]['reple']/top_value['reple'])*100+"%");
        		$("#bar_"+(4-s)+"_reple").text(averages_flot[week_cur_flot-4+s]['reple']);
        		$("#bar_"+(4-s)+"_reple").attr("title", averages_flot[week_cur_flot-4+s]['reple']);
        		$("#bar_"+(4-s)+"_gebichu").css("height", (averages_flot[week_cur_flot-4+s]['gebichu']/top_value['gebichu'])*100+"%");
        		$("#bar_"+(4-s)+"_gebichu").text(averages_flot[week_cur_flot-4+s]['gebichu']);
        		$("#bar_"+(4-s)+"_gebichu").attr("title", averages_flot[week_cur_flot-4+s]['gebichu']);
        		$("#bar_"+(4-s)+"_aggro").css("height", (averages_flot[week_cur_flot-4+s]['aggro']/top_value['aggro'])*100+"%");
        		$("#bar_"+(4-s)+"_aggro").text(averages_flot[week_cur_flot-4+s]['aggro']);
        		$("#bar_"+(4-s)+"_aggro").attr("title", averages_flot[week_cur_flot-4+s]['aggro']);
        		$("#bar_"+(4-s)+"_loyalty").css("height", (averages_flot[week_cur_flot-4+s]['loyalty']/top_value['loyalty'])*100+"%");
        		$("#bar_"+(4-s)+"_loyalty").text(averages_flot[week_cur_flot-4+s]['loyalty']);
        		$("#bar_"+(4-s)+"_loyalty").attr("title", averages_flot[week_cur_flot-4+s]['loyalty']);
        	}
		}

		function getCacheToFlot(j, s) {
			
			console.log('week_cur_flot: '+week_cur_flot);
			console.log('week: '+weeks[week_cur_flot]['week']);
			var week_start = new Date(weeks[week_cur_flot]['year_of_startdate']+'-'+weeks[week_cur_flot]['month_of_startdate']+'-'+weeks[week_cur_flot]['startdate']);
        	var week_end = new Date(weeks[week_cur_flot]['year_of_enddate']+'-'+weeks[week_cur_flot]['month_of_enddate']+'-'+weeks[week_cur_flot]['enddate']);
            for(j++; j<cache_cur; j++){
            	var article_date = new Date(cache[j]['date'].slice(0,10));

            	// console.log(j+': '+cache[j]['titles'].slice(0,10)+'... week_start: '+weeks[week_cur_flot]['year_of_startdate']+'-'+weeks[week_cur_flot]['month_of_startdate']+'-'+weeks[week_cur_flot]['startdate']+' article_date: '+cache[j]['date'].slice(0,10)+' enddate: '+weeks[week_cur_flot]['year_of_enddate']+'-'+weeks[week_cur_flot]['month_of_enddate']+'-'+weeks[week_cur_flot]['enddate']);
            	if(week_start <= article_date && article_date <= week_end){
            		if($("#list_invisible").html().indexOf(cache[j]['date']) == -1){
	            		// console.log(j+"(if)");
	            		$("#list_invisible").append('<tr><td>'+cache[j]['date']+'</td></tr>');
	            		averages_flot[week_cur_flot]['count'] = Number(averages_flot[week_cur_flot]['count']) + Number(cache[j]['count']);
	            		averages_flot[week_cur_flot]['chu'] = Number(averages_flot[week_cur_flot]['chu']) + Number(cache[j]['chu']);
	            		averages_flot[week_cur_flot]['bichu'] = Number(averages_flot[week_cur_flot]['bichu']) + Number(cache[j]['bichu']);
	            		averages_flot[week_cur_flot]['reple'] = Number(averages_flot[week_cur_flot]['reple']) + Number(cache[j]['reple']);
	            		averages_flot[week_cur_flot]['gebichu'] = Number(averages_flot[week_cur_flot]['gebichu']) + Number(cache[j]['gebichu']);
	            		averages_flot[week_cur_flot]['aggro'] = Number(averages_flot[week_cur_flot]['aggro']) + Number(cache[j]['aggro']);
	            		averages_flot[week_cur_flot]['loyalty'] = Number(averages_flot[week_cur_flot]['loyalty']) + Number(cache[j]['loyalty']);
	            		this_week_articles++;
            		}
            	}
            	else if(article_date < week_start){
        			break;
            	}
            	if(j == cache_cur-1){
            		page_cur++;
            		console.log('page: '+page_cur);
        			setAndGetCacheToFlot(j, s, true);
        			return 0;
            	}
            }

			$("#bar_"+(4-s)+"_tag").text(weeks[week_cur_flot]['month_of_startdate']+"월 "+weeks[week_cur_flot]['week']+"주차");

            if(this_week_articles > 0){
            	averages_flot[week_cur_flot]['count'] = (averages_flot[week_cur_flot]['count']/this_week_articles).toFixed(0);
        		averages_flot[week_cur_flot]['chu'] = (averages_flot[week_cur_flot]['chu']/this_week_articles).toFixed(0);
        		averages_flot[week_cur_flot]['bichu'] = (averages_flot[week_cur_flot]['bichu']/this_week_articles).toFixed(0);
        		averages_flot[week_cur_flot]['reple'] = (averages_flot[week_cur_flot]['reple']/this_week_articles).toFixed(0);
        		averages_flot[week_cur_flot]['gebichu'] = (averages_flot[week_cur_flot]['gebichu']/this_week_articles).toFixed(3);
        		averages_flot[week_cur_flot]['aggro'] = (averages_flot[week_cur_flot]['aggro']/this_week_articles).toFixed(3);
        		averages_flot[week_cur_flot]['loyalty'] = (averages_flot[week_cur_flot]['loyalty']/this_week_articles).toFixed(2);
    		}
    		else{
    			averages_flot[week_cur_flot]['count'] = 0;
        		averages_flot[week_cur_flot]['chu'] = 0;
        		averages_flot[week_cur_flot]['bichu'] = 0;
        		averages_flot[week_cur_flot]['reple'] = 0;
        		averages_flot[week_cur_flot]['gebichu'] = 0;
        		averages_flot[week_cur_flot]['aggro'] = 0;
        		averages_flot[week_cur_flot]['loyalty'] = 0;	
    		}
    		week_cur_flot++;
    		$("#list_invisible").empty();
		}

		function setAndGetCacheToFlot(k, s, recursive) {
			$("#prev_4weeks").attr("disabled", true);
            $("#next_4weeks").attr("disabled", true);
			$.ajax({
		        url:'/index.php/studio/listitems',
		        type:'post',
		        dataType:'json',
		        data: { "username" : username, "page" : page_cur },
		        success: function(data){
		            console.log(data);
		            for(var j=0; j<data.list.date.length; j++){
		            	cache[cache_cur] = new Array();
		            	cache[cache_cur]['aggro'] = data.list.aggro[j];
		            	cache[cache_cur]['bichu'] = data.list.bichu[j];
		            	cache[cache_cur]['chu'] = data.list.chu[j];
		            	cache[cache_cur]['count'] = data.list.count[j];
		            	cache[cache_cur]['date'] = data.list.date[j];
		            	cache[cache_cur]['gebichu'] = data.list.gebichu[j];
		            	cache[cache_cur]['loyalty'] = data.list.loyalty[j];
		            	cache[cache_cur]['reple'] = data.list.reple[j];
		            	cache[cache_cur]['titles'] = data.list.titles[j];
		            	cache[cache_cur]['url'] = data.list.url[j];
		            	cache_cur++;
		            }
		            for(; s<4; s++){
		            	console.log('setAndGetCacheToFlot: '+s+'th loop start')
		            	if(!recursive){
		            		console.log('!recursive: averages_flot['+week_cur_flot+'] setting')
							averages_flot[week_cur_flot] = new Array();
			            	averages_flot[week_cur_flot]['count'] = 0;
			            	averages_flot[week_cur_flot]['chu'] = 0;
			            	averages_flot[week_cur_flot]['bichu'] = 0;
			            	averages_flot[week_cur_flot]['reple'] = 0;
			            	averages_flot[week_cur_flot]['gebichu'] = 0;
			            	averages_flot[week_cur_flot]['aggro'] = 0;
			            	averages_flot[week_cur_flot]['loyalty'] = 0;
			            	k = -1;
			            	this_week_articles = 0;
			            }
			            if( getCacheToFlot(k, s) == 0)
        					return 0;
		            	recursive = false;
		            }
		            this_week_articles=0;
		            var top_value = new Array();
	            	top_value['count'] = averages_flot[week_cur_flot-1]['count'];
	            	top_value['chu'] = averages_flot[week_cur_flot-1]['chu'];
	            	top_value['bichu'] = averages_flot[week_cur_flot-1]['bichu'];
	            	top_value['reple'] = averages_flot[week_cur_flot-1]['reple'];
	            	top_value['gebichu'] = averages_flot[week_cur_flot-1]['gebichu'];
	            	top_value['aggro'] = averages_flot[week_cur_flot-1]['aggro'];
	            	top_value['loyalty'] = averages_flot[week_cur_flot-1]['loyalty'];

	            	if(top_value['count'] == 0) top_value['count'] = 1;
					if(top_value['chu'] == 0) top_value['chu'] = 1;
					if(top_value['bichu'] == 0) top_value['bichu'] = 1;
					if(top_value['reple'] == 0) top_value['reple'] = 1;
					if(top_value['gebichu'] == 0) top_value['gebichu'] = 1;
					if(top_value['aggro'] == 0) top_value['aggro'] = 1;
					if(top_value['loyalty'] == 0) top_value['loyalty'] = 1;
	            	
	            	for(s=0; s<4; s++){
	            		if(Number(averages_flot[week_cur_flot-1-s]['count']) >= Number(top_value['count']))
	            			top_value['count'] = averages_flot[week_cur_flot-1-s]['count'];
	            		if(Number(averages_flot[week_cur_flot-1-s]['chu']) >= Number(top_value['chu']))
	            			top_value['chu'] = averages_flot[week_cur_flot-1-s]['chu'];
	            		if(Number(averages_flot[week_cur_flot-1-s]['bichu']) >= Number(top_value['bichu']))
	            			top_value['bichu'] = averages_flot[week_cur_flot-1-s]['bichu'];
	            		if(Number(averages_flot[week_cur_flot-1-s]['reple']) >= Number(top_value['reple']))
	            			top_value['reple'] = averages_flot[week_cur_flot-1-s]['reple'];
	            		if(Number(averages_flot[week_cur_flot-1-s]['gebichu']) >= Number(top_value['gebichu']))
	            			top_value['gebichu'] = averages_flot[week_cur_flot-1-s]['gebichu'];
	            		if(Number(averages_flot[week_cur_flot-1-s]['aggro']) >= Number(top_value['aggro']))
	            			top_value['aggro'] = averages_flot[week_cur_flot-1-s]['aggro'];
	            		if(Number(averages_flot[week_cur_flot-1-s]['loyalty']) >= Number(top_value['loyalty']))
	            			top_value['loyalty'] = averages_flot[week_cur_flot-1-s]['loyalty'];
	            	}
	            	if(Number(top_value['chu']) < Number(top_value['bichu']))
        					top_value['chu'] = top_value['bichu']
	            	for(s=0; s<4; s++){
	            		$("#bar_"+(4-s)+"_count").css("height", (averages_flot[week_cur_flot-4+s]['count']/top_value['count'])*100+"%");
	            		$("#bar_"+(4-s)+"_count").text(averages_flot[week_cur_flot-4+s]['count']);
	            		$("#bar_"+(4-s)+"_count").attr("title", averages_flot[week_cur_flot-4+s]['count']);
	            		$("#bar_"+(4-s)+"_chu").css("height", (averages_flot[week_cur_flot-4+s]['chu']/top_value['chu'])*100+"%");
	            		$("#bar_"+(4-s)+"_chu").text(averages_flot[week_cur_flot-4+s]['chu']);
	            		$("#bar_"+(4-s)+"_chu").attr("title", averages_flot[week_cur_flot-4+s]['chu']);
	            		$("#bar_"+(4-s)+"_bichu").css("height", (averages_flot[week_cur_flot-4+s]['bichu']/top_value['chu'])*100+"%");
	            		$("#bar_"+(4-s)+"_bichu").text(averages_flot[week_cur_flot-4+s]['bichu']);
	            		$("#bar_"+(4-s)+"_bichu").attr("title", averages_flot[week_cur_flot-4+s]['bichu']);
	            		$("#bar_"+(4-s)+"_reple").css("height", (averages_flot[week_cur_flot-4+s]['reple']/top_value['reple'])*100+"%");
	            		$("#bar_"+(4-s)+"_reple").text(averages_flot[week_cur_flot-4+s]['reple']);
	            		$("#bar_"+(4-s)+"_reple").attr("title", averages_flot[week_cur_flot-4+s]['reple']);
	            		$("#bar_"+(4-s)+"_gebichu").css("height", (averages_flot[week_cur_flot-4+s]['gebichu']/top_value['gebichu'])*100+"%");
	            		$("#bar_"+(4-s)+"_gebichu").text(averages_flot[week_cur_flot-4+s]['gebichu']);
	            		$("#bar_"+(4-s)+"_gebichu").attr("title", averages_flot[week_cur_flot-4+s]['gebichu']);
	            		$("#bar_"+(4-s)+"_aggro").css("height", (averages_flot[week_cur_flot-4+s]['aggro']/top_value['aggro'])*100+"%");
	            		$("#bar_"+(4-s)+"_aggro").text(averages_flot[week_cur_flot-4+s]['aggro']);
	            		$("#bar_"+(4-s)+"_aggro").attr("title", averages_flot[week_cur_flot-4+s]['aggro']);
	            		$("#bar_"+(4-s)+"_loyalty").css("height", (averages_flot[week_cur_flot-4+s]['loyalty']/top_value['loyalty'])*100+"%");
	            		$("#bar_"+(4-s)+"_loyalty").text(averages_flot[week_cur_flot-4+s]['loyalty']);
	            		$("#bar_"+(4-s)+"_loyalty").attr("title", averages_flot[week_cur_flot-4+s]['loyalty']);
	            	}
		        },
		        error: function(e){
		        	console.log(e);
		        }
		    })
		}

		function weekChange(){
			$("#list_average_title").text(weeks[week_cur]['month_of_startdate']+"월 "+weeks[week_cur]['week']+"주차 지표 평균");
    		$("#best_title").text("주간 BEST :: "+weeks[week_cur]['month_of_startdate']+"월 "+weeks[week_cur]['week']+"주차("+weeks[week_cur]['month_of_startdate']+"/"+weeks[week_cur]['startdate']+" - "+weeks[week_cur]['month_of_enddate']+"/"+weeks[week_cur]['enddate']+")");
    		$("#list_average").empty();
    		$("#list_average").append('<tr align="center" id="list_average_loading"><td><i class="fa fa-refresh fa-spin"></i></td></tr>');
    		$("#list").empty();
    		$("#list").append('<tr align="center" id="list_loading"><td><i class="fa fa-refresh fa-spin"></i></td></tr>');
    		averages[week_cur] = new Array();
        	averages[week_cur]['count'] = 0;
        	averages[week_cur]['chu'] = 0;
        	averages[week_cur]['bichu'] = 0;
        	averages[week_cur]['reple'] = 0;
        	averages[week_cur]['gebichu'] = 0;
        	averages[week_cur]['aggro'] = 0;
        	averages[week_cur]['loyalty'] = 0;
        	this_week_articles=0;
        	getCache(-1, 0, 0, 0, true);
		}

		function getCache(j, best_count_idx, best_chu_idx, best_reple_idx, flag) {
			var week_start = new Date(weeks[week_cur]['year_of_startdate']+'-'+weeks[week_cur]['month_of_startdate']+'-'+weeks[week_cur]['startdate']);
        	var week_end = new Date(weeks[week_cur]['year_of_enddate']+'-'+weeks[week_cur]['month_of_enddate']+'-'+weeks[week_cur]['enddate']);
            for(j++; j<cache_cur; j++){
            	var article_date = new Date(cache[j]['date'].slice(0,10));

            	// console.log(j+': '+cache[j]['titles'].slice(0,15)+'... week_start: '+weeks[week_cur]['year_of_startdate']+'-'+weeks[week_cur]['month_of_startdate']+'-'+weeks[week_cur]['startdate']+' article_date: '+cache[j]['date'].slice(0,10)+' enddate: '+weeks[week_cur]['year_of_enddate']+'-'+weeks[week_cur]['month_of_enddate']+'-'+weeks[week_cur]['enddate']);
            	if(week_start <= article_date && article_date <= week_end){
            		if($("#list").html().indexOf(cache[j]['date']) == -1){
	            		// console.log(j+"(if)");
	            		$("#list").append('<tr><td><a href="'+cache[j]['url']+'" target="_blank">'+cache[j]['titles']+'</a> ['+cache[j]['reple']+']</td><td>'+cache[j]['date']+'</td><td>'+cache[j]['count']+'</td><td>'+cache[j]['chu']+'</td><td>'+cache[j]['bichu']+'</td><td>'+cache[j]['gebichu']+'</td><td>'+cache[j]['aggro']+'</td><td>'+cache[j]['loyalty']+'</td></tr>');

	            		averages[week_cur]['count'] = Number(averages[week_cur]['count']) + Number(cache[j]['count']);
	            		averages[week_cur]['chu'] = Number(averages[week_cur]['chu']) + Number(cache[j]['chu']);
	            		averages[week_cur]['bichu'] = Number(averages[week_cur]['bichu']) + Number(cache[j]['bichu']);
	            		averages[week_cur]['reple'] = Number(averages[week_cur]['reple']) + Number(cache[j]['reple']);
	            		averages[week_cur]['gebichu'] = Number(averages[week_cur]['gebichu']) + Number(cache[j]['gebichu']);
	            		averages[week_cur]['aggro'] = Number(averages[week_cur]['aggro']) + Number(cache[j]['aggro']);
	            		averages[week_cur]['loyalty'] = Number(averages[week_cur]['loyalty']) + Number(cache[j]['loyalty']);
	            		this_week_articles++;

	            		if(flag){
	            			best_count_idx= j;
	            			best_chu_idx= j;
	            			best_reple_idx= j;
	            		}

	            		if(Number(cache[j]['count']) >= Number(cache[best_count_idx]['count'])){
	            			best_count_idx = j;
	            		}
	            		if(Number(cache[j]['chu']) >= Number(cache[best_chu_idx]['chu'])){
	            			best_chu_idx = j;
	            		}
	            		if(Number(cache[j]['reple']) >= Number(cache[best_reple_idx]['reple'])){
	            			best_reple_idx = j;
	            		}
	            		flag = false;
            		}
            	}
            	else if(article_date < week_start){
        			break;
            	}
            	if(j == cache_cur-1){
            		page_cur++;
        			setAndGetCache(j, 0, best_count_idx, best_chu_idx, best_reple_idx, flag, false);
        			return 0;
            	}
            }
            if(this_week_articles > 0){
            	averages[week_cur]['count'] = (averages[week_cur]['count']/this_week_articles).toFixed(0);
        		averages[week_cur]['chu'] = (averages[week_cur]['chu']/this_week_articles).toFixed(0);
        		averages[week_cur]['bichu'] = (averages[week_cur]['bichu']/this_week_articles).toFixed(0);
        		averages[week_cur]['reple'] = (averages[week_cur]['reple']/this_week_articles).toFixed(0);
        		averages[week_cur]['gebichu'] = (averages[week_cur]['gebichu']/this_week_articles).toFixed(3);
        		averages[week_cur]['aggro'] = (averages[week_cur]['aggro']/this_week_articles).toFixed(3);
        		averages[week_cur]['loyalty'] = (averages[week_cur]['loyalty']/this_week_articles).toFixed(2);

        		$("#list_average").append('<tr><td>'+averages[week_cur]['count']+'</td><td>'+averages[week_cur]['chu']+'</td><td>'+averages[week_cur]['bichu']+'</td><td>'+averages[week_cur]['reple']+'</td><td>'+averages[week_cur]['gebichu']+'</td><td>'+averages[week_cur]['aggro']+'</td><td>'+averages[week_cur]['loyalty']+'</td></tr>');

        		$("#best_count_val").html(cache[best_count_idx]['count']);
	            $("#best_count_title").text(cache[best_count_idx]['titles']);
	            $("#best_count_title").attr("href", cache[best_count_idx]['url']);
	            $("#best_chu_val").html(cache[best_chu_idx]['chu']);
	            $("#best_chu_title").text(cache[best_chu_idx]['titles']);
	            $("#best_chu_title").attr("href", cache[best_chu_idx]['url']);
	            $("#best_reple_val").html(cache[best_reple_idx]['reple']);
	            $("#best_reple_title").text(cache[best_reple_idx]['titles']);
	            $("#best_reple_title").attr("href", cache[best_reple_idx]['url']);
    		}
    		else{
    			$("#list_average").append('<tr><td>해당 주차에 투고한 작품이 없습니다.</td></tr>');

        		$("#best_count_val").html('0');
	            $("#best_count_title").html('&nbsp;');
	            $("#best_count_title").attr("href", 'javascript:void(0);');
	            $("#best_chu_val").html('0');
	            $("#best_chu_title").html('&nbsp;');
	            $("#best_chu_title").attr("href", 'javascript:void(0);');
	            $("#best_reple_val").html('0');
	            $("#best_reple_title").html('&nbsp;');
	            $("#best_reple_title").attr("href", 'javascript:void(0);');
    		}

    		$("#list_average_loading").hide();
            $("#list_loading").hide();
		}

		function setAndGetCache(k, s, best_count_idx, best_chu_idx, best_reple_idx, flag, init) {

			$("#best_count_val").html('<i class="fa fa-refresh fa-spin"></i>');
            $("#best_count_title").html('<i class="fa fa-refresh fa-spin"></i>');
            $("#best_chu_val").html('<i class="fa fa-refresh fa-spin"></i>');
            $("#best_chu_title").html('<i class="fa fa-refresh fa-spin"></i>');
            $("#best_reple_val").html('<i class="fa fa-refresh fa-spin"></i>');
            $("#best_reple_title").html('<i class="fa fa-refresh fa-spin"></i>');
            $("#prev_week").attr("disabled", true);
            $("#next_week").attr("disabled", true);
            $("#prev_4weeks").attr("disabled", true);
            $("#next_4weeks").attr("disabled", true);

			$.ajax({
		        url:'/index.php/studio/listitems',
		        type:'post',
		        dataType:'json',
		        data: { "username" : username, "page" : page_cur },
		        success: function(data){
		            console.log(data);
		            for(var j=0; j<data.list.date.length; j++){
		            	cache[cache_cur] = new Array();
		            	cache[cache_cur]['aggro'] = data.list.aggro[j];
		            	cache[cache_cur]['bichu'] = data.list.bichu[j];
		            	cache[cache_cur]['chu'] = data.list.chu[j];
		            	cache[cache_cur]['count'] = data.list.count[j];
		            	cache[cache_cur]['date'] = data.list.date[j];
		            	cache[cache_cur]['gebichu'] = data.list.gebichu[j];
		            	cache[cache_cur]['loyalty'] = data.list.loyalty[j];
		            	cache[cache_cur]['reple'] = data.list.reple[j];
		            	cache[cache_cur]['titles'] = data.list.titles[j];
		            	cache[cache_cur]['url'] = data.list.url[j];
		            	cache_cur++;
		            }

		            if(init){
		            	for(s++; s<4; s++){
							averages_flot[week_cur_flot] = new Array();
			            	averages_flot[week_cur_flot]['count'] = 0;
			            	averages_flot[week_cur_flot]['chu'] = 0;
			            	averages_flot[week_cur_flot]['bichu'] = 0;
			            	averages_flot[week_cur_flot]['reple'] = 0;
			            	averages_flot[week_cur_flot]['gebichu'] = 0;
			            	averages_flot[week_cur_flot]['aggro'] = 0;
			            	averages_flot[week_cur_flot]['loyalty'] = 0;
			            	this_week_articles = 0;
		            		getCacheToFlot(k, s);
		            	}
		            	this_week_articles=0;
		            	var top_value = new Array();
		            	top_value['count'] = averages_flot[week_cur_flot-1]['count'];
		            	top_value['chu'] = averages_flot[week_cur_flot-1]['chu'];
		            	top_value['bichu'] = averages_flot[week_cur_flot-1]['bichu'];
		            	top_value['reple'] = averages_flot[week_cur_flot-1]['reple'];
		            	top_value['gebichu'] = averages_flot[week_cur_flot-1]['gebichu'];
		            	top_value['aggro'] = averages_flot[week_cur_flot-1]['aggro'];
		            	top_value['loyalty'] = averages_flot[week_cur_flot-1]['loyalty'];

		            	if(top_value['count'] == 0) top_value['count'] = 1;
						if(top_value['chu'] == 0) top_value['chu'] = 1;
						if(top_value['bichu'] == 0) top_value['bichu'] = 1;
						if(top_value['reple'] == 0) top_value['reple'] = 1;
						if(top_value['gebichu'] == 0) top_value['gebichu'] = 1;
						if(top_value['aggro'] == 0) top_value['aggro'] = 1;
						if(top_value['loyalty'] == 0) top_value['loyalty'] = 1;

		            	for(s=0; s<4; s++){
		            		if(Number(averages_flot[week_cur_flot-1-s]['count']) >= Number(top_value['count']))
		            			top_value['count'] = averages_flot[week_cur_flot-1-s]['count'];
		            		if(Number(averages_flot[week_cur_flot-1-s]['chu']) >= Number(top_value['chu']))
		            			top_value['chu'] = averages_flot[week_cur_flot-1-s]['chu'];
		            		if(Number(averages_flot[week_cur_flot-1-s]['bichu']) >= Number(top_value['bichu']))
		            			top_value['bichu'] = averages_flot[week_cur_flot-1-s]['bichu'];
		            		if(Number(averages_flot[week_cur_flot-1-s]['reple']) >= Number(top_value['reple']))
		            			top_value['reple'] = averages_flot[week_cur_flot-1-s]['reple'];
		            		if(Number(averages_flot[week_cur_flot-1-s]['gebichu']) >= Number(top_value['gebichu']))
		            			top_value['gebichu'] = averages_flot[week_cur_flot-1-s]['gebichu'];
		            		if(Number(averages_flot[week_cur_flot-1-s]['aggro']) >= Number(top_value['aggro']))
		            			top_value['aggro'] = averages_flot[week_cur_flot-1-s]['aggro'];
		            		if(Number(averages_flot[week_cur_flot-1-s]['loyalty']) >= Number(top_value['loyalty']))
		            			top_value['loyalty'] = averages_flot[week_cur_flot-1-s]['loyalty'];
		            	}
		            	if(Number(top_value['chu']) < Number(top_value['bichu']))
        					top_value['chu'] = top_value['bichu']
		            	for(s=0; s<4; s++){
		            		$("#bar_"+(4-s)+"_count").css("height", (averages_flot[week_cur_flot-4+s]['count']/top_value['count'])*100+"%");
		            		$("#bar_"+(4-s)+"_count").text(averages_flot[week_cur_flot-4+s]['count']);
		            		$("#bar_"+(4-s)+"_count").attr("title", averages_flot[week_cur_flot-4+s]['count']);
		            		$("#bar_"+(4-s)+"_chu").css("height", (averages_flot[week_cur_flot-4+s]['chu']/top_value['chu'])*100+"%");
		            		$("#bar_"+(4-s)+"_chu").text(averages_flot[week_cur_flot-4+s]['chu']);
		            		$("#bar_"+(4-s)+"_chu").attr("title", averages_flot[week_cur_flot-4+s]['chu']);
		            		$("#bar_"+(4-s)+"_bichu").css("height", (averages_flot[week_cur_flot-4+s]['bichu']/top_value['chu'])*100+"%");
		            		$("#bar_"+(4-s)+"_bichu").text(averages_flot[week_cur_flot-4+s]['bichu']);
		            		$("#bar_"+(4-s)+"_bichu").attr("title", averages_flot[week_cur_flot-4+s]['bichu']);
		            		$("#bar_"+(4-s)+"_reple").css("height", (averages_flot[week_cur_flot-4+s]['reple']/top_value['reple'])*100+"%");
		            		$("#bar_"+(4-s)+"_reple").text(averages_flot[week_cur_flot-4+s]['reple']);
		            		$("#bar_"+(4-s)+"_reple").attr("title", averages_flot[week_cur_flot-4+s]['reple']);
		            		$("#bar_"+(4-s)+"_gebichu").css("height", (averages_flot[week_cur_flot-4+s]['gebichu']/top_value['gebichu'])*100+"%");
		            		$("#bar_"+(4-s)+"_gebichu").text(averages_flot[week_cur_flot-4+s]['gebichu']);
		            		$("#bar_"+(4-s)+"_gebichu").attr("title", averages_flot[week_cur_flot-4+s]['gebichu']);
		            		$("#bar_"+(4-s)+"_aggro").css("height", (averages_flot[week_cur_flot-4+s]['aggro']/top_value['aggro'])*100+"%");
		            		$("#bar_"+(4-s)+"_aggro").text(averages_flot[week_cur_flot-4+s]['aggro']);
		            		$("#bar_"+(4-s)+"_aggro").attr("title", averages_flot[week_cur_flot-4+s]['aggro']);
		            		$("#bar_"+(4-s)+"_loyalty").css("height", (averages_flot[week_cur_flot-4+s]['loyalty']/top_value['loyalty'])*100+"%");
		            		$("#bar_"+(4-s)+"_loyalty").text(averages_flot[week_cur_flot-4+s]['loyalty']);
		            		$("#bar_"+(4-s)+"_loyalty").attr("title", averages_flot[week_cur_flot-4+s]['loyalty']);
		            	}
		            }
		            getCache(k, best_count_idx, best_chu_idx, best_reple_idx, flag);
		        },
		        error: function(e){
		        	console.log(e);
		        }
		    })
		}

		function getWeek(datetime) {
			// var datetime = new Date(arg);
			var date = datetime.getDate();
			var day = datetime.getDay();
			var month = datetime.getMonth()+1;
			var year = datetime.getFullYear();

			var week;
			var year_of_startdate = year;
			var year_of_enddate = year;
			var month_of_startdate;
			var month_of_enddate;
			var startdate;
			var enddate;

			startdate = date-day;
			if(startdate <= 0){
				if((month == 5) || (month == 7) || (month == 8) || (month == 10) || (month == 12)){
					startdate = 30+startdate;
					week = startdate%7 == 0 ? parseInt(startdate/7) : parseInt(startdate/7) + 1;
					month_of_startdate = month-1;
				}
				else if((month == 1) || (month == 2) || (month == 4) || (month == 6) || (month == 9) || (month == 11)){
					startdate = 31+startdate;
					week = startdate%7 == 0 ? parseInt(startdate/7) : parseInt(startdate/7) + 1;
					if(month == 1){
						month_of_startdate = 12;
						year_of_startdate++;
					}
					else{
						month_of_startdate = month-1;
					}
				}
				else{
					startdate = 28+startdate;
					week = startdate%7 == 0 ? parseInt(startdate/7) : parseInt(startdate/7) + 1;
					month_of_startdate = 2;
				}

			}
			else{
				week = startdate%7 == 0 ? parseInt(startdate/7) : parseInt(startdate/7) + 1;
				month_of_startdate = month;
			}

			enddate = 6+date-day;
			month_of_enddate = month;
			if(enddate > 28 && month == 2){
				enddate = enddate-28;
				month_of_enddate = 3;
			}
			else if(enddate > 30 && ((month == 4) || (month == 6) || (month == 9) || (month == 11)) ){
				enddate = enddate-30;
				month_of_enddate = month+1;	
			}
			else if(enddate > 31 && ((month == 1) || (month == 3) || (month == 5) || (month == 7) || (month == 8) || (month == 10) || (month == 12)) ){
				enddate = enddate-31;
				if(month == 12){
					month_of_enddate = 1;
					year_of_enddate++;
				}
				else{
					month_of_enddate = month+1;
				}
			}

			return {week: week,	month_of_startdate: leadingZeros(month_of_startdate, 2),	month_of_enddate: leadingZeros(month_of_enddate, 2),	year_of_startdate: year_of_startdate, year_of_enddate: year_of_enddate,	startdate: leadingZeros(startdate, 2), enddate: leadingZeros(enddate, 2)};   
		}

		function leadingZeros(n, digits) {
		  var zero = '';
		  n = n.toString();

		  if (n.length < digits) {
		    for (i = 0; i < digits - n.length; i++)
		      zero += '0';
		  }
		  return zero + n;
		}
	});		
}
else{
	alert("인터넷 익스플로러로 접속해주세요.");
	opener = self;
	window.close();
}
	</script>
</head>
<body class="hold-transition sidebar-mini">
<div id="contact" class="modal fade" role="dialog">
	<div class="modal-dialog">

	<!-- Modal content-->
	<div class="modal-content">
	  <div class="modal-header">
	    <button type="button" class="close" data-dismiss="modal">&times;</button>
	    <h4 class="modal-title">Contact</h4>
	  </div>
	  <div class="modal-body">
	    <dl>
	      <dt>DC 갤로그</dt>
	      <dd><a href="https://gallog.dcinside.com/atalanta16" target="_blank">gallog.dcinside.com/atalanta16</a></dd>
	      <dt>네이버 블로그</dt>
	      <dd><a href="https://blog.naver.com/atalanta16" target="_blank">blog.naver.com/atalanta16</a></dd>
	      <dt>E-mail</dt>
	      <dd>atalanta16@naver.com</dd>
	    </dl>
	  </div>
	  <div class="modal-footer">
	    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	  </div>
	</div>

	</div>
</div>
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand bg-white navbar-light border-bottom">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item" tag="">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fa fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block" tag="">
        <a href="/index.php/studio" class="nav-link">Home</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block" tag="">
        <a href="/" target="_blank" class="nav-link">Add-on Page</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block" tag="">
        <a href="#" class="nav-link" data-toggle="modal" data-target="#contact">Contact</a>
      </li>
    </ul>

    <!-- SEARCH FORM -->
    <!-- <form class="form-inline ml-3">
      <div class="input-group input-group-sm">
        <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-navbar" type="submit">
            <i class="fa fa-search"></i>
          </button>
        </div>
      </div>
    </form> -->

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Messages Dropdown Menu -->
      <li class="nav-item dropdown">
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="fa fa-bell-o"></i>
          <!-- <span class="badge badge-warning navbar-badge">15</span> -->
        </a>
        <!-- <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">15 Notifications</span>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fa fa-envelope mr-2"></i> 4 new messages
            <span class="float-right text-muted text-sm">3 mins</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fa fa-users mr-2"></i> 8 friend requests
            <span class="float-right text-muted text-sm">12 hours</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fa fa-file mr-2"></i> 3 new reports
            <span class="float-right text-muted text-sm">2 days</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
        </div> -->
      </li>
      <!-- <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#"><i
            class="fa fa-th-large"></i></a>
      </li> -->
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->      
    <a href="/index.php/studio" class="brand-link">
      <span>&nbsp;&nbsp;<i class="fa fa-comments" style="color: white"></i>  </span><span class="brand-text font-weight-light">&nbsp;&nbsp;카연갤 Studio</span>
    </a>
   
    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      	<div class="image" style="padding-top: 5px; padding-left: 23px">
          <i class="fa fa-user nav-icon" style="color: white"></i>&nbsp; 
        </div>
        <div class="info">
			<a href="#" class="d-block" id="username"></a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="#" class="nav-link active">
              <i class="nav-icon fa fa-dashboard"></i>
              <p>
                대시보드
              </p>
            </a>
          </li>
          
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">대시보드</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/index.php/studio">Home</a></li>
              <li class="breadcrumb-item active">Dashboard</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
      	
      	<!-- test -->
      	<!-- <div class="row">
      		<span><input type="text" id="datetime"></span><span><button class="btn btn-default" id="btn_datetime">test</button></span>
      	</div> -->
      	<!-- test -->
      	
      	<div class="row">
          <div class="col-md-9">
            <!-- Line chart -->
            <div class="card card-primary card-outline">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="fa fa-bar-chart-o"></i>
                  지표 평균 추이
                </h3>
                <div class="card-tools">
                	<table>
                		<tr>
		                  <td><i class="fa fa-calendar"></i>&nbsp;&nbsp;</td>
		                  <td><button type="button" class="btn btn-default btn-sm" id="prev_4weeks">< 이전 4주</button></td>
		                  <td><button type="button" class="btn btn-default btn-sm" id="next_4weeks">다음 4주 ></button></td>
		                </tr>
	                </table>
                </div>
              </div>
              <div class="card-body">
                <div id="chart" style="height: 480px;">
                	<ul class="nav nav-pills ml-auto p-2">
	                  <li class="nav-item" tag="bar_count">
	                    <a class="nav-link active" href="#" data-toggle="tab">조회수</a>
	                  </li>
	                  <li class="nav-item" tag="bar_reple">
	                    <a class="nav-link" href="#" data-toggle="tab">댓글수</a>
	                  </li>
	                  <li class="nav-item" tag="bar_chu">
	                    <a class="nav-link" href="#" data-toggle="tab">추천/비추천</a>
	                  </li>
	                  <li class="nav-item" tag="bar_gebichu">
	                    <a class="nav-link" href="#" data-toggle="tab">개비추비율</a>
	                  </li>
	                  <li class="nav-item" tag="bar_aggro">
	                    <a class="nav-link" href="#" data-toggle="tab">어그로지수</a>
	                  </li>
	                  <li class="nav-item" tag="bar_loyalty">
	                    <a class="nav-link" href="#" data-toggle="tab">충성도</a>
	                  </li>
	                </ul>

					<div class="row" id="bar_count">
						<div class="col-3">
		                	<div class="progress progress-bar-vertical">
							    <div id="bar_1_count" class="progress-bar progress-bar-info progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="height: 100%;" title="">
							      <i class="fa fa-refresh fa-spin"></i>
							    </div>
							</div>
						</div>
						<div class="col-3">
		                	<div class="progress progress-bar-vertical">
							    <div id="bar_2_count" class="progress-bar progress-bar-info progress-bar" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="height: 100%;" title="">
							      <i class="fa fa-refresh fa-spin"></i>
							    </div>
							</div>
						</div>
						<div class="col-3">
		                	<div class="progress progress-bar-vertical">
							    <div id="bar_3_count" class="progress-bar progress-bar-info progress-bar" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="height: 100%;" title="">
							      <i class="fa fa-refresh fa-spin"></i>
							    </div>
							</div>
						</div>
						<div class="col-3">
		                	<div class="progress progress-bar-vertical">
							    <div id="bar_4_count" class="progress-bar progress-bar-info progress-bar" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="height: 100%;" title="">
							      <i class="fa fa-refresh fa-spin"></i>
							    </div>
							</div>
						</div>
					</div>

					<div class="row" id="bar_reple">
						<div class="col-3">
		                	<div class="progress progress-bar-vertical">
							    <div id="bar_1_reple" class="progress-bar progress-bar-info progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="height: 100%;" title="">
							      <i class="fa fa-refresh fa-spin"></i>
							    </div>
							</div>
						</div>
						<div class="col-3">
		                	<div class="progress progress-bar-vertical">
							    <div id="bar_2_reple" class="progress-bar progress-bar-info progress-bar" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="height: 100%;" title="">
							      <i class="fa fa-refresh fa-spin"></i>
							    </div>
							</div>
						</div>
						<div class="col-3">
		                	<div class="progress progress-bar-vertical">
							    <div id="bar_3_reple" class="progress-bar progress-bar-info progress-bar" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="height: 100%;" title="">
							      <i class="fa fa-refresh fa-spin"></i>
							    </div>
							</div>
						</div>
						<div class="col-3">
		                	<div class="progress progress-bar-vertical">
							    <div id="bar_4_reple" class="progress-bar progress-bar-info progress-bar" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="height: 100%;" title="">
							      <i class="fa fa-refresh fa-spin"></i>
							    </div>
							</div>
						</div>
					</div>

					<div class="row" id="bar_chu">
						<div class="col-3">
		                	<div class="progress progress-bar-vertical" style="width: 80px">
							    <div id="bar_1_chu" class="progress-bar progress-bar-info progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="height: 100%;" title="">
							      <i class="fa fa-refresh fa-spin"></i>
							    </div>
							    <div id="bar_1_bichu" class="progress-bar progress-bar-info progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="height: 100%; background-color: red; margin-left: 5px" title="">
							      <i class="fa fa-refresh fa-spin"></i>
							    </div>
							</div>
						</div>
						<div class="col-3">
		                	<div class="progress progress-bar-vertical" style="width: 80px">
							    <div id="bar_2_chu" class="progress-bar progress-bar-info progress-bar" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="height: 100%;" title="">
							      <i class="fa fa-refresh fa-spin"></i>
							    </div>
							    <div id="bar_2_bichu" class="progress-bar progress-bar-info progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="height: 100%; background-color: red; margin-left: 5px" title="">
							      <i class="fa fa-refresh fa-spin"></i>
							    </div>
							</div>
						</div>
						<div class="col-3">
		                	<div class="progress progress-bar-vertical" style="width: 80px">
							    <div id="bar_3_chu" class="progress-bar progress-bar-info progress-bar" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="height: 100%;" title="">
							      <i class="fa fa-refresh fa-spin"></i>
							    </div>
							    <div id="bar_3_bichu" class="progress-bar progress-bar-info progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="height: 100%; background-color: red; margin-left: 5px" title="">
							      <i class="fa fa-refresh fa-spin"></i>
							    </div>
							</div>
						</div>
						<div class="col-3">
		                	<div class="progress progress-bar-vertical" style="width: 80px">
							    <div id="bar_4_chu" class="progress-bar progress-bar-info progress-bar" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="height: 100%;" title="">
							      <i class="fa fa-refresh fa-spin"></i>
							    </div>
							    <div id="bar_4_bichu" class="progress-bar progress-bar-info progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="height: 100%; background-color: red; margin-left: 5px" title="">
							      <i class="fa fa-refresh fa-spin"></i>
							    </div>
							</div>
						</div>
					</div>

					<div class="row" id="bar_gebichu">
						<div class="col-3">
		                	<div class="progress progress-bar-vertical">
							    <div id="bar_1_gebichu" class="progress-bar progress-bar-info progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="height: 100%;" title="">
							      <i class="fa fa-refresh fa-spin"></i>
							    </div>
							</div>
						</div>
						<div class="col-3">
		                	<div class="progress progress-bar-vertical">
							    <div id="bar_2_gebichu" class="progress-bar progress-bar-info progress-bar" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="height: 100%;" title="">
							      <i class="fa fa-refresh fa-spin"></i>
							    </div>
							</div>
						</div>
						<div class="col-3">
		                	<div class="progress progress-bar-vertical">
							    <div id="bar_3_gebichu" class="progress-bar progress-bar-info progress-bar" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="height: 100%;" title="">
							      <i class="fa fa-refresh fa-spin"></i>
							    </div>
							</div>
						</div>
						<div class="col-3">
		                	<div class="progress progress-bar-vertical">
							    <div id="bar_4_gebichu" class="progress-bar progress-bar-info progress-bar" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="height: 100%;" title="">
							      <i class="fa fa-refresh fa-spin"></i>
							    </div>
							</div>
						</div>
					</div>

					<div class="row" id="bar_aggro">
						<div class="col-3">
		                	<div class="progress progress-bar-vertical">
							    <div id="bar_1_aggro" class="progress-bar progress-bar-info progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="height: 100%;" title="">
							      <i class="fa fa-refresh fa-spin"></i>
							    </div>
							</div>
						</div>
						<div class="col-3">
		                	<div class="progress progress-bar-vertical">
							    <div id="bar_2_aggro" class="progress-bar progress-bar-info progress-bar" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="height: 100%;" title="">
							      <i class="fa fa-refresh fa-spin"></i>
							    </div>
							</div>
						</div>
						<div class="col-3">
		                	<div class="progress progress-bar-vertical">
							    <div id="bar_3_aggro" class="progress-bar progress-bar-info progress-bar" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="height: 100%;" title="">
							      <i class="fa fa-refresh fa-spin"></i>
							    </div>
							</div>
						</div>
						<div class="col-3">
		                	<div class="progress progress-bar-vertical">
							    <div id="bar_4_aggro" class="progress-bar progress-bar-info progress-bar" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="height: 100%;" title="">
							      <i class="fa fa-refresh fa-spin"></i>
							    </div>
							</div>
						</div>
					</div>

					<div class="row" id="bar_loyalty">
						<div class="col-3">
		                	<div class="progress progress-bar-vertical">
							    <div id="bar_1_loyalty" class="progress-bar progress-bar-info progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="height: 100%;" title="">
							      <i class="fa fa-refresh fa-spin"></i>
							    </div>
							</div>
						</div>
						<div class="col-3">
		                	<div class="progress progress-bar-vertical">
							    <div id="bar_2_loyalty" class="progress-bar progress-bar-info progress-bar" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="height: 100%;" title="">
							      <i class="fa fa-refresh fa-spin"></i>
							    </div>
							</div>
						</div>
						<div class="col-3">
		                	<div class="progress progress-bar-vertical">
							    <div id="bar_3_loyalty" class="progress-bar progress-bar-info progress-bar" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="height: 100%;" title="">
							      <i class="fa fa-refresh fa-spin"></i>
							    </div>
							</div>
						</div>
						<div class="col-3">
		                	<div class="progress progress-bar-vertical">
							    <div id="bar_4_loyalty" class="progress-bar progress-bar-info progress-bar" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="height: 100%;" title="">
							      <i class="fa fa-refresh fa-spin"></i>
							    </div>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-3" id="bar_1_tag" align="center">
							주차
						</div>
						<div class="col-3" id="bar_2_tag" align="center">
							주차
						</div>
						<div class="col-3" id="bar_3_tag" align="center">
							주차
						</div>
						<div class="col-3" id="bar_4_tag" align="center">
							주차
						</div>
					</div>
                </div>
              </div>
              <!-- /.card-body-->
            </div>
           </div>
           <div class="col-md-3">
           	<div class="card card-primary card-outline">
              <div class="card-header">
                <h3 class="card-title" id="best_title">
                  주간 BEST ::
                </h3>
              </div>
              <div class="card-body">
                <div class="row">
		          <div class="col-12">
		            <!-- small box -->
		            <div class="small-box bg-info">
		              <div class="inner">
		                <h3 id="best_count_val"><i class="fa fa-refresh fa-spin"></i></h3>

		                <p>주간 최다 조회수</p>
		              </div>
		              <div class="icon">
		                <img src="/hand-pointer.png">
		              </div>
		              <a href="#" target="_blank" class="small-box-footer" id="best_count_title"><i class="fa fa-refresh fa-spin"></i></a>
		            </div>
		          </div>
		          <div class="col-12">
		            <!-- small box -->
		            <div class="small-box bg-success">
		              <div class="inner">
		                <h3 id="best_chu_val"><i class="fa fa-refresh fa-spin"></i></h3>

		                <p>주간 최다 추천수</p>
		              </div>
		              <div class="icon">
		                <img src="/thumbs-up.png">
		              </div>
		              <a href="#" target="_blank" class="small-box-footer" id="best_chu_title"><i class="fa fa-refresh fa-spin"></i></a>
		            </div>
		          </div>
		          <div class="col-12">
		            <!-- small box -->
		            <div class="small-box bg-warning">
		              <div class="inner">
		                <h3 id="best_reple_val"><i class="fa fa-refresh fa-spin"></i></h3>

		                <p>주간 최다 댓글수</p>
		              </div>
		              <div class="icon">
		                <img src="/reply.png">
		              </div>
		              <a href="#" target="_blank" class="small-box-footer" id="best_reple_title"><i class="fa fa-refresh fa-spin"></i></a>
		            </div>
		          </div>
		      	</div>
              </div>
           </div>
       		</div>
       </div>
      	<div class="row">
        	<div class="col-12">
        	<div class="card card-primary card-outline">
              <div class="card-header">
                <h3 class="card-title" id="list_average_title">
                  지표 평균
                </h3>
                <div class="card-tools">
                	<table>
                		<tr>
		                  <td><i class="fa fa-calendar"></i>&nbsp;&nbsp;</td>
		                  <td><button type="button" class="btn btn-default btn-sm" id="prev_week">< 앞주차</button></td>
		                  <td><button type="button" class="btn btn-default btn-sm" id="next_week">차주차 ></button></td>
		                </tr>
	                </table>
                </div>
              </div>
              <div class="card-body">
	        	<table class="table">
				    <thead>
				        <tr>
				        	<th>조회수</th>
				            <th>추천</th>
				            <th>비추천</th>
				            <th>댓글</th>
				            <th>개비추비율 <a href="javascript:void(0);" data-toggle="tooltip" title="비추천수÷추천수"> <i class="fa fa-info-circle"></i></a></th>
				            <th>어그로지수 <a href="javascript:void(0);" data-toggle="tooltip" title="댓글수x개비추비율"> <i class="fa fa-info-circle"></i></span></a></th>
				            <th>충성도 <a href="javascript:void(0);" data-toggle="tooltip" title="(추천수÷조회수)x100"> <i class="fa fa-info-circle"></i></span></a></th>
				        </tr>
				    </thead>
				    <tbody id="list_average">
				    	<tr align="center" id="list_average_loading"><td><i class="fa fa-refresh fa-spin"></i></td></tr>
				    </tbody>
				</table>
			  </div>
			</div>
			</div>
        </div>
        <div class="row">
        	<div class="col-12">
        	<div class="card card-primary card-outline">
              <div class="card-header">
                <h3 class="card-title">
                  작품목록
                </h3>
              </div>
              <div class="card-body">
	        	<table class="table">
				    <thead>
				        <tr>
				            <th>제목</th>
				            <th>날짜</th>
				            <th>조회</th>
				            <th>추천</th>
				            <th>비추천</th>
				            <th>개비추비율</th>
				            <th>어그로지수</th>
				            <th>충성도</th>
				        </tr>
				    </thead>
				    <tbody id="list">
				    	<tr align="center" id="list_loading"><td><i class="fa fa-refresh fa-spin"></i></td></tr>
				    </tbody>
				</table>
			  </div>
			</div>
			</div>
        </div>
        <table style="display: none">
        	<tbody id="list_invisible">
        	</tbody>
        </table>
    	</div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <strong>Copyright &copy; 2018 <a href="http://blog.naver.com/atalanta16" target="_blank">Spaghetti code</a> </strong>  
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 1.0
    </div>
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="/AdminLTE-3.0.0-alpha.2/plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="/AdminLTE-3.0.0-alpha.2/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- Morris.js charts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="/AdminLTE-3.0.0-alpha.2/plugins/morris/morris.min.js"></script>
<!-- Sparkline -->
<script src="/AdminLTE-3.0.0-alpha.2/plugins/sparkline/jquery.sparkline.min.js"></script>
<!-- jvectormap -->
<script src="/AdminLTE-3.0.0-alpha.2/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="/AdminLTE-3.0.0-alpha.2/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- jQuery Knob Chart -->
<script src="/AdminLTE-3.0.0-alpha.2/plugins/knob/jquery.knob.js"></script>
<!-- daterangepicker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>
<script src="/AdminLTE-3.0.0-alpha.2/plugins/daterangepicker/daterangepicker.js"></script>
<!-- datepicker -->
<script src="/AdminLTE-3.0.0-alpha.2/plugins/datepicker/bootstrap-datepicker.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="/AdminLTE-3.0.0-alpha.2/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<!-- Slimscroll -->
<script src="/AdminLTE-3.0.0-alpha.2/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="/AdminLTE-3.0.0-alpha.2/plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="/AdminLTE-3.0.0-alpha.2/dist/js/adminlte.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="/AdminLTE-3.0.0-alpha.2/dist/js/pages/dashboard.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="/AdminLTE-3.0.0-alpha.2/dist/js/demo.js"></script>
</body>
</html>
