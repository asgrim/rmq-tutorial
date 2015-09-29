RabbitMQ Tutorial - PHPNW15 Conference
======================================

Tutorial Abstract
-----------------
As your application grows, you soon realise you need to break up your
application into smaller chunks that talk to each other. You could just use web
services to interact, or you could take a more robust approach and use the
message broker RabbitMQ. In this tutorial, I will introduce RabbitMQ as a
solution to scalable, interoperable and flexible applications. 

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
   * 09:00 ... Slides - Messaging basics (15m) - done
   * 09:15 ... Setup assistance (5m) - done
   * 09:20 ... t1 - Basic pub/sub (15m) - done
   * 09:35 ... t2 - Fanout exchange (10m) - done
   * 09:45 ... t3 - Direct exchange (15m) - done
   * 10:00 ... t4 - Topic exchange (15m) - done
   * 10:15 ... t5 - Broken message acknowledgement - fix it (15m) - done
   * 10:30 ... Pre-break wrap-up (2m) - done
 * Second half
   * 11:00 ... t6 - RPC (10m) - done
   * 11:10 ... t7 - TTL types (10m) - done
   * 11:20 ... t8 - DLX (10m) - done
   * 11:30 ... t9 - delayed messages (10m) - done
   * 11:40 ... t10 - Shovel plugin (10m) - done
   * 11:50 ... t11 - priority messages (10m) - done
   * 12:00 ... t12 - Management API (10m) - done
   * 12:10 ... Clustering - slides (5m) - done
   * 12:15 ... Homework: Create a simple application with RabbitMQ

Homework ideas
--------------
 - A webpage that logs output as it is displayed
 - A chat application
 - Simulate a shopping cart with Commands/Events or even CQRS
 - Investigate async RabbitMQ (hint: https://github.com/jakubkulhan/bunny)
