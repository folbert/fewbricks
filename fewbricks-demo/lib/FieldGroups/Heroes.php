<?php

namespace App\FewbricksDemo\FieldGroups;

use App\FewbricksDemo\SharedFields\Background;
use App\FewbricksDemo\SharedFields\BackgroundColors;
use Fewbricks\ACF\FieldGroup;
use Fewbricks\ACF\Fields\FlexibleContent;
use Fewbricks\ACF\Fields\Layout;
use Fewbricks\ACF\Fields\Message;

class Heroes extends FieldGroup
{

    protected $title = 'Heroes';

    /**
     * @return mixed|void
     * @throws \Fewbricks\KeyInUseException
     */
    public function build()
    {

        $flexibleContent = new FlexibleContent('Heroes', 'heroes', '1712262158a');

        $flexibleContent->addLayout(
            (new Layout('Hero Type 1', 'hero_type_1', '1712262159i'))
            ->addSubFields(new BackgroundColors())
        );

        $flexibleContent->addLayout(
            (new Layout('Hero Type 2', 'hero_type_2', '1712262159t'))
                ->addSubField(
                    (new Message('Message', 'message', '1712262215r'))
                    ->setMessage('Lorem ipsum dolor')
                )
                ->addSubFields(new Background())
        );

        $flexibleContent->setMin(1);
        $flexibleContent->setMax(3);

        $this->addField($flexibleContent);

    }

}
