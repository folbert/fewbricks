<?php

namespace App\FewbricksDemo\Bricks;

use App\FewbricksDemo\ProjectBrick;
use Fewbricks\ACF\Fields\Select;
use Fewbricks\ACF\Fields\Text;

/**
 * Class Badge
 *
 * @package App\FewbricksDemo\Bricks
 */
class Badge extends ProjectBrick
{

    protected $name = 'Badge';

    /**
     * @return string
     */
    public function getBrickHtml()
    {

        $viewData = $this->getViewData();

        if (!empty($viewData)) {
            $outcome = $this->getBrickTemplateHtml($this->getViewData());
        } else {
            $outcome = '';
        }

        return $outcome;

    }

    /**
     * @return array
     */
    private function getViewData()
    {

        $viewData = $this->getFieldValues([
            'text',
            'modifier',
        ]);

        if(empty($viewData['modifier'])) {
            $viewData['modifier'] = 'primary';
        }

        return $viewData;

    }

    /**
     *
     */
    public function setFields()
    {

        $this->addField(new Text('Text', 'text', '1801082330a'));

        if ($this->getArgument('modifier', false) !== false) {

            $this->addModifierField();

        }

    }

    public function addModifierField()
    {

        $choices = $this->getArgument('modifier_choices', [
            'primary'   => 'Primary',
            'secondary' => 'Secondary',
            'success'   => 'Success',
            'danger'    => 'Danger',
            'warning'   => 'Warning',
            'info'      => 'Info',
            'light'     => 'Light',
            'dark'      => 'Dark',
        ]);

        $this->addField(
            (new Select('Style', 'modifier', '1801082334a'))
                ->setChoices($choices)
        );

    }

}
