<section id="content">
    <div class="title-wrapper">
        <div class="news-title"><?php echo $news_array['article_title']; ?></div>
        <div class="news-date"><?php echo $news_array['activate_at']; ?></div>
    </div>
   <div class="news-content"> <?php echo $news_array['body']; ?></div>
    <br /><br />
    <div class="news-links">
        <div class="social-links">
            <div class="fb-box">
                <div class="fb-share-button" data-href="<?php echo current_url(); ?>" data-width="200" data-type="button_count"></div>
                &nbsp;&nbsp;&nbsp;&nbsp;
            </div>
            <div class="twitter-box">
                <a href="https://twitter.com/share" class="twitter-share-button">Tweet</a>
                <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
            </div>
            <div class="gplus-box">
                <div class="g-plusone" data-size="medium"></div>
                <script type="text/javascript">
                    (function() {
                      var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
                      po.src = 'https://apis.google.com/js/platform.js';
                      var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
                    })();
                </script>
            </div>
        </div>
        <a href="<?php echo base_url('news'); ?>"><div class="news-node-link"><?php echo $this->data['Lang']['vissza']; ?></div></a>
        <div class="clearfix"></div>
        <br />
    </div>
</section>
