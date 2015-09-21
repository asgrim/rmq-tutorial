Exercise Summary
================

 - Consumer:
    - Ignore the consumer for now...
    - Just watch the Management page ;)
 - Producer:
    - Strip back and simplify to AMQP default queue (no explicit exchange)
    - per-message.php
       - Add metadata to the message with `expiration` key
       - Must be a string, set to `'10000'` (ms)
    - per-queue-message.php
       - Add new AMQPTable (basically metadata)
       - Key of `x-message-ttl` and set to 10000 (ms)
       - Change the name of the queue!
    - per-queue.php
       - Similar to per-queue-message, but use the `x-expires` key instead
       - Deletes the entire queue after 10s
