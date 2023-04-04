<?php


namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use App\Entity\Fruit;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpClient\Response;
use App\Controller\MailerController;



class GetFruitsCommand extends Command
{
    const ENDPOINT = 'https://fruityvice.com/api/fruit/';

    protected static $defaultName = 'fruits:get-fruits';
    protected static $defaultDescription = 'Get Fruits from https://fruityvice.com/ and save in DB';
    public EntityManagerInterface $entityManager;
    public MailerController $mailerController;

    public function __construct(private HttpClientInterface $client, EntityManagerInterface $entityManager, MailerController $mailerController)
    {
        $this->entityManager = $entityManager;
        $this->mailerController = $mailerController;
        parent::__construct();
    }

    /**
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     * @throws \Symfony\Component\Mailer\Exception\TransportExceptionInterface
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $response = $this->client->request(
          'GET',
          self::ENDPOINT.'all'
        );
        $statusCode = $response->getStatusCode();
        if($statusCode == 200) {
            $this->entityManager->createQuery("DELETE FROM App\Entity\Fruit")->execute();
            $output->writeln('Table data was deleted');
            $content = $response->toArray();

            foreach ($content as $key => $item) {
                $fruit = new Fruit();
                $fruit->setName($item['name']);
                $fruit->setGenus($item['genus']);
                $fruit->setApiId($item['id']);
                $fruit->setFamily($item['family']);
                $fruit->setApiOrder($item['order']);
                $fruit->setCarbohydrates($item['nutritions']['carbohydrates']);
                $fruit->setProtein($item['nutritions']['protein']);
                $fruit->setFat($item['nutritions']['fat']);
                $fruit->setCalories($item['nutritions']['calories']);
                $fruit->setSugar($item['nutritions']['sugar']);
                $this->entityManager->persist($fruit);
                $this->entityManager->flush();

                $output->writeln('Saved new fruit con id: ' . $fruit->getId());
            }
            $this->mailerController->sendEmail();
            return Command::SUCCESS;
        }
        else{
            $output->writeln('API request error. Status code: '.$statusCode);
            return Command::FAILURE;
        }
    }

}