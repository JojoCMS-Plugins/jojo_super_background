jQuery(function ($) {
    var win = $(window);
    win.resize(function() {

        var win_w = win.width(),
            win_h = win.height(),
            $bg   = $("#super_background");
        if (!$bg.length) { return false; }
        // Load narrowest background image based on 
        // viewport width, but never load anything narrower 
        // that what's already loaded if anything.
        var available = [
            // Maybe pull these from an option at some point
            640, 960,
            1024, 1280, // 1366,
            //1400, 1680, 1920,
            //2560, 3840, 4860
        ];

        var current = $bg.attr('src').match(/([0-9]+)/) ? RegExp.$1 : null;
        if (!current || ((current < win_w) && (current < available[available.length - 1]))) {
            var chosen = available[available.length - 1];
            for (var i=0; i<available.length; i++) {
                if (available[i] >= win_w) {
                chosen = available[i];
                break;
            }
        }

        // Set the new image
        var path = $bg.data('path').replace('*', chosen);
            $bg.attr('src', path);
        }

        // Determine whether width or height should be 100%
        // Not tested with all edge-cases
        if ((win_w / win_h) < ($bg.width() / $bg.height())) {
            $bg.css({height: '100%', width: 'auto'});
        } else {
            $bg.css({width: '100%', height: 'auto'});
        }

    }).resize();
});
