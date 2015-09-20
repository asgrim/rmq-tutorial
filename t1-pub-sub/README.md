Exercise Summary
================

 - Create shared connection code (channel.php)
 - Set up a basic producer and consumer
 - Consumer:
    - is basically a callback function
    - declare queue
    - consume queue with callback
    - to "unregister" the callback, simply `$channel->basic_cancel('foo');` in
      the handler
 - Producer:
    - declare queue
    - publish anything to the queue
 
