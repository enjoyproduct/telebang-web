<div class="ssk-group">
	<a href="" class="ssk ssk-facebook"></a>
	<a href="" class="ssk ssk-twitter"></a>
	<a href="" class="ssk ssk-google-plus"></a>
	<a href="" class="ssk ssk-pinterest"></a>
</div>
<script type="text/javascript">
    // Init Social Share Kit
    SocialShareKit.init({
        url: '<?php echo current_url(); ?>',
        twitter: {
            title: 'Social Share Kit',
            via: 'socialsharekit'
        },
    });
    $(function () {
        // Just to disable href for other example icons
        $('.ssk').on('click', function (e) {
            e.preventDefault();
        });

        // Navigation collapse on click
        $('.navbar-collapse ul li a:not(.dropdown-toggle)').bind('click', function () {
            $('.navbar-toggle:visible').click();
        });

        // Sticky icons changer
        $('.sticky-changer').click(function (e) {
            e.preventDefault();
            var $link = $(this);
            $('.ssk-sticky').removeClass($link.parent().children().map(function () {
                return $(this).data('cls');
            }).get().join(' ')).addClass($link.data('cls'));
            $link.parent().find('.active').removeClass('active');
            $link.addClass('active').blur();
        });
    });

</script>