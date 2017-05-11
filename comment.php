<?php
    if(isset($_POST['message']))
    {
        if($_POST['message'] != "" and !ctype_space($_POST['message']))
        {
            $name = "";
            $message = $_POST['message'];
            $message = htmlentities(strip_tags($message));

            if(isset($_POST['name']))
            {
                if($_POST['name'] != "")
                {
                    $name = $_POST['name'];
                    $name = htmlentities(strip_tags($name));
                }
            }

            if(file_exists("comments.json"))
            {
                $commentsjson = file_get_contents("comments.json");
                $comments = json_decode($commentsjson, true);
                $id = count($comments);

                $comments["$id"]['name'] = $name;
                $comments["$id"]['message'] = $message;
                $comments["$id"]['timestamp'] = time();

                $file = fopen("comments.json", "w");
                fwrite($file, json_encode($comments));
                fclose($file);
            }
            else
            {
                $comments["0"]['name'] = $name;
                $comments["0"]['message'] = $message;
                $comments["0"]['timestamp'] = time();

                $file = fopen("comments.json", "w");
                fwrite($file, json_encode($comments));
                fclose($file);
            }
        }
    }
?>
