<?php

namespace eXpansion\Bundle\Acme\Plugins\Gui;

use eXpansion\Bundle\Acme\Plugins\Test;
use eXpansion\Framework\Core\Helpers\Translations;
use eXpansion\Framework\Core\Model\Gui\ManialinkInterface;
use eXpansion\Framework\Core\Model\Gui\Widget;
use eXpansion\Framework\Core\Plugins\Gui\ActionFactory;
use eXpansion\Framework\Core\Plugins\Gui\WidgetFactory;
use eXpansion\Framework\Core\Plugins\Gui\WindowFactory as BaseWindowFactory;
use eXpansion\Framework\Core\Plugins\GuiHandler;
use eXpansion\Framework\Core\Plugins\UserGroups\Factory;
use eXpansion\Framework\Gui\Components\uiButton;
use eXpansion\Framework\Gui\Components\uiCheckbox;
use eXpansion\Framework\Gui\Components\uiDropdown;
use eXpansion\Framework\Gui\Components\uiLabel;
use eXpansion\Framework\Gui\Components\uiLine;
use eXpansion\Framework\Gui\Components\uiTooltip;
use eXpansion\Framework\Gui\Layouts\layoutLine;
use eXpansion\Framework\Gui\Layouts\layoutRow;
use FML\Controls\Label;

class MemoryWidgetFactory extends WidgetFactory
{
    /** @var  Label */
    protected $memoryMessage;


    protected function createContent(ManialinkInterface $manialink)
    {
        parent::createContent($manialink);
        $this->memoryMessage = new Label();
        $this->memoryMessage->setTextPrefix('$s')->setText("waiting data...");

        $manialink->getContentFrame()->setScale(0.8)->setPosition(160, -130);
        $manialink->addChild($this->memoryMessage);

    }

    protected function updateContent(ManialinkInterface $manialink)
    {
        parent::updateContent($manialink); // TODO: Change the autogenerated stub
        $this->memoryMessage->setText(Test::$memoryMsg);
    }

}
