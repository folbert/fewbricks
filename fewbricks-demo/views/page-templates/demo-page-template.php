<html>
<head>
    <title>Fewbricks Demo Page</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

</head>

<body class="fewbricks-demo">

<div class="container">
    <div class="row">
        <div class="col-sm-6">

            <?php
            echo (new FewbricksDemo\Bricks\HeadlineAndText('headline_and_text_1'))->get_layouted_html();
            ?>

        </div>

        <div class="col-sm-6">

            <?php
            echo (new \App\FewbricksDemo\Bricks\HeadlineAndText('headline_and_text_2'))->get_layouted_html();
            ?>

        </div>

    </div>
</div>

</body>
</html>
