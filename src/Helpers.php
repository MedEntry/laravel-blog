<?php

namespace BinshopsBlog;

use Session;

/**
 * Class Helpers
 */
class Helpers
{
    /**
     * What key to use for the session::flash / pull / has
     */
    const string FLASH_MESSAGE_SESSION_KEY = 'BINSHOPS_FLASH';

    /**
     * Set a new message
     */
    public static function flash_message(string $message): void
    {
        Session::flash(self::FLASH_MESSAGE_SESSION_KEY, $message);
    }

    /**
     * Is there a flashed message?
     */
    public static function has_flashed_message(): bool
    {
        return Session::has(self::FLASH_MESSAGE_SESSION_KEY);
    }

    /**
     * return the flashed message. Use with ::has_flashed_message() if you need to check if it has a value...
     */
    public static function pull_flashed_message(): string
    {
        return Session::pull(self::FLASH_MESSAGE_SESSION_KEY);
    }

    /**
     * Use this (Helpers::rss_html_tag()) in your blade/template files, within <head>
     * to auto insert the links to rss feed
     */
    public static function rss_html_tag(): string
    {

        return '<link rel="alternate" type="application/atom+xml" title="Atom RSS Feed" href="'.e(route('binshopsblog.feed')).'?type=atom" />
  <link rel="alternate" type="application/rss+xml" title="XML RSS Feed" href="'.e(route('binshopsblog.feed')).'?type=rss" />
  ';

    }

    /**
     * This method is depreciated. Just use the config() directly.
     *
     * @deprecated
     */
    public static function image_sizes(): array
    {
        return config('binshopsblog.image_sizes');
    }
}
