<?php

/*
*     Model    : Solar System
*     Author   : K SHEIK MOHAIDEEN
*     Created  : 21st Feb 2017  
*/

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Solarsystem_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->tbl = 'solar_system';
        $this->tbl_planets = 'solar_planets';
    }

    //Get All Solar System
    public function getList() {
        $query = $this->db->select('*')->from($this->tbl)->get();
        $result = $query->result_array();
        return $result;
    }
    
    //Check existing Solar System
    public function checkExistingSolar($name,$id = 0) {
        
        $this->db->select('solar_id');
        $this->db->from($this->tbl);
        $this->db->where("solar_name",$name);
        if($id != 0)
        {
           $this->db->where("solar_id != ",$id); 
        }
        $query = $this->db->get();
        $count = $query->num_rows();
        //echo $this->db->queries[0];
        
        if($count > 0)
        {
            $response = array("result" => "error",
                    "message" => "Solar System Already Exists"
            );
            echo json_encode($response);  
            exit;
        }
        else
        {
            return true;
        }
    }
    
    //Add Soloar
    public function addSolar($data,$id = 0)
    {
        if($id == 0)
        {
            $this->db->insert($this->tbl, $data);
            $id = $this->db->insert_id();
        }
        else
        {
            $this->db->where('solar_id',$id);
            $this->db->update($this->tbl,$data);
        }
        $result = $this->getSingleSolar($id);
        return $result;
    }
    
    //Get Single Solar
    public function getSingleSolar($id)
    {
        $this->db->select('*');
        $this->db->from($this->tbl);
        $this->db->where("solar_id",$id);
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }
    
    //Remove Solar
    public function deleteSolar($id)
    {
        $this->db->where('solar_id', $id);
        $query = $this->db->delete($this->tbl);
        if($this->db->affected_rows() > 0)
        {
            return 1;
        }
        else
        {
            return 0;
        }
    }
    
    //Check existing Solar System By ID
    public function checkExistingSolarById($id) {
        
        $this->db->select('solar_id');
        $this->db->from($this->tbl);
        $this->db->where("solar_id",$id);
        $query = $this->db->get();
        $count = $query->num_rows();
        //echo $this->db->queries[0]; exit;
        
        if($count <= 0)
        {
            $response = array("result" => "error",
                    "message" => "Solar System Not Found"
            );
            echo json_encode($response);  
            exit;
        }
        else
        {
            return true;
        }
    }
    
    
    //Find solor, planer and sun name
    public function findSolarPlanerSunByName($name)
    {
        $this->db->select('solar_id');
        $this->db->from($this->tbl);
        $this->db->where("solar_name",$name);
        $query1 = $this->db->get();
        $result1 = $query1->result_array();
        //echo $this->db->queries[0]; exit;
        //print_r($result1); exit;
        
        $this->db->select('planet_solar_id');
        $this->db->from($this->tbl_planets);
        $this->db->where("planet_name",$name);
        $query2 = $this->db->get();
        $result2 = $query2->result_array();
        
        $result = array();
        if(count($result1) > 0 || count($result2) > 0)
        {
            $solarList = $this->getList();            
            $oneDimensionalSolar = array_map('current', $result1);
            $oneDimensionalPlanet = array_map('current', $result2);
            //print_r($oneDimensionalPlanet); exit;
            $finalArray = array();
            if(count($solarList)>0)
            {
                foreach($solarList as $key => $val)
                {
                    if(in_array($val['solar_id'],$oneDimensionalSolar) || in_array($val['solar_id'],$oneDimensionalPlanet))
                    {
                        $result = $val;
                        $result['planets_list'] = array();
                        $query = $this->db->select('*')->from($this->tbl_planets)->where("planet_solar_id",$val['solar_id'])->where("planet_name",$name)->order_by("planet_is_sun", "desc")->get();
                        $planetList = $query->result_array();
                        //if(count($planetList)>0 && in_array($val['solar_id'],$oneDimensionalSolar))
                        $result['planets_list'] = $planetList;
                        $finalArray[] = $result;
                    }
                }
            }
        }
        
        return $finalArray;
    }
    
    //Find solor, planer and sun size
    public function findSolarPlanerSunBySize($size)
    {
        $this->db->select('solar_id');
        $this->db->from($this->tbl);
        $this->db->where("solar_size",$size);
        $query1 = $this->db->get();
        $result1 = $query1->result_array();
        //echo $this->db->queries[0]; exit;
        //print_r($result1); exit;
        
        $this->db->select('planet_solar_id');
        $this->db->from($this->tbl_planets);
        $this->db->where("planet_size",$size);
        $query2 = $this->db->get();
        $result2 = $query2->result_array();
        
        $result = array();
        if(count($result1) > 0 || count($result2) > 0)
        {
            $solarList = $this->getList();            
            $oneDimensionalSolar = array_map('current', $result1);
            $oneDimensionalPlanet = array_map('current', $result2);
            //print_r($oneDimensionalPlanet); exit;
            $finalArray = array();
            if(count($solarList)>0)
            {
                foreach($solarList as $key => $val)
                {
                    if(in_array($val['solar_id'],$oneDimensionalSolar) || in_array($val['solar_id'],$oneDimensionalPlanet))
                    {
                        $result = $val;
                        $result['planets_list'] = array();
                        $query = $this->db->select('*')->from($this->tbl_planets)->where("planet_solar_id",$val['solar_id'])->where("planet_size",$size)->order_by("planet_is_sun", "desc")->get();
                        $planetList = $query->result_array();
                        //if(count($planetList)>0 && in_array($val['solar_id'],$oneDimensionalSolar))
                        $result['planets_list'] = $planetList;
                        $finalArray[] = $result;
                    }
                }
            }
        }
        
        return $finalArray;
    }
    
    //Find Solar Distance
    public function findDistanceSolar($p1,$p2,$type) {
        
        if($type == 'solar')
        {
            $this->db->select('*');
            $this->db->from($this->tbl);
            $this->db->where("solar_id",$p1);
            $query = $this->db->get();
            $p1result = $query->row_array();

            $this->db->select('*');
            $this->db->from($this->tbl);
            $this->db->where("solar_id",$p2);
            $query1 = $this->db->get();
            $p2result = $query1->row_array();
            //print_r($p2result); exit;
            
            $x1 = $p1result['solar_coordinate_x'];
            $y1 = $p1result['solar_coordinate_y'];
            $z1 = $p1result['solar_coordinate_z'];
            
            $x2 = $p2result['solar_coordinate_x'];
            $y2 = $p2result['solar_coordinate_y'];
            $z2 = $p2result['solar_coordinate_z'];
        }
        else
        {
            $this->db->select('*');
            $this->db->from($this->tbl_planets);
            $this->db->where("planet_id",$p1);
            $query = $this->db->get();
            $p1result = $query->row_array();

            $this->db->select('*');
            $this->db->from($this->tbl_planets);
            $this->db->where("planet_id",$p2);
            $query1 = $this->db->get();
            $p2result = $query1->row_array();
            //print_r($p2result); exit;
            
            $x1 = $p1result['planet_coordinate_x'];
            $y1 = $p1result['planet_coordinate_y'];
            $z1 = $p1result['planet_coordinate_z'];
            
            $x2 = $p2result['planet_coordinate_x'];
            $y2 = $p2result['planet_coordinate_y'];
            $z2 = $p2result['planet_coordinate_z'];
        }
        
        $result = array();
        if(count($p1result)>0 && count($p2result)>0)
        {
            $total = sqrt($x2-$x1)+sqrt($y2-$y1)+sqrt($z2-$z1);
            $finalval = sqrt($total);
            
            $result['distance'] = $finalval;
        }
        return $result;
    }
    
}

?>