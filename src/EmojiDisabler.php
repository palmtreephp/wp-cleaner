<?php

namespace Palmtree\WordPress\Cleaner;

class EmojiDisabler
{
    public function __construct()
    {
        remove_action('wp_head', 'print_emoji_detection_script', 7);
        remove_action('admin_print_scripts', 'print_emoji_detection_script');

        remove_action('wp_print_styles', 'print_emoji_styles');
        remove_action('admin_print_styles', 'print_emoji_styles');

        remove_filter('the_content_feed', 'wp_staticize_emoji');
        remove_filter('comment_text_rss', 'wp_staticize_emoji');

        remove_filter('wp_mail', 'wp_staticize_emoji_for_email');

        add_filter('tiny_mce_plugins', [$this, 'filterTinyMcePlugins']);
    }

    /**
     * Callback for the 'tiny_mce_plugins' filter.
     */
    public function filterTinyMcePlugins($plugins)
    {
        if (!is_array($plugins)) {
            return [];
        }

        return array_diff($plugins, ['wpemoji']);
    }
}
