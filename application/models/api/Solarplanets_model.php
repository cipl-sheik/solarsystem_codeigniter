<?php

/*
*     Model    : Solar System
*     Author   : K SHEIK MOHAIDEEN
*     Created  : 21st Feb 2017  
*/

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Solarplanets_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->tbl = 'solar_planets';
    }

    //Get All Solar Planet
    public function getList() {
        $query = $this->db->select('*')->from($this->tbl)->order_by("planet_is_sun", "desc")->get();
        $result = $query->result_array();
        return $result;
    }
    
    //Check existing Solar Planet
    public function checkExistingPlanet($name,$solar_id,$id = 0) {
        
        $this->db->select('planet_id');
        $this->db->from($this->tbl);
        $this->db->where("planet_name",$name);
        $this->db->where("planet_solar_id",$solar_id);
        if($id != 0)
        {
           $this->db->where("planet_id != ",$id); 
        }
        $query = $this->db->get();
        $count = $query->num_rows();
        //echo $this->db->queries[0]; exit;
        
        if($count > 0)
        {
            $response = array("result" => "error",
                    "message" => "Solar Planet Already Exists"
            );
            echo json_encode($response);  
            exit;
        }
        else
        {
            return true;
        }
    }
    
    //Add Planet
    public function addPlanet($data,$id = 0)
    {
        if($id == 0)
        {
            $this->db->insert($this->tbl, $data);
            $id = $this->db->insert_id();
        }
        else
        {
            $this->db->where('planet_id',$id);
            $this->db->update($this->tbl,$data);
        }
        $result = $this->getSinglePlanet($id);
        return $result;
    }
    
    //Get Single Planet
    public function getSinglePlanet($id)
    {
        $this->db->select('*');
        $this->db->from($this->tbl);
        $this->db->where("planet_id",$id);
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }
    
    //Remove planet
    public function deletePlanet($id)
    {
        $this->db->where('planet_id', $id);
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
    
    //Check existing Planet Sun
    public function checkExistingPlanetSun($solarid) {
        
        $this->db->select('planet_id');
        $this->db->from($this->tbl);
        $this->db->where("planet_is_sun",1);
        $this->db->where("planet_solar_id",$solarid);
        $query = $this->db->get();
        $count = $query->num_rows();
        //echo $this->db->queries[0]; exit;
        
        if($count > 0)
        {
            $response = array("result" => "error",
                    "message" => "Planet Sun Already Exists in Solar System"
            );
            echo json_encode($response);  
            exit;
        }
        else
        {
            return true;
        }
    }
    
    //Find Solar Sun
    public function findSolarSun($id,$sun = 1)
    {
        $this->db->select('*');
        $this->db->from($this->tbl);
        $this->db->where("planet_solar_id",$id);
        $this->db->where("planet_is_sun",$sun);
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }
    
    //Find Solar Orbit Sun
    public function findSolarOrbitSun($id)
    {
        $this->db->select('planet_solar_id');
        $this->db->from($this->tbl);
        $this->db->where("planet_id",$id);
        $query = $this->db->get();
        $result = $query->row_array();
        //print_r($result); exit;
        
        $this->db->select('*');
        $this->db->from($this->tbl);
        $this->db->where("planet_solar_id",$result['planet_solar_id']);
        $this->db->where("planet_is_sun",0);
        $this->db->where("planet_is_orbit_sun",1);
        $query2 = $this->db->get();
        $result2 = $query2->result_array();
        
        return $result2;
    }
    
    //Check existing Solar Sun By ID
    public function checkExistingSunById($id) {
        
        $this->db->select('planet_id');
        $this->db->from($this->tbl);
        $this->db->where("planet_id",$id);
        $this->db->where("planet_is_sun",1);
        $query = $this->db->get();
        $count = $query->num_rows();
        //echo $count; exit;
        
        if($count <= 0)
        {
            $response = array("result" => "error",
                    "message" => "Invalid / Sun Not Found"
            );
            echo json_encode($response);  
            exit;
        }
        else
        {
            return true;
        }
    }

}

?>