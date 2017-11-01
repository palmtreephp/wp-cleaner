<?php

namespace Palmtree\WordPress\Cleaner;

class HeadCleaner
{
    protected $callbacks = [
        'wp_head' => [
            'wp_generator'         => 10,
            'rsd_link'             => 10,
            'wlwmanifest_link'     => 10,
            'wp_shortlink_wp_head' => 10,
        ],
    ];

    public function __construct(array $callbacks = [])
    {
        add_filter('feed_links_show_comments_feed', '__return_false');
    }

    public function clean()
    {
        foreach ($this->getCallbacks() as $action => $callbacks) {
            foreach ($callbacks as $callback => $priority) {
                remove_action($action, $callback, $priority);
            }
        }
    }

    /**
     * @return array
     */
    public function getCallbacks()
    {
        return $this->callbacks;
    }

    /**
     * @param array $callbacks
     * @return HeadCleaner
     */
    public function setCallbacks(array $callbacks)
    {
        $this->callbacks = $callbacks;
        return $this;
    }

    public function addCallback($action, $callback, $priority)
    {
        $this->callbacks[$action][$callback] = $priority;
    }
}
