<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$this->load->view('init');
	}

	public function all()
	{
		include_once('./simple_html_dom.php');
		$html = file_get_html('http://gall.dcinside.com/board/lists/?id=cartoon&list_num=20');

		$ret = $html->find('table');
		$list = str_replace('href="/board/view/', 'href="http://gall.dcinside.com/board/view/', $ret[0]);
		$list = $this->rendering($list);
		$data['list'] = $list;

		$ret = $html->find('div.bottom_paging_box');
		$paging = str_replace('href="/board/lists/?', 'href="/index.php/main/paging/', $ret[0]);
		$paging = str_replace("id=", "id", $paging);
		$paging = str_replace("exception_mode=", "exceptionmode", $paging);
		$paging = str_replace("page=", "page", $paging);
		$paging = str_replace("list_num=", "listnum", $paging);
		$paging = str_replace("&", "amp", $paging);
		$data['paging'] = $paging;

		$data['main_btn'] = 'on';
		$data['recommend_btn'] = '';

		$this->load->view('main', $data);
	}

	public function recommend()
	{
		include_once('./simple_html_dom.php');
		$html = file_get_html('http://gall.dcinside.com/board/lists?id=cartoon&exception_mode=recommend&list_num=20');
		
		$ret = $html->find('table');
		$list = str_replace('href="/board/view/', 'href="http://gall.dcinside.com/board/view/', $ret[0]);
		$list = $this->rendering($list);
		$data['list'] = $list;

		$ret = $html->find('div.bottom_paging_box');
		$paging = str_replace('href="/board/lists/?', 'href="/index.php/main/paging/', $ret[0]);
		$paging = str_replace("id=", "id", $paging);
		$paging = str_replace("exception_mode=", "exceptionmode", $paging);
		$paging = str_replace("page=", "page", $paging);
		$paging = str_replace("list_num=", "listnum", $paging);
		$paging = str_replace("&", "amp", $paging);
		$data['paging'] = $paging;
		$data['main_btn'] = '';
		$data['recommend_btn'] = 'on';

		$this->load->view('main', $data);
	}

	public function paging($arg)
	{
		include_once('./simple_html_dom.php');

		$str = str_replace("id", "id=", $arg);
		$str = str_replace("exceptionmode", "exception_mode=", $str);
		$str = str_replace("page", "page=", $str);
		$str = str_replace("searchpos", "search_pos=", $str);
		$str = str_replace("stype", "s_type=", $str);
		$str = str_replace("skeyword", "s_keyword=", $str);
		$str = str_replace("listnum", "list_num=", $str);
		$str = str_replace("amp", "&", $str);
		$src = 'http://gall.dcinside.com/board/lists?'.$str;
		$html = file_get_html($src);
		
		$ret = $html->find('table');
		$list = str_replace('href="/board/view/', 'href="http://gall.dcinside.com/board/view/', $ret[0]);
		$list = $this->rendering($list);
		$data['list'] = $list;

		$ret = $html->find('div.bottom_paging_box');
		$paging = str_replace('href="/board/lists/?', 'href="/index.php/main/paging/', $ret[0]);
		$paging = str_replace("id=", "id", $paging);
		$paging = str_replace("exception_mode=", "exceptionmode", $paging);
		$paging = str_replace("page=", "page", $paging);
		$paging = str_replace("list_num=", "listnum", $paging);
		$paging = str_replace("search_pos=", "searchpos", $paging);
		$paging = str_replace("s_type=", "stype", $paging);
		$paging = str_replace("s_keyword=", "skeyword", $paging);
		$paging = str_replace("&", "amp", $paging);
		$data['paging'] = $paging;

		if(strpos($arg, "recommend")){
			$data['main_btn'] = '';
			$data['recommend_btn'] = 'on';
		}
		else{
			$data['main_btn'] = 'on';
			$data['recommend_btn'] = '';
		}

		$this->load->view('main', $data);
	}

	public function search($arg)
	{
		include_once('./simple_html_dom.php');

		$str = 'id=cartoon&s_type=search_name&s_keyword='.$arg.'&page=1';
		$src = 'http://gall.dcinside.com/board/lists?'.$str;
		$html = file_get_html($src);

		$ret = $html->find('table');
		$list = str_replace('href="/board/view/', 'href="http://gall.dcinside.com/board/view/', $ret[0]);
		$list = $this->rendering($list);
		$data['list'] = $list;

		$ret = $html->find('div.bottom_paging_box');
		$paging = str_replace('href="/board/lists/?', 'href="/index.php/main/paging/', $ret[0]);
		$paging = str_replace("id=", "id", $paging);
		$paging = str_replace("exception_mode=", "exceptionmode", $paging);
		$paging = str_replace("page=", "page", $paging);
		$paging = str_replace("list_num=", "listnum", $paging);
		$paging = str_replace("search_pos=", "searchpos", $paging);
		$paging = str_replace("s_type=", "stype", $paging);
		$paging = str_replace("s_keyword=", "skeyword", $paging);
		$paging = str_replace("&", "amp", $paging);
		$data['paging'] = $paging;

		if(strpos($arg, "recommend")){
			$data['main_btn'] = '';
			$data['recommend_btn'] = 'on';
		}
		else{
			$data['main_btn'] = 'on';
			$data['recommend_btn'] = '';
		}

		$this->load->view('main', $data);
	}	

	public function rendering($list)
	{
		include_once('./simple_html_dom.php');
		
		$ret = "";
		$tbody = explode('</thead>', $list);
		$tr = explode('</tr>', $tbody[1]);
		$hrefs = explode('<a href="', $list);
		$recommends = explode('<td class="gall_recommend">', $list);
		$counts = explode('<td class="gall_count">', $list);
		$url = array();
		$topannounce = count(explode('user_name="운영자"', $list))-1;

		// for($i=0; $i < count($hrefs)-1; $i++){
		// for($i=1; $i < count($hrefs); $i++){	//상단공지 1개
		// for($i=2; $i < count($hrefs)+1; $i++){	//상단공지 2개
		for($i=$topannounce; $i < count($hrefs)-1+$topannounce; $i++){

			// $tmp = explode('"><em class="', $hrefs[$i+1]);
			// $tmp = explode('"><em class="', $hrefs[$i]);	//상단공지 1개
			// $tmp = explode('"><em class="', $hrefs[$i-1]);	//상단공지 2개
			$tmp = explode('"><em class="', $hrefs[$i+1-$topannounce]);

			$url[$i] = $tmp[0];
			$html = file_get_html($url[$i]);

			$bichu = $html->find('p.down_num');
			$tmp = explode('>', $bichu[0]);
			$bichu_val = explode('<', $tmp[1]);
			$reple = $html->find('span.gall_comment');
			$tmp = explode('>댓글 ', $reple[0]);
			$reple_val = explode('<', $tmp[1]);

			if(!strpos($tr[$i], 'data-nick="운영자"')){
				$username = explode('><em>', $tr[$i]);
				$username_val = explode('</em></span>', $username[1]);
				$tr[$i] = str_replace('><em>', '><a href="/index.php/main/search/'.$username_val[0].'"><em>', $tr[$i]);
				$tr[$i] = str_replace('</em></span>', '</em></a></span>', $tr[$i]);
			}

			$ret .= $tr[$i].'<td class="gall_count">'.$bichu[0].'</td>';
			
			$chu = explode('</td></tr>', $recommends[$i+1]);
			$gebichu = 0;
			if((int)$chu[0] > 0){
				$gebichu = sprintf("%.3f", round((int)$bichu_val[0]/(int)$chu[0], 3));
			}
			else{
				if((int)$bichu_val[0] == 0)
					$gebichu = 0;	
				else
					$gebichu = 999;
			}
			$ret .= '<td class="gall_count">'.$gebichu.'</td>';
			$ret .= '<td class="gall_count">'.sprintf("%.3f", round((int)$reple_val[0]*$gebichu, 3)).'</td>';

			$count = explode('</td></tr>', $counts[$i+1]);
			if((int)$count[0] > 0)
				$ret .= '<td class="gall_count">'.sprintf("%.2f", round((int)$chu[0]/(int)$count[0], 4)*100).'</td></tr>';
			else
				$ret .= '<td class="gall_count">0</td></tr>';
		}

		return $ret;
	}

	public function m_all($page)
	{
		include_once('./simple_html_dom.php');
		$pagenum = explode('page', $page);
		$html = file_get_html('http://gall.dcinside.com/board/lists/?id=cartoon&list_num=20&page='.$pagenum[1]);
		$ret = $html->find('table');
		$list = str_replace('href="/board/view/', 'href="http://gall.dcinside.com/board/view/', $ret[0]);
		$pagepage['prev'] = $pagenum[1]-1;
		$pagepage['next'] = $pagenum[1]+1;
		$parent = 'all';
		$list = $this->m_rendering($list, $pagepage, $parent);
		$data['list'] = $list;
		$data['main_btn'] = 'active';
		$data['recommend_btn'] = '';
		$this->load->view('mobile', $data);
	}

	public function m_recommend($page)
	{
		include_once('./simple_html_dom.php');
		$pagenum = explode('page', $page);
		$html = file_get_html('http://gall.dcinside.com/board/lists/?id=cartoon&exception_mode=recommend&list_num=20&page='.$pagenum[1]);
		$ret = $html->find('table');
		$list = str_replace('href="/board/view/', 'href="http://gall.dcinside.com/board/view/', $ret[0]);
		$pagepage['prev'] = $pagenum[1]-1;
		$pagepage['next'] = $pagenum[1]+1;
		$parent = 'recommend';
		$list = $this->m_rendering($list, $pagepage, $parent);
		$data['list'] = $list;
		$data['main_btn'] = '';
		$data['recommend_btn'] = 'active';
		$this->load->view('mobile', $data);
	}

	public function m_search($arg, $page)
	{
		include_once('./simple_html_dom.php');

		$pagenum = explode('page', $page);
		$str = 'id=cartoon&s_type=search_name&s_keyword='.$arg.'&page='.$pagenum[1];
		$src = 'http://gall.dcinside.com/board/lists?'.$str;
		$html = file_get_html($src);

		$ret = $html->find('table');
		$list = str_replace('href="/board/view/', 'href="http://gall.dcinside.com/board/view/', $ret[0]);
		$pagepage['prev'] = $pagenum[1]-1;
		$pagepage['next'] = $pagenum[1]+1;
		$parent = $arg.' search';
		$list = $this->m_rendering($list, $pagepage, $parent);
		$data['list'] = $list;

		$data['main_btn'] = 'active';
		$data['recommend_btn'] = '';

		$this->load->view('mobile', $data);
	}

	public function m_rendering($list, $page, $parent)
	{
		include_once('./simple_html_dom.php');

		$prev = "";
		$next = "";

		if(strpos($list, '없습니다')){

			$search = explode(' search', $parent);

			$ret = "<div class='row' align='center' style='padding-top: 100px;'><br>마지막 페이지입니다.<br><br>또는, 검색결과가 없습니다.</div>";


			$prev = $page['prev'] == 0? '<a href="/index.php/main/m_all/page1">< 이전페이지&nbsp;&nbsp;</a>' : '<a href="/index.php/main/m_search/'.$search[0].'/page'.$page['prev'].'">< 이전페이지&nbsp;&nbsp;</a>';
			$next = '&nbsp;&nbsp;다음페이지 >';
		}
		else{
			$ret = "";
			$tbody = explode('</thead>', $list);
			$tr = explode('</tr>', $tbody[1]);
			$hrefs = explode('<a href="', $list);
			$recommends = explode('<td class="gall_recommend">', $list);
			$counts = explode('<td class="gall_count">', $list);
			$url = array();
			$topannounce = count(explode('user_name="운영자"', $list))-1;

			// for($i=0; $i < count($hrefs)-1; $i++){
			// for($i=1; $i < count($hrefs); $i++){	//상단공지 1개
			// for($i=2; $i < count($hrefs)+1; $i++){	//상단공지 2개
			for($i=$topannounce; $i < count($hrefs)-1+$topannounce; $i++){

				// $tmp = explode('"><em class="', $hrefs[$i+1]);
				// $tmp = explode('"><em class="', $hrefs[$i]);	//상단공지 1개
				// $tmp = explode('"><em class="', $hrefs[$i-1]);	//상단공지 2개
				$tmp = explode('"><em class="', $hrefs[$i+1-$topannounce]);
				
				$url[$i] = $tmp[0];
				$html = file_get_html($url[$i]);

				$bichu = $html->find('p.down_num');
				$tmp = explode('>', $bichu[0]);
				$bichu_val = explode('<', $tmp[1]);
				$reple = $html->find('span.gall_comment');
				$tmp = explode('>댓글 ', $reple[0]);
				$reple_val = explode('<', $tmp[1]);

				if(!strpos($tr[$i], 'data-nick="운영자"')){
					$username = explode('><em>', $tr[$i]);
					$username_val = explode('</em></span>', $username[1]);
					$tr[$i] = str_replace('><em>', '><a href="/index.php/main/m_search/'.$username_val[0].'/page1" style="color: black;"><em>', $tr[$i]);
					$tr[$i] = str_replace('</em></span>', '</em></a></span>', $tr[$i]);
				}

				$articleid = $html->getElementById('no')->getAttribute('value');
				$tr[$i] = str_replace('<a class="reply_numbox"', '<span class="reply_numbox"', $tr[$i]);
				$tr[$i] = str_replace('<span class="reply_num">', '</span><a href="http://m.dcinside.com/board/cartoon/'.$articleid.'#comment_box"><span class="reply_num">', $tr[$i]);				

				$ret .= $tr[$i].'<td style="font-size: small;">&nbsp;<span class="glyphicon glyphicon-thumbs-down" style="color: #66ccff"></span>&nbsp;'.$bichu[0].'</td>';
				// $ret .= $tr[$i];
				
				$chu = explode('</td></tr>', $recommends[$i+1]);
				$gebichu = 0;
				if((int)$chu[0] > 0){
					$gebichu = sprintf("%.2f", round((int)$bichu_val[0]/(int)$chu[0], 2));
				}
				else{
					if((int)$bichu_val[0] == 0)
						$gebichu = 0;	
					else
						$gebichu = 99.99;
				}
				$ret .= '<br><td style="font-size: small;"> 개비추%:'.($gebichu*100).'</td>';
				$ret .= '<td style="font-size: small;"> | 어그로:'.sprintf("%.2f", round((int)$reple_val[0]*$gebichu, 2)).'</td>';

				$count = explode('</td></tr>', $counts[$i+1]);
				if((int)$count[0] > 0)
					$ret .= '<td style="font-size: small;"> | 충성도:'.sprintf("%.2f", round((int)$chu[0]/(int)$count[0], 4)*100).'</td></tr>';
				else
					$ret .= '<td style="font-size: small;"> | 충성도:0</td></tr>';
			}

			$ret = str_replace('<td class="gall_count">', '<td class="gall_count" style="font-size: small;">| 조회:', $ret);
			$ret = str_replace('<td class="gall_recommend">', '<td class="gall_recommend" style="font-size: small;">&nbsp;<span class="glyphicon glyphicon-thumbs-up" style="color: #66ccff"></span>&nbsp;', $ret);
			$ret = str_replace('<td class="gall_num" >', '<td class="gall_num" style="display: none;">', $ret);
			$ret = str_replace('<em class="', '<span><img src="/', $ret);
			$ret = str_replace('"></em>', '.jpg"></span>', $ret);
			$ret = str_replace('<td class="gall_writer ub-writer"', '<br><td class="gall_writer ub-writer"', $ret);
			$ret = str_replace('<td', '<span', $ret);
			$ret = str_replace('</td>', '</span>', $ret);
			$ret = str_replace('<p', '<span', $ret);
			$ret = str_replace('</p>', '</span>', $ret);
			$ret = str_replace('<span class="gall_tit ub-word">', '<td class="gall_tit ub-word">', $ret);

			if(strpos($parent, ' search')){
				$search = explode(' search', $parent);
				$prev = $page['prev'] > 0 ? '<a href="/index.php/main/m_search/'.$search[0].'/page'.$page['prev'].'">< 이전페이지&nbsp;&nbsp;</a>' : '< 이전페이지';
				$next = count($hrefs) < 20 ? '&nbsp;&nbsp;다음페이지 >' : '<a href="/index.php/main/m_search/'.$search[0].'/page'.$page['next'].'">&nbsp;&nbsp;다음페이지 ></a>';
			}
			else{
				$prev = $page['prev'] > 0 ? '<a href="/index.php/main/m_'.$parent.'/page'.$page['prev'].'">< 이전페이지&nbsp;&nbsp;</a>' : '< 이전페이지';
				$next = count($hrefs) < 20 ? '&nbsp;&nbsp;다음페이지 >' : '<a href="/index.php/main/m_'.$parent.'/page'.$page['next'].'">&nbsp;&nbsp;다음페이지 ></a>';
			}
		}
		$ret .= '
			<div class="row" style="background: #4b58a7;">
				<table>
					<tbody>
						<tr>
							<td style="padding: 7px;"><a href="#">top</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$prev.'</td>
							<td style="padding: 7px;">'.$next.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:void(0);" onClick="window.location.reload()"><span class="glyphicon glyphicon-refresh"></span></a></td>
						</tr>
					</tbody>
				</table>
			</div>
		';

		return $ret;
	}

}
