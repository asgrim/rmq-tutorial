Exercise Summary
================

 - Producer:
    - Set exchange name to `test_priority_exchange`
    - Delete remaining `exchange_declare` booleans (no longer needed)
    - Create a `for` loop, to create 3 messages
       - Each message should now have `$metadata` again but with `priority` key
       - Higher number = higher priority
       - Also add the priority into the message (so visible on consumer)
       - Also we'll use `batch_basic_publish` just for fun
    - Add call to `publish_batch` at the end - don't forget
 - Consumer:
    - Add `PhpAmqpLib\Wire\AMQPTable` import back in
    - Create metadata with `x-max-priority` setting to `3`
    - Define an explicit queue name this time `test_priority_queue` so we can
      inspect
    - Also do not auto-delete the queue (4th bool to `false`)
    - Update exchange name to `test_priority_exchange` in `exchange_declare`
    - Update call to `queue_bind` too
    
 - NOTES:
    - Run consumer.php as usual, then producer.php. Notice, order is 1, 2, 3 ?!
    - Even using batch publish, the consumer already prefetched in that order
    - To solve, kill the consumer, THEN publish, THEN restart consumer
    - Demonstrates that priority is useful in extremely high volume throughput
      but not so much if you have a handful of messages.
    - What happens if we have 30000 random priority messages? In producer:
       - loop to 30000
       - `$priority = rand(1, 3);
       - Pass random priority in each message
       - Run consumer, then producer
       - You should see 1, 2, 3, 1, 2, 3 etc. then 3, 3, 3, 2, 2, 2, 1, 1, 1
          - This is because PREFETCH
          - Try `$channel->basic_qos(null, 1, null);`
          - Only first message is random, then all in order 3, 2, 1
          - Notice it is actually slower (go back to server each time)
