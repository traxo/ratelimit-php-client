#!/bin/sh
#
#

protoc --proto_path=./proto  --php_out=./src  --grpc_out=./src --plugin=protoc-gen-grpc=./../grpc/bins/opt/grpc_php_plugin ./proto/ratelimit/ratelimit.proto
