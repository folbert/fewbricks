<?php

namespace App\FewbricksDemo\FieldGroups;

use App\FewbricksDemo\SharedFields\Background;
use App\FewbricksDemo\SharedFields\BackgroundColors;
use Fewbricks\ACF\FieldGroup;
use Fewbricks\ACF\Fields\FlexibleContent;
use Fewbricks\ACF\Fields\Layout;
use Fewbricks\ACF\Fields\Message;
use Fewbricks\ACF\Fields\Text;

class Heroes extends FieldGroup
{

    /**
     * Heroes constructor.
     *
     * @param string $key
     * @param array  $settings
     * @param array  $arguments
     */
    public function __construct($key, array $settings = [], array $arguments = [])
    {
        parent::__construct('Heroes', $key, $settings, $arguments);
    }

    /**
     * @return mixed|void
     */
    public function build()
    {

        $flexibleContent = (new FlexibleContent('Heroes', 'heroes', '1712262158a'))
            ->setMin(1)
            ->setMax(3)
            ->setButtonLabel('Add hero');

        $flexibleContent->addLayout(
            (new Layout('Hero Type 1', 'hero_type_1', 'l1712262159i'))
                ->addFieldCollection(new BackgroundColors())
        );

        $flexibleContent->addLayout(
            (new Layout('Hero Type 2', 'hero_type_2', 'l1712262159t'))
                ->addField(
                    (new Message('Message', 'message', '1712262215r'))
                        ->setMessage('Lorem ipsum dolor')
                )
                ->addFieldCollection(new Background())
                ->addFieldBeforeByName(new Text('Headline', 'headline', '1712272054a'), 'message')
        );

        $this->addField($flexibleContent);

    }

}
