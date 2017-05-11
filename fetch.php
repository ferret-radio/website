<?php
    session_name("ferretradio_cookie");
    if(!isset($_SESSION))
    {
        session_start();
    }
    
    if(isset($_SESSION['timezone']))
    {
        date_default_timezone_set($_SESSION['timezone']);
    }
    else
    {
        date_default_timezone_set("Europe/London");
    }
    
    // This script will simpy fetch and parse our JSON feed
    $feed['json'] = file_get_contents('https://control.internet-radio.com:2199/recentfeed/ferretradio/json/');
    $feed['parsed'] = json_decode($feed['json'], true);

    // THIS IS A TEST ONLY, SO YOU CAN SEE IT HAS UPDATED, FEEL FREE TO REMOVE
    if(isset($_GET['np']))
    {
        echo("<p>Now Playing: ".$feed['parsed']['items'][0]['title']."</p>");
    }
    else if(isset($_GET['comments']))
    {
        if(file_exists("comments.json"))
        {
            $commentsjson = file_get_contents("comments.json");
            $comments = json_decode($commentsjson, true);

            if(count($comments) < 1)
            {
                echo("No comments, yet");
            }
            else
            {
                if(count($comments) < 15)
                    $limit = count($comments);
                else
                    $limit = 15;

                for($i = (count($comments)-1); $i >= 0; $i--)
                {
                    if($limit == 0)
                    {
                        break;
                    }

                    $limit--;
                    echo("<p style='border-bottom: 1px solid #e1e1e1'>");
                    
                    if(isset($comments[$i]['timestamp']))
                    {
                        // Since this is being added and comments are already in the live comments.json, check if it is-set
                        echo("<em>".date("h:i", $comments[$i]['timestamp'])."</em> - ");
                    }
                    
                    if($comments[$i]['name'] != "")
                    {
                        echo("<em><strong>".$comments[$i]['name']."</strong></em> : ");
                    }
                    else
                    {
                        echo("<em><strong>Anonymous</strong></em> : ");
                    }
                    echo($comments[$i]['message']);
                    echo("</p>");
                }
            }
        }
    }
    else
    {
        echo("<p style='margin:0;'>Recently Played:<div style='font-size:9px;'>Last Updated: ".date("h:i:s", time())."</div></p><ul>");

        // For recently played tracks, we're only interested in the "items" JSON feed.
        foreach($feed['parsed']['items'] as $item)
        {
            /***
            * The PHP has been formatted in this way so you can easilly see the colour-coding of HTML in an editor
            *
            * In here, you can edit the styling of the <p> tag, it will inherit anything in your CSS since this is echoed back
            * and then shown in the HTML of listen.html, seamlessly, like this script never existed.
            * Also within this file, you can print out the other data included in the feed such as:
            * - $item['link'] (I guess this is a link to the song)
            * - $item['date'] (Date played or released? You can use date("h:s i", $item['date']); to print out a friendly timestamp)
            * - $item['enclosure']['url'] (I think this links to album art)
            ***/
            ?>
            <li><?php echo($item['title']); ?></li>
            <?php
        }
        echo("</ul>");
    }
?>
