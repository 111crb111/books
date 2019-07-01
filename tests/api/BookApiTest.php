<?php

namespace App\Tests;

use App\Entity\Book;
use Hautelook\AliceBundle\PhpUnit\RefreshDatabaseTrait;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class BookApiTest extends WebTestCase
{
    use RefreshDatabaseTrait;

    /** @var KernelBrowser */
    protected $client;

    /**
     * Creates a book.
     */
    public function testCreateABook(): void
    {
        $data = [
            'name' => 'Harry Potter and the Philosopher\'s Stone',
            'publisher' => 'Bloomsbury (UK) (Canada 2010–present)',
            'author' => 'J. K. Rowling',
            'genre' => 'Fantasy',
            'publishYear' => 1997,
            'words' => 76944,
            'price' => 27,
        ];

        $response = $this->request('POST', 'api/books', $data);
        $json = json_decode($response->getContent(), true);

        $this->assertEquals(201, $response->getStatusCode());
        $this->assertEquals('application/ld+json; charset=utf-8', $response->headers->get('Content-Type'));

        $this->assertArrayHasKey('name', $json);
        $this->assertEquals($data['name'], $json['name']);
    }

    /**
     * Gets a book.
     */
    public function testGetABook(): void
    {
        $response = $this->request('GET', $this->findOneIriBy(Book::class, ['name' => 'book_name_9']));
        $json = json_decode($response->getContent(), true);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('application/ld+json; charset=utf-8', $response->headers->get('Content-Type'));

        $this->assertArrayHasKey('name', $json);
        $this->assertEquals('book_name_9', $json['name']);
    }

    /**
     * Retrieves the book list.
     */
    public function testRetrieveTheBookList(): void
    {
        $response = $this->request('GET', 'api/books');
        $json = json_decode($response->getContent(), true);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('application/ld+json; charset=utf-8', $response->headers->get('Content-Type'));

        $this->assertArrayHasKey('hydra:totalItems', $json);
        $this->assertEquals(10, $json['hydra:totalItems']);
    }

    /**
     * Updates a book.
     */
    public function testUpdateABook(): void
    {
        $newPublisher = 'Arthur A. Levine/Scholastic (US)';
        $data = ['publisher' => $newPublisher];

        $response = $this->request('PUT', $this->findOneIriBy(Book::class, ['name' => 'book_name_9']), $data);
        $json = json_decode($response->getContent(), true);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('application/ld+json; charset=utf-8', $response->headers->get('Content-Type'));

        $this->assertArrayHasKey('publisher', $json);
        $this->assertEquals($newPublisher, $json['publisher']);
    }

    /**
     * Deletes a book.
     */
    public function testDeleteABook(): void
    {
        $response = $this->request('DELETE', $this->findOneIriBy(Book::class, ['name' => 'book_name_8']));

        $this->assertEquals(204, $response->getStatusCode());

        $this->assertEmpty($response->getContent());
    }

    /**
     * Retrieves the documentation.
     */
    public function testRetrieveTheDocumentation(): void
    {
        $response = $this->request('GET', '/api', null, ['Accept' => 'text/html']);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('text/html; charset=UTF-8', $response->headers->get('Content-Type'));

        $this->assertContains('API Platform', $response->getContent());
    }

    protected function setUp()
    {
        parent::setUp();

        $this->client = static::createClient();
    }

    /**
     * @param string|array|null $content
     */
    protected function request(string $method, string $uri, $content = null, array $headers = []): Response
    {
        $server = ['CONTENT_TYPE' => 'application/ld+json', 'HTTP_ACCEPT' => 'application/ld+json'];
        foreach ($headers as $key => $value) {
            if (strtolower($key) === 'content-type') {
                $server['CONTENT_TYPE'] = $value;

                continue;
            }

            $server['HTTP_'.strtoupper(str_replace('-', '_', $key))] = $value;
        }

        if (is_array($content) && false !== preg_match('#^application/(?:.+\+)?json$#', $server['CONTENT_TYPE'])) {
            $content = json_encode($content);
        }

        $this->client->request($method, $uri, [], [], $server, $content);

        return $this->client->getResponse();
    }

    protected function findOneIriBy(string $resourceClass, array $criteria): string
    {
        $resource = static::$container->get('doctrine')->getRepository($resourceClass)->findOneBy($criteria);

        return static::$container->get('api_platform.iri_converter')->getIriFromitem($resource);
    }
}