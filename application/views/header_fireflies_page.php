<div class="header-inner row">
     <div class="col-lg-6 col-md-6 col-sm-4 clo-xs-6">
   	 	<a href="<?php echo base_url(); ?>"><img src="<?php echo base_url(); ?>media/logo_fireflies_1.png" class="logo" alt="" /></a>
     </div>
    
    <div class="col-lg-18 col-md-18 col-sm-20 clo-xs-18">
        <div class="row dropdown" id="main-menu">
            <div class="navbar navbar-default" role="navigation">
                           <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                  <i class="icomoon icomoon-menu"></i>
            </button>
            <div class="clearfix visible-xs"></div>  
        </div>        
                  <div class="collapse navbar-collapse navbar-ex1-collapse">                   
                         <ul class="nav navbar navbar-nav" id="menu_1">
                            <li class="topLevel-li">
                                <div class="hotline-menu">
                                    <div class="hotline-menu-text"><?php echo $this->data['Lang']['kerdesed_van']; ?></div>
                                    <div class="hotline-menu-number"><?php echo $this->data['Lang']['hotline_szamok']; ?></div>
                                </div>
                            </li>
                            <li class="topLevel-li"> <a href="<?php echo base_url('news'); ?>"><div class="news-menu"><?php echo $this->data['Lang']['hirek']; ?></div></a></li>
                             <li class="topLevel-li"><a href="<?php echo base_url('faq'); ?>"><div class="flights-menu"><?php echo $this->data['Lang']['faq']; ?></div></a></li>
                             <li class="topLevel-li"><a href="<?php echo base_url('compensationsystem'); ?>"><div class="flights-menu"><?php echo $this->data['Lang']['compensationsystem']; ?></div></a></li>
                            
                          </ul>           
                  </div>
            </div>
        </div> <!-- #main-menu -->  	
        <div class="lang-select" id="lang_select"> 
            <a href="<?php echo base_url(); ?>set_lang/en/<?php echo base64_encode(current_url()); ?>"><div class="button<?php if ($this->session->userdata('langCode') !== 'en') { echo ' hidden'; } ?>">English<?php if ($this->session->userdata('langCode') == 'en') { ?><span class="select-icon"><?php } ?></span></div></a>
            <a href="<?php echo base_url(); ?>set_lang/hu/<?php echo base64_encode(current_url()); ?>"><div class="button<?php if ($this->session->userdata('langCode') !== 'hu') { echo ' hidden'; } ?>">Magyar<?php if ($this->session->userdata('langCode') == 'hu') { ?><span class="select-icon"><?php } ?></span></div></a>
            <a href="<?php echo base_url(); ?>set_lang/de/<?php echo base64_encode(current_url()); ?>"><div class="button<?php if ($this->session->userdata('langCode') !== 'de') { echo ' hidden'; } ?>">Deutsch<?php if ($this->session->userdata('langCode') == 'de') { ?><span class="select-icon"><?php } ?></span></div></a>
            <a href="<?php echo base_url(); ?>set_lang/ro/<?php echo base64_encode(current_url()); ?>"><div class="button<?php if ($this->session->userdata('langCode') !== 'ro') { echo ' hidden'; } ?>">Romana<?php if ($this->session->userdata('langCode') == 'ro') { ?><span class="select-icon"><?php } ?></span></div></a>
            <a href="<?php echo base_url(); ?>set_lang/ru/<?php echo base64_encode(current_url()); ?>"><div class="button<?php if ($this->session->userdata('langCode') !== 'ru') { echo ' hidden'; } ?>">Pусский<?php if ($this->session->userdata('langCode') == 'ru') { ?><span class="select-icon"><?php } ?></span></div></a>
            <a href="<?php echo base_url(); ?>set_lang/sk/<?php echo base64_encode(current_url()); ?>"><div class="button<?php if ($this->session->userdata('langCode') !== 'sk') { echo ' hidden'; } ?>">Slovak<?php if ($this->session->userdata('langCode') == 'sk') { ?><span class="select-icon"><?php } ?></span></div></a>
            <a href="<?php echo base_url(); ?>set_lang/cz/<?php echo base64_encode(current_url()); ?>"><div class="button<?php if ($this->session->userdata('langCode') !== 'cz') { echo ' hidden'; } ?>">Čeština<?php if ($this->session->userdata('langCode') == 'cz') { ?><span class="select-icon"><?php } ?></span></div></a>
            <a href="<?php echo base_url(); ?>set_lang/pl/<?php echo base64_encode(current_url()); ?>"><div class="button<?php if ($this->session->userdata('langCode') !== 'pl') { echo ' hidden'; } ?>">Polski<?php if ($this->session->userdata('langCode') == 'pl') { ?><span class="select-icon"><?php } ?></span></div></a>
        </div>   
        
        
        
    </div>
    <div class="clearfix"></div>
    
</div>

