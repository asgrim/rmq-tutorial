Exercise Summary
================

 - Producer:
    - Use t7/3-per-queue-messaage.php as base
    - Add `'x-dead-letter-exchange' => 'test_dlx_exchange'` to metadata
    - Change name of queue to `test_dlx_queue` (2 places)
 - Consumer:
    - Remove RPC stuff
    - Convert queue to temporary queue
    - Last boolean to false (we want to auto-delete the queue)
    - `exchange_declare` change name to `test_dlx_exchange`, type `fanout`
    - Simplify the `queue_bind` call accordingly (no BK required) AND change
      name of the exchange to `test_dlx_exchange`
