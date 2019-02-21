<?php
namespace Traxo\RateLimit;

use Pb\Lyft\Ratelimit;


class Client
{
    /*
     * Pb\Lyft\Ratelimit\RateLimitServiceClient
     */
    var $service;


    /**
     * @param array $args
     *
     */
    public function __construct(array $args = [])
    {
        $defaultSettings = [
            'address' => 'localhost:8081',
            'header'  => 'X-RateLimit',
        ];
        $this->settings = array_merge($defaultSettings, $args);

        return $this->service = new RateLimit\RateLimitServiceClient($this->settings['address'], [
            'credentials' => \Grpc\ChannelCredentials::createInsecure(),
        ]);
    }


    /**
     * Determine whether rate limiting should take place.
     * @param \Pb\Lyft\Ratelimit\RateLimitRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function ShouldRateLimit($argument, $metadata = [], $options = [])
    {
        return $this->service->ShouldRateLimit($argument, $metadata, $options);
    }


    /**
     * Returns an array of standard rate limiting headers for each matched descriptor.
     *
     * @return array
     */
    public function getHeaders($response)
    {
        $statuses = $response->getStatuses();
        if (empty($statuses)) {
            return [];
        }

        $limits = [];

        foreach ($statuses as $s) {
            $reqPerUnit = $reqUnit = $reqRemaining = 0;

            $currentLimit = $s->getCurrentLimit();
            if (!empty($currentLimit)) {
                $reqPerUnit = (int) $currentLimit->getRequestsPerUnit();
                $reqUnit    = $currentLimit->getUnit();
            }

            $limitRemaining = $s->getLimitRemaining();
            if (!empty($limitRemaining)) {
                $reqRemaining = (int) $limitRemaining;
            }

            // Calculate how close each limit is to an overage on a percentage basis:
            // (Remaining / Limit) * 100
            $pctRemaining = ($reqPerUnit > 0)
                ? number_format(($reqRemaining / $reqPerUnit) * 100.0, 2)
                : 100.0;

            $limits[] = [
                'limit'         => $reqPerUnit,
                'remaining'     => $reqRemaining,
                'remaining_pct' => $pctRemaining,
                // 'reset'         => 'TBD',
            ];
        } // close $statuses

        // Sort the results by increasing remaining_pct.
        // The implementing client will need to decide how to present the results when
        // more than one is present.
        ksort($limits);

        $output = [];

        foreach ($limits as $l) {
            // The reset timestamp is not part of the normal response yet.
            // see https://github.com/lyft/ratelimit/pull/56
            $output[] = [
                $this->settings['header'] . '-Limit'     => $l['limit'],
                $this->settings['header'] . '-Remaining' => $l['remaining'],
                // $this->settings['header'] . '-Reset'     => $l['reset'],
            ];
        }

        return $output;
    }
}
