<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: ratelimit/ratelimit.proto

namespace Pb\Lyft\Ratelimit\RateLimitResponse;

/**
 * Protobuf type <code>pb.lyft.ratelimit.RateLimitResponse.Code</code>
 */
class Code
{
    /**
     * Generated from protobuf enum <code>UNKNOWN = 0;</code>
     */
    const UNKNOWN = 0;
    /**
     * Generated from protobuf enum <code>OK = 1;</code>
     */
    const OK = 1;
    /**
     * Generated from protobuf enum <code>OVER_LIMIT = 2;</code>
     */
    const OVER_LIMIT = 2;
}

// Adding a class alias for backwards compatibility with the previous class name.
class_alias(Code::class, \Pb\Lyft\Ratelimit\RateLimitResponse_Code::class);
