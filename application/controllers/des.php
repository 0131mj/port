<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Des extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model('Portfolio_m');

        $this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
        $this->output->set_header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
    }

    public function index()
	{
        $this->main();
	}

	public function main(){
        //$dev_data['portfolio_list'] = $this->get_dev_port();
        $dev_data['portfolio_list'] = $this->Portfolio_m->gets();
        $data['des_v']      = $this->load->view('des_v',$dev_data, TRUE);
        $data['header_v']   = $this->load->view('include/header_v','',TRUE);
        $this->load->view('main_v',$data);
    }


	private function get_dev_port(){
        $portfolio_list[0] = array(
            'title'=>'단골도서',
            'img'=>'dangoll.png',
            'url'=>'http://dangoll.com',
            'purpose'=>'도서 판매 쇼핑몰',
            'start_date'=>'2016.11.11',
            'end_date'=>'2016.12.16',
            'period'=>'1개월',
            'member'=>'2',
            'language'=>'HTML / PHP(CodeIgniter Framework) / JavaScript',
            'environment'=>'PHPStorm, HeidiSQL',
            'workarea'=>'사용자 페이지(웹/모바일) 퍼블리싱 및 개발, 관리자 페이지 개발'
        );
        $portfolio_list[1] = array(
            'title'=>'고시마트 리뉴얼',
            'img'=>'gosimart.png',
            'url'=>'http://gosimart.com',
            'purpose'=>'수험관련 컨텐츠 쇼핑몰',
            'start_date'=>'2016.7.12',
            'end_date'=>'2016.10.13',
            'period'=>'2개월',
            'member'=>'2',
            'language'=>'HTML / PHP(CodeIgniter Framework) / JavaScript',
            'environment'=>'PHPStorm, HeidiSQL',
            'workarea'=>'사용자 페이지(웹/모바일) 퍼블리싱 및 개발, 관리자 페이지 개발'
        );
        $portfolio_list[2] = array(
            'title'=>'(주)에버스톤 웹사이트',
            'img'=>'evst.png',
            'url'=>'http://bmj.dothome.co.kr/jportfolio/port_evst/',
            'purpose'=>'업체 소개, 홍보',
            'start_date'=>'2015.4.8',
            'end_date'=>'2015.4.17',
            'period'=>'10일간',
            'member'=>'단독작업',
            'language'=>'HTML / PHP / JavaScript',
            'environment'=>'Aptana, Photoshop',
            'workarea'=>'전체내용 구성 및 기획,SNS메일발송,반응형웹,디자인,퍼블리싱'
        );
        $portfolio_list[3] = array(
            'title'=>'PETner',
            'img'=>'petner.png',
            'url'=>'교육기관 수행과제',
            'purpose'=>'동물관련 정보를 공유하기 위한 SNS',
            'start_date'=>'2014.12.22',
            'end_date'=>'2015.01.20.',
            'period'=>'30 일간',
            'member'=>'4',
            'language'=>'JSP / javascript / Android / Oracle SQL',
            'environment'=>'Eclipse, Oracle, Tomcat',
            'workarea'=>'담당 메뉴(메인게시판) 기능 구현, 프레젠테이션 제작 및 발표'
        );
        $portfolio_list[4] = array(
            'title'=>'분수계산기',
            'img'=>'calc.png',
            'url'=>'교육기관 수행과제',
            'purpose'=>'분수 두개를 입력하여 결과값을 분수로 도출',
            'start_date'=>'2014.10.23',
            'end_date'=>'2011.10.28',
            'period'=>'5일간',
            'member'=>'단독작업',
            'language'=>'Java / Android',
            'environment'=>'Eclipse/ GenyMotion',
            'workarea'=>'MainActivity, 각 메뉴별 클래스구현'
        );
        $portfolio_list[5] = array(
            'title'=>'(주)허브동산 웹사이트',
            'img'=>'herb.png',
            'url'=>'http://herbdongsan.co.kr',
            'purpose'=>'업체 정보 및 공법 소개, 홍보',
            'start_date'=>'2011.10.20',
            'end_date'=>'2011.10.31',
            'period'=>'12일간',
            'member'=>'단독작업',
            'language'=>'HTML / JavaScript',
            'environment'=>'Dreamweaver, Photoshop, Flash',
            'workarea'=>'전체 내용 구성 및 기획, 2D 및 3D 모델링 등 디자인 총괄, 디자인, 퍼블리싱'
        );

        //<h2>Anroid Application 개발</h2>

//            <dt>개발 문서</dt>
//			<dd>
//				<a href="FracCalc_BaeMyoungJin.pdf" target="_blank">분수계산기.pdf<br>
//                <img src="img/pdf.png"></a>
//			</dd>
//			<dt>개발 문서2</dt>
//			<dd>
//				<a href="frc_logic.xlsx" target="_blank">분수계산기_로직.xls<br> <img
//					src="img/xls.png"></a>
//			</dd>
//			<dt>실행 파일</dt>
//			<dd>
//				<a href="Individual_Project.apk" target="_blank">안드로이드 분수계산기.apk<br>
//					<img src="img/apk.png"></a>
//			</dd>
        return $portfolio_list;
    }

}
