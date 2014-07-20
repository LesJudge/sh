<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Lang_model extends CI_Model {
	
	var $dbnames;
	
	function __construct()
	{
		parent::__construct();
		$dbswitch = $this->config->item('dbswitch');
		$dbnames  = $this->config->item('dbnames');

		$this->dbnames = $dbnames[$dbswitch];
		
		//$this->captions 	= '`1_admin`.`captions`';
		//$this->captions_lang= '`1_admin`.`captions_lang`';
		$this->captions 	= '`' . $this->db->database . '`.`captions`';
		$this->captions_lang= '`' . $this->db->database . '`.`captions_lang`';
	}
	
	function get_captions($modul_name, $lang_id = FALSE)
	{
        
		$sess_lang_id = $this->session->userdata('lang_id');
		$lang_id = ($lang_id)? $lang_id : $sess_lang_id;
		$lang_id = ($lang_id)? $lang_id : 2;
		
		$sql = "SELECT caption, "
			 . "IFNULL(" . $this->captions_lang . ".`lang_text`, default_lang.`lang_text`) as lang_text "
			 . "FROM (" . $this->captions . ") "
			 . "LEFT JOIN " . $this->captions_lang . " as default_lang ON (default_lang.`caption_id` = " . $this->captions . ".`id` AND default_lang.`lang_id` = 2) "
			 . "LEFT JOIN " . $this->captions_lang . " ON " . $this->captions_lang . ".`caption_id` = " . $this->captions . ".`id` AND " . $this->captions_lang . ".`lang_id` = " . $lang_id . " "
			 . "WHERE `modul_name` = '" . $modul_name . "'";
     
		$query = $this->db->query($sql);
        
		if($query->num_rows() > 0)
		{
			$data = array();
			foreach( $query->result_array() as $row)
			{
				$data[$row['caption']] = $row['lang_text'];
			}
			return $data;
		}
		return FALSE;
	}

	function get_lang_id_by_lang_code($lang_code)
	{
		$this->db->where('language_short', $lang_code);
		$query = $this->db->get('languages');
		if($query->num_rows() > 0)
		{
			return $query->row_array();
		}
		return FALSE;
	}
	
	function get_languages($all = FALSE)
	{
        if ($all == FALSE) {
            $this->db->where('enabled', 1);
        }
		$this->db->order_by('language');
		$query = $this->db->get('languages');
		
		if ($query->num_rows() > 0)
		{
			return $query->result_array();
		}
		
		return FALSE;
	}
	
	function update_user_lang($langCode, $felh_id)
	{
		$data = array(
			'felh_lang' => $langCode
		);
		$this->db->where('felh_id', $felh_id);
		return $this->db->update('felhasznalok', $data);
	}
	
	
	function get_captions_by_lang_id($lang_id)
	{
		$query = $this->db->query('SELECT c.modul_name,c.caption,l.lang_text,c.default_text FROM '.$this->captions.' c LEFT JOIN '.$this->captions_lang.' l on (c.id=l.caption_id and l.lang_id='.$lang_id.') where c.simple_text=1  order by c.modul_name,c.caption ');
		if ($query->num_rows() > 0)
		{
			return $query->result_array();
		}
		
		return FALSE;
	}
}