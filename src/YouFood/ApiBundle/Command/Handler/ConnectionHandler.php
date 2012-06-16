<?php

namespace YouFood\ApiBundle\Command\Handler;

use Symfony\Component\Console\Output\OutputInterface;

use React\Socket\Connection;
use Predis\Async\Client as PredisAsync;

/**
 * ConnectionHandler
 *
 * @author Adrien Brault <adrien.brault@gmail.com>
 */
class ConnectionHandler
{
    /**
     * @var Connection
     */
    protected $connection;

    /**
     * @var PredisAsync
     */
    protected $redis;

    /**
     * @var array
     */
    protected $tablesIds;

    /**
     * @param PredisAsync $redis
     * @param Connection  $connection
     */
    public function __construct(PredisAsync $redis, Connection $connection)
    {
        $this->redis = $redis;
        $this->connection = $connection;
    }

    public function bindEvents()
    {
        $this->connection->on('connect', function () {
            echo 'yeah'.PHP_EOL;
        });
        $this->connection->once('data', array($this, 'onceData'));
    }

    /**
     * @param string     $data
     * @param Connection $connection
     */
    public function onceData($data, Connection $connection)
    {
        $content = @json_decode($data, true);
        $this->tablesIds = is_array($content) && isset($content['tables_ids']) && is_array($content['tables_ids'])
            ? $content['tables_ids']
            : null;

        if (empty($this->tablesIds)) {
            echo print_r(array(
                'error' => 'No table id.',
            ), true).PHP_EOL;

            $connection->write(json_encode(array(
                'error' => 'No table id.',
            )));

            return $connection->close();
        }

        echo print_r(array(
            'content' => $content,
        ), true).PHP_EOL;

        $this->bindRedisSubscribe();
    }

    public function bindRedisSubscribe()
    {
        $this->redis->connect(array($this, 'onRedisConnect'));
    }

    public function onRedisConnect()
    {
        foreach ($this->tablesIds as $tableId) {
            $this->redis->subscribe(sprintf('tables.%d.orders', $tableId), array($this, 'onRedisData'));
            $this->redis->subscribe(sprintf('tables.%d.requests_waiter', $tableId), array($this, 'onRedisData'));
        }
    }

    /**
     * @param string $event
     */
    public function onRedisData($event)
    {
        list($type, $chan, $message) = $event;

        switch ($type) {
            case 'message': return $this->onRedisMessage($chan, $message);
            case 'subscribe': return $this->onRedisSubscribe($chan, $message);
        }
    }

    /**
     * @param string $chan
     * @param string $message
     */
    public function onRedisMessage($chan, $message)
    {
        if (!preg_match('/[.](?P<type>[^.]+)$/', $chan, $matches)) {
            return;
        }

        $this->connection->write(json_encode(array(
            'type' => $matches['type'],
            'data' => $message,
        )));
    }

    /**
     * @param string $chan
     * @param string $message
     */
    public function onRedisSubscribe($chan, $message)
    {

    }
}
