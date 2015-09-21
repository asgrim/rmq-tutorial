Exercise Summary
================

 - Producer:
    - Create a `correlation_id` (identifies the unique request/response pair)
    - `queue_declare` a temporary queue - this'll be where our response goes
    - Create a handler for this temporary queue and call `basic_consume`
    - In the handler, check the `correlation_id` matches, and echo the response
    - Modify the AMQPMessage (request) creation to have some metadata:
       - The `correlation_id` from above
       - The `reply_to` with the name of the temporary queue above
    - Call `$channel->wait()` after `basic_publish` to "wait" for the response!
 - Consumer:
    - Remove the exception stuff in `handler` function
    - Add a `sleep(3)` to simluate work happening
    - Create `$metadata` for response message, copy `correlation_id` from
      request to response metadata
    - Create a new AMQPMessage with the metadata and a response message
    - Call `basic_publish` with `$responseMessage`, empty exchange, and use the
      `reply_to` queue name from the request message as ROUTING KEY
