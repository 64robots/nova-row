<?php

namespace R64\NovaRow;

use Laravel\Nova\Fields\Field;
use R64\NovaFields\Configurable;

class Row extends Field
{
    use Configurable;
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'nova-row';

    /**
     * Indicates if the element should be shown on the index view.
     *
     * @var bool
     */
    public $showOnIndex = false;

    /**
     * The child fields.
     *
     * @var array
     */
    public $fields = [];

    /**
     * Create a new JSON field.
     *
     * @param  string  $name
     * @param  string|null  $attribute
     * @param  mixed|null  $resolveCallback
     * @return void
     */
    public function __construct($name, $fields, $attribute = null, $resolveCallback = null)
    {
        parent::__construct($name, $attribute, $resolveCallback);

        $this->withMeta(['fields' => $fields]);
    }

    /**
     * Indicate that the heading should be hidden.
     *
     * @return $this
     */
    public function hideHeading()
    {
        return $this->withMeta(['hideHeading' => true]);
    }
}
