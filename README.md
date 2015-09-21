RabbitMQ Tutorial - PHPNW15 Conference
======================================

Tutorial Abstract
-----------------
As your application grows, you soon realise you need to break up your
application into smaller chunks that talk to each other. You could just use web
services to interact, or you could take a more robust approach and use the
message broker RabbitMQ. In this tutorial, I will introduce RabbitMQ as a
solution to scalable, interoperable and flexible applications. 

We will first set up a hypothetical domain, around which we will structure
practical coding exercises to learn the features of RabbitMQ from the ground up.
This tutorial is perfect for those who would like a deep dive into RabbitMQ with
little or no pre-existing knowledge about message queuing systems. Once you've
finished the tutorial, you will have learnt how to set up basic
publish/subscribe message queues, control the flow of messages using various
exchanges, and understand various features of RabbitMQ such as RPC, TTL, and DLX. 

Prerequisites
-------------
 * Vagrant box from: https://github.com/asgrim/rmq-vm
   * RabbitMQ
   * PHP
 * Distribute pre-packaged box via USB stick

Outline
-------
 * First half
   * Slides - Messaging basics (15m) - done
   * Setup assistance (5m) - done
   * t1 - Basic pub/sub (15m) - done
   * t2 - Fanout exchange (10m) - done
   * t3 - Direct exchange (15m) - done
   * t4 - Topic exchange (15m) - done
   * t5 - Broken message acknowledgement - fix it (15m) - done
 * Second half
   * t6 - RPC (10m) - done
   * t7 - TTL types (10m)
   * t8 - DLX (10m)
   * t9 - delayed messages (10m)
   * t10 - priority messages (10m)
   * t11 - Shovel plugin (10m)
   * t12 - Management API (10m)
   * Clustering - slides (20m)
