<?php

/*
*     Module   : Solar System
*     Author   : K SHEIK MOHAIDEEN
*     Created  : 21st Feb 2017  
*/

defined('BASEPATH') OR exit('No direct script access allowed');

class Solarplanets extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('api/solarplanets_model');
        $this->load->model('api/solarsystem_model');
        header("content-type:application/json");
        
        //Simple Authorization
        basic_auth();
        
    }

    // Get List of Solar planets
    public function index() {
        $response = array();
        $result = $this->solarplanets_model->getList();
        $response = $this->review_Response_Results($result,"Solar planets List Returned","No Records Found");
        echo json_encode($response);
    }
    
    // Add/Edit Solar system
    public function add_planet($id = 0) {
        $response = array();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $input = json_decode(file_get_contents("php://input"));
            $device_input = get_object_vars($input);
            
            if(isset($device_input['pid']) && $device_input['pid'] != '')
            {
               $id =  $device_input['pid'];
            }
            
            $planetName = trim($this->db->escape_str($device_input['planet_name']));
            
            $planetCount = $this->solarplanets_model->checkExistingPlanet($planetName,$device_input['planet_solar_id'],$id);
            
            $solarCount = $this->solarsystem_model->checkExistingSolarById($device_input['planet_solar_id']);
            
            //Check planet sun exists in solar system
            $planetSunCount = true;            
            if($device_input['planet_sun'] == 1)
            {
                $planetSunCount = $this->solarplanets_model->checkExistingPlanetSun($device_input['planet_solar_id']);
            }
            
            //Check existing planet name and insert it
            if($planetCount && $planetName != '' && $solarCount && $planetSunCount)
            {
                $data = array(
                    'planet_name'         => $planetName,
                    'planet_solar_id'     => $this->db->escape_str($device_input['planet_solar_id']),
                    'planet_size'         => $this->db->escape_str($device_input['planet_size']),
                    'planet_coordinate_x' => $this->db->escape_str($device_input['planet_x']),
                    'planet_coordinate_y' => $this->db->escape_str($device_input['planet_y']),
                    'planet_coordinate_z' => $this->db->escape_str($device_input['planet_z']),
                    'planet_is_sun'       => $this->db->escape_str($device_input['planet_sun']),
                    'planet_is_orbit_sun' => $this->db->escape_str($device_input['planet_orbit_sun']),
                    'planet_created_at'          => date('Y-m-d H:i:s')
                );

                if($id == 0)
                {
                    $result = $this->solarplanets_model->addPlanet($data);
                    $response = $this->review_Response_Results($result,"Solar planet Added Successfully");
                }
                else
                {
                    $result = $this->solarplanets_model->addPlanet($data,$id);
                    $response = $this->review_Response_Results($result,"Solar planet Updated Successfully","Solar planet Not Found");
                }
                
            }
            else
            {
                $response = array("result" => "error",
                    "message" => "Please enter the valid planet information"
                );
            }
            
        } else {
            $response = array("result" => "error",
                "message" => "Undefined Request Method"
            );
        }

        echo json_encode($response);
    }
    
    // Remove Solar system
    public function remove_planet() {
        $response = array();
        if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
            $input = json_decode(file_get_contents("php://input"));
            $device_input = get_object_vars($input);
            
            if ($device_input['pid'] == '') {
                $response = array("result" => "error",
                    "message" => "Please enter the valid id"
                );
                echo json_encode($response);
                exit;
            }
            
            $planetId = trim($this->db->escape_str($device_input['pid']));
            
            //Remove solor id
            if($planetId)
            {
                $result = $this->solarplanets_model->deletePlanet($planetId);
                $response = $this->review_Response_Results($result,"Solar planet Removed Successfully","Solar planet Not Found");
            }
            
        } else {
            $response = array("result" => "error",
                "message" => "Undefined Request Method"
            );
        }

        echo json_encode($response);
    }

    //Response Generate
    public function review_Response_Results($result,$suss_msg = 'Action Success',$error_msg = 'Action Failed') {
        if ($result) {
            $response = array("result" => "success",
                "message" => $suss_msg,
                "response" => $result
            );
        } else {
            $response = array("result" => "error",
                "message" => $error_msg
            );
        }
        echo json_encode($response);
    }  

}
