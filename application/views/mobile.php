<!DOCTYPE html>
<html lang="ko">
<head>
	<meta charset="UTF-8">
	<meta name="content-language" content="kr">
	<meta name="title" content="dcinside 스파게티 애드온">
	<title>dcinside 스파게티 애드온</title>
	<script type="text/javascript" src="//nstatic.dcinside.com/dc/w/js/html5shiv.min.js"></script>
	<script type="text/javascript" src="//nstatic.dcinside.com/dgn/gallery/js/ctr_cookie.min.js"></script>
	<!--[if IE 7]>
	<link rel="stylesheet" type="text/css" href="//nstatic.dcinside.com/dc/w/css/ie7.css"/>
	<![endif]-->
		<script type="text/javascript" src="//nstatic.dcinside.com/dgn/gallery/js/cross_domain.js"></script>
	<!--[if lt IE 9]>
	<script src="//nstatic.dcinside.com/dgn/gallery/js/jquery-1.7.2.min.js"></script>
	<![endif]-->
	<!--[if gte IE 9]>
	<script src="//nstatic.dcinside.com/dgn/gallery/js/jquery-3.2.1.min.js"></script>
	<![endif]-->
	<!--[if !IE]> -->
	<script src="//nstatic.dcinside.com/dgn/gallery/js/jquery-3.2.1.min.js"></script>
	<!-- <![endif]-->
	<!--script type="text/javascript" src="/_js/jquery/jquery-migrate-1.2.1.min.js"></script-->
	<script type="text/javascript" src="//nstatic.dcinside.com/dgn/gallery/js/jquery.tmpl.min.js"></script>
	<script type="text/javascript" src="//nstatic.dcinside.com/dgn/gallery/js/jquery-ui.min.js"></script>
	<script type="text/javascript" src="/_js/jquery/jquery.matchHeight.js"></script>
	<script type="text/javascript" src="/_js/common.js?v=18091815"></script> 
	<script type="text/javascript" src="/_js/navigation.js"></script>
	<script type="text/javascript" src="/_js/favorite.js?v=180106"></script>
	<script type="text/javascript" src="/_js/gallery_top.js"></script>
	<script type="text/javascript" src="/_js/user_block.js"></script>
	<script type="text/javascript" src="/_js/crossDomainStorage.js"></script>
	<script type="text/javascript" src="//search.dcinside.com/_js/globalSearch.js"></script>
	<script type="text/javascript">
		document.domain = "dcinside.com";
		var k_cnt = 0;
		var _GALLERY_TYPE_ = "G";
	</script>
	
		<script src="/_js/list.js" type="text/javascript" charset="utf-8"></script>
<script src="/_js/total_singo.js" type="text/javascript" charset="utf-8"></script>
<script src="/_js/dccon/dccon.js?v=180105" type="text/javascript" charset="utf-8"></script>
<script src="/_js/search.js?v=1541596434" type="text/javascript" charset="utf-8"></script>
	<!-- Taboola -->
	<script type="text/javascript">
      window._taboola = window._taboola || [];
      _taboola.push({category:'auto'});
      !function (e, f, u, i) {
        if (!document.getElementById(i)){
          e.async = 1;
          e.src = u;
          e.id = i;
          f.parentNode.insertBefore(e, f);
        }
      }(document.createElement('script'),
      document.getElementsByTagName('script')[0],
      '//cdn.taboola.com/libtrc/dcinside/loader.js',
      'tb_loader_script');
      if(window.performance && typeof window.performance.mark == 'function')
      {window.performance.mark('tbl_ic');}
	</script>

<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-67526956-2"></script>
	<script>
	  window.dataLayer = window.dataLayer || [];
	  function gtag(){dataLayer.push(arguments);}
	  gtag('js', new Date());

	  gtag('config', 'UA-67526956-2');
	</script>
	
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	</head>
	<style>
	#refresh {
		background-color: transparent;
		position: absolute;
		width:50px;
		height: :50px;
		top:90%;
		left:83%;
	}

	</style>
	<script>
		$(document).ready(function(){
			
			$("#loading_sign").hide();

			$("a").click(function(){
				if($(this).text() != 'top' && $(this).text().indexOf('업데이트공지') == -1)
					$("#loading_sign").modal();
			});

			$("#search").click(function(){
		        $(location).attr('href', '/index.php/main/m_search/'+$("#search_keyword").val()+'/page1');
		    });
		     $("#search_keyword").keyup(function(e){
		    	if(e.keyCode == 13){
		    		$("#loading_sign").modal();
		    		$(location).attr('href', '/index.php/main/m_search/'+$("#search_keyword").val()+'/page1');
		    	}
		    });
		
			var currentPosition = parseInt($("#refresh").css("top"));
			
			$(window).scroll(function(){
				var position = $(window).scrollTop();
				var window_heigth = $(window).height();
				var scrol_pos = position+currentPosition;
				var docu_heigth = document.body.clientHeight;
				console.log('window_heigth: '+window_heigth);
				console.log('scrol_pos: '+scrol_pos);
				console.log('docu_heigth: '+docu_heigth);
				$("#refresh").stop().animate({"top":scrol_pos+"px"},'fast');
				if(scrol_pos+(0.1*window_heigth) == docu_heigth)
					$("#refresh").hide();
				else
					$("#refresh").show();
			});

			$("#refresh").click(function(){
				$("#loading_sign").modal();
				location.reload();
			});

		});

	</script>
