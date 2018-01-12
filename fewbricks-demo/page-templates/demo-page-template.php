<html>
<head>
    <title>Fewbricks Demo Page</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css"
          integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">

</head>

<body class="fewbricks-demo">

<?php
$attributeStringBuilder = (new \Fewbricks\HtmlElementAttributesStringBuilder())
    ->addClassName('container')
    ->addClassName('container-fluid')
    ->removeClassName('container')
    ->addStylePropertyAndValue('background', 'red')
    ->addStylePropertyAndValue('color', 'white')
    ->addStylePropertiesAndValues([
        ['font-size', '2rem'],
        ['color', 'blue'],
        ['padding', '20px'],
    ])
    ->removeStyleProperty('padding')
    ->addStylePropertyAndValue('font-size', '3rem')
    ->addValueToAttribute('value1', 'data-test-1')
    ->addValueToAttribute('value2', 'data-test-1')
    ->addValueToAttribute('value3', 'data-test-1')
    ->setValuesSeparatorsForAttribute('|', 'data-test-1')
    ->removeValueFromAttribute('value3', 'data-test-1')
    ->addValuesToAttribute([
        ['first1', 'first2', 'first3'],
        ['second1', 'second2', 'second3'],
        ['third1', 'third2', 'third3'],
    ], 'data-test-2')
    // + will separate "first1" and "first2" (and "second1" and"second2")
    // - will separate "first2" and "first3" (and "second2" and "second3")
    // * will separate values from each array above ("first3" and "second1")
    ->setValuesSeparatorsForAttribute([' + ', ' - ', ' * '], 'data-test-2')
    ->removeValueFromAttribute(['third1', 'third2', 'third3'], 'data-test-2')
    ->setIdValue('element-id');

echo $attributeStringBuilder;

?>

<div <?php echo $attributeStringBuilder; ?>><div class="row"><div class="col">Lorem ipsum</div></div></div>


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
