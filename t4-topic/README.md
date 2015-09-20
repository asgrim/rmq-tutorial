Exercise Summary
================

 - Consumer:
    - Simply change exchange name and type to `topic`
 - Producer:
    - Simply change exchange name and type to `topic`
 - The topic exchange now allows us:
    - Use of words (separated by dots)
    - `*` (asterisk) = exactly ONE word
    - `#` (hash) = ZERO or more words
 - Examples:
    - `php consumer.php *.apple`
    - `php consumer.php green.*`
    - `php consumer.php \#` (slash because CLI)
