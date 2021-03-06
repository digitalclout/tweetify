<?php
/*
 * tweetify.php
 *
 * Ported from Remy Sharp's 'ify' javascript function; see:
 * http://code.google.com/p/twitterjs/source/browse/trunk/src/ify.js
 *
 * Based on revision 46:
 * http://code.google.com/p/twitterjs/source/detail?spec=svn46&r=46
 *
 * Forked from https://github.com/fiveminuteargument/tweetify
 */


/*
 * Clean a tweet: translate links, usernames beginning '@', and hashtags
 */
function clean_tweet($tweet)
{
        $regexps = array
        (
                "link"  => '/[a-z]+:\/\/[a-z0-9-_]+\.[a-z0-9-_@:~%&\?\+#\/.=]+[^:\.,\)\s*$]/i',
                "at"    => '/(^|[^\w]+)\@([a-zA-Z0-9_]{1,15}(\/[a-zA-Z0-9-_]+)*)/',
                "hash"  => "/(^|[^&\w'\"]+)\#([a-zA-Z0-9_]+)/"
        );

        foreach ($regexps as $name => $re)
        {
                $tweet = preg_replace_callback($re, 'parse_tweet_'.$name, $tweet);
        }

        return $tweet;
}

/*
 * Wrap a link element around URLs matched via preg_replace()
 */
function parse_tweet_link($m)
{
        return '<a target="_blank" class="ital_link" href="'.$m[0].'">'.((strlen($m[0]) > 25) ? substr($m[0], 0, 24).'...' : $m[0]).'</a>';
}

/*
 * Wrap a link element around usernames matched via preg_replace()
 */
function parse_tweet_at($m)
{
        return $m[1].'@<a target="_blank" class="ital_link" href="http://twitter.com/'.$m[2].'">'.$m[2].'</a>';
}

/*
 * Wrap a link element around hashtags matched via preg_replace()
 */
function parse_tweet_hash($m)
{
        return $m[1].'#<a target="_blank" class="ital_link" href="https://twitter.com/search?q=%23'.$m[2].'">'.$m[2].'</a>';
}
?>
