<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Seminar_model extends CI_Model {

    public $article;
    const EXPERIENCE = 162;
    const HOTEL = 165;
    const GUESTS = 164;
    const CONFERENCE = 163;
    const ENTERTAINMENT = 166;
    
    const FIVESTARNEWS = 120;
    const PAGEBREAK = '<!-- pagebreak -->';
    
    function __construct() {
        parent::__construct();
    }
    
    public function get_article_content($lang_id, $article_id) {
        
        $article_query = $this->db
                ->where('lang_id', $lang_id)
                ->where('article_id', $article_id)
                ->get('article_content');
        
        if ($article_query->num_rows() == 1) {
            
            return $article_query->row_array();
        } else {
            
            return FALSE;
        }
    }
    
    public function get_all_articles($langID) {
        
        $articles[$this::EXPERIENCE] = $this->get_article_content((int)$langID, $this::EXPERIENCE);
        $articles[$this::HOTEL] = $this->get_article_content($langID, $this::HOTEL);
        $articles[$this::GUESTS] = $this->get_article_content($langID, $this::GUESTS);
        $articles[$this::CONFERENCE] = $this->get_article_content($langID, $this::CONFERENCE);
        $articles[$this::ENTERTAINMENT] = $this->get_article_content($langID, $this::ENTERTAINMENT);
        
        return $articles;
    }
    
    public function get_lang_id() {
        
        $language_query = $this->db
                ->where('language_short', $this->session->userdata('langCode'))
                ->get('languages');
        
        if ($language_query->num_rows() == 1) {
            $lang =  $language_query->row_array();
            return $lang['lang_id'];
        } else {
            return FALSE;
        }
    }
    
    public function get_video($folder) {
        
        $this->load->helper('directory');
        
        $video_dir = directory_map('./media/'.$folder);
        
        $ext_array = array(); 
        foreach ($video_dir as $file) {
            $ext = explode('.', $file);
            $ext_array[] = $ext[1];
        }
        
        $jpg = array_search('jpg', $ext_array);
        $mp4 = array_search('mp4', $ext_array);
        $ogv = array_search('ogv', $ext_array);
        $webm = array_search('webm', $ext_array);
        
        $video_string = '';
        
        if (!is_null($jpg)) {
            if ($folder == 'bg_video') {
                $video_string = $video_string . '<video autoplay loop class="slider-video-element" poster="' . base_url() . 'media/'.$folder.'/' . $video_dir[$jpg] . '">';
            } else {
                $video_string = $video_string . '<video controls autobuffer poster="' . base_url() . 'media/'.$folder.'/' . $video_dir[$jpg] . '">';
            }
                
        } else {
            echo 'Missing poster image for media/'.$folder;
            exit;
        }
        
        if (!is_null($mp4)) {
            if ($folder == 'bg_video') {
                $video_string = $video_string . '<source src="' . base_url() . 'media/'.$folder.'/' . $video_dir[$mp4] . '" type="video/mp4" />';
            } else {  
                $video_string = $video_string . '<source src="' . base_url() . 'media/'.$folder.'/' . $video_dir[$mp4] . '" type="video/mp4" media="all" />';
                $video_string = $video_string . '<source src="' . base_url() . 'media/mobile/promo_360p.mp4" type="video/mp4" media="all and (max-width:700px)" />';
                $video_string = $video_string . '<source src="' . base_url() . 'media/mobile/promo_720p.mp4" type="video/mp4" media="all and (min-width:700px) and (max-width:1300px)" />';
            }
        } else {
            echo 'Missing MP4 file for media/'.$folder;
            exit;
        }
        
        if (!is_null($ogv)) {
            $video_string = $video_string . '<source src="' . base_url() . 'media/'.$folder.'/' . $video_dir[$ogv] . '" type="video/ogv" />';
        } else {
            echo 'Missing OGV file for media/'.$folder;
            exit;
        }
        
        if (!is_null($webm)) {
            $video_string = $video_string . '<source src="' . base_url() . 'media/'.$folder.'/' . $video_dir[$webm] . '" type="video/webm" />';
        } else {
            echo 'Missing WEBM file for media/'.$folder;
            exit;
        }
        
        if (!is_null($jpg)) {
            $video_string = $video_string . '<img src="' . base_url() . 'media/'.$folder.'/' . $video_dir[$jpg] . '" alt="" />';
        } else {
            echo 'Missing poster image for media/'.$folder;
            exit;
        }
        
        $video_string = $video_string . '</video>';
        
        return $video_string;
    }
    
    public function get_price() {
        
        $ticket = $this->get_ticket();
        return $ticket['price'];
    }
    
    protected function get_ticket()
	{
		$this->db->where('tickets.processId', 'turkey201407');
		$this->db->where('from <=', date('Y-m-d'));
		$this->db->where('to >', date('Y-m-d'));
		$this->db->join($this->db->database . '.ticket_prices', 'ticket_prices.ticket_id=tickets.ticket_id', 'LEFT');
		$query = $this->db->get($this->db->database . '.tickets');

		if($query->num_rows() > 0)
		{
			return $query->row_array();
		}
		return FALSE;
	}
    
    public function get_news_by_url($url, $lang_id) {

        $article_query = $this->db
                ->select('a.article_id, a.title AS article_title, a.body, b.activate_at')
                ->from('article_content AS a')
                ->join('article AS b', 'a.article_id=b.article_id')
                ->where('a.lang_id', $lang_id)
                ->where('a.burl', $url)
                ->get();
        
        if ($article_query->num_rows() == 1) {
            
            $article_array = $article_query->row_array();
            $article_array['index_image'] = $this->_get_index_image($article_array['article_id']);
            $body = explode($this::PAGEBREAK, $article_array['body']);
            
            if (isset($body[1]) && $body[1] !== $body[0]) {
                $bodyContent = str_replace(
                        array('#stream_cz#', '#stream_en#', '#stream_hu#', '#stream_ro#', '#stream_ru#', '#stream_sk#'),
                        array(
                            '<iframe src="//www.ustream.tv/embed/18513575?wmode=direct&autoplay=true" style="border: 0 none transparent; margin: 0 auto;" frameborder="no" width="480" height="302"></iframe><br /><a href="http://www.ustream.tv/" style="padding: 2px 0px 4px; width: 400px; background: #ffffff; display: block; color: #000000; font-weight: normal; font-size: 10px; text-decoration: underline; text-align: center;" target="_blank">Live streaming video by Ustream</a>',
                            '<iframe src="//www.ustream.tv/embed/18513564?wmode=direct&autoplay=true" style="border: 0 none transparent; margin: 0 auto;" frameborder="no" width="480" height="302"></iframe><br /><a href="http://www.ustream.tv/" style="padding: 2px 0px 4px; width: 400px; background: #ffffff; display: block; color: #000000; font-weight: normal; font-size: 10px; text-decoration: underline; text-align: center;" target="_blank">Live streaming video by Ustream</a>',
                            '<iframe src="//www.ustream.tv/embed/18513569?wmode=direct&autoplay=true" style="border: 0 none transparent; margin: 0 auto;" frameborder="no" width="480" height="302"></iframe><br /><a href="http://www.ustream.tv/" style="padding: 2px 0px 4px; width: 400px; background: #ffffff; display: block; color: #000000; font-weight: normal; font-size: 10px; text-decoration: underline; text-align: center;" target="_blank">Live streaming video by Ustream</a>',
                            '<iframe src="//www.ustream.tv/embed/18513572?wmode=direct&autoplay=true" style="border: 0 none transparent; margin: 0 auto;" frameborder="no" width="480" height="302"></iframe><br /><a href="http://www.ustream.tv/" style="padding: 2px 0px 4px; width: 400px; background: #ffffff; display: block; color: #000000; font-weight: normal; font-size: 10px; text-decoration: underline; text-align: center;" target="_blank">Live streaming video by Ustream</a>',
                            '<iframe src="//www.ustream.tv/embed/18513578?wmode=direct&autoplay=true" style="border: 0 none transparent; margin: 0 auto;" frameborder="no" width="480" height="302"></iframe><br /><a href="http://www.ustream.tv/" style="padding: 2px 0px 4px; width: 400px; background: #ffffff; display: block; color: #000000; font-weight: normal; font-size: 10px; text-decoration: underline; text-align: center;" target="_blank">Live streaming video by Ustream</a>',
                            '<iframe src="//www.ustream.tv/embed/18513580?wmode=direct&autoplay=true" style="border: 0 none transparent; margin: 0 auto;" frameborder="no" width="480" height="302"></iframe><br /><a href="http://www.ustream.tv/" style="padding: 2px 0px 4px; width: 400px; background: #ffffff; display: block; color: #000000; font-weight: normal; font-size: 10px; text-decoration: underline; text-align: center;" target="_blank">Live streaming video by Ustream</a>'
                        ),
                        $body[1]
                );
            } else {
                $bodyContent = '';
            }

            $article_array['preview'] = $body[0];
            $article_array['body'] = $bodyContent;
            
            return $article_array;
            
        } else {
            
            $article_query = $this->db->get_where('article_content', array ('burl' => $url));
            
            if ($article_query->num_rows() == 1) {
                $article_array = $article_query->row_array();
                
                $article_query = $this->db
                    ->select('a.article_id, a.title AS article_title, a.body, b.activate_at')
                    ->from('article_content AS a')
                    ->join('article AS b', 'a.article_id=b.article_id')
                    ->where('a.lang_id', $lang_id)
                    ->where('a.article_id', $article_array['article_id'])
                    ->get();
                
                if ($article_query->num_rows() == 1) {
                    
                    $article_array = $article_query->row_array();
                    $article_array['index_image'] = $this->_get_index_image($article_array['article_id']);
                    $body = explode($this::PAGEBREAK, $article_array['body']);
                    
            if (isset($body[1]) && $body[1] !== $body[0]) {
                $bodyContent = str_replace(
                        array('#stream_cz#', '#stream_en#', '#stream_hu#', '#stream_ro#', '#stream_ru#', '#stream_sk#'),
                        array(
                            '<iframe src="//www.ustream.tv/embed/18513575?wmode=direct&autoplay=true" style="border: 0 none transparent; margin: 0 auto;" frameborder="no" width="480" height="302"></iframe><br /><a href="http://www.ustream.tv/" style="padding: 2px 0px 4px; width: 400px; background: #ffffff; display: block; color: #000000; font-weight: normal; font-size: 10px; text-decoration: underline; text-align: center;" target="_blank">Live streaming video by Ustream</a>',
                            '<iframe src="//www.ustream.tv/embed/18513564?wmode=direct&autoplay=true" style="border: 0 none transparent; margin: 0 auto;" frameborder="no" width="480" height="302"></iframe><br /><a href="http://www.ustream.tv/" style="padding: 2px 0px 4px; width: 400px; background: #ffffff; display: block; color: #000000; font-weight: normal; font-size: 10px; text-decoration: underline; text-align: center;" target="_blank">Live streaming video by Ustream</a>',
                            '<iframe src="//www.ustream.tv/embed/18513569?wmode=direct&autoplay=true" style="border: 0 none transparent; margin: 0 auto;" frameborder="no" width="480" height="302"></iframe><br /><a href="http://www.ustream.tv/" style="padding: 2px 0px 4px; width: 400px; background: #ffffff; display: block; color: #000000; font-weight: normal; font-size: 10px; text-decoration: underline; text-align: center;" target="_blank">Live streaming video by Ustream</a>',
                            '<iframe src="//www.ustream.tv/embed/18513572?wmode=direct&autoplay=true" style="border: 0 none transparent; margin: 0 auto;" frameborder="no" width="480" height="302"></iframe><br /><a href="http://www.ustream.tv/" style="padding: 2px 0px 4px; width: 400px; background: #ffffff; display: block; color: #000000; font-weight: normal; font-size: 10px; text-decoration: underline; text-align: center;" target="_blank">Live streaming video by Ustream</a>',
                            '<iframe src="//www.ustream.tv/embed/18513578?wmode=direct&autoplay=true" style="border: 0 none transparent; margin: 0 auto;" frameborder="no" width="480" height="302"></iframe><br /><a href="http://www.ustream.tv/" style="padding: 2px 0px 4px; width: 400px; background: #ffffff; display: block; color: #000000; font-weight: normal; font-size: 10px; text-decoration: underline; text-align: center;" target="_blank">Live streaming video by Ustream</a>',
                            '<iframe src="//www.ustream.tv/embed/18513580?wmode=direct&autoplay=true" style="border: 0 none transparent; margin: 0 auto;" frameborder="no" width="480" height="302"></iframe><br /><a href="http://www.ustream.tv/" style="padding: 2px 0px 4px; width: 400px; background: #ffffff; display: block; color: #000000; font-weight: normal; font-size: 10px; text-decoration: underline; text-align: center;" target="_blank">Live streaming video by Ustream</a>'
                        ),
                        $body[1]
                );
            } else {
                $bodyContent = '';
            }
                    
                    $article_array['preview'] = $body[0];
                    $article_array['body'] = $bodyContent;

                    return $article_array;
                }
            } 
            
            return FALSE;
        }
    }
    
    public function get_all_news($lang_id) {
        
        $article_query = $this->db
                ->select('a.article_id, a.title AS article_title, b.activate_at, a.burl')
                ->from('article_content AS a')
                ->join('article AS b', 'a.article_id=b.article_id')
                ->where('a.lang_id', $lang_id)
                ->where('b.deleted !=', 1)
                //->where('b.editable !=', 1)
                //->where('b.enabled', 1)
                ->where('b.menuitem_id', $this::FIVESTARNEWS)
                ->order_by('a.ts_mod', 'DESC')
                ->get();
        
        if ($article_query->num_rows() > 0) {
            
            $article_array = $article_query->result_array();
            
            foreach ($article_array AS &$article_row) {
                $article_row['index_image'] = $this->_get_index_image($article_row['article_id']);
                $article_content = $this->get_article_content($lang_id, $article_row['article_id']);
                $body = explode($this::PAGEBREAK, $article_content['body']);
                $article_row['preview'] = str_replace(array('<p>', '</p>', '<p dir="ltr">'), '', $body[0]); 
                
                if (substr($article_row['burl'], 0, 1) == "/") {
                    $article_row['burl'] = substr($article_row['burl'], 1);
                }
            }
            
            return $article_array;
            
        } else {
            
            return FALSE;
        }
    }
    
    protected function _get_index_image($article_id) {
        
        $file = 'https://admin.swisshalley.com/uploads/articles/'. $article_id . '/index.jpg';
        $file_headers = get_headers($file);
        
        if (strstr($file_headers[0], '404')) {
            return base_url() . 'media/demo_index.png';
        } else {
            return 'https://admin.swisshalley.com/uploads/articles/'. $article_id . '/index.jpg';
        }
    }
    
function update_utazas_stat($reset=0) {
      if ($reset=="1") {
	      $sql="update " . $this->db->database . ".kosar set stat_countryId='', stat_country='', stat_utazok=0, stat_category='', 
	              stat_hotelName='', stat_ejszakak=0,stat_roomBasis=''";
	      $query = $this->db->query($sql);
      }
      $sql="select * from " . $this->db->database . ".kosar 
      left join " . $this->db->database . ".rendelesek on rendelesek.rendeles_id=kosar.kosar_rendelesid
        where kosar_tipus=1 and kosar_booked=1 and stat_country='' and 
            rendeles_fizetve=1 and rendeles_szamlazva=1 and rendeles_torolve=0
            and kosar_adatok<>''";
      $query = $this->db->query($sql);
      $ret=$query->result_array();
      for ($i=0; $i<count($ret); $i++) {
        if ($ret[$i]['kosar_adatok']<>'') {
          $tmp=unserialize($ret[$i]['kosar_adatok']);
          if ($ret[$i]['kosar_id']=='39191') {
            //print_r($tmp);
          }
//          echo $ret[$i]['kosar_id']."<br/>";
          $country='';
          $countryId='';
          $city='';
          if (isset($tmp['form']['country']) and $tmp['form']['country']<>'')  {
            $countryId=$tmp['form']['country']; 
          } elseif (isset($tmp['xml']['country']) and $tmp['xml']['country']<>'')  {
            $country=$tmp['xml']['country']; 
          } 
          if (isset($tmp['xml']['countryId']) and $tmp['xml']['countryId']<>'')  {
            $countryId=$tmp['xml']['countryId']; 
          } 
          if ($country=='' and isset($tmp['hotelInfo']['Country'])) {
            $country=$tmp['hotelInfo']['Country'];
          }
          if ($country=='' and isset($tmp['hotel']['country'])) {
            $country=$tmp['hotel']['country'];
          }
          if ($country=='' and isset($tmp['hotel']['Info']['country'])) {
            $country=$tmp['hotel']['Info']['country'];
          }
          if (isset($tmp['xml']['city']) and $tmp['xml']['city']<>'')  {
            $city=$tmp['xml']['city']; 
          } 
          if ($city=='' and isset($tmp['hotelInfo']['Destination'])) {
            $city=$tmp['hotelInfo']['Destination'];
          }
          if ($city=='' and isset($tmp['hotelInfo']['City'])) {
            $city=$tmp['hotelInfo']['City'];
          }
          if ($city=='' and isset($tmp['hotel']['destinationName'])) {
            $city=$tmp['hotel']['destinationName'];
          }
          if ($city=='' and isset($tmp['hotel']['city'])) {
            $city=$tmp['hotel']['city'];
          }
          if ($city=='' and isset($tmp['hotel']['Info']['city'])) {
            $city=$tmp['hotel']['Info']['city'];
          }
          if ($city=='' and isset($tmp['hotel']['Info']['City'])) {
            $city=$tmp['hotel']['Info']['City'];
          }
          if ($city=='' and isset($tmp['hotel']['Info']['LocationCode'])) {
            $city=$tmp['hotel']['Info']['LocationCode'];
          }
		  


          if (($countryId=='' and $country=='') or $city=='') {
               echo "ERROR: Az orszag (".$countryId.":".$country.") vagy a varos (".$city.") ures."; 
               print_r($tmp);die(); 
          }

		  // utazok szama
		  $utazok = 0;
          $szobak = 0;
		  if (isset($tmp['utazok']))
		  {
			foreach($tmp['utazok'] as $room)
			{
				$utazok += count($room);
			}
            $szobak=count($room);
		  }
		  else
		  {
			if (isset($tmp['travellers']))
			{
				$utazok += count($tmp['travellers']);
			}
            
            $za=array();
            if (isset($tmp['travellers'][0]['roomindex'])) {
                for ($z=0; $z<count($tmp['travellers']);$z++) {
                    $za[]=$tmp['travellers'][$z]['roomindex'];
                }
                $szobak=count(array_unique($za));
            } else {
               if (isset($tmp['form']['rooms'])) {
                $szobak=$tmp['form']['rooms'];
               } 
            }
		  }

          if (($szobak==0  and isset($tmp['travellers'][0]) and $tmp['travellers'][0]<>1) or $utazok==0) {
               echo "ERROR: Szobak szama (".$szobak.") vagy az utazok szama (".$utazok.") ures."; 
               print_r($tmp);die(); 
          }
			
		// ejszakak szama	
		$nights = 0;
		if (isset($tmp['form']['nights']))
		{
			$nights = $tmp['form']['nights'];
		}
		else
		{
			if (isset($tmp['xml']['dateFrom']))
			{
				$ds = $tmp['xml']['dateFrom'];
				$de = $tmp['xml']['dateTo'];
				$ds = new DateTime(date(substr($ds,0,4).'-'.substr($ds,4,2).'-'.substr($ds,6,2) ));
				$de  = new DateTime(date(substr($de,0,4).'-'.substr($de,4,2).'-'.substr($de,6,2) ));
				$nights = $de->diff($ds)->days;
			}
			else
			{
				if (isset($tmp['search']['nights']))
				{
					$nights = $tmp['search']['nights'];
				}
				else
				{
					if (isset($tmp['search']['checkin']))
					{
						$ds = new DateTime(date($tmp['search']['checkin']));
						$de  = new DateTime(date($tmp['search']['checkout'] ));
						$nights = $de->diff($ds)->days;
					}
				}
			}
		}
				
          if ($nights==0) {
               echo "Error: Ejszakak szama nulla";print_r($tmp);die(); 
          }

		// hotelnev
		
		$hotelname='';
		if (isset($tmp['xml']['hotelName']))
		{
			$hotelname = $tmp['xml']['hotelName'];
		}
    	if ($hotelname=="" and isset($tmp['hotelInfo']['HotelName']))
		{
			$hotelname = $tmp['hotelInfo']['HotelName'];
		}
    	if ($hotelname=="" and isset($tmp['hotelInfo']['HotelName']))
		{
			$hotelname = $tmp['hotelInfo']['HotelName'];
		}
		if ($hotelname=="" and isset($tmp['hotel']['name']))
		{
			$hotelname = $tmp['hotel']['name'];
		} 
		if ($hotelname=="" and isset($tmp['hotel']['hotelName']))
		{
			$hotelname = $tmp['hotel']['hotelName'];
		} 
		if ($hotelname=="" and isset($tmp['hotel']['Info']['hotelname']))
		{
			$hotelname = $tmp['hotel']['Info']['hotelname'];
		} 
          if ($hotelname=='' and isset($tmp['hotel']['Info']['name'])) {
            $hotelname=$tmp['hotel']['Info']['name'];
          }
        if ($hotelname=="" and isset($tmp['hotel']['offers'])){
          foreach(array_keys($tmp['hotel']['offers']) as $key){
              if(is_array($tmp['hotel']['offers'][$key]) and isset($tmp['hotel']['offers'][$key]['hotel']['hotelName'])) {
                $hotelname=$tmp['hotel']['offers'][$key]['hotel']['hotelName'];
              }
          }
        }
		
          if ($hotelname=="") {
               echo "Error: Hotel neve ures";print_r($tmp);die(); 
          }

		// category
		
		$category = 100;
		
		if ($category==100 and isset($tmp['xml']['category']))
		{
			$category = (int)$tmp['xml']['category'];
		}
		if ($category==100 and isset($tmp['xml']['star']))
		{
			$category = (int)$tmp['xml']['star'];
		}
		if ($category==100 and isset($tmp['xml']['categoryName']))
		{
			$category = (int)$tmp['xml']['categoryName'];
		}
		if ($category==100 and isset($tmp['search']['stars'][0]))
		{
			$category = (int)$tmp['search']['stars'][0];
		}
		if ($category==100 and isset($tmp['hotel']['star']))
		{
			$category = (int)$tmp['hotel']['star'];
		}
		if ($category==100 and isset($tmp['hotel']['Category']))
		{
			$category = (int)$tmp['hotel']['Category'];
		}
		if ($category==100 and isset($tmp['hotel']['Info']['starrating']))
		{
			$category = (int)$tmp['hotel']['Info']['starrating'];
		}
		if ($category==100 and isset($tmp['hotel']['starRating']))
		{
			$category = (int)$tmp['hotel']['starRating'];
		}
		if ($category==100 and isset($tmp['hotel']['categoryShortName']))
		{
			$category = (int)$tmp['hotel']['categoryShortName'];
		}
		if ($category==100 and isset($tmp['hotelInfo']['StarRating']))
		{
			$category = (int)$tmp['hotelInfo']['StarRating'];
		} 
		if ($category==100 and isset($tmp['service']['purchase']['services'][0]['hotelInfo']['categoryName']))
		{
			$category = (int)$tmp['service']['purchase']['services'][0]['hotelInfo']['categoryName'];
		} 
		
          if ($category==100) {
               echo "Error: Hotel kategoria ures";print_r($tmp);die(); 
          }
        
        
		$sql="update " . $this->db->database . ".kosar set stat_utazok='".$utazok."', stat_ejszakak='".$nights."',
    stat_countryId='".$countryId."', stat_country='".$country."', stat_city=".$this->db->escape($city).", 
    stat_hotelName=".$this->db->escape($hotelname).",stat_category=".$this->db->escape($category).", stat_roomBasis=".$szobak."
		where kosar_id=".$ret[$i]['kosar_id'];
		$query = $this->db->query($sql);
		
		if (!$hotelname)
		{
		/*
      print_r($tmp['hotel']['offers']);
      echo '<br/><br/>';
			print_r($tmp); exit;
		*/
		}
		 
        }
	
      }
        $sql="update " . $this->db->database . ".kosar as a
        join " . $this->db->database . ".t_orszagok as b on
        a.stat_countryId = b.id
        set a.stat_country = b.name
        where a.stat_country='' and a.stat_countryId<>'' and a.stat_countryId<>'0'";
    		$query = $this->db->query($sql);

        $sql="update " . $this->db->database . ".kosar as a
        join " . $this->db->database . ".t_orszagok as b on
        a.stat_country = b.name
        set a.stat_countryId = b.id
        where a.stat_countryId='' and a.stat_country<>''";
    		$query = $this->db->query($sql);

	  		echo 'vege';
  }

  public function get_rooms_left() {
  
      $query = "select sum(k.stat_roomBasis) as total from " . $this->db->database . ".hotel_booking b 
                inner join " . $this->db->database . ".kosar k on k.kosar_booking_code=b.confirmationNumber 
                left join " . $this->db->database . ".rendelesek r on r.rendeles_id=k.kosar_rendelesid
                LEFT JOIN " . $this->db->database . ".felhasznalok f on f.felh_id=k.kosar_felhasznaloid
                LEFT JOIN " . $this->db->database . ".t_orszagok tt on tt.id=f.felh_orszag
                where  b.HotelCode in ('SH260', 'SH272', 'SH287') and b.cancelled is null
                 and b.source='sh' and b.checkin>'2014-07-01' and b.checkin<'2014-07-24'";
      
      $rooms_query = $this->db->query($query);
      
      if ($rooms_query->num_rows() == 1) {
          
          $room_array = $rooms_query->row_array();
          return $room_array['total'];
      } else {
          return 0;
      }
  }
    
}
