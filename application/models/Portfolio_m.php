<?php
class Portfolio_m extends CI_Model{

    function __construct()
    {
        parent::__construct();
    }

    /** 포트폴리오 리스트 리턴
     * @return mixed
     */
    function get_port_list()
    {
        $this->db->select('*');
        $this->db->from('portfolio');
        $this->db->order_by('idx','desc');
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    /** 포트폴리오 한개 데이터 리턴(수정)
     * @param $idx
     * @return mixed
     */
    function get_port_data($idx)
    {
        $this->db->select('*');
        $this->db->from('portfolio');
        $this->db->where('idx',$idx);

        $query = $this->db->get();
        $result = $query->row_array();

        return $result;
    }


    /**
     * @brief 포트폴리오 등록
     * @param $data
     * @return bool
     */
    function insert_port($data)
    {
        $this->db->insert('portfolio',$data);
        $new_idx = $this->db->insert_id();
        //echo $this->db->last_query();
        return $new_idx;
    }

    /**
     * @brief 포트폴리오 수정
     * @param $data
     * @param $idx
     * @return bool
     */
    function update_port($data, $idx)
    {
        $this->db->where('idx',$idx);
        $this->db->update('portfolio',$data);
        echo $this->db->last_query();
        $result = true;
        if($this->db->affected_rows()!= 1)
        {
            $result = false;
        }
        return $result;
    }


    /**
     * @brief 포트폴리오 이미지 업로드
     * @param $idx
     * @param $img
     * @return bool
     */
    function insert_port_img($idx, $img)
    {
        $data = array(
            'port_idx'=>$idx,
            'img'=>$img
        );

        $this->db->insert('port_img',$data);

        $result = true;
        if($this->db->affected_rows()!= 1)
        {
            $result = false;
        }

        echo $this->db->last_query();
        return $result;
    }

    /**
     * @brief 포트폴리오 이미지 업로드
     * @param $img
     * @param $img_idx
     * @return bool
     */
    function update_port_img($img, $img_idx)
    {
        $data = array(
            'img'=>$img
        );
        $this->db->where('img_idx',$img_idx);
        $this->db->update('port_img',$data);

        $result = true;
        if($this->db->affected_rows()!= 1)
        {
            $result = false;
        }

        echo $this->db->last_query();
        return $result;
    }

    /**
     * @brief 포트폴리오 이미지 업로드
     * @param $img_idx
     * @return string
     */
    function get_old_file($img_idx)
    {
        $this->db->select('img');
        $this->db->from('port_img');
        $this->db->where('img_idx',$img_idx);
        $query = $this->db->get();
        $result = $query->row();

        echo $this->db->last_query();
        return $result;
    }

    /**
     * @brief 포트폴리오 이미지 로드
     * @param $idx
     * @return bool
     */
    function get_port_img($idx)
    {
        $this->db->select('img_idx,img');
        $this->db->from('port_img');
        $this->db->where('port_idx',$idx);
        $query = $this->db->get();

        $result = $query->result();

        //echo $this->db->last_query();

        return $result;
    }

    /**
     * @param $idx
     * @return bool
     */
    function delete_port($idx)
    {
        $this->db->where('idx',$idx);
        $this->db->delete('portfolio');

        $result = true;
        if($this->db->affected_rows() != 1)
        {
            $result = false;
        }

        return $result;
    }

    /**
     * @param $img_idx_arr
     * @param $port_idx
     * @return bull
     */
    function delete_removed_img($img_idx_arr,$port_idx)
    {
        $this->db->where_not_in('img_idx', $img_idx_arr);
        $this->db->where('port_idx',$port_idx);
        $this->db->delete('port_img');

        $result = true;
        if($this->db->affected_rows() != 1)
        {
            $result = false;
        }

        return $result;

    }


}