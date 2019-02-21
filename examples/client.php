<?php

require dirname(__FILE__) . '/../vendor/autoload.php';

$client = new Traxo\RateLimit\Client([
    'address' => 'localhost:8081'
]);

$req = new Pb\Lyft\Ratelimit\RateLimitRequest([
    'domain' => 'api',
    'descriptors' => [
        // The requester's remote address.
        // This can be used to limit unauthenticated requests.
        new Pb\Lyft\Ratelimit\RateLimitDescriptor([
                'entries' => [
                    new Pb\Lyft\Ratelimit\RateLimitDescriptor\Entry([
                        'key' => 'remote_address',
                        'value' => '10.0.2.15',
                    ]),
                ]
        ]),

        // The requester's OAuth client_id.
        // This can be used to limit authenticated requests.
        new Pb\Lyft\Ratelimit\RateLimitDescriptor([
                'entries' => [
                    new Pb\Lyft\Ratelimit\RateLimitDescriptor\Entry([
                        'key' => 'client_id',
                        'value' => 'abc1234',
                    ]),
                ]
        ]),
    ],
    'hits_addend' => 1,
]);

try {
    list($response, $status) = $client->ShouldRateLimit($req)->wait();
} catch (Exception $e) {
    var_dump($e->getMessage());
    exit;
}

# gRPC request error handling.
# https://github.com/grpc/grpc/issues/15040
# https://github.com/grpc/grpc/pull/15652
# https://github.com/grpc/grpc/blob/master/doc/statuscodes.md

# Handle the low-level GRPC request status.
if (empty($status) || ($status->code !== 0)) {
    echo 'Request failed: ' . $status->details . PHP_EOL;
    var_dump($status);
    exit;
}

# When the overall code = 2, the request should be denied.
$overallCode = $response->getOverallCode();
switch ($overallCode) {
    case 0:
        $overallCode = 'UNKNOWN';
        break;
    case 1:
        $overallCode = 'OK';
        break;
    case 2:
        $overallCode = 'OVER_LIMIT';
        break;
}

echo 'Overall Code: ' . $overallCode . PHP_EOL;

# Get the standard rate limiting headers.
# This feature is specific to this client project.
$headers = $client->getHeaders($response);
foreach ($headers as $header) {
    echo '---' . PHP_EOL;
    var_dump($header) . PHP_EOL;
}

# A status is returned for each matched descriptor.
$statuses = $response->getStatuses();
foreach ($statuses as $s) {
    $reqPerUnit = $reqUnit = 0;
    $currentLimit = $s->getCurrentLimit();
    if (!empty($currentLimit)) {
        $reqPerUnit = $currentLimit->getRequestsPerUnit();
        $reqUnit    = $currentLimit->getUnit();
    }

    if (!empty($reqUnit)) {
        switch ($reqUnit) {
            case 0:
                $reqUnit = 'UNKNOWN';
                break;
            case 1:
                $reqUnit = 'SECOND';
                break;
            case 2:
                $reqUnit = 'MINUTE';
                break;
            case 3:
                $reqUnit = 'HOUR';
                break;
            case 4:
                $reqUnit = 'DAY';
                break;
        }
    }

    $code = $s->getCode();
    switch ($code) {
        case 0:
            $code = 'UNKNOWN';
            break;
        case 1:
            $code = 'OK';
            break;
        case 2:
            $code = 'OVER_LIMIT';
            break;
    }

    echo '---' . PHP_EOL;
    echo 'code ' . $code . PHP_EOL;
    echo 'unit ' . $reqUnit . PHP_EOL;
    echo 'request-per-unit: ' . $reqPerUnit . PHP_EOL;
    echo 'limit-remaining:  ' . $s->getLimitRemaining() . PHP_EOL;
}
