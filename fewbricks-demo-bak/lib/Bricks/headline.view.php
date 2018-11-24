<?php

$tag = 'h' . \Fewbricks\Helper::getValueFromArray($data, 'level', 2);

if(false !== ($badgeHtml = \Fewbricks\Helper::getValueFromArray($data, 'badgeHtml', false))) {
    $badgeHtml = ' ' . $badgeHtml;
}

echo '<' . $tag . '>' . $data['text'] . $badgeHtml . '</' . $tag . '>';



