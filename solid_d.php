<?php

/**
 * Устранить нарушения принципа инверсии зависимостей (D: Dependency Inversion Principle) SOLID:
 * «Модули верхних уровней не должны зависеть от модулей нижних уровней.
 * Оба типа модулей должны зависеть от абстракций.»
 * (код представлен в папке architecture, в файле solid_d.php).
 */

/**
 * Connection.
 */
interface Connection
{
    public function request(string $url, string $method, array $options = []);
}

/**
 * MockHttpService.
 */
class MockHttpService implements Connection
{
    /**
     * @param string $url
     * @param string $method
     * @param array $options
     * @return string
     * @throws Exception
     */
    public function request(string $url, string $method, array $options = []): string
    {
        echo PHP_EOL;
        echo "Sending {$method} request to {$url}...";
        echo PHP_EOL;

        return (random_int(0, 1) > 0.5) ? '1' : '0';
    }
}

/**
 * NativeHttpService.
 */
class NativeHttpService implements Connection
{
    /**
     * @param string $url
     * @param string $method
     * @param array $options
     * @return string
     * @throws Exception
     */
    public function request(string $url, string $method, array $options = []): string
    {
        echo PHP_EOL;
        echo "Sending {$method} request to {$url}...";
        echo PHP_EOL;

        switch ($method) {
            case 'GET':
                $query = [
                    'http' => [
                        'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                        'method' => 'POST',
                        'content' => http_build_query($options),
                    ],
                ];

                $context = stream_context_create($query);

                return substr(file_get_contents($url, false, $context), 0, 30) . '...';

            case 'POST':
                return "This method is still not realized!";
        }

        throw new Exception('Method not allowed!', 405);
    }
}

/**
 * Http.
 */
readonly class Http
{
    /**
     * @param Connection $connection
     */
    public function __construct(private Connection $connection)
    {
    }

    /**
     * @param string $url
     * @param array $options
     * @return string
     */
    public function get(string $url, array $options = []): string
    {
        return $this->connection->request($url, 'GET', $options);
    }

    /**
     * @param string $url
     * @param array $options
     * @return string
     */
    public function post(string $url, array $options = []): string
    {
        return $this->connection->request($url, 'POST', $options);
    }
}

$url = 'random';
$service = new MockHttpService();
$http = new Http($service);

echo $http->get($url);
echo $http->post($url);

$url = 'https://ya.ru';
$service = new NativeHttpService();
$http = new Http($service);

echo $http->get($url);
echo $http->post($url);

echo PHP_EOL;
