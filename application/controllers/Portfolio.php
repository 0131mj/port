<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @brief Class Portfolio 포트폴리오 메인컨트롤러
 * @author 배명진(0131mj@gmail.com)
 * @see https://github.com/0131mj/port
 * @todo 수정, 삭제 기능 구현
 */
class Portfolio extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model('Portfolio_m');
        $this->load->helper(array('url','MY_common'));

        $this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT'); ('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
        $this->output->set_header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
    }

    public function index()
	{
        $this->_list('dev');
	}

    public function dev()
    {
        $this->_list('dev');
    }

    public function des()
    {
        $this->_list('des');
    }

    public function profile()
    {
        $this->_list('profile');
    }

    public function edit()
    {
        $this->_list('edit');
    }

    /**
     * @brief 본문페이지 호출
     * @param $page
     */
    public function _list($page)
    {
        $dev_data['portfolio_list'] = $this->Portfolio_m->get_port_list();

        //이미지 로드
        foreach($dev_data['portfolio_list'] as $portfolio)
        {
            $portfolio->img_list = $this->Portfolio_m->get_port_img($portfolio->idx);
        }

        $data['list'] = $this->load->view($page."_v", $dev_data, TRUE);
        $this->load->view('main_v',$data);
    }

    /**
     * @brief 포트폴리오 삭제
     * @param $idx
     */
    public function delete($idx)
    {
        $result = $this->Portfolio_m->delete_port($idx);
        if($result == true)
        {
            $msg='삭제가 올바르게 수행되었습니다.';
        }
        else
        {
            $msg='잘못된 요청입니다.';
        }
        redirect_go($msg,'/');
    }

    /**
     * @brief 포트폴리오 수정
     * @param $idx
     */
    public function modify($idx)
    {
        $edit_data['list'] = $this->Portfolio_m->get_port_data($idx);
        $edit_data['list']['img_list'] = $this->Portfolio_m->get_port_img($idx);
        $data['list'] = $this->load->view('edit_v', $edit_data, TRUE);

        $this->load->view('main_v',$data);
    }




    /**
     * @brief
     */
    public function insert_run()
    {
        // 1. 데이터 저장
        $post_data =  $this->input->post();
        unset($post_data['img_idx']);
        $port_idx = $this->Portfolio_m->insert_port($post_data);

        // 2. 이미지 저장(파일이 있는 경우)
        if(isset($_FILES['img']) && count($_FILES['img'])!=0)
        {
            $cnt = count($_FILES['img']['name']);
            echo '이미지 수량 : '.$cnt;

            for ($i=0; $i<$cnt; $i++)
            {
                if($_FILES['img']['tmp_name'][$i]!=NULL)
                {
                    $temp_file = $_FILES['img']['tmp_name'][$i];
                    $file_type =  str_replace('image/','',$_FILES['img']['type'][$i]);
                    $file_name = 'img/upload/'.$port_idx.'_'.$i.'.'.$file_type;
                    echo $temp_file.'<br>';
                    echo $file_type.'<br>';

                    move_uploaded_file($temp_file,$file_name);

                    $result = $this->Portfolio_m->insert_port_img($port_idx,$file_name);

                    echo $result;
                }
            }
        }

        redirect_go("글이 성공적으로 등록되었습니다.","/portfolio");
    }

    /**
     *
     */
    public function update_run()
    {
        // 1. 데이터 수정
        $post_data =  $this->input->post();

        $_FILES['img']['img_idx'] = $post_data['img_idx'];
        dump($post_data);
        dump($_FILES);

        $p_idx    = $post_data['p_idx'];
        $img_idx_arr = $post_data['img_idx'];
        unset($post_data['img_idx']);
        unset($post_data['p_idx']);

        $this->Portfolio_m->update_port($post_data, $p_idx);

        // 2. 이미지 저장

        // 2-1. 없는 이미지 삭제(수정의 경우)
        if($img_idx_arr != NULL)
        {
            $this->Portfolio_m->delete_removed_img($img_idx_arr,$p_idx);
        }

        // 2-2. 이미지 신규 저장

        // 2-3. 이미지 순서 변경
        /*경우의 수
        1. 파일 유, 번호 유
        2. 파일 유, 번호 무

        파일 우선

        3. 파일 무, 번호 유
         * */

        if(isset($_FILES['img']) && count($_FILES['img'])!=0)
        {
            $cnt = count($_FILES['img']['name']);
            echo '이미지 수량 : '.$cnt;
            //echo '<br>';

            for ($i=0; $i<$cnt; $i++)
            {
                if($_FILES['img']['tmp_name'][$i]!=NULL)
                {
                    $temp_file = $_FILES['img']['tmp_name'][$i];
                    $file_type =  str_replace('image/','',$_FILES['img']['type'][$i]);
                    $file_name = 'img/upload/'.$p_idx.'_'.$i.'.'.$file_type;
                    echo $temp_file.'<br>';
                    echo $file_type.'<br>';

                    move_uploaded_file($temp_file,$file_name);

                    $result = $this->Portfolio_m->insert_port_img($p_idx,$file_name);

                    echo $result;
                }
                else if($_FILES['img']['img_idx'][$i]!=NULL)
                {
                    $img_idx =$_FILES['img']['img_idx'][$i];
                    $exist_file = $this->Portfolio_m->get_old_file($img_idx);

                    $file_dir = explode('_', $exist_file->img)[0];
                    $file_name = explode('_', $exist_file->img)[1];
                    $file_type = explode('.', $file_name)[1];
                    echo '<br>'.$file_dir;

                    $update_file = $file_dir.'_'.$i.'.'.$file_type;
                    dump($update_file);

                    //파일명 변경
                    $this->Portfolio_m->update_port_img($update_file, $img_idx);

                    //파일 무브
                    rename($exist_file,$update_file);
                }
            }
        }
        redirect_go("글이 성공적으로 등록되었습니다.","/portfolio");
        echo '';

//        print_r($post_data);




//        if($_FILES['img']['name'] != "")
//        {
//            $temp_filename = $_FILES['img']['tmp_name'];  //for upload
//            $real_filename = $_FILES['img']['name'];
//
//            $_rename = "_".".file"; //파일 인덱스에 따라 구성함.아니, 정렬순을 파일명 그자체로 해도 됨.
//            $sql = "update board set
//                    `file`='$_rename',
//                    `file_name`='$real_filename'"; //파일다운로드 시 필요한 파일명, 저장하지 않는다. 대신 sort 저장
//            dbquery($sql) or die(mysql_error());
//
//            $target_file = "./file/board/".$_rename;
//            if (move_uploaded_file($temp_filename, $target_file)) {
//                chmod("$target_file", 0606);
//            }
//        }

//        print_r($_FILES['img']);
//        $upload_dir='img/';
//        $upload_file=$upload_dir.basename($_FILES['img']['name']);
//        if(move_uploaded_file($_FILES['img']['tmp_name'],$upload_file)){
//            echo "SUCCESS";
//        }else{
//            echo "FAILED";
//        }
//            echo '<br>';
//        $result = $this->Portfolio_m->edit($post_data);
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
