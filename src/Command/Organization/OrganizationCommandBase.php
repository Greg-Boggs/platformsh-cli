<?php

namespace Platformsh\Cli\Command\Organization;

use Platformsh\Cli\Command\CommandBase;
use Platformsh\Client\Model\Organization\Member;
use Symfony\Component\Console\Input\InputInterface;

class OrganizationCommandBase extends CommandBase
{
    public function isEnabled()
    {
        if (!$this->config()->getWithDefault('api.organizations', false)) {
            return false;
        }
        return parent::isEnabled();
    }

    protected function memberLabel(Member $member)
    {
        if ($info = $member->getUserInfo()) {
            return $info->email;
        }

        return $member->id;
    }

    /**
     * Returns an example of another organization command, on this organization, for use in help messages.
     *
     * The current input needs to have been validated already (e.g. the --org option).
     *
     * Arguments will not be escaped (pre-escape them, or ideally only use args that do not use escaping).
     *
     * @param InputInterface $input
     * @param string $commandName
     * @param string $otherArgs
     *
     * @return string
     */
    protected function otherCommandExample(InputInterface $input, $commandName, $otherArgs = '')
    {
        $args = [
            $this->config()->get('application.executable'),
            $commandName,
        ];
        if ($input->hasOption('org') && $input->getOption('org')) {
            $args[] = '--org ' . $input->getOption('org');
        }
        if ($otherArgs !== '') {
            $args[] = $otherArgs;
        }
        return \implode(' ', $args);
    }
}
