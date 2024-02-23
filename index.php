<?php
    require_once 'simplehtmldom_1_9_1/simple_html_dom.php';
    $dom = file_get_html('https://mashable.com/', false);

    //https://mashable.com/?ajax=1&page=994
    $answer = array();
    if(!empty($dom)) 
    {
        $link = $divClass = $title = '';

        foreach($dom->find(".w-full") as $divClass) 
        {
            $titleElement = $divClass->find('a[class*="header-500"][href^="/article/"]', 0);

            if ($titleElement) 
            {
                $title = trim($titleElement->innertext);
                $link = $titleElement->href;

                $dateElement = $divClass->find('.subtitle-1', 0);
                $date = '';
                if ($dateElement) 
                {
                    $date = trim($dateElement->datetime);
                }

                $answer[] = ['title' => $title, 'link' => $link, 'date' => $date];
            }
        }
    }
    array_shift($answer);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Title Aggregator</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
            flex-direction: column; 
        }

        h1 {
            margin-bottom: 10px; 
        }

        table {
            border-collapse: collapse;
            width: 20%;
            margin-top: 10px; 
            margin-bottom: 10px; 
        }

        table, th, td {
            border: 1px solid black;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }
    </style>
</head>
<body>
    <table>
        <thead>
            <tr>
                <th>Title</th>
                <th>Link</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            <?php 
                foreach ($answer as $ans)
                {
            ?>
                <tr>
                    <td> <?php echo $ans['title']; ?> </td>
                    <td> <a href="<?php echo 'https://mashable.com'.$ans['link']; ?>"><?php echo $ans['link']; ?></a> </td>
                    <td> <?php echo $ans['date']; ?> </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</body>
</html>