Exercise Summary
================

 - Consumer:
    - Rename the exchange to `test_direct_exchange`
    - Change the exchange type to `direct`
    - `queue_bind` takes an additional argument - BINDING KEY (`$argv[1]`)
 - Producer:
    - Rename the exchange to `test_direct_exchange`
    - Change the exchange type to `direct`
    - `basic_publish` takes third argument (again)
       - This is the ROUTING KEY. First example used the QUEUE name as the
         routing key, and the "empty" exchange name meant we used "AMQP Default"
         queue - which is a DIRECT EXCHANGE!!! (big reveal, woo!)
