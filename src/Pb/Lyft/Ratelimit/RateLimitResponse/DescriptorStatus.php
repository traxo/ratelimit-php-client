<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: ratelimit/ratelimit.proto

namespace Pb\Lyft\Ratelimit\RateLimitResponse;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;
use Google\Protobuf\Internal\GPBWrapperUtils;

/**
 * Generated from protobuf message <code>pb.lyft.ratelimit.RateLimitResponse.DescriptorStatus</code>
 */
class DescriptorStatus extends \Google\Protobuf\Internal\Message
{
    /**
     * The response code for an individual descriptor.
     *
     * Generated from protobuf field <code>.pb.lyft.ratelimit.RateLimitResponse.Code code = 1;</code>
     */
    private $code = 0;
    /**
     * The current limit as configured by the server. Useful for debugging, etc.
     *
     * Generated from protobuf field <code>.pb.lyft.ratelimit.RateLimit current_limit = 2;</code>
     */
    private $current_limit = null;
    /**
     * The limit remaining in the current time unit.
     *
     * Generated from protobuf field <code>uint32 limit_remaining = 3;</code>
     */
    private $limit_remaining = 0;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type int $code
     *           The response code for an individual descriptor.
     *     @type \Pb\Lyft\Ratelimit\RateLimit $current_limit
     *           The current limit as configured by the server. Useful for debugging, etc.
     *     @type int $limit_remaining
     *           The limit remaining in the current time unit.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Ratelimit\Ratelimit::initOnce();
        parent::__construct($data);
    }

    /**
     * The response code for an individual descriptor.
     *
     * Generated from protobuf field <code>.pb.lyft.ratelimit.RateLimitResponse.Code code = 1;</code>
     * @return int
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * The response code for an individual descriptor.
     *
     * Generated from protobuf field <code>.pb.lyft.ratelimit.RateLimitResponse.Code code = 1;</code>
     * @param int $var
     * @return $this
     */
    public function setCode($var)
    {
        GPBUtil::checkEnum($var, \Pb\Lyft\Ratelimit\RateLimitResponse_Code::class);
        $this->code = $var;

        return $this;
    }

    /**
     * The current limit as configured by the server. Useful for debugging, etc.
     *
     * Generated from protobuf field <code>.pb.lyft.ratelimit.RateLimit current_limit = 2;</code>
     * @return \Pb\Lyft\Ratelimit\RateLimit
     */
    public function getCurrentLimit()
    {
        return $this->current_limit;
    }

    /**
     * The current limit as configured by the server. Useful for debugging, etc.
     *
     * Generated from protobuf field <code>.pb.lyft.ratelimit.RateLimit current_limit = 2;</code>
     * @param \Pb\Lyft\Ratelimit\RateLimit $var
     * @return $this
     */
    public function setCurrentLimit($var)
    {
        GPBUtil::checkMessage($var, \Pb\Lyft\Ratelimit\RateLimit::class);
        $this->current_limit = $var;

        return $this;
    }

    /**
     * The limit remaining in the current time unit.
     *
     * Generated from protobuf field <code>uint32 limit_remaining = 3;</code>
     * @return int
     */
    public function getLimitRemaining()
    {
        return $this->limit_remaining;
    }

    /**
     * The limit remaining in the current time unit.
     *
     * Generated from protobuf field <code>uint32 limit_remaining = 3;</code>
     * @param int $var
     * @return $this
     */
    public function setLimitRemaining($var)
    {
        GPBUtil::checkUint32($var);
        $this->limit_remaining = $var;

        return $this;
    }

}

// Adding a class alias for backwards compatibility with the previous class name.
class_alias(DescriptorStatus::class, \Pb\Lyft\Ratelimit\RateLimitResponse_DescriptorStatus::class);

