<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class VoyageControllerTest extends WebTestCase
{
    /**
     * Click du lien new depuis la page index
     */
    public function testClickNewLinkFromIndex(): void
    {
        $client = static::createClient();

        $client->request('GET', '/');
        $this->assertResponseIsSuccessful();

        $client->clickLink('Create new');
        $this->assertResponseIsSuccessful();
    }

    /**
     * Click du lien index depuis la page new
     */
    public function testClickIndexLinkFromNew(): void
    {
        $client = static::createClient();

        $client->request('GET', '/new');
        $this->assertResponseIsSuccessful();

        $client->clickLink('back to list');
        $this->assertResponseIsSuccessful();
    }

    /**
     * Soumission du formulaire d'edition d'un voyage existant
     */
    public function testSubmitEditForm(): void
    {
        $client = static::createClient();

        $client->request('GET', '/');
        $crawler = $client->clickLink('edit');
        $this->assertResponseIsSuccessful();

        $editForm = $crawler->selectButton('Update')->form();
        $client->followRedirects();
        $client->submit($editForm);
        $this->assertResponseIsSuccessful();
    }
}
