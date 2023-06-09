<?php

/**
 * Имеется метод getUserData, который получает данные из внешнего API, передавая в запрос необходимые параметры,
 * вместе с ключом (token) идентификации. Необходимо реализовать универсальное решение getSecretKey(),
 * с использованием какого-либо шаблона (pattern) проектирования для хранения этого ключа всевозможными способами:
 * - in file
 * - in DB
 * - in server memоry (redis as example)
 * - in cloud
 * etc.
 * Достаточно реализовать простое решение, которое бы позволяло через параметр
 * (в условной "глобальной конфигурации" / внутри класса данного метода), выбирать любой существующий способ хранения.
 * Перечисленные способы хранения служат лишь примерами для глобального восприятия задачи и не обязательны
 * к реализации, можно ограничиться заглушками.
 */

/**
 * Config.
 */
interface Config
{
    public function put(string $key, string $data);

    public function get(string $key);
}

/**
 * FileConfig.
 */
class FileConfig implements Config
{
    /**
     * @param string $path
     * @param array $data
     */
    public function __construct(protected string $path = __DIR__ . '/config.dat', protected array $data = [])
    {
        /** @noinspection UnserializeExploitsInspection */
        $this->data = unserialize(file_get_contents($this->path));
    }

    /**
     * Setter.
     * @param string $key
     * @param string $data
     * @return void
     */
    public function put(string $key, string $data): void
    {
        $this->data[$key] = $data;
    }

    /**
     * Getter.
     * @param string $key
     * @return mixed|null
     */
    public function get(string $key): mixed
    {
        return $this->data[$key] ?? null;
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        file_put_contents($this->path, serialize($this->data));
    }
}

/**
 * DBConfig.
 */
class DBConfig implements Config
{
    /**
     * Constructor.
     */
    public function __construct()
    {
    }

    /**
     * Setter.
     * @param string $key
     * @param string $data
     * @return void
     */
    public function put(string $key, string $data): void
    {
    }

    /**
     * Getter.
     * @param string $key
     * @return string
     */
    public function get(string $key): string
    {
        return '';
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
    }
}

/**
 * Concept.
 */
class Concept
{
    /**
     * @var \GuzzleHttp\Client
     */
    private $client;

    /**
     * Constructor.
     */
    public function __construct(private Config $config)
    {
        $this->client = new \GuzzleHttp\Client();
    }

    /**
     * @return mixed
     */
    protected function getSecretKey()
    {
        return $this->config->get('SECRET');
    }

    /**
     * @return void
     */
    public function getUserData(): void
    {
        $params = [
            'auth' => ['user', 'pass'],
            'token' => $this->getSecretKey(),
        ];

        // var_dump($this->getSecretKey());

        $request = new \Request('GET', 'https://api.method', $params);

        $promise = $this->client->sendAsync($request)->then(function ($response) {
            $result = $response->getBody();
        });

        $promise->wait();
    }
}

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

switch (getenv('STORAGE_TYPE')) {
    case 'File':
        $concept = new Concept(new FileConfig());
        break;
    case 'DB':
        $concept = new Concept(new DBConfig());
        break;
    default:
        $concept = null;
}

$concept?->getUserData();
