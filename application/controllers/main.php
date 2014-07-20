<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @property CI_Config $config Description
 * @property Seminar_model $seminar Seminar model.
 */
class Main extends CI_Controller {

    public $data;
    
    function __construct()
    {
        parent::__construct();
        // Loads the site configuration.
        $this->load->config('site');
        // Loads the site model.
        $this->load->model('site_model', 'site');
        $this->load->model('lang_model');
        $this->load->model('seminar_model', 'seminar');
        
        $langCode = $this->session->userdata('langCode');
        
        if (empty($langCode)) {
            $this->set_lang('en');
        }
        // Sets the default <body> class.
        $this->data['bodyClass'] = $this->site->getTemplateItem('body_class');
        $this->data['langID'] = $this->seminar->get_lang_id();
        $this->data['Lang'] = $this->lang_model->get_captions('ffs_microsite', $this->data['langID']);
        $this->data['langCode'] = $this->session->userdata('langCode');
    }
    
    public function index() {
        //$data['buy_ticket_link'] = 'https://swisshalley.com/'.$this->data['langCode'].'/addtocart/ticket:turkey201407';
        //$data['buy_ticket_link'] = base_url('packages');
        $data['buy_ticket_link'] = base_url('livecoverage');

        if (date('Y-m-d') < '2014-03-23') {
            $data['offer_valid'] = 'Offer valid until 22 March 2014, Saturday, 23:59 CET';
        } else {
            $data['offer_valid'] = FALSE;
        }

        //$data['price'] = $this->seminar->get_price();
        $data['price'] = false;

        $data['articles_array'] = $this->seminar->get_all_articles($this->data['langID']);
        $data['video'] = $this->seminar->get_video('intro_video');
        $data['bg_video'] = $this->seminar->get_video('bg_video');

        if (date('Y-m-d') < '2014-03-23') {
            $data['offer_valid'] = $this->data['Lang']['ajanlat_ervenyes'];
        } else {
            $data['offer_valid'] = FALSE;
        }
        $data['date'] = $this->data['Lang']['2014_julius_22_23'];
        $data['location'] = $this->data['Lang']['torokorszag_antalya'];
        $data['terms'] = $this->data['Lang']['jegyvasarlasi_felhasznalasai_feltetelek'];

        $siteBeforePopupContent = false;
        if (!$this->site->getIsNew()) {
            $article = $this->seminar->get_article_content(
                $this->data['langID'],
                $this->config->item('site_before_popup_article_id')
            ); // Returns the article from database.
            if (is_array($article)) { // If the article exists.
                $siteBeforePopupContent = $article['body'];
            }
        }
        $data['siteBeforePopupContent'] = $siteBeforePopupContent;
        $data['sliderImg'] = $this->site->getTemplateItem('slider_image');
        $data['button_text'] = $this->data['Lang'][$this->site->getTemplateItem('btn_text_lk')];

        $this->data['header'] = $this->load->view($this->site->getTemplateItem('header'), $data, TRUE);
        $this->data['slider'] = $this->load->view('slider', $data, TRUE);
        $this->data['content'] = $this->load->view('content', $data, TRUE);
        $this->data['footer'] = $this->load->view($this->site->getTemplateItem('footer'), $data, TRUE);

        $this->load->view('wrapper', $this->data);
    }
    /**
     * FAQ page.
     */
    public function faq()
    {
        $this->loadArticleById($this->config->item('site_faq_article_id'));
    }
    /**
     * UStream Live coverage page.
     */
    public function livecoverage()
    {
        $this->loadArticleById($this->config->item('site_ustream_article_id'));
    }
    /**
     * Compensationsystem page.
     */
    public function compensationsystem()
    {
        $this->loadArticleById($this->config->item('site_cs_article_id'));
    }
    /**
     * Loads and renders the requested article by ID.
     * @param int $articleId Article ID
     */
    private function loadArticleById($articleId)
    {
        // Override template.
        //$this->data['bodyClass'] = $this->site->getSiteConfigItem('body_class_new');
        $this->data['slider'] = false;
        $article = $this->seminar->get_article_content($this->data['langID'], $articleId);
        if (is_array($article)) {
                $body = explode(Seminar_model::PAGEBREAK, $article['body']);
                if (isset($body[1])) {
                    $bodyContent = str_replace(
                            array('#stream_cz#', '#stream_en#', '#stream_hu#', '#stream_ro#', '#stream_ru#', '#stream_sk#'),
                            array(
                                '<iframe src="//www.ustream.tv/embed/18513575?wmode=direct&autoplay=true" style="border: 0 none transparent; margin: 0 auto; display: block;" frameborder="no" width="480" height="302"></iframe><br /><a href="http://www.ustream.tv/" style="padding: 2px 0px 4px; width: 400px; background: #ffffff; display: block; color: #000000; font-weight: normal; font-size: 10px; text-decoration: underline; text-align: center; margin: 0 auto;" target="_blank">Live streaming video by Ustream</a>',
                                '<iframe src="//www.ustream.tv/embed/18513564?wmode=direct&autoplay=true" style="border: 0 none transparent; margin: 0 auto; display: block;" frameborder="no" width="480" height="302"></iframe><br /><a href="http://www.ustream.tv/" style="padding: 2px 0px 4px; width: 400px; background: #ffffff; display: block; color: #000000; font-weight: normal; font-size: 10px; text-decoration: underline; text-align: center; margin: 0 auto;" target="_blank">Live streaming video by Ustream</a>',
                                '<iframe src="//www.ustream.tv/embed/18513569?wmode=direct&autoplay=true" style="border: 0 none transparent; margin: 0 auto; display: block;" frameborder="no" width="480" height="302"></iframe><br /><a href="http://www.ustream.tv/" style="padding: 2px 0px 4px; width: 400px; background: #ffffff; display: block; color: #000000; font-weight: normal; font-size: 10px; text-decoration: underline; text-align: center; margin: 0 auto;" target="_blank">Live streaming video by Ustream</a>',
                                '<iframe src="//www.ustream.tv/embed/18513572?wmode=direct&autoplay=true" style="border: 0 none transparent; margin: 0 auto; display: block;" frameborder="no" width="480" height="302"></iframe><br /><a href="http://www.ustream.tv/" style="padding: 2px 0px 4px; width: 400px; background: #ffffff; display: block; color: #000000; font-weight: normal; font-size: 10px; text-decoration: underline; text-align: center; margin: 0 auto;" target="_blank">Live streaming video by Ustream</a>',
                                '<iframe src="//www.ustream.tv/embed/18513578?wmode=direct&autoplay=true" style="border: 0 none transparent; margin: 0 auto; display: block;" frameborder="no" width="480" height="302"></iframe><br /><a href="http://www.ustream.tv/" style="padding: 2px 0px 4px; width: 400px; background: #ffffff; display: block; color: #000000; font-weight: normal; font-size: 10px; text-decoration: underline; text-align: center; margin: 0 auto;" target="_blank">Live streaming video by Ustream</a>',
                                '<iframe src="//www.ustream.tv/embed/18513580?wmode=direct&autoplay=true" style="border: 0 none transparent; margin: 0 auto; display: block;" frameborder="no" width="480" height="302"></iframe><br /><a href="http://www.ustream.tv/" style="padding: 2px 0px 4px; width: 400px; background: #ffffff; display: block; color: #000000; font-weight: normal; font-size: 10px; text-decoration: underline; text-align: center; margin: 0 auto;" target="_blank">Live streaming video by Ustream</a>'
                            ),
                            $body[1]
                    );
                } else {
                    $bodyContent = $body[0];
                }
                $data['articles_array']['body'] = $body;
            $data['articles_array'] = $article;
            $this->data['header'] = $this->load->view($this->site->getTemplateItem('header_page'), $data, TRUE);
            $this->data['content'] = $this->load->view('content_page', $data, true);
            $this->data['footer'] = $this->load->view($this->site->getTemplateItem('footer'), $data, TRUE);
            $this->load->view('wrapper_page', $this->data);
        } else {
            redirect('/');
        }
    }
    