<body>
	<div class="container-fluid">
		<div class="modal fade" id="loading_sign" role="dialog">
		    <div class="modal-dialog modal-sm">
		    
		      <!-- Modal content-->
		      <div class="modal-content">
		        <div class="modal-body" align="right">
		          <img src="/dcin_logo_loading.gif">
		        </div>
		      </div>
		      
		    </div>
		</div>
		<div class="modal fade" id="help" role="dialog">
		    <div class="modal-dialog">
		    
		      <!-- Modal content-->
		      <div class="modal-content">
		      	<div class="modal-header">
		      	</div>
		        <div class="modal-body" align="center">
		          <table class="table">
		          	<tbody>
		          		<tr>
		          			<td>개비추% : (비추천수 ÷ 추천수)x100</td>
		          		</tr>
		          		<tr>
		          			<td>어그로지수 : 댓글수 x 비추천수 ÷ 추천수</td>
		          		</tr>
		          		<tr>
		          			<td>충성도 : (추천수 ÷ 조회수)x100</td>
		          		</tr>
		          		<tr>
		          			<td>※문의 및 건의 : atalanta16@naver.com</td>
		          		</tr>
		          	</tbody>
		          </table>
		        </div>
		        <div class="modal-footer">
		        	<button type="button" class="btn btn-primary" data-dismiss="modal">닫기</button>
		        </div>
		      </div>
		      
		    </div>
		</div>
		<div class="modal fade" id="announce" role="dialog">
		    <div class="modal-dialog">
		    
		      <!-- Modal content-->
		      <div class="modal-content">
		        <div class="modal-body">
		          <table class="table">
		          	<tbody>
		    	      	<tr>
		          			<td>
				          		2018-11-13)<br>
				          		작성자 게시물검색 바로가기 기능 추가:<br>
				          		게시물 목록에서 작성자 이름을 클릭하면 해당<br>
				          		작성자의 전체 게시물 검색결과로 바로 연결됩니다.
			          		</td>
		    	      	</tr>		    	      		
		    	      	<tr>
		    	      		<td>
			    	      		2018-11-12)<br>
			    	      		새로고침 플로팅 버튼 추가
		    	      		</td>
		    	      	</tr>
		          		<tr>
		          			<td>
				          		2018-11-11)<br>
				          		댓글 바로가기 링크가 추가되었습니다.<br>
				          		게시물 제목 우측의 괄호(<b style="color: #66ccff">[1]</b>)를 클릭하면<br>
				          		해당 게시물의 댓글로 바로 이동합니다 ;)
			          		</td>
		    	      	</tr>
		          	</tbody>
		          </table>
		        </div>
		        <div class="modal-footer">
		        	<button type="button" class="btn btn-primary" data-dismiss="modal">닫기</button>
		        </div>
		      </div>
		      
		    </div>
		</div>
		<div id="refresh">
			<img src="/refresh_floating.png">
		</div>
		<div class="row">
			<a href="/index.php/main/m_all/page1">
				<img src="/dcin_logo_addon.png" alt="디시인사이드 스파게티 애드온" style="margin-left: 7px; width: auto; height: 60px">
			</a>
		</div>
		<div class="row" style="background: #4b58a7">
			<table>
				<tr>
					<td style="color: white;">&nbsp;글쓴이</td>
					<td style="padding: 7px;"><input type="text" id="search_keyword" title="검색어 입력" value=""></td>
					<td style="padding: 7px;"><a href="#" id='search' style="color: white;"><span class="glyphicon glyphicon-search"></a></span></td>
					<td style="color: white; padding: 7px;"><button type="button" class="btn btn-info" data-toggle="modal" data-target="#help"><span style="font-size: small">도움말</span></button></td>
				</tr>
			</table>
		</div>
		<div class="row" style="padding:10px">
			<a data-toggle="modal" href="#announce"><span><img src="/icon_img icon_notice.jpg"></span><b>업데이트공지(11/13)</b> </a>
		</div>
		<div class="row">
			<ul class="nav nav-tabs">
			  <li class="<?= $main_btn; ?>"><a href="/index.php/main/m_all/page1">전체</a></li>
			  <li class="<?= $recommend_btn; ?>"><a href="/index.php/main/m_recommend/page1">개념글</a></li>
			</ul>
		</div>
		<table class="table">
			<?php echo $list; ?>
		</table>
	</div>
</body>
</html>
