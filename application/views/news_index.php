<div class="news-top">
    <div class="title-h2"><strong>FIVE STAR</strong> Seminar</div>
    <div class="title-sub-h2">News</div>
</div>
<?php if (!empty($all_news_array)) { ?>
<?php foreach ($all_news_array AS $news_array) { ?>
<section class="news-node row">
    <div class="title-wrapper">
        <div class="news-title"><?php echo $news_array['article_title']; ?></div>
        <div class="news-date"><?php echo $news_array['activate_at']; ?></div>
    </div>
    <div class="news-node-wrapper row">
        <div class="col-lg-6 col-md-6 col-sm-6  col-xs-24"><a href="<?php echo base_url() . 'news/'. $news_array['burl']; ?>"><img src="<?php echo $news_array['index_image']; ?>" alt="<?php echo $news_array['article_title']; ?>" title="<?php echo $news_array['article_title']; ?>" class="img-responsive" /></a></div>
        <div class="col-lg-17 col-lg-offset-1 col-md-17 col-md-offset-1 col-sm-17 col-sm-offset-1 col-xs-24  col-xs-offset-0">
       		<div class="news-preview-text"><?php echo $news_array['preview']; ?></div>
        	<a href="<?php echo base_url() . 'news/'. $news_array['burl']; ?>">
            <div class="news-node-link"><?php echo $this->data['Lang']['tovabb']; ?></div></a>
    	</div>
        <div class="clearfix"></div>
    </div>
    
</section>
<?php } ?>
<?php } ?>
