<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loading Page</title>
    <link rel="stylesheet" href="main.css">
</head>
<body>
        <div class="content">
            <div class="loading">
                <p>Processing</p>
                <span></span>
            </div>


            <?php
            function redirect($url)
            {
                echo <<<HTML
                <script> window.top.location.href = "{$url}";</script>
                HTML;
            
                echo <<<HTML
              <script> window.opener.location.href="{$url}";
                    self.close();</script>
            HTML;
            
            
            }
            function redirect_back_with_message($message)
            {
                redirect("https://carplus.co.uk/quote/?message=" . $message);
                // header("Location: https://carplus.co.uk/quote/?message=" . $message);
                exit();
            }
            if (empty($_GET)){
                $user_id = "";
                redirect_back_with_message("ID not received!");
            }
            else{
                $user_id = trim($_GET['acref']);
            }

            ?>

            <iframe src="/process/?acref=<?=$user_id?>" style="display: none" hidden>

            </iframe>
        </div>
</body>
</html>
