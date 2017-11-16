<?php

namespace App\Fewbricks\EditScreens;

use Fewbricks\EditScreen;

class _EditScreenBoilerplate extends EditScreen
{

    /**
     * @var array Location rules. Corresponds to the "Location" settings
     *            when you create a field group in the ACF GUI.
     *            These can be a bit complicated, so I suggest that you
     *            create a field group in the UI, set the rules you want
     *            there ane then use ACFs export functionality to render
     *            the PHP code and then copy the location array here.
     */
    protected $location = [];

}
