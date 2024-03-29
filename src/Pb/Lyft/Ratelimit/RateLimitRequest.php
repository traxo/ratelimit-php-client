<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: ratelimit/ratelimit.proto

namespace Pb\Lyft\Ratelimit;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;
use Google\Protobuf\Internal\GPBWrapperUtils;

/**
 * Main message for a rate limit request. The rate limit service is designed to be fully generic
 * in the sense that it can operate on arbitrary hierarchical key/value pairs. The loaded
 * configuration will parse the request and find the most specific limit to apply. In addition,
 * a RateLimitRequest can contain multiple "descriptors" to limit on. When multiple descriptors
 * are provided, the server will limit on *ALL* of them and return an OVER_LIMIT response if any
 * of them are over limit. This enables more complex application level rate limiting scenarios
 * if desired.
 *
 * Generated from protobuf message <code>pb.lyft.ratelimit.RateLimitRequest</code>
 */
class RateLimitRequest extends \Google\Protobuf\Internal\Message
{
    /**
     * All rate limit requests must specify a domain. This enables the configuration to be per
     * application without fear of overlap. E.g., "envoy".
     *
     * Generated from protobuf field <code>string domain = 1;</code>
     */
    private $domain = '';
    /**
     * All rate limit requests must specify at least one RateLimitDescriptor. Each descriptor is
     * processed by the service (see below). If any of the descriptors are over limit, the entire
     * request is considered to be over limit.
     *
     * Generated from protobuf field <code>repeated .pb.lyft.ratelimit.RateLimitDescriptor descriptors = 2;</code>
     */
    private $descriptors;
    /**
     * Rate limit requests can optionally specify the number of hits a request adds to the matched limit. If the
     * value is not set in the message, a request increases the matched limit by 1.
     *
     * Generated from protobuf field <code>uint32 hits_addend = 3;</code>
     */
    private $hits_addend = 0;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $domain
     *           All rate limit requests must specify a domain. This enables the configuration to be per
     *           application without fear of overlap. E.g., "envoy".
     *     @type \Pb\Lyft\Ratelimit\RateLimitDescriptor[]|\Google\Protobuf\Internal\RepeatedField $descriptors
     *           All rate limit requests must specify at least one RateLimitDescriptor. Each descriptor is
     *           processed by the service (see below). If any of the descriptors are over limit, the entire
     *           request is considered to be over limit.
     *     @type int $hits_addend
     *           Rate limit requests can optionally specify the number of hits a request adds to the matched limit. If the
     *           value is not set in the message, a request increases the matched limit by 1.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Ratelimit\Ratelimit::initOnce();
        parent::__construct($data);
    }

    /**
     * All rate limit requests must specify a domain. This enables the configuration to be per
     * application without fear of overlap. E.g., "envoy".
     *
     * Generated from protobuf field <code>string domain = 1;</code>
     * @return string
     */
    public function getDomain()
    {
        return $this->domain;
    }

    /**
     * All rate limit requests must specify a domain. This enables the configuration to be per
     * application without fear of overlap. E.g., "envoy".
     *
     * Generated from protobuf field <code>string domain = 1;</code>
     * @param string $var
     * @return $this
     */
    public function setDomain($var)
    {
        GPBUtil::checkString($var, True);
        $this->domain = $var;

        return $this;
    }

    /**
     * All rate limit requests must specify at least one RateLimitDescriptor. Each descriptor is
     * processed by the service (see below). If any of the descriptors are over limit, the entire
     * request is considered to be over limit.
     *
     * Generated from protobuf field <code>repeated .pb.lyft.ratelimit.RateLimitDescriptor descriptors = 2;</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getDescriptors()
    {
        return $this->descriptors;
    }

    /**
     * All rate limit requests must specify at least one RateLimitDescriptor. Each descriptor is
     * processed by the service (see below). If any of the descriptors are over limit, the entire
     * request is considered to be over limit.
     *
     * Generated from protobuf field <code>repeated .pb.lyft.ratelimit.RateLimitDescriptor descriptors = 2;</code>
     * @param \Pb\Lyft\Ratelimit\RateLimitDescriptor[]|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setDescriptors($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::MESSAGE, \Pb\Lyft\Ratelimit\RateLimitDescriptor::class);
        $this->descriptors = $arr;

        return $this;
    }

    /**
     * Rate limit requests can optionally specify the number of hits a request adds to the matched limit. If the
     * value is not set in the message, a request increases the matched limit by 1.
     *
     * Generated from protobuf field <code>uint32 hits_addend = 3;</code>
     * @return int
     */
    public function getHitsAddend()
    {
        return $this->hits_addend;
    }

    /**
     * Rate limit requests can optionally specify the number of hits a request adds to the matched limit. If the
     * value is not set in the message, a request increases the matched limit by 1.
     *
     * Generated from protobuf field <code>uint32 hits_addend = 3;</code>
     * @param int $var
     * @return $this
     */
    public function setHitsAddend($var)
    {
        GPBUtil::checkUint32($var);
        $this->hits_addend = $var;

        return $this;
    }

}

