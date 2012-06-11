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
     * @var string
     */
    protected $tableId;

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
        $this->connection->once('data', array($this, 'onceData'));
    }

    /**
     * @param string     $data
     * @param Connection $connection
     */
    public function onceData($data, Connection $connection)
    {
        $content = @json_decode($data, true);
        $this->tableId = is_array($content) && isset($content['table_id']) ? $content['table_id'] : null;

        if (empty($this->tableId)) {
            $connection->write(json_encode(array(
                'error' => 'No table id.',
            )));

            return $connection->close();
        }

        $this->bindRedisSubscribe();
    }

    public function bindRedisSubscribe()
    {
        $this->redis->connect(array($this, 'onRedisConnect'));
    }

    public function onRedisConnect()
    {
        $channels = array(
            sprintf('tables.%d.orders', $this->tableId),
            sprintf('tables.%d.requests_waiter', $this->tableId),
        );
        $this->redis->subscribe($channels, array($this, 'onRedisData'));
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
