<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ArticleControllerTest extends WebTestCase
{
    public function testSomething(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/recent-articles');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Recent articles');
    }

    public function testCommentForm()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/articles/1');
        $this->assertResponseIsSuccessful();
        $buttonCrawlerNode = $crawler->selectButton('comment_submit');
        $form = $buttonCrawlerNode->form();
        $form['comment[content]'] = 'Test comment';
        $client->submit($form);
        $crawler = $client->followRedirect();
        $this->assertCount(1, $crawler->filter('ul#comments li'));
        $this->assertEquals('Test comment', $crawler->filter('ul#comments li')->first()->text());
    }
}
