<?php

/*
*     Module   : Solar System
*     Author   : K SHEIK MOHAIDEEN
*     Created  : 21st Feb 2017  
*/

defined('BASEPATH') OR exit('No direct script access allowed');

class Solarsystem extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('api/solarsystem_model'); 
        $this->load->model('api/solarplanets_model');
        header("content-type:application/json");
        
        //Simple Authorization
        basic_auth();
        
    }

    // Get List of Solar system
    public function index() {
        $response = array();
        $result = $this->solarsystem_model->getList();
        $response = $this->review_Response_Results($result,"Solar sytem List Returned","No Records Found");
        echo json_encode($response);
    }
    
    // Add/Edit Solar system
    public function add_solar($id = 0) {
        $response = array();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $input = json_decode(file_get_contents("php://input"));
            $device_input = get_object_vars($input);
            
            if(isset($device_input['sid']) && $device_input['sid'] != '')
            {
               $id =  $device_input['sid'];
            }
            
            $solarName = trim($this->db->escape_str($device_input['solar_name']));
            
            $solarCount = $this->solarsystem_model->checkExistingSolar($solarName,$id);
            
            //Check existing solar name and insert it
            if($solarCount && $solarName != '')
            {
                $data = array(
                    'solar_name'         => $solarName,
                    'solar_size'         => $this->db->escape_str($device_input['solar_size']),
                    'solar_coordinate_x' => $this->db->escape_str($device_input['solar_x']),
                    'solar_coordinate_y' => $this->db->escape_str($device_input['solar_y']),
                    'solar_coordinate_z' => $this->db->escape_str($device_input['solar_z']),
                    'created_at'         => date('Y-m-d H:i:s')
                );

                if($id == 0)
                {
                    $result = $this->solarsystem_model->addSolar($data);
                    $response = $this->review_Response_Results($result,"Solar sytem Added Successfully");
                }
                else
                {
                    $result = $this->solarsystem_model->addSolar($data,$id);
                    $response = $this->review_Response_Results($result,"Solar sytem Updated Successfully","Solar sytem Not Found");
                }                
            }
            else
            {
                $response = array("result" => "error",
                    "message" => "Please enter the valid solar information"
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
    public function remove_solar() {
        $response = array();
        if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
            $input = json_decode(file_get_contents("php://input"));
            $device_input = get_object_vars($input);
            
            if ($device_input['sid'] == '') {
                $response = array("result" => "error",
                    "message" => "Please enter the valid id"
                );
                echo json_encode($response);
                exit;
            }
            
            $solarId = trim($this->db->escape_str($device_input['sid']));
            
            //Remove solor id
            if($solarId)
            {
                $result = $this->solarsystem_model->deleteSolar($solarId);
                $response = $this->review_Response_Results($result,"Solar System Removed Successfully","Solar System Not Found");
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
    
    // Find the Solar system Sun
    public function find_solarsun() {
        $response = array();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $input = json_decode(file_get_contents("php://input"));
            $device_input = get_object_vars($input);
            
            if ($device_input['sid'] == '') {
                $response = array("result" => "error",
                    "message" => "Please enter the valid id"
                );
                echo json_encode($response);
                exit;
            }
            
            $solarId = trim($this->db->escape_str($device_input['sid']));
            
            $solarCount = $this->solarsystem_model->checkExistingSolarById($solarId);
            
            //Find solor sun
            if($solarId)
            {
                $result = $this->solarplanets_model->findSolarSun($solarId);
                $response = $this->review_Response_Results($result,"Solar System Sun Information","Solar System Sun Not Found");
            }
            
        } else {
            $response = array("result" => "error",
                "message" => "Undefined Request Method"
            );
        }

        echo json_encode($response);
    }
    
    // Find the Solar system planets orbit Sun
    public function find_solar_orbitsun() {
        $response = array();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $input = json_decode(file_get_contents("php://input"));
            $device_input = get_object_vars($input);
            
            if ($device_input['sunid'] == '') {
                $response = array("result" => "error",
                    "message" => "Please enter the valid id"
                );
                echo json_encode($response);
                exit;
            }
            
            $sunId = trim($this->db->escape_str($device_input['sunid']));
            
            $sunCount = $this->solarplanets_model->checkExistingSunById($sunId);
            
            //Find solor sun
            if($sunCount)
            {
                $result = $this->solarplanets_model->findSolarOrbitSun($sunId);
                $response = $this->review_Response_Results($result,"Solar System Planets Orbit Sun Information","No Planets Orbit the sub in Solar System");
            }
            
        } else {
            $response = array("result" => "error",
                "message" => "Undefined Request Method"
            );
        }

        echo json_encode($response);
    }
    
    // Find the Solar system, planets and Sun by name
    public function find_solarplanetsun_byname() {
        $response = array();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $input = json_decode(file_get_contents("php://input"));
            $device_input = get_object_vars($input);
            
            if ($device_input['name'] == '') {
                $response = array("result" => "error",
                    "message" => "Please enter the valid name"
                );
                echo json_encode($response);
                exit;
            }
            
            $name = trim($this->db->escape_str($device_input['name']));
            
            //Find solor, planer and sun
            if($name)
            {
                $result = $this->solarsystem_model->findSolarPlanerSunByName($name);
                $response = $this->review_Response_Results($result,"Name Matches Found","No Match Found");
            }
            
        } else {
            $response = array("result" => "error",
                "message" => "Undefined Request Method"
            );
        }

        echo json_encode($response);
    }
    
    // Find the Solar system Sun
    public function find_solarplanets() {
        $response = array();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $input = json_decode(file_get_contents("php://input"));
            $device_input = get_object_vars($input);
            
            if ($device_input['sid'] == '') {
                $response = array("result" => "error",
                    "message" => "Please enter the valid id"
                );
                echo json_encode($response);
                exit;
            }
            
            $solarId = trim($this->db->escape_str($device_input['sid']));
            
            $solarCount = $this->solarsystem_model->checkExistingSolarById($solarId);
            
            //Find solor sun
            if($solarId)
            {
                $result = $this->solarplanets_model->findSolarSun($solarId,0);
                $response = $this->review_Response_Results($result,"Solar System Planets Information","Solar System Planets Not Found");
            }
            
        } else {
            $response = array("result" => "error",
                "message" => "Undefined Request Method"
            );
        }

        echo json_encode($response);
    }
    
    // Find the Solar system, planets and Sun by size
    public function find_solarplanetsun_bysize() {
        $response = array();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $input = json_decode(file_get_contents("php://input"));
            $device_input = get_object_vars($input);
            
            if ($device_input['size'] == '') {
                $response = array("result" => "error",
                    "message" => "Please enter the valid size"
                );
                echo json_encode($response);
                exit;
            }
            
            $size = trim($this->db->escape_str($device_input['size']));
            
            //Find solor, planer and sun
            if($size)
            {
                $result = $this->solarsystem_model->findSolarPlanerSunBySize($size);
                $response = $this->review_Response_Results($result,"Size Matches Found","No Match Found");
            }
            
        } else {
            $response = array("result" => "error",
                "message" => "Undefined Request Method"
            );
        }

        echo json_encode($response);
    }    
    
    // Find the Solar system, planets and Sun by size
    public function find_distance_solar() {
        $response = array();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $input = json_decode(file_get_contents("php://input"));
            $device_input = get_object_vars($input);
                        
            $p1 = trim($this->db->escape_str($device_input['p1']));
            $p2 = trim($this->db->escape_str($device_input['p2']));
            
            //Find solor, planer and sun
            if($p1 != '' && $p2 != '')
            {
                if($device_input['type'] == 'solar')
                {
                    $result = $this->solarsystem_model->findDistanceSolar($p1,$p2,$device_input['type']);
                    $response = $this->review_Response_Results($result,"Solar Distance Found","No Distance Found");
                }
                else
                {
                    $result = $this->solarsystem_model->findDistanceSolar($p1,$p2,$device_input['type']);
                    $response = $this->review_Response_Results($result,"Planet Distance Found","No Distance Found");
                }
            }
            else
            {
                $response = array("result" => "error",
                    "message" => "Please enter the valid planet id"
                );
            }
            
        } else {
            $response = array("result" => "error",
                "message" => "Undefined Request Method"
            );
        }

        echo json_encode($response);
    }

}
