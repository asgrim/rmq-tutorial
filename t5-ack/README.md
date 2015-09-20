Exercise Summary
================

 - Consumer:
    - Connect to a named queue now `my_acked_queue` in `queue_declare`
       - Add 4 `false`s - last means "DO NOT AUTODELETE"
       - Creates a "permanent queue" - but not durable, unless 2nd is TRUE
    - In `basic_consume`, change second `bool` to `false`
       - We will now manually acknowledge messages
    - At end of handler:
       - `$channel->basic_ack($message->delivery_info['delivery_tag']);`
    - At start of handler:
       - throw an exception
 - Producer:
    - no change
 - Run consumer, run producer. Application dies as we expect.
    - But when we restart the consumer, it instantly consumer the last message
