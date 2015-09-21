Exercise Summary
================

NOTE: Experimental plugin `rabbitmq_delayed_message_exchange` being used here!

 - Producer:
    - Create new metadata for `exchange_declare` (is an `AMQPTable`, which is
      simply a collection)
       - Uses the `x-delayed-type` key, with the `value` being the actual
         exchange type you want to use (e.g. `direct`, `fanout`, `topic`, etc.)
    - Modify `exchange_declare`:
       - Name to `test_delayed_exchange`
       - Exchange type is `x-delayed-message`
       - then `false, false, true, false, false, $metadata`
    - Modify `queue_bind` to bind to new exchange, and set BK to `foo`
 - Consumer:
    - Copy exchange definition from producer
    - Create metadata with `x-delay` header
       - Note that the array key is `application_headers` and it is an
         `AMQPTable` again (a collection)
    - Add metadata to the message
    - Publish to `test_delayed_exchange`, with the `foo` RK
