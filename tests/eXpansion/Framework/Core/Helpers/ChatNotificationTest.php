<?php
/**
 * Created by PhpStorm.
 * User: olive
 * Date: 13/05/2017
 * Time: 11:02
 */

namespace Tests\eXpansion\Framework\Core\Helpers;

use eXpansion\Framework\Core\Helpers\ChatNotification;
use eXpansion\Framework\Core\Storage\Data\Player;
use Tests\eXpansion\Framework\Core\TestCore;

class ChatNotificationTest extends TestCore
{
    public function testSendMessageLogin() {

        $colorCodes = $this->container->getParameter('expansion.config.core_chat_color_codes');
        $colorCode = $colorCodes['test'];

        $dedicatedConnection = $this->container->get('expansion.service.dedicated_connection');
        $dedicatedConnection->expects($this->once())
            ->method('chatSendServerMessage')
            ->with('$z' . $colorCode . 'This is a test translation : Toto', 'toto');

        $player = new Player();
        $player->merge(['language' => 'en']);
        $this->container->set('expansion.storage.player', $this->getMockPlayerStorage($player));

        $chatNotification = $this->getChatNotificationHelper();
        $chatNotification->sendMessage('expansion_core.test_color', 'toto', ['%test%' => 'Toto']);
    }

    public function testSendMessageToAll() {

        $colorCodes = $this->container->getParameter('expansion.config.core_chat_color_codes');
        $colorCode = $colorCodes['test'];

        $translate = [
            0 => ['Lang' => 'fr', 'Text' => '$z' . $colorCode . 'Ceci est une trad de test : Toto'],
            1 => ['Lang' => 'de', 'Text' => '$z' . $colorCode . 'This is a test translation : Toto'],
            2 => ['Lang' => 'fi', 'Text' => '$z' . $colorCode . 'Tämä on testikäännös : Toto'],
            3 => ['Lang' => 'nl', 'Text' => '$z' . $colorCode . 'This is a test translation : Toto'],
            4 => ['Lang' => 'en', 'Text' => '$z' . $colorCode . 'This is a test translation : Toto'],
        ];

        $dedicatedConnection = $this->container->get('expansion.service.dedicated_connection');
        $dedicatedConnection->expects($this->once())
            ->method('chatSendServerMessage')
            ->with($translate, null);

        $player = new Player();
        $player->merge(['language' => 'en']);
        $this->container->set('expansion.storage.player', $this->getMockPlayerStorage($player));

        $chatNotification = $this->getChatNotificationHelper();
        $chatNotification->sendMessage('expansion_core.test_color', null, ['%test%' => 'Toto']);
    }


    /**
     * @return ChatNotification
     */
    protected function getChatNotificationHelper()
    {
        return $this->container->get('expansion.helper.chat_notification');
    }
}
