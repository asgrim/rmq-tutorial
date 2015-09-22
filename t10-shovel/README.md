Exercise Summary
================

NOTE: Needs Shovel + Shovel Management plugins

 - RabbitMQ Configuration:
    - Open Management http://192.168.33.99:15672/
    - Go to Admin > Shovel Management > Add new shovel:
       - Name: test_shovel
       - src: uri=amqp://, exchange=test_shovel_src_exchange, RK=foo
       - dest: uri=amqp://, exchange=test_shovel_dest_exchange, RK=foo
    - Note the dest could be a totally separate location on WAN
    - We can configure Shovel to "pull" or to "push"
    - Better at surviving network failures
 - Producer:
    - Delete the metadata stuff now, not needed
    - In `exchange_declare`:
       - set name of exchange `test_shovel_src_exchange`
       - change type to `direct`
       - auto-delete must be FALSE
       - Don't forget to remove metadata parameter
    - Remove metadata from `AMQPMessage` creation
    - Update exchange name in `basic_publish`
 - Consumer:
    - In `exchange_declare`:
       - set name of exchange `test_shovel_dest_exchange`
       - change type to `direct`
       - remove other parameters
    - Update exchange name in `queue_bind` to `test_shovel_dest_exchange`

