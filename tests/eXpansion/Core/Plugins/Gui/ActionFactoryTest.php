<?php

namespace Tests\eXpansion\Core\Plugins\Gui;

use eXpansion\Core\Plugins\Gui\ActionFactory;
use Tests\eXpansion\Core\TestCore;
use Tests\eXpansion\Core\TestHelpers\ManialinkDataTrait;


class ActionFactoryTest extends TestCore
{
    use ManialinkDataTrait;

    protected $called = false;

    public function testAction()
    {
        $manialink = $this->getManialink(['test1']);

        /** @var ActionFactory $actionFactory */
        $actionFactory = $this->container->get('expansion.core.plugins.gui.action_factory');
        $actionId = $actionFactory->createManialinkAction($manialink, array($this, 'actionCall'), ['testParam']);
        $actionFactory->onPlayerManialinkPageAnswer('test1', $actionId, ['entry' => 'value1']);

        $this->assertTrue($this->called);
    }

    public function testDestroy()
    {
        $manialink = $this->getManialink(['test1']);

        /** @var ActionFactory $actionFactory */
        $actionFactory = $this->container->get('expansion.core.plugins.gui.action_factory');
        $actionId = $actionFactory->createManialinkAction($manialink, array($this, 'actionCall'), ['testParam']);
        $actionFactory->destroyManialinkActions($manialink);
        $actionFactory->onPlayerManialinkPageAnswer('test1', $actionId, ['entry' => 'value1']);

        $this->assertFalse($this->called);
    }

    public function actionCall($login, $answerValues, $arguments)
    {
        $this->called = true;

        $this->assertEquals('test1', $login);
        $this->assertEquals(['entry' => 'value1'], $answerValues);
        $this->assertEquals(['testParam'], $arguments);
    }

}
