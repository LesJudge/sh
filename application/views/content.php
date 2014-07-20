<nav id="menu">
<ul>
    <li>
        <a href="#experience" id="link_experience" class="current first-link">
            <span class="link-title1">Five Star</span> 
            <span class="link-title2">Experience</span>
        </a>
    </li>
    <li>
        <a href="#hotel" id="link_hotel">
            <span class="link-title1">Five Star</span> 
            <span class="link-title2">Hotel</span>
        </a>
    </li>
    <li>
        <a href="#guests" id="link_guests">
            <span class="link-title1">Five Star</span> 
            <span class="link-title2">Guests</span>
        </a>
    </li>
    <li>
        <a href="#conference" id="link_conference">
            <span class="link-title1">Five Star</span> 
            <span class="link-title2">Conference</span>
        </a>
    </li>
    <li>
        <a href="#party" id="link_party">
            <span class="link-title1">Five Star</span> 
            <span class="link-title2">Entertainment</span>
        </a>
    </li>
</ul>
</nav>

<section id="experience">
    <?php echo str_replace(':VIDEO_HELYE:', '<center>' . $video . '</center>', $articles_array[seminar_model::EXPERIENCE]['body']) ?>
    <?php //echo $video; ?>
</section>
<section id="hotel" style="display: none;">
    <?php echo $articles_array[seminar_model::HOTEL]['body']; ?>
</section>
<section id="guests" style="display: none;">
    <?php echo $articles_array[seminar_model::GUESTS]['body']; ?>
</section>
<section id="conference" style="display: none;">
    <?php echo $articles_array[seminar_model::CONFERENCE]['body']; ?>
</section>
<section id="party" style="display: none;">
    <?php echo $articles_array[seminar_model::ENTERTAINMENT]['body']; ?>
</section>

<br /><br />