<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: ratelimit/ratelimit.proto

namespace Pb\Lyft\Ratelimit;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;
use Google\Protobuf\Internal\GPBWrapperUtils;

/**
 * A response from a ShouldRateLimit call.
 *
 * Generated from protobuf message <code>pb.lyft.ratelimit.RateLimitResponse</code>
 */
class RateLimitResponse extends \Google\Protobuf\Internal\Message
{
    /**
     * The overall response code which takes into account all of the descriptors that were passed
     * in the RateLimitRequest message.
     *
     * Generated from protobuf field <code>.pb.lyft.ratelimit.RateLimitResponse.Code overall_code = 1;</code>
     */
    private $overall_code = 0;
    /**
     * A list of DescriptorStatus messages which matches the length of the descriptor list passed
     * in the RateLimitRequest. This can be used by the caller to determine which individual
     * descriptors failed and/or what the currently configured limits are for all of them.
     *
     * Generated from protobuf field <code>repeated .pb.lyft.ratelimit.RateLimitResponse.DescriptorStatus statuses = 2;</code>
     */
    private $statuses;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type int $overall_code
     *           The overall response code which takes into account all of the descriptors that were passed
     *           in the RateLimitRequest message.
     *     @type \Pb\Lyft\Ratelimit\RateLimitResponse\DescriptorStatus[]|\Google\Protobuf\Internal\RepeatedField $statuses
     *           A list of DescriptorStatus messages which matches the length of the descriptor list passed
     *           in the RateLimitRequest. This can be used by the caller to determine which individual
     *           descriptors failed and/or what the currently configured limits are for all of them.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Ratelimit\Ratelimit::initOnce();
        parent::__construct($data);
    }

    /**
     * The overall response code which takes into account all of the descriptors that were passed
     * in the RateLimitRequest message.
     *
     * Generated from protobuf field <code>.pb.lyft.ratelimit.RateLimitResponse.Code overall_code = 1;</code>
     * @return int
     */
    public function getOverallCode()
    {
        return $this->overall_code;
    }

    /**
     * The overall response code which takes into account all of the descriptors that were passed
     * in the RateLimitRequest message.
     *
     * Generated from protobuf field <code>.pb.lyft.ratelimit.RateLimitResponse.Code overall_code = 1;</code>
     * @param int $var
     * @return $this
     */
    public function setOverallCode($var)
    {
        GPBUtil::checkEnum($var, \Pb\Lyft\Ratelimit\RateLimitResponse_Code::class);
        $this->overall_code = $var;

        return $this;
    }

    /**
     * A list of DescriptorStatus messages which matches the length of the descriptor list passed
     * in the RateLimitRequest. This can be used by the caller to determine which individual
     * descriptors failed and/or what the currently configured limits are for all of them.
     *
     * Generated from protobuf field <code>repeated .pb.lyft.ratelimit.RateLimitResponse.DescriptorStatus statuses = 2;</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getStatuses()
    {
        return $this->statuses;
    }

    /**
     * A list of DescriptorStatus messages which matches the length of the descriptor list passed
     * in the RateLimitRequest. This can be used by the caller to determine which individual
     * descriptors failed and/or what the currently configured limits are for all of them.
     *
     * Generated from protobuf field <code>repeated .pb.lyft.ratelimit.RateLimitResponse.DescriptorStatus statuses = 2;</code>
     * @param \Pb\Lyft\Ratelimit\RateLimitResponse\DescriptorStatus[]|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setStatuses($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::MESSAGE, \Pb\Lyft\Ratelimit\RateLimitResponse\DescriptorStatus::class);
        $this->statuses = $arr;

        return $this;
    }

}

