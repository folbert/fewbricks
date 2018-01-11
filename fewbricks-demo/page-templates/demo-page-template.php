<html>
<head>
    <title>Fewbricks Demo Page</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css"
          integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">

</head>


<body class="fewbricks-demo">

<?php
$attributeStringBuilder = new \Fewbricks\HtmlElementAttributesStringBuilder();

$attributeStringBuilder->addClassName('container');
$attributeStringBuilder->addClassName('container-fluid');
$attributeStringBuilder->removeClassName('container');

$attributeStringBuilder->addStylePropertyAndValue('background', 'red');
$attributeStringBuilder->addStylePropertyAndValue('color', 'white');
$attributeStringBuilder->addStylePropertiesAndValues([
    ['font-size', '2rem'],
    ['color', 'blue'],
]);
$attributeStringBuilder->removeStylePropertyAndValue('color');

$attributeStringBuilder->addValue('data-test-1', 'value1');
$attributeStringBuilder->addValue('data-test-1', 'value2');
$attributeStringBuilder->addValue('data-test-1', 'value3');
$attributeStringBuilder->setValuesSeparators('data-test-1', '|');
$attributeStringBuilder->removeValue('data-test-1', 'value3');

$attributeStringBuilder->addValues('data-test-2', [
    ['first1', 'first2', 'first3'],
    ['second1', 'second2', 'second3'],
    ['third1', 'third2', 'third3'],
]);
// + will separate values from each array above ("first3" and "second1")
// - will separate "first1" and "first2" (and "second1" and"second2")
// * will separate "first2" and "first3" (and "second2" and "second3")
$attributeStringBuilder->setValuesSeparators('data-test-2', [' + ', ' - ', ' * ']);
$attributeStringBuilder->removeValue('data-test-2', ['third1', 'third2', 'third3']);

echo $attributeStringBuilder;

?>

<div <?php echo $attributeStringBuilder; ?>>Lorem ipsum</div>


<div class="container">
    <div class="row">
        <div class="col-sm-6">

            <?php
            echo (new \App\FewbricksDemo\Bricks\HeadlineAndText('headline_and_text_1'))->getHtml();
            ?>

        </div>

        <div class="col-sm-6">

            <?php
            echo (new \App\FewbricksDemo\Bricks\HeadlineAndText('headline_and_text_2'))->getHtml();
            ?>

        </div>

    </div>
</div>

</body>
</html>
