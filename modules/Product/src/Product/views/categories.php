<script>
jQuery(document).ready(function() {
    jQuery.each(jQuery('.cat-item'), function(index, category) {
        var link = jQuery(category).find('a').attr('href');
        jQuery(category).css('cursor', 'pointer');
        jQuery(category).on('click', function() {
            window.location.href = link;
        });
    });
});
</script>