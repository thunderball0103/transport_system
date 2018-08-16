<?php

namespace App;

use DB;


class FreightModel
{
    public function __constructor(){
        
    }
    public function get_all_orders(){
        return DB::select('select * from freightorders');
	}    
	
	public function get_address_by_id($id){
		return DB::select('select address from freightorders where id = "'.$id.'"');
	}

	public function get_orders_by_date($start, $end){
		return DB::select('select * from freightorders where delivery_date >= '.$start.' and delivered_date <= '.$end);
	}

	public function get_orders_today(){
		return DB::select('select * from freightorders where delivered_date = CURDATE() ');
	}

	public function get_remove_orders($remove_town, $status){
		if($remove_town == 'all'){
			DB::table('freightorders')
            ->update(['shown_status' => $status]);	
		}
		DB::table('freightorders')
            ->where('town', $remove_town)
            ->update(['shown_status' => $status]);
		return DB::select('select * from freightorders where shown_status="show" ');
	}

	public function update_table_default(){
		DB::update('UPDATE freightorders SET deliver_color=color, deliver_town = town');
	}

	public function update_table_delivered(){
		DB::update('UPDATE freightorders SET color=deliver_color,  town=deliver_town');
	}

	public function get_update_orders($name, $update_town, $color){
		
		DB::table('freightorders')
            ->where('name', $name)
            ->update(['deliver_color' => $color, 'deliver_town' => $update_town]);
	}

	public function get_points($town){
		$points = array();
		$result = DB::select('select address,zipcode, town  from freightorders where town = "'.$town.'"');
		
		for($i=0;$i<count($result);$i++){
			array_push($points, $result[$i]->address.', '.$result[$i]->zipcode.'  '.$this->filter_address($result[$i]->town).', Denmark');
		}
		return $points;
	}

    //convert zip address to full
    public function filter_address($string){
        // var_dump($string);exit;
        if($string == "aar") { $return_string = "Aarhus"; } 
        else if($string == "ulf") { $return_string = "Ulfborg"; } 
        else if($string == "vid") { $return_string = "Videbaek"; }
        else if($string == "vib") { $return_string = "Viborg"; }
        else if($string == "rin") { $return_string = "Ringkobing"; }
        else if($string == "var") { $return_string = "Varde"; }
		else if($string == "Aarhus") { $return_string = "aar"; } 
        else if($string == "Ulfborg") { $return_string = "ulf"; }
        else if($string == "Viborg") { $return_string = "vib"; }
        else if($string == "Ringkobing") { $return_string = "rin"; }
        else if($string == "Varde") { $return_string = "var"; }
        else if($string == "Videbaek") { $return_string = "vid"; }
        else { $return_string = ""; }
        
        return $return_string;
    }
    
    public function locate_icons_default($town){

        $public_url = "http://127.0.0.1:8000/icon/";
        $icon = $public_url.$town."/default.png";
		return $icon;
	}

	public function update_delivery_icon($town, $color){
		$public_url = "http://127.0.0.1:8000/icon/";
		$icon = $public_url.$town."/".$color.".png";
		//var_dump($town);exit;
		return $icon;
	}
}