    public function terms()
    {
        $data['buy_ticket_link'] = 'https://swisshalley.com/'.$this->data['langCode'].'/addtocart/ticket:turkey201407';
        $data['articles_array'] = $this->seminar->get_article_content($this->data['langID'], 167);
        
        $this->data['header'] = $this->load->view('header_page', $data, TRUE);
        $this->data['content'] = $this->load->view('content_page', $data, TRUE);
        $this->data['footer'] = $this->load->view('footer', $data, TRUE);
        
        $this->load->view('wrapper_page', $this->data);
    }
    
    public function set_lang($langCode = FALSE, $redirect = FALSE) {
        
        $langCode = (!empty($langCode)) ? $langCode : 'en';
        $this->session->set_userdata('langCode', $langCode);
        
        if (!empty($redirect)) {
            
            redirect(base64_decode($redirect));
        }
    }
    
    public function packages() {
        
        /*if ($this->input->ip_address() !== '92.249.176.254') {
            echo 'Our site is under construction! Please refresh within a short time!';
            exit;
        }*/
        
        /* frissítjük a lefoglalt szállásokat */
        $this->seminar->update_utazas_stat();
        
        /* lekérdezzük a maradék szállást */
        $data['rooms_left'] = 405-$this->seminar->get_rooms_left();
        
        if ((int)$data['rooms_left'] > 0) {
            $this->data['layer_url'] = 'rooms-left/'.$data['rooms_left'];
            $this->data['can_book'] = TRUE;
        } else {
            $this->data['layer_url'] = 'no-more-rooms';
            $this->data['can_book'] = FALSE;
        }
        
        /* live config */
        $data['package1_link'] = 'https://swisshalley.com/'.$this->data['langCode'].'/addtocart/ticket:turkey201407dp';
        $data['package2_link'] = 'https://swisshalley.com/'.$this->data['langCode'].'/addtocart/ticket:turkey201407ctdp';
        $data['package3_link'] = 'https://swisshalley.com/'.$this->data['langCode'].'/ticket/accommodation';
        $data['package4_link'] = 'https://swisshalley.com/'.$this->data['langCode'].'/ticket/fivestarpackage';
        
        /* test config */
        /*$data['package1_link'] = 'http://test07.fireflies.com/'.$this->data['langCode'].'/addtocart/ticket:turkey201407dp';
        $data['package2_link'] = 'http://test07.fireflies.com/'.$this->data['langCode'].'/addtocart/ticket:turkey201407ctdp';
        $data['package3_link'] = 'http://test07.fireflies.com/'.$this->data['langCode'].'/ticket';
        $data['package4_link'] = 'http://test07.fireflies.com/'.$this->data['langCode'].'/ticket';*/
        
        $data['langCode'] = $this->data['langCode'];
        $this->data['header'] = $this->load->view('header_page', $data, TRUE);
        $this->data['content'] = $this->load->view('packages', $data, TRUE);
        $this->data['footer'] = $this->load->view('footer', $data, TRUE);
        
		$this->load->view('wrapper_page', $this->data);
    }
    
