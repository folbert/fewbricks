<?php

$tag = 'h' . \Fewbricks\Helpers\Helper::getValueFromArray($data, 'level', 2);

if(false !== ($badgeHtml = \Fewbricks\Helpers\Helper::getValueFromArray($data, 'badgeHtml', false))) {
    $badgeHtml = ' ' . $badgeHtml;
}

echo '<' . $tag . '>' . $data['text'] . $badgeHtml . '</' . $tag . '>';



