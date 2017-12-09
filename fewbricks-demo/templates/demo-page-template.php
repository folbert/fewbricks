<html>
<head>
    <title>Fewbricks Demo Page</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css"
          integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">

</head>


<body class="fewbricks-demo">

<?php
while (have_posts()) {

    the_post();

}

?>

</body>
</html>
