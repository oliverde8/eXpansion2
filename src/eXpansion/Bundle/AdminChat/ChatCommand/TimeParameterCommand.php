<?php

namespace eXpansion\Bundle\AdminChat\ChatCommand;

use eXpansion\Framework\AdminGroups\Helpers\AdminGroups;
use eXpansion\Framework\Core\Helpers\ChatNotification;
use eXpansion\Framework\Core\Storage\PlayerStorage;
use Maniaplanet\DedicatedServer\Connection;
use Monolog\Logger;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;

/**
 * Class ReasonUserCommand
 *
 * @author  Reaby
 * @package eXpansion\Bundle\AdminChat\ChatCommand
 */
class TimeParameterCommand extends AbstractConnectionCommand
{
    /**
     * Description of the parameter
     *
     * @var string
     */
    protected $parameterDescription;

    /**
     * Description of the command.
     *
     * @var string
     */
    protected $description;

    /**
     * Message to display in chat.
     *
     * @var string
     */
    protected $chatMessage;

    /**
     * Name of the dedicated function to call.
     *
     * @var string
     */
    protected $functionName;

    /**
     * @inheritdoc
     */
    protected function configure()
    {
        parent::configure();

        $this->inputDefinition->addArgument(
            new InputArgument('parameter', InputArgument::REQUIRED, $this->parameterDescription)
        );
    }

    /**
     * @inheritdoc
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @inheritdoc
     */
    public function execute($login, InputInterface $input)
    {
        $nickName = $this->playerStorage->getPlayerInfo($login)->getNickName();
        $parameter = $this->timeHelper->textToTime($input->getArgument('parameter'));
        $group = $this->getGroupLabel($login);

        $this->chatNotification->sendMessage(
            $this->chatMessage,
            $this->isPublic ? null : $login,
            ['%adminLevel%' => $group, '%admin%' => $nickName, "%parameter%" => $parameter]
        );

        $this->connection->{$this->functionName}($parameter);
    }

    /**
     * @param string $parameterDescription
     */
    public function setParameterDescription($parameterDescription)
    {
        $this->parameterDescription = $parameterDescription;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @param string $chatMessage
     */
    public function setChatMessage($chatMessage)
    {
        $this->chatMessage = $chatMessage;
    }

    /**
     * @param string $functionName
     */
    public function setFunctionName($functionName)
    {
        $this->functionName = $functionName;
    }

    public function validate($login, $parameter)
    {
        print_r($parameter);

        return parent::validate($login, $parameter); // TODO: Change the autogenerated stub
    }
}
