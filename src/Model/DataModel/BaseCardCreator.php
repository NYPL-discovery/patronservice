<?php
namespace NYPL\Services\Model\DataModel;

use NYPL\Services\Model\DataModel;
use NYPL\Services\Model\ModelTrait\SierraTrait\CardCreatorCreateTrait;
use NYPL\Starter\Model\ModelTrait\TranslateTrait;

abstract class BaseCardCreator extends DataModel
{
    use TranslateTrait, CardCreatorCreateTrait;
}
