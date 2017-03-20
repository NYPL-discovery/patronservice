<?php
namespace NYPL\Services\Model\DataModel;

use NYPL\Services\Model\DataModel;
use NYPL\Starter\Model\ModelTrait\TranslateTrait;

abstract class BaseCardCreatorRequest extends DataModel
{
    use TranslateTrait;
}
