<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Studio extends CI_Controller {

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
		$this->load->view('studio');
		// $this->load->view('dclogin');
	}

	public function listitems()
	{
		$username = $_POST['username'];
		$page = $_POST['page'];

		include_once('./simple_html_dom.php');

		if($page < 4)
			$str = 'id=cartoon&s_type=search_name&s_keyword='.urlencode($username).'&page='.$page;
		else
			$str = 'id=cartoon&s_type=search_name&s_keyword='.urlencode($username).'&page='.($page-3).'&search_pos=-370071';
		$src = 'http://gall.dcinside.com/board/lists?'.$str;
		$html = file_get_html($src);   
		$ret = $html->find('table');
		$list = str_replace('href="/board/view/', 'href="http://gall.dcinside.com/board/view/', $ret[0]);
		$list = $this->rendering($list);
		$result['list'] = $list;
              
		echo json_encode($result);
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
		$titles = array();
		$reple = array();
		$date = array();
		$count = array();
		$chu = array();
		$bichu = array();
		$gebichu = array();
		$aggro = array();
		$loyalty = array();
		$topannounce = count(explode('user_name="운영자"', $list))-1;

		for($i=0; $i < count($hrefs)-1; $i++){
			$tmp = explode('"><em class="', $hrefs[$i+1]);
			$url[$i] = $tmp[0];

			$tmp = explode('</em>', $hrefs[$i+1]);
			$tmp2 = explode('</a>', $tmp[1]);
			$titles[$i] = $tmp2[0];

			$tmp = explode('<td class="gall_date" title="', $hrefs[$i+1]);
			$tmp2 = explode('">', $tmp[1]);
			$date[$i] = $tmp2[0];
			
			// $tmp = explode('</td>', $recommends[$i+1]);
			// $tmp = explode('</td>', $recommends[$i+2]);	//상단공지 1개
			// $tmp = explode('</td>', $recommends[$i+3]);	//상단공지 2개
			$tmp = explode('</td>', $recommends[$i+1+$topannounce]);
			$chu[$i] = $tmp[0];

			$html = file_get_html($url[$i]);

			$tmp = $html->find('p.down_num');
			$tmp2 = explode('>', $tmp[0]);
			$tmp3 = explode('<', $tmp2[1]);
			$bichu[$i] = $tmp3[0];

			$tmp = $html->find('span.gall_comment');
			$tmp2 = explode('>댓글 ', $tmp[0]);
			$tmp3 = explode('<', $tmp2[1]);
			$reple[$i] = $tmp3[0];
			

			$gebichu[$i] = 0;
			if((int)$chu[$i] > 0){
				$gebichu[$i] = sprintf("%.3f", round((int)$bichu[$i]/(int)$chu[$i], 3));
			}
			else{
				if((int)$bichu[$i] == 0)
					$gebichu[$i] = 0;	
				else
					$gebichu[$i] = 999;
			}

			$aggro[$i] = sprintf("%.3f", round((int)$reple[$i]*$gebichu[$i], 3));

			// $tmp = explode('</td>', $counts[$i+1]);
			// $tmp = explode('</td>', $counts[$i+2]);	//상단공지 1개
			// $tmp = explode('</td>', $counts[$i+3]);	//상단공지 2개
			$tmp = explode('</td>', $counts[$i+1+$topannounce]);
			$count[$i] = $tmp[0];

			if((int)$count[$i] > 0)
				$loyalty[$i] = sprintf("%.2f", round((int)$chu[$i]/(int)$count[$i], 4)*100);
			else
				$loyalty[$i] = 0;
		}

		$ret = array();
		$ret['url'] = $url;
		$ret['titles'] = $titles;
		$ret['reple'] = $reple;
		$ret['date'] = $date;
		$ret['count'] = $count;
		$ret['chu'] = $chu;
		$ret['bichu'] = $bichu;
		$ret['gebichu'] = $gebichu;
		$ret['aggro'] = $aggro;
		$ret['loyalty'] = $loyalty;
    
		return $ret;
	}
}
?>