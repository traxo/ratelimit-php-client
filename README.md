RateLimit PHP Client
====================

A php client for the [lyft/ratelimit](https://github.com/lyft/ratelimit/) gRPC service.

Proto Version: [v1.3.0](https://github.com/lyft/ratelimit/releases/tag/v1.3.0).


## Usage

This section describes the typical usage of the client within a php application to implement
request blocking upon reaching the configured rate limits.

An instance of the ratelimit gRPC service should be running on the local workstation. A
`docker-compose.yml` file is provided by the upstream project to stand up the `ratelimit` service
and a redis instance.

An example client implementation is provided in the `examples` directory.

The code snippets in this section are representative when using the following
[service configuration](https://github.com/lyft/ratelimit#configuration):
```yaml
domain: api
descriptors:
  - key: remote_address
    rate_limit:
      unit: minute
      requests_per_unit: 60

  - key: client_id
    rate_limit:
      unit: minute
      requests_per_unit: 600
```

Install the library with composer:
```
composer require traxo/ratelimit-php-client
```

Instantiate a client:
```
<?php
$client = new Traxo\RateLimit\Client([
    'address' => 'localhost:8081'
]);
```

Build a request object with a complex argument:
```
$req = new Pb\Lyft\Ratelimit\RateLimitRequest([
    'domain' => 'api',
    'descriptors' => [
        new Pb\Lyft\Ratelimit\RateLimitDescriptor([
                'entries' => [
                    new Pb\Lyft\Ratelimit\RateLimitDescriptor\Entry([
                        'key' => 'remote_address',
                        'value' => '10.0.2.15',
                    ]),
                ]
        ])
    ],
    'hits_addend' => 2,
]);
```

Or use the provided setters to build a request object:
```
$req->setDomain('api');

$req->setDescriptors([
    new Pb\Lyft\Ratelimit\RateLimitDescriptor([
            'entries' => [
                new Pb\Lyft\Ratelimit\RateLimitDescriptor\Entry([
                    'key' => 'remote_address',
                    'value' => '10.0.2.15',
                ]),

                // Additional variants that can be tried:
                // new Pb\Lyft\Ratelimit\RateLimitDescriptor\Entry([
                //     'key' => 'client_id',
                //     'value' => 'abc1234',
                // ]),
            ]
    ])
]);
```

#### Request / Response Handling

Call the ratelimit network service and wait for the response:
```
try {
    list($result, $status) = $client->ShouldRateLimit($req)->wait();
} catch (Exception $e) {
    var_dump($e->getMessage());
    exit;
}
```

The gRPC request status should be checked:
```
if (empty($status) || ($status->code !== 0)) {
    echo 'Request failed: ' . $status->details . PHP_EOL;
    exit;
}
```

Most implementations will block additional requests when the overall code is `OVER_LIMIT`:
```
if ($response->getOverallCode() === 2) {
    // block the request here
}
```

#### Rate Limit Headers

This client can generate conventional rate limiting headers from the service response:
```
$headers = $client->getHeaders($response);
foreach ($headers as $header) {
    // handle $header here
}
```

where `$headers` is an array of header objects for each matched descriptor in the domain configuration:
```
[
    {
        "X-RateLimit-Limit" => 60,
        "X-RateLimit-Remaining" => 59
    }
]
```

In the case where multiple descriptors are matched, `$headers` is ranked in order of least remaining
limit on a percentage basis (i.e. (Remaining / Limit) * 100 ). Most implementers will elect to use
the first header object and ignore the others.

Note that the `X-RateLimit-Reset` header is not yet supported. Monitor this
[pull request](https://github.com/lyft/ratelimit/pull/56) for updates.

The header prefix (i.e. `X-RateLimit`) is configurable.


## Development

This client implements the protocol buffer file (i.e. `ratelimit.proto`) from the ratelimit project
repository. The gRPC project provides code generation across many programming languages. The
generated php classes are used by this client.

#### Prerequisites

Prior to generating the client code, the local workstation must be properly configured.

This section generally follows the [PHP Quickstart](https://grpc.io/docs/quickstart/php.html#install-other-prerequisites-for-both-mac-os-x-and-linux)
from the gRPC project website.

1. Install the gRPC php extension:
```
sudo pecl install grpc
or
sudo yum install --enablerepo=epel,remi,remi-php73 php-pecl-grpc
```

2. Add the module file `/etc/php.d/30-grpc.ini`:
```
; Enable grpc extension module
extension = grpc.so
```

3. Install the Protobuf runtime library:
```
sudo pecl install protobuf
```

4) Install the protobuf compiler:
```
wget https://github.com/protocolbuffers/protobuf/releases/download/v3.6.1/protoc-3.6.1-linux-x86_64.zip
unzip protoc-3.6.1-linux-x86_64.zip
sudo cp bin/protoc /usr/local/bin/
sudo cp -Rf include/google /usr/local/include/
```


#### Code Generation

This section describes how to generate or re-generate the generated php classes used by this client.

1. Copy the `ratelimit.proto` file from [lyft/ratelimit](https://github.com/lyft/ratelimit/) service
project.

2. Checkout the gRPC repository next to this one:
```
git clone -b v1.18.0 https://github.com/grpc/grpc
```

3. Run the `proto-gen.sh` script from the root of this client repository. The script uses relative
paths to locate the `grpc` repository on the local filesystem.


### Limitations / Future Work

1) Implement `DNS SRV` and/or consul service support for service discovery. This will allow the address
for each request to be resolved at runtime and avoid the requirement for a load balancer in front of
the ratelimit service simply to normalize the address and port.


2) The `X-RateLimit-Reset` header is not yet supported. Monitor this
[pull request](https://github.com/lyft/ratelimit/pull/56) for updates.

3) Decide how to generate headers when no descriptors match the conditions.

4) Finish development of `Request` and `Response` classes that are tailored to typical use cases
in php, can handle simple descriptor entries in a more compact fashion.

While attempting to extend `\Pb\Lyft\Ratelimit\RateLimitRequest` in a `Request` class, the following
error was encountered:
```
PHP Notice:  Traxo\RateLimit\Request is not found in descriptor pool. in /vagrant/ratelimit-php-client/vendor/google/protobuf/php/src/Google/Protobuf/Internal/Message.php on line 96
PHP Fatal error:  Uncaught Error: Call to a member function getField() on null in /vagrant/ratelimit-php-client/vendor/google/protobuf/php/src/Google/Protobuf/Internal/Message.php:98
```

This could be a limitation of protocol buffers and the lack of class inheritance properties. If so,
a `Request` class may need to instead marshall the requests through the generated request class and
handle the response independent of the generated response class.


## License

MIT
