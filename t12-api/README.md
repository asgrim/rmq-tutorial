RabbitMQ Management API
=======================

 - All docs available at http://192.168.33.99:15672/api/
 
 - Might need http://jsonviewer.stack.hu/ for this ;)

 - Get an overview:
    - curl -i -u guest:guest http://192.168.33.99:15672/api/overview

 - Let's create a exchange & queue, publish a message to it, and fetch it
    - Create exchange (PUT)
        curl -i -u guest:guest -H "content-type:application/json" \
            -XPUT -d'{"type":"direct","durable":true}' \
            http://192.168.33.99:15672/api/exchanges/%2f/test_http_exchange
            
    - List it (GET)
        curl -i -u guest:guest http://192.168.33.99:15672/api/exchanges/%2f
          
    - Create queue (PUT)
        curl -i -u guest:guest -H "content-type:application/json" \
            -XPUT -d'{"auto_delete":false,"durable":true}' \
            http://192.168.33.99:15672/api/queues/%2f/test_http_queue
            
    - List it (GET)
        curl -i -u guest:guest http://192.168.33.99:15672/api/queues/%2f
            
    - Bind queue to exchange (POST)
        curl -i -u guest:guest -H "content-type:application/json" \
            -XPOST -d'{"routing_key":"foo","arguments":{}}' \
            http://192.168.33.99:15672/api/bindings/%2f/e/test_http_exchange/q/test_http_queue

    - Publish a message to exchange (POST)
        curl -i -u guest:guest -H "content-type:application/json" \
            -XPOST -d'{"properties":{},"routing_key":"foo","payload":"Hello phptek16 Tutorial","payload_encoding":"string"}' \
            http://192.168.33.99:15672/api/exchanges/%2f/test_http_exchange/publish

    - Fetch the message (POST - not GET as it can modify(delete) the message)
        curl -i -u guest:guest -H "content-type:application/json" \
            -XPOST -d'{"count":1,"requeue":false,"encoding":"auto"}' \
            http://192.168.33.99:15672/api/queues/%2f/test_http_queue/get