    public function news($seo_url = NULL) {
        $this->load->helper('security');
        if (!empty($seo_url)) {
            $data['news_array'] = $this->seminar->get_news_by_url(xss_clean($seo_url), $this->data['langID']);
            $this->data['og_title'] = $data['news_array']['article_title'];
            $this->data['og_image'] = $data['news_array']['index_image'];
            $this->data['og_description'] = $data['news_array']['preview'];
            $this->data['content'] = $this->load->view('news_page', $data, TRUE);
        
        } else {
            $data['all_news_array'] = $this->seminar->get_all_news($this->data['langID']);
            $this->data['content'] = $this->load->view('news_index', $data, TRUE);
        }
        $data['langCode'] = $this->data['langCode'];
        $this->data['header'] = $this->load->view($this->site->getTemplateItem('header_page'), $data, TRUE);
        $this->data['footer'] = $this->load->view($this->site->getTemplateItem('footer'), $data, TRUE);
		$this->load->view('wrapper_page', $this->data);
    }
    
    public function flights() {
        
        $data['buy_ticket_link'] = 'https://swisshalley.com/'.$this->data['langCode'].'/addtocart/ticket:turkey201407';
        
        $data['articles_array'] = $this->seminar->get_article_content($this->data['langID'], 192);
        
        $this->data['header'] = $this->load->view('header_page', $data, TRUE);
        $this->data['content'] = $this->load->view('content_page', $data, TRUE);
        $this->data['footer'] = $this->load->view('footer', $data, TRUE);
        
        $this->load->view('wrapper_page', $this->data);
    }
    
    public function rooms_left($count) {
        
        if ((int)$count <= 20) {
            $article_id = 207;
        } else {
            $article_id = 210;
        }
        
        $data['article'] = $this->seminar->get_article_content($this->data['langID'], $article_id);
        $data['article']['body'] = str_replace("&hellip;", $count, $data['article']['body']);
        
        $this->load->view('layer_green', $data);
    }
    
    public function no_more_rooms() {
        
        $data['article'] = $this->seminar->get_article_content($this->data['langID'], 208);
        $this->load->view('layer_red', $data);
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
