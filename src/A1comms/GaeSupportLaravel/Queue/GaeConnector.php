<?php

namespace A1comms\GaeSupportLaravel\Queue;

use Illuminate\Contracts\Encryption\Encrypter as EncrypterContract;
use Illuminate\Http\Request;
use Illuminate\Queue\Connectors\ConnectorInterface;
use Illuminate\Support\Arr;

class GaeConnector implements ConnectorInterface
{
    /**
     * The encrypter instance.
     *
     * @var \Illuminate\Encryption\Encrypter
     */
    protected $crypt;

    /**
     * The current request instance.
     *
     * @var \Illuminate\Http\Request;
     */
    protected $request;

    /**
     * Create a new GAE connector instance.
     *
     * @param \Illuminate\Contracts\Encryption\Encrypter $crypt
     * @param \Illuminate\Http\Request $request
     */
    public function __construct(
        EncrypterContract $crypt,
        Request $request
    ) {
        $this->crypt = $crypt;
        $this->request = $request;
    }

    /**
     * Establish a queue connection.
     *
     * @param array $config
     *
     * @return \Illuminate\Queue\QueueInterface
     */
    public function connect(array $config)
    {
        return new GaeQueue(
            $this->request,
            $config['queue'],
            $config['url'],
            (bool) Arr::get($config, 'encrypt'),
            (bool) Arr::get($config, 'compress')
        );
    }
}
