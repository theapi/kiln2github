<?php

namespace kiln2github\Command\Kiln;

use kiln2github\Kiln\ClientFactory;
use kiln2github\Kiln\Projects;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ReposList extends Command {

  protected function configure() {
    $this
      ->setName('kiln:repos')
      ->setDescription('Lists repos on Kiln.')
      ->setHelp('Gets the lists of repos from Kiln.')
      ->addArgument('token', InputArgument::REQUIRED, 'The Kiln access token.')
    ;
  }

  protected function execute(InputInterface $input, OutputInterface $output) {
    $output->writeln('Token: ' . $input->getArgument('token'));

    $client = ClientFactory::get($input->getArgument('token'), 'Project');
    $response = $client->request('GET', '');
    $output->writeln('Response code: ' . (string)$response->getStatusCode());

    $projects = new Projects();
    $projects->setResponse((string)$response->getBody());
    $output->writeln(json_encode($projects->getRepos()));
  }
}
