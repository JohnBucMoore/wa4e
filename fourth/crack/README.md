The Reverse Hash Application
============================

This application uses a very simple brute force attack to 
"reverse" an MD5 hash.  It is really not reversing the hash
at all as that would be impossible.  Instead it knows that 
the original pre hash text was a four-number PIN string with 
exactly four numbers.

So the application uses four nested loops and tests all 
10 * 10 * 10 * 10 combinations of four numbers, and computes the
hashes of those values and checks to see if the computed hash
matches.

You can play with a similar application using a two-character key
of lowercase letters a-z at:

http://www.wa4e.com/code/crack

This is a lesson in how easy it is to crack short passwords
with a limited number set/alphabet.  While this works well to crack 
very short passwords it is not practical as password 
length grows.

A more sophisticated attack to reverse hashes which uses a 
lot of storage to pre-compute lots of hashes and look them up
quickly is called "Rainbow Tables".  This tiny application
is *not* using a Rainbow Table approach.

