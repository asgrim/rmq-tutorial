Exercise Summary
================

 - Consumer:
    - No queue name when calling `queue_declare` - it is returned to `$q`
    - `$queue_name = $q[0]`
    - New call to `exchange_declare` - type `fanout`
    - We must bind the queue to the exchange
       - `$channel->queue_bind($queue_name, 'test_fanout_exchange');`
    - Modify `basic_consume` to use the generated `$queue_name`
    - Also consumer ID should be unique - `'foo' . getmypid()` is fine for us
 - Producer:
    - Remove `queue_declare` call - we no longer publish to a queue, we publish
      to the exchange, who sends to the correct queue for us. We are delegating
      the "routing" to the exchange.
    - Add `exchange_declare` call - type `fanout`
    - Call to `basic_publish` now adds `test_fanout_exchange`, but we must now
      omit the queue name!
 
